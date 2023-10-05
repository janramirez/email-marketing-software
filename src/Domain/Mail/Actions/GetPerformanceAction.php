<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Contracts\Sendable;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\Models\SentMail;

class GetPerformanceAction
{
    public static function execute(Sendable $sendable): PerformanceData
    {
        return new PerformanceData(
            total: SentMail::countOf($sendable),
            open_rate: SentMail::openRate($sendable, $total),
            click_rate: SentMail::clickRate($sendable, $total),
        );
    }
}