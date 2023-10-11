<?php

namespace Domain\Mail\Models\MailGroup;

use Illuminate\Support\Str;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Contracts\Sendable;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Shared\Models\BaseModel;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Domain\Mail\Enums\MailGroup\ScheduledMailStatus;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Subscriber\Models\Concerns\HasAudience;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ScheduledMail extends BaseModel implements Sendable
{
    use HasUser, HasAudience, HasPerformance;

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

    // RELATIONSHIPS

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

    public function subject(): string
    {
        return $this->subject;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function filters(): FilterData
    {
        return $this->filters;
    }

    // HELPER METHODS

    public function shouldSendToday(): bool
    {
        $dayName = Str::lower(now()->dayName);
        
        return $this->schedule->allowed_days->{$dayName};
    }

    public function enoughTimePassedSince(SentMail $mail): bool
    {
        return $this->schedule->unit->timePassedSince($mail->sent_at) >= $this->schedule->delay;
    }

    // QUERY BUILDERS

    public function audienceQuery(): Builder
    {
        return Subscriber::whereIn(
            'id',
            $this->mail_group->subscribers()->select('subscribers.id')->pluck('id')
        );
    }

    // PERFORMANCE
    public function performance(): PerformanceData
    {
        $total = SentMail::countOf($this);

        return new PerformanceData(
            total: $total,
            open_rate: $this->openRate($total),
            click_rate: $this->clickRate($total),
        );
    }
}
