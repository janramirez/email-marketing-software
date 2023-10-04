<?php

namespace Domain\Subscriber\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly array $ids)
    {
    }

    abstract public function filter(Builder $subscribers): Builder;
}