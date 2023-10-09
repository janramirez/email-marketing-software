<?php

namespace Domain\Subscriber\Builders;

use Domain\Mail\Models\MailGroup\ScheduledMail;
use Illuminate\Database\Eloquent\Builder;

class SubscriberBuilder extends Builder
{
    public function alreadyReceived(ScheduledMail $mail): bool
    {
        return $this->model->received_mails()->whereSendable($mail)->exists();
    }
}