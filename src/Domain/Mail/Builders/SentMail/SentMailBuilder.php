<?php

namespace Domain\Mail\Builders\SentMail;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Blast\Blast;
use Illuminate\Database\Eloquent\Builder;

class SentMailBuilder extends Builder
{
    public function countOf(Sendable $sendable): int
    {
        return $this
            ->where('sendable_id', $sendable->id())
            ->where('sendable_type', $sendable->type())
            ->count();
    }

    public function openRate(Sendable $sendable, int $total): float
    {
        $openedCount = $this
            ->where('sendable_id', $sendable->id())
            ->where('sendable_type', $sendable->type())
            ->whereNotNull('opened_at')
            ->count();

        return $openedCount / $total;
    }

}