<?php

namespace Domain\Subscriber\Models;

use Carbon\Carbon;
use Domain\Mail\Models\Blast;
use Domain\Mail\Models\MailGroup;
use Domain\Mail\Models\MailGroup\ScheduledMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Builders\SubscriberBuilder;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Spatie\LaravelData\WithData;

class Subscriber extends BaseModel
{
    use Notifiable, WithData, HasUser, HasUuids;

    protected $dataClass = SubscriberData::class;
    
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id',
        'user_id'
    ];

    // <!-- Castable attributes -->
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    // RELATIONSHIPS

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class)
            ->withDefault();
    }

    public function blast(): BelongsToMany
    {
        return $this->belongsToMany(Blast::class);
    }

    public function mail_group(): BelongsToMany
    {
        return $this->belongsToMany(MailGroup::class)->withPivot('subscribed_at');
    }

    public function sent_mails(): HasMany
    {
        return $this->hasMany(SentMail::class);
    }
    
    // ADDITIONAL ATTRIBUTES

    public function received_mails(): HasMany
    {
        return $this->hasMany(SentMail::class);
    }

    public function last_received_mail(): HasOne
    {
        return $this->hasOne(SentMail::class)->latestOfMany()->withDefault();
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}"
        );
    }

    // HELPER METHODS

    public function tooEarlyfor(ScheduledMail $mail): bool
    {
        return !$mail->enoughTimePassedSince($this->last_received_mail);
    }

    // QUERY BUILDER
    public function newEloquentBuilder($query): SubscriberBuilder
    {
        return new SubscriberBuilder($query);
    }
}