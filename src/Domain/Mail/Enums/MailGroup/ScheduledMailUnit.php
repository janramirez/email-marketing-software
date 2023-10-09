<?php

namespace Domain\Mail\Enums\MailGroup;

use Carbon\Carbon;

enum ScheduledMailUnit: string
{
    case Day = 'day';
    case Hour = 'hour';

    public function timePassedSince(Carbon $date): int
    {
        return match ($this) {
            self::Day => now()->diffInDays($date),
            self::Hour => now()->diffInHours($date),
        };
    }
}