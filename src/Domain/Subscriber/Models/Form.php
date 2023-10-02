<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Subscriber\DataTransferObjects\FormData;
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