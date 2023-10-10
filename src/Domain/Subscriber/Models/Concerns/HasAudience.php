<?php

namespace Domain\Subscriber\Models\Concerns;

use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Subscriber\Enums\Filters;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasAudience
{
    /*
    |``````````````````````````````````````````````````````````````````````````````````````````
    |   NOTE:
    |``````````````````````````````````````````````````````````````````````````````````````````
    |    Any model that uses this trait must implement this abstract methods.
    |   This is to prevent assumptions that a model have filters() and audienceQuery() methods
    |   and prevent unnecessary bugs.
    */ 
    abstract public function filters(): FilterData;
    abstract protected function audienceQuery(): Builder;


    public function audience(): Collection
    {
        $filters = collect($this->filters->toArray())
            ->map( fn (array $ids, string $key) => 
                Filters::from($key)->createFilter($ids)
            )
            ->values()
            ->all();

        return app(Pipeline::class)
            ->send($this->audienceQuery())
            ->through($filters)
            ->thenReturn()
            ->get();
    }
}