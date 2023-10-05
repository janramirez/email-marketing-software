<?php

namespace Domain\Mail\ViewModels\Blast;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\Models\Blast\Blast;
use Illuminate\Support\Collection;

class GetBlastsViewModel
{
    public function blasts(): Collection
    {
        return Blast::latest()->get()->map->getData();
    }

    public function performances(): Collection
    {
        return Blast::all()
            ->mapWithKeys(fn (Blast $blast) => [
                $blast->id => GetPerformanceAction::execute($blast),
            ]);
    }
}