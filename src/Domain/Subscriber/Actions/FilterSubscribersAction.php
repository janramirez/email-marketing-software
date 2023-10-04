<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Models\Blast\Blast;
use Domain\Subscriber\Enums\Filters;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Collection;

class FilterSubscribersAction
{
    /**
     * @return Collection<Subscriber>
     */
    public static function execute(Blast $blast): Collection
    {
        return app(Pipeline::class)
            ->send(Subscriber::query())
            ->through(self::filters($blast))
            ->thenReturn()
            ->get();
    }

    public static function filters(Blast $blast): array
    {
        return collect($blast->filters->toArray())
            ->map(fn (array $ids, string $key) => 
                Filters::from($key)->createFilter($ids)
            )
            ->values()
            ->all();
    }
}