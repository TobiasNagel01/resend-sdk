<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve account-level email metrics
 *
 * GET /emails/metrics
 *
 * @generated from the Resend OpenAPI spec (emails/metrics). Do not edit by hand, run `composer generate` instead.
 */
class GetEmailMetricsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string|null  $startDate  The start of the date range, as an ISO 8601 date or datetime. Must be on or before `end_date`. Defaults to 6 days before `end_date`.
     * @param  string|null  $endDate  The end of the date range, as an ISO 8601 date or datetime. Values in the future are clamped to the current time. Defaults to now.
     * @param  string|null  $timezone  The IANA timezone (e.g. `America/New_York`) used to bucket periods when `period` is in `dimensions`.
     * @param  'hourly'|'daily'|'weekly'|'monthly'|null  $granularity  The bucket size used when `period` is in `dimensions`. The date range can't produce more than 10,000 periods at the chosen granularity.
     * @param  list<'received'|'delivered'|'complained'|'suppressed'|'bounced'|'bounced_transient'|'bounced_permanent'|'bounced_undetermined'|'opened'|'clicked'|'unsubscribed'|'delivery_delayed'|'failed'|'sent'|'unique_opened'|'unique_clicked'|'delivery_rate'|'open_rate'|'click_rate'|'bounce_rate'|'complaint_rate'|'unsubscribe_rate'>|null  $metrics  List of metrics to include in the response. Defaults to all metrics. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<'period'|'domain'|'email'|'broadcast'>|null  $dimensions  List of dimensions to break the response down by. `email` cannot be combined with `broadcast`. Defaults to `[]`, returning a single `totals` row for the whole range, with no `data`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<string>|null  $domainId  List of sending domain IDs to restrict the response to, up to 100. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<string>|null  $emailId  List of email IDs to restrict the response to, up to 100. Cannot be combined with the `broadcast` dimension or `broadcast_id`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     * @param  list<string>|null  $broadcastId  List of broadcast IDs to restrict the response to, up to 100. Cannot be combined with the `email` dimension or `email_id`. Accepts a comma-separated value, the parameter repeated, or a mix of both.
     */
    public function __construct(
        public readonly ?string $startDate = null,
        public readonly ?string $endDate = null,
        public readonly ?string $timezone = null,
        public readonly ?string $granularity = null,
        public readonly ?array $metrics = null,
        public readonly ?array $dimensions = null,
        public readonly ?array $domainId = null,
        public readonly ?array $emailId = null,
        public readonly ?array $broadcastId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/metrics';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'timezone' => $this->timezone,
            'granularity' => $this->granularity,
            'metrics' => $this->metrics,
            'dimensions' => $this->dimensions,
            'domain_id' => $this->domainId,
            'email_id' => $this->emailId,
            'broadcast_id' => $this->broadcastId,
        ]);
    }
}
