<?php

namespace Domain\Mail\Models\MailGroup;

use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\Enums\MailGroup\MailGroupStatus;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\LaravelData\WithData;

class MailGroup extends BaseModel
{
    use WithData, HasUser, HasPerformance;

    protected $fillable = [
        'title',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => MailGroupStatus::class,
    ];

    protected $attributes = [
        'status' => MailGroupStatus::Draft,
    ];

    protected $dataClass = MailGroupData::class;

    // TODO newEloquentBuilder($query) method

    /**
    * Relationships
    */

    public function mails(): HasMany
    {
        return $this->hasMany(ScheduledMail::class);
    }

    public function sent_mails(): HasManyThrough
    {
        return $this->hasManyThrough(
            SentMail::class,
            MailGroup::class,
            'mailgroup_id',
            'sendable_id'
        )->where('sent_mails.sendable_type', MailGroup::class);
    }

    public function subscribers(): BelongsToMany
    {
        return  $this->belongsToMany(Subscriber::class)->withPivot(['subscribed_at', 'status']);
    }

    // PERFORMANCE
    public function performance(): PerformanceData
    {
        $total = $this->activeSubscriberCount();

        return new PerformanceData(
            total: $total,
            open_rate: $this->openRate($total),
            click_rate: $this->clickRate($total),
        );
    }
}
