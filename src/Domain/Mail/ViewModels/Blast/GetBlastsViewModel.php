<?php

namespace Domain\Mail\ViewModels\Blast;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\Models\Blast\Blast;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class GetBlastsViewModel extends ViewModel
{
    /**
     * @return Collection<BlastData>
     */
    public function blasts(): Collection
    {
        return Blast::latest()->get()->map->getData();
    }

    public function performances(): Collection
    {
        /**
         * @return Collection<int, PerformanceData>
         */
        return Blast::all()
            ->mapWithKeys(fn (Blast $blast) => [
                $blast->id => $blast->performance(),
            ]);
    }
}