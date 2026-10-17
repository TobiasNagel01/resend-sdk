<?php

/*
|--------------------------------------------------------------------------
| Generator overrides
|--------------------------------------------------------------------------
|
| Everything the OpenAPI spec cannot express (or gets wrong) lives here, so
| generated files never need manual edits. Keys are operationIds.
|
*/

return [

    // Resource key (operationId prefix) => [class name, accessor on the connector, singular used in request names].
    'resources' => [
        'oauth' => ['class' => 'OAuth', 'accessor' => 'oauth', 'singular' => 'OAuth'],
        'usage' => ['class' => 'Usage', 'accessor' => 'usage', 'singular' => 'Usage'],
    ],

    // operationId => request class name (without the "Request" suffix).
    'requestNames' => [
        'emails/send-batch' => 'SendBatchEmails',
        'emails/list-receiving' => 'ListReceivedEmails',
        'emails/get-receiving' => 'GetReceivedEmail',
        'emails/list-receiving-attachments' => 'ListReceivedEmailAttachments',
        'emails/get-receiving-attachment' => 'GetReceivedEmailAttachment',
        'emails/metrics' => 'GetEmailMetrics',
        'broadcasts/recipients' => 'ListBroadcastRecipients',
        'suppressions/batch-add' => 'BatchAddSuppressions',
        'suppressions/batch-remove' => 'BatchRemoveSuppressions',
    ],

    // operationId => resource method name.
    'methodNames' => [
        'broadcasts/recipients' => 'listRecipients',
    ],

    // Request bodies missing from the spec (operationId => JSON schema).
    'requestBodies' => [
        'emails/update' => [
            'type' => 'object',
            'required' => ['scheduled_at'],
            'properties' => [
                'scheduled_at' => [
                    'type' => 'string',
                    'description' => 'Schedule email to be sent later. The date should be in ISO 8601 format (e.g: 2024-08-05T11:52:01.858Z) or natural language (e.g.: "in 1 min").',
                ],
            ],
        ],
    ],

    // Multipart fields that take a JSON-encoded string; arrays passed to them are encoded automatically.
    'jsonFields' => [
        'contacts/create-import' => ['column_map', 'segments', 'topics'],
    ],

    // Default filename for binary multipart uploads.
    'uploadFilenames' => [
        'contacts/create-import' => 'contacts.csv',
    ],

    // Argument names that would clash with properties of Saloon\Http\Request.
    'reservedProperties' => [
        'headers' => 'customHeaders',
        'query' => 'searchQuery',
    ],

    /*
    | DTO name => sources. A source is either an operationId (its 200 response,
    | or the items of a list response) or "schema:<ComponentName>" for nested
    | objects. Properties of all sources are merged.
    */
    'dtos' => [
        'Email' => ['emails/list', 'emails/get', 'emails/cancel'],
        'Attachment' => ['emails/list-attachments', 'emails/get-attachment', 'emails/list-receiving-attachments', 'emails/get-receiving-attachment'],
        'ReceivedEmail' => ['emails/list-receiving', 'emails/get-receiving'],
        'Domain' => ['domains/list', 'domains/get'],
        'DomainRecord' => ['schema:DomainRecord'],
        'DomainClaim' => ['domains/create-claim', 'domains/get-claim', 'domains/verify-claim'],
        'ApiKey' => ['api-keys/list'],
        'OAuthGrant' => ['oauth/list-grants'],
        'Template' => ['templates/list', 'templates/get'],
        'TemplateVariable' => ['schema:TemplateVariable'],
        'Audience' => ['audiences/list', 'audiences/get'],
        'Contact' => ['contacts/list', 'contacts/get', 'segments/list-contacts'],
        'ContactImport' => ['contacts/list-imports', 'contacts/get-import'],
        'ContactProperty' => ['contact-properties/list', 'contact-properties/get'],
        'Broadcast' => ['broadcasts/list', 'broadcasts/get'],
        'Webhook' => ['webhooks/list', 'webhooks/get'],
        'WebhookEvent' => ['webhooks/list-events', 'webhooks/get-event'],
        'Segment' => ['segments/list', 'segments/get', 'contacts/list-segments'],
        'Topic' => ['topics/list', 'topics/get'],
        'Log' => ['logs/list', 'logs/get'],
        'Automation' => ['automations/list', 'automations/get'],
        'AutomationRun' => ['automations/list-runs', 'automations/get-run'],
        'Event' => ['events/list', 'events/get'],
        'Suppression' => ['suppressions/list', 'suppressions/get'],
        'Inbox' => ['inboxes/list', 'inboxes/get'],
        'InboxLabel' => ['inboxes/list-labels'],
        'InboxThread' => ['inboxes/list-threads', 'inboxes/get-thread'],
        'InboxThreadLabel' => ['schema:InboxThreadLabel'],
        'InboxThreadEmail' => ['inboxes/list-thread-emails', 'inboxes/get-thread-email'],
        'InboxDraft' => ['inboxes/list-drafts', 'inboxes/get-draft'],
    ],

];
