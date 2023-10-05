<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\Models\SentMail;

class GetPerformanceAction
{
    public static function execute(Sendable $sendable): PerformanceData
    {
        $total = SentMail::countOf($sendable);

        return new PerformanceData(
            total: $total,
            open_rate: SentMail::openRate($sendable, $total),
            click_rate: SentMail::clickRate($sendable, $total),
        );
    }
}