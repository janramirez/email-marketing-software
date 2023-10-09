<?php

namespace Domain\Mail\Models\Casts\MailGroup;

use Domain\Mail\DataTransferObjects\MailGroup\ScheduleAllowedDaysData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleAllowedDaysCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return ScheduleAllowedDaysData::from(
            json_decode($value, true)
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'allowed_days' => json_encode($value),
        ];
    }
}