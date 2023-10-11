<?php

namespace Domain\Mail\Models\Concerns;

use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Shared\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasPerformance
{
    abstract public function totalInstances(): int;

    public function performance(): PerformanceData
    {
        $total = $this->totalInstances();

        return new PerformanceData(
            total: $total,
            open_rate: $this->openRate($total),
            click_rate: $this->clickRate($total),
        );
    }

    public function openRate(int $total): Percent
    {
        return Percent::from(
            $this->sent_mails()->whereOpened()->count(),
            $total
        );
    }

    public function clickRate(int $total): Percent
    {
        return Percent::from(
            $this->sent_mails()->whereClicked()->count(),
            $total
        );
    }
}