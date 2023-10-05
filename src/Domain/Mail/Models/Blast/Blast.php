<?php

namespace Domain\Mail\Models\Blast;

use Domain\Mail\Builders\Blast\BlastBuilder;
use Domain\Mail\DataTransferObjects\Blast\BlastData;
use Domain\Mail\Enums\Blast\BlastStatus;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Spatie\LaravelData\WithData;

class Blast extends BaseModel
{
    use WithData, HasUser;

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

    public function newEloquentBuilder($query): BlastBuilder
    {
        return new BlastBuilder($query);
    }
}
