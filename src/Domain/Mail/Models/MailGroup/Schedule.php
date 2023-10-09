<?php

namespace Domain\Mail\Models\MailGroup;

use Domain\Mail\Enums\MailGroup\ScheduledMailUnit;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends BaseModel
{
    protected $fillable = [
        'delay',
        'unit',
        'allowed_days',
        'scheduled_mail_id',
    ];

    protected $casts = [
        'allowed_days' => ScheduleAllowedDaysCast::class, // TODO
        'unit' => ScheduledMailUnit::class, // TODO
    ];

    public function scheduled_mail(): BelongsTo
    {
        return $this->belongsTo(ScheduledMail::class);
    }

    // TODO delayInHours()
}
