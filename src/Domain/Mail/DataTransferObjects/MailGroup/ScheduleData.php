<?php

namespace Domain\Mail\DataTransferObjects\MailGroup;

use Spatie\LaravelData\Data;

class ScheduleData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $delay,
        public readonly ScheduledMailUnit $unit, // TODO class ScheduledMailUnit
        public readonly ScheduleAllowedDaysData $allowed_days,
    ) {}
}