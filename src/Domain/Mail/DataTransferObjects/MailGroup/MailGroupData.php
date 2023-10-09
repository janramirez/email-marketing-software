<?php

namespace Domain\Mail\DataTransferObjects\MailGroup;

use Domain\Mail\Enums\MailGroup\MailGroupStatus;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\WithCast;

class MailGroupData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        #[WithCast(EnumCast::class)]
        public readonly MailGroupStatus $status,
        public readonly null|Lazy|DataCollection $mails,
    ) {}
}