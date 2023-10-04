<?php

namespace Domain\Subscriber\Filters;

use Illuminate\Database\Eloquent\Builder;

class TagFilter
{
    public function __construct(
        protected readonly array $ids
    ) {}

    public function filter(Builder $subscribers): Builder
    {
        if(count($this->ids) === 0) {
            return $subscribers;
        }

        return $subscribers->whereHas('tags', fn (Builder $tags) =>
            $tags->whereIn('id', $this->ids)
        );
    }
}