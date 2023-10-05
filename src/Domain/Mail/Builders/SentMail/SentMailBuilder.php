<?php

namespace Domain\Mail\Builders\SentMail;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\Models\Blast\Blast;
use Illuminate\Database\Eloquent\Builder;

class SentMailBuilder extends Builder
{
    public function countOf(Sendable $sendable): int
    {
        return $this->whereSendable($sendable)->count();
    }

    public function openRate(Sendable $sendable, int $total): float
    {
        return $this
            ->whereSendable($sendable)
            ->whereOpened()
            ->count() / $total;
    }

    public function clickRate(Sendable $sendable, int $total): float
    {
        return $this
            ->whereSendable($sendable)
            ->whereClicked()
            ->count / $total;
    }

    public function whereSendable(Sendable $sendable): self
    {
        return $this
        ->where('sendable_id', $sendable->id())
        ->where('sendable_type', $sendable->type());
    }

    public function whereOpened(): self
    {
        return $this->whereNotNull('opened_at');
    }

    public function whereClicked(): self
    {
        return $this->whereNotNull('clicked_at');
    }

}