<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Blast\Blast;
use Domain\Subscriber\Enums\Filters;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

class FilterSubscribersAction
{
    /**
     * @return Collection<Subscriber>
     */
    public static function execute(Sendable $mail): Collection
    {
        return app(Pipeline::class)
            ->send(Subscriber::query())
            ->through(self::filters($mail))
            ->thenReturn()
            ->get();
    }

    public static function filters(Sendable $mail): array
    {
        return collect($mail->filters->toArray())
            ->map(fn (array $ids, string $key) => 
                Filters::from($key)->createFilter($ids)
            )
            ->values()
            ->all();
    }
}