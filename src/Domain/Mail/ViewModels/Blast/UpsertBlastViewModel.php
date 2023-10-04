<?php

namespace Domain\Mail\ViewModels\Blast;

use Domain\Mail\DataTransferObjects\Blast\BlastData;
use Domain\Mail\Models\Blast\Blast;
use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;

class UpsertBlastViewModel extends ViewModel
{
    use HasTags, HasForms;

    public function __construct(
        public readonly ?Blast $blast = null
    ) {}

    public function blast(): ?BlastData
    {
        if(!$this->blast) {
            return null;
        }

        return $this->blast->getData();
    }
}