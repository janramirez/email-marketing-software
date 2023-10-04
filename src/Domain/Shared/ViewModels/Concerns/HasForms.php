<?php

namespace Domain\Shared\ViewModels\Concerns;

use Domain\Subscriber\Models\Form;
use Illuminate\Support\Collection;

trait HasForms
{
    public function forms(): Collection
    {
        return Form::all()->map->getData();
    }
}