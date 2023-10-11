<?php

namespace Domain\Mail\DataTransferObjects\MailGroup;

use Spatie\LaravelData\Data;

class MailGroupProgressData extends Data
{
    public function __construct(
        public readonly int $total,
        public readonly int $in_progress,
        public readonly int $completed,
    ) {}
}