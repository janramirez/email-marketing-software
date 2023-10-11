<?php

namespace Domain\Mail\Models\Blast;

use Domain\Mail\Builders\Blast\BlastBuilder;
use Domain\Mail\Contracts\Sendable;
use Domain\Mail\DataTransferObjects\Blast\BlastData;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\Enums\Blast\BlastStatus;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Mail\Models\Concerns\HasPerformance;
use Domain\Mail\Models\SentMail;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\Models\Concerns\HasAudience;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\LaravelData\WithData;

class Blast extends BaseModel implements Sendable
{
    use WithData, HasUser, HasAudience, HasPerformance;

    protected $fillable = [
        'id',
        'subject',
        'content',
        'status',
        'filters',
        'sent_at',
        'user_id',
    ];

    protected $dataClass = BlastData::class;

    protected $casts = [
        'filters' => FiltersCast::class,
        'status' => BlastStatus::class,
    ];

    protected $attributes = [
        'status' => BlastStatus::Draft,
    ];

    // SENDABLE

    public function id(): int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this::class;
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

    // QUERY BUILDER

    public function newEloquentBuilder($query): BlastBuilder
    {
        return new BlastBuilder($query);
    }

    public function sent_mails(): MorphMany
    {
        return $this->morphMany(SentMail::class, 'sendable');
    }

    public function audienceQuery(): Builder
    {
        return Subscriber::query();
    }

    // PERFORMANCE
    public function totalInstances(): int
    {
        return SentMail::countOf($this);
    }
}
