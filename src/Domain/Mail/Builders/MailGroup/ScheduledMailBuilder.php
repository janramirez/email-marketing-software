<?php

namespace Domain\Mail\Builders\MailGroup;

use Domain\Mail\Enums\MailGroup\ScheduledMailStatus;
use Illuminate\Database\Eloquent\Builder;

class ScheduledMailBuilder extends Builder
{
    public function wherePublished(): self
    {
        return $this->whereStatus(ScheduledMailStatus::Published);
    }
}