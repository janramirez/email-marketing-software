<?php

namespace Domain\Subscriber\Builders;

use Domain\Mail\Models\MailGroup\ScheduledMail;
use Domain\Shared\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;

class SubscriberBuilder extends Builder
{
    public function alreadyReceived(ScheduledMail $mail): bool
    {
        return $this->model->received_mails()->whereSendable($mail)->exists();
    }

    public function whereSubscribedBetween(DateFilter $dateFilter): self
    {
        return $this->whereBetween('subscribed_at', $dateFilter->toArray());
    }
}