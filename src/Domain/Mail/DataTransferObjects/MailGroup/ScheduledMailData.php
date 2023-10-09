<?php

namespace Domain\Mail\DataTransferObjects\MailGroup;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Attributes\WithCast;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\Enums\MailGroup\ScheduledMailStatus;
use Spatie\LaravelData\Lazy;

class ScheduledMailData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        #[WithCast(EnumCast::class)]
        public readonly ScheduledMailStatus $status,
        public readonly FilterData $filters,
        public readonly null|Lazy|MailGroupData $mailgroup,
        public readonly Lazy|ScheduleData $schedule,
    )
    {
        
    }
    public static function dummy(): self
    {
        return self::from([
            'subject' => 'My Awesome E-mail',
            'content' => 'My Awesome Content',
            'status' => ScheduledMailStatus::Draft,
            'filters' => FilterData::empty(),
            'schedule' => [
                'delay' => 1,
                'unit' => 'day',
                'allowed_days' => ScheduleAllowedDaysData::empty(),
            ]
        ]);
    }
}