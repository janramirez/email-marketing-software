<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends BaseModel
{
    protected $fillable = [
        'title',
        'content',
        'form_id'
    ];

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class);
    }
}