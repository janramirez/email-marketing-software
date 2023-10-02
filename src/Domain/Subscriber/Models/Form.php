<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Subscriber\DataTransferObjects\FormData;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\LaravelData\WithData;

class Form extends BaseModel
{
    use WithData, HasUser;

    protected $dataClass = FormData::class;

    protected $fillable = [
        'title',
        'content',
        'form_id'
    ];

    protected $attributes = [
        'title' => '-',
        'content' => '',
    ];
}