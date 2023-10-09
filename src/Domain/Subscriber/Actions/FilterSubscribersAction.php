<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Blast\Blast;
use Domain\Mail\Models\MailGroup\ScheduledMail;
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
        $subscribers = Subscriber::query();
        
        if ($mail instanceof ScheduledMail) {
            $subscribers = Subscriber::query()
                ->whereIn(
                    'id',
                    $mail->mail_group->subscribers()->select('subscribers.id')->pluck('id')
                );
        }

        return app(Pipeline::class)
            ->send($subscribers)
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