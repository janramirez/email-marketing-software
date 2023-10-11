<?php

namespace Domain\Mail\ViewModels\MailGroup;

use Domain\Mail\DataTransferObjects\MailGroup\MailGroupData;
use Domain\Mail\DataTransferObjects\MailGroup\MailGroupProgressData;
use Domain\Mail\DataTransferObjects\PerformanceData;
use Domain\Mail\Models\MailGroup\MailGroup;
use Domain\Mail\Models\MailGroup\ScheduledMail;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Collection;

class GetSequenceReportsViewModel extends ViewModel
{
    public function __construct(private readonly MailGroup $mail_group)
    {
    }

    public function mailGroup(): MailGroupData
    {
        return $this->mail_group->getData();
    }

    public function totalPerformance(): PerformanceData
    {
        return $this->mail_group->performance();
    }

    public function mailPerformances(): Collection
    {
        return $this->mail_group
            ->mails
            ->mapWithKeys(fn (ScheduledMail $mail) =>[
                $mail->id => $mail->performance()
            ]);
    }

    public function progress(): MailGroupProgressData
    {
        return new MailGroupProgressData(
            total: $this->mail_group->activeSubscriberCount(),
            in_progress: $this->mail_group->inProgressSubscriberCount(),
            completed: $this->mail_group->completedSubscriberCount(),
        );
    }
}