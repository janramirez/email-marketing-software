<?php

namespace Domain\Mail\Enums\Blast;

enum BlastStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';

    public function canSend(): bool
    {
        return match ($this) {
            self::Draft => true,
            self::Sent => false,
        };
    }
}