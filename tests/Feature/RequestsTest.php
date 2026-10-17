<?php

use Saloon\Data\MultipartValue;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use TobiasNagel01\ResendSdk\Data\Domain;
use TobiasNagel01\ResendSdk\Data\DomainRecord;
use TobiasNagel01\ResendSdk\Data\Email;
use TobiasNagel01\ResendSdk\Data\Inbox;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Requests\Contacts\CreateContactImportRequest;
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;
use TobiasNagel01\ResendSdk\Requests\Inboxes\UpdateInboxAgentRequest;

function json_body($response): array
{
    return json_decode((string) $response->getPsrRequest()->getBody(), true);
}

it('sends an email with snake_case keys, custom headers and an idempotency key', function () {
    $mockClient = new MockClient([MockResponse::make(['id' => '49a3999c-0ce1-4ea6-ab68-afcd6dc2e794'])]);

    $response = resend($mockClient)->emails()->send(
        from: 'Acme <onboarding@resend.dev>',
        to: ['delivered@resend.dev'],
        subject: 'Hello World',
        replyTo: 'support@acme.com',
        html: '<strong>It works!</strong>',
        customHeaders: ['X-Entity-Ref-ID' => '123'],
        tags: [['name' => 'category', 'value' => 'welcome']],
        idempotencyKey: 'welcome-user-123',
    );

    expect($response->json('id'))->toBe('49a3999c-0ce1-4ea6-ab68-afcd6dc2e794')
        ->and($response->getPsrRequest()->getMethod())->toBe('POST')
        ->and($response->getPsrRequest()->getHeaderLine('Idempotency-Key'))->toBe('welcome-user-123')
        ->and(json_body($response))->toBe([
            'from' => 'Acme <onboarding@resend.dev>',
            'to' => ['delivered@resend.dev'],
            'subject' => 'Hello World',
            'reply_to' => 'support@acme.com',
            'html' => '<strong>It works!</strong>',
            'headers' => ['X-Entity-Ref-ID' => '123'],
            'tags' => [['name' => 'category', 'value' => 'welcome']],
        ]);
});

it('omits the idempotency header when no key is given', function () {
    $mockClient = new MockClient([MockResponse::make(['id' => 'abc'])]);

    $response = resend($mockClient)->emails()->send('a@acme.com', 'b@acme.com', 'Hi', text: 'Hi');

    expect($response->getPsrRequest()->hasHeader('Idempotency-Key'))->toBeFalse();
});

it('can be sent as a request object', function () {
    $mockClient = new MockClient([SendEmailRequest::class => MockResponse::make(['id' => 'abc'])]);

    $request = new SendEmailRequest('a@acme.com', 'b@acme.com', 'Hi', text: 'Hi');
    $request->body()->add('scheduled_at', 'in 1 min');

    $response = resend($mockClient)->send($request);

    expect(json_body($response))->toMatchArray(['scheduled_at' => 'in 1 min']);
});

it('sends batch emails as a json array', function () {
    $mockClient = new MockClient([MockResponse::make(['data' => [['id' => '1'], ['id' => '2']]])]);

    $emails = [
        ['from' => 'a@acme.com', 'to' => 'b@acme.com', 'subject' => 'One', 'text' => '1'],
        ['from' => 'a@acme.com', 'to' => 'c@acme.com', 'subject' => 'Two', 'text' => '2'],
    ];

    $response = resend($mockClient)->emails()->sendBatch($emails, idempotencyKey: 'batch-1');

    expect($response->getPsrRequest()->getUri()->getPath())->toBe('/emails/batch')
        ->and(json_body($response))->toBe($emails);
});

it('passes pagination parameters and maps list responses to DTOs', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'object' => 'list',
            'has_more' => true,
            'data' => [
                ['object' => 'email', 'id' => 'e-1', 'to' => ['a@acme.com'], 'from' => 'x@acme.com', 'last_event' => 'delivered'],
                ['object' => 'email', 'id' => 'e-2', 'to' => ['b@acme.com'], 'from' => 'x@acme.com', 'last_event' => 'bounced'],
            ],
        ]),
    ]);

    $response = resend($mockClient)->emails()->list(limit: 2, after: 'e-0');
    $list = $response->dto();

    expect($response->getPsrRequest()->getUri()->getQuery())->toBe('limit=2&after=e-0')
        ->and($list)->toBeInstanceOf(ListResponse::class)
        ->and($list)->toHaveCount(2)
        ->and($list->hasMore)->toBeTrue()
        ->and($list->nextCursor())->toBe('e-2')
        ->and($list->data[0])->toBeInstanceOf(Email::class)
        ->and($list->data[0]->lastEvent)->toBe('delivered')
        ->and($list->data[1]->to)->toBe(['b@acme.com']);
});

it('maps nested DTOs', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'object' => 'domain',
            'id' => 'd91cd9bd-1176-453e-8fc1-35364d380206',
            'name' => 'example.com',
            'status' => 'not_started',
            'records' => [
                ['record' => 'SPF', 'name' => 'send', 'type' => 'MX', 'value' => 'feedback-smtp.us-east-1.amazonses.com', 'status' => 'not_started'],
            ],
        ]),
    ]);

    $domain = resend($mockClient)->domains()->get('d91cd9bd-1176-453e-8fc1-35364d380206')->dto();

    expect($domain)->toBeInstanceOf(Domain::class)
        ->and($domain->name)->toBe('example.com')
        ->and($domain->records[0])->toBeInstanceOf(DomainRecord::class)
        ->and($domain->records[0]->type)->toBe('MX');
});

it('maps required DTO properties', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'object' => 'inbox',
            'id' => 'b3e2b2b6-3f0e-4c8e-9ad3-2f43a1e2c7f1',
            'name' => 'Support',
            'email_address' => 'support@acme.com',
            'domain_id' => 'd-1',
            'receiving_address' => null,
            'from_name' => null,
            'unread' => 3,
            'drafts' => 0,
            'last_received' => null,
            'created_at' => '2026-01-01T00:00:00.000Z',
            'updated_at' => '2026-01-01T00:00:00.000Z',
        ]),
    ]);

    $response = resend($mockClient)->inboxes()->get('support@acme.com');
    $inbox = $response->dto();

    expect($response->getPsrRequest()->getUri()->getPath())->toBe('/inboxes/support%40acme.com')
        ->and($inbox)->toBeInstanceOf(Inbox::class)
        ->and($inbox->emailAddress)->toBe('support@acme.com')
        ->and($inbox->unread)->toBe(3)
        ->and($inbox->fromName)->toBeNull();
});

it('serializes array query parameters comma separated and booleans as strings', function () {
    $mockClient = new MockClient([MockResponse::make(['object' => 'list', 'data' => []]), MockResponse::make(['object' => 'list', 'data' => []])]);

    $metrics = resend($mockClient)->emails()->metrics(metrics: ['delivered', 'opened'], dimensions: ['period'], granularity: 'daily');
    $threads = resend($mockClient)->inboxes()->listThreads('inbox-1', read: false);

    expect(urldecode($metrics->getPsrRequest()->getUri()->getQuery()))->toBe('granularity=daily&metrics=delivered,opened&dimensions=period')
        ->and($threads->getPsrRequest()->getUri()->getQuery())->toContain('read=false');
});

it('renames arguments that clash with saloon request properties', function () {
    $mockClient = new MockClient([MockResponse::make(['object' => 'list', 'data' => []])]);

    $response = resend($mockClient)->inboxes()->searchThreads('inbox-1', searchQuery: 'invoice');

    expect($response->getPsrRequest()->getUri()->getQuery())->toContain('query=invoice');
});

it('only sends null for nullable fields when passed explicitly', function () {
    $request = new UpdateInboxAgentRequest('inbox-1', instructions: null, actions: ['draft_reply']);

    expect($request->body()->all())->toBe([
        'instructions' => null,
        'actions' => ['draft_reply'],
    ]);
});

it('uploads contact imports as multipart form data', function () {
    $mockClient = new MockClient([MockResponse::make(['object' => 'contact_import', 'id' => 'imp-1'], 201)]);

    $file = fopen(__DIR__.'/../Fixtures/contacts.csv', 'r');

    $response = resend($mockClient)->contacts()->createImport(
        file: $file,
        columnMap: ['email' => 'email', 'first_name' => 'first_name'],
        onConflict: 'upsert',
    );

    $parts = collect($response->getPendingRequest()->body()->all())->keyBy('name');
    $body = (string) $response->getPsrRequest()->getBody();

    expect($response->getPendingRequest()->getRequest())->toBeInstanceOf(CreateContactImportRequest::class)
        ->and($response->getPsrRequest()->getHeaderLine('Content-Type'))->toStartWith('multipart/form-data; boundary=')
        ->and($parts['file'])->toBeInstanceOf(MultipartValue::class)
        ->and($parts['file']->filename)->toBe('contacts.csv')
        ->and($parts['column_map']->value)->toBe('{"email":"email","first_name":"first_name"}')
        ->and($parts['on_conflict']->value)->toBe('upsert')
        ->and($parts->has('segments'))->toBeFalse()
        ->and($body)->toContain('jane@example.com');
});

it('sends the request body that the spec is missing for email updates', function () {
    $mockClient = new MockClient([MockResponse::make(['object' => 'email', 'id' => 'e-1'])]);

    $response = resend($mockClient)->emails()->update('e-1', scheduledAt: '2026-11-01T10:00:00Z');

    expect($response->getPsrRequest()->getMethod())->toBe('PATCH')
        ->and(json_body($response))->toBe(['scheduled_at' => '2026-11-01T10:00:00Z']);
});
