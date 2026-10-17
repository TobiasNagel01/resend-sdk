<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Omit;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update the agent settings for an inbox
 *
 * Updates the agent settings of the inbox. The agent is created when the inbox has none. Omitted fields keep their current value.
 *
 * PATCH /inboxes/{inbox_id}/agent
 *
 * @generated from the Resend OpenAPI spec (inboxes/update-agent). Do not edit by hand, run `composer generate` instead.
 */
class UpdateInboxAgentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|null|Omit  $instructions  Instructions the agent follows when it handles the threads of the inbox. Max 4000 characters. Leading and trailing whitespace is trimmed, and the trimmed value must not be empty. Send null to clear the instructions.
     * @param  'concise_professional'|'concise_casual'|'expanded_professional'|'expanded_casual'|null|Omit  $tone  The tone the agent writes in. Send null to clear the tone.
     * @param  list<'draft_reply'|'forward_thread'|'add_labels'|'assign_thread'|'mark_as_spam'|'archive'|'move_to_trash'>|null  $actions  The actions the agent can take. Replaces the whole set. Duplicates are removed. Send an empty array to disable all actions. The old names `archive_thread` and `delete_thread` return a 422. Use `archive` and `move_to_trash`.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string|Omit|null $instructions = Omit::Value,
        public readonly string|Omit|null $tone = Omit::Value,
        public readonly ?array $actions = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/agent';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'instructions' => $this->instructions,
            'tone' => $this->tone,
            'actions' => $this->actions,
        ], nullable: ['instructions', 'tone']);
    }
}
