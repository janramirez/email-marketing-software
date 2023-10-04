<?php

namespace Domain\Shared\ViewModels\Concerns;

use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Collection;

trait HasTags
{
    public function tags(): Collection
    {
        return Tag::all()->map->getData();
    }
}