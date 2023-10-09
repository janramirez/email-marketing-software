<?php

namespace Domain\Mail\Models\MailGroup;

use Illuminate\Support\Str;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Contracts\Sendable;
use Domain\Shared\Models\BaseModel;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Domain\Mail\Enums\MailGroup\ScheduledMailStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ScheduledMail extends BaseModel implements Sendable
{
    use HasUser;

    protected $fillable = [
        'mail_group_id',
        'scheduledmail_schedule_id',
        'subject',
        'content',
        'status',
        'filters',
        'user_id',
    ];

    protected $casts = [
        'status' => ScheduledMailStatus::class,
        'filters' => FiltersCast::class,
    ];

    protected $attributes = [
        'status' => ScheduledMailStatus::Draft,
    ];

    public function mail_group(): BelongsTo
    {
        return $this->belongsTo(MailGroup::class);
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }

    // SENDABLE
    public function id(): int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->subject;
    }

    public function shouldSendToday(): bool
    {
        $dayName = Str::lower(now()->dayName);
        
        return $this->schedule->allowed_days->{$dayName};
    }
}
