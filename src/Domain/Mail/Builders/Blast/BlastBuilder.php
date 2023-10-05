<?php

namespace Domain\Mail\Builders\Blast;

use Domain\Mail\Enums\Blast\BlastStatus;
use Illuminate\Database\Eloquent\Builder;

class BlastBuilder extends Builder
{
    public function markAsSent(): void
    {
        $this->model->status = BlastStatus::Sent;
        $this->model->sent_at = now();
        $this->model->save();
    }
}