<?php

namespace Domain\Mail\Actions\MailGroup;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\MailGroup\MailGroup;
use Domain\Mail\Models\MailGroup\ScheduledMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedMailGroupAction
{
    private static array $mailsBySubscribers = [];

    public static function execute(MailGroup $mailgroup): void
    {
        foreach ($mailgroup->mails()->wherePublished()->get() as $mail) {
            [$audience, $schedulableAudience] = self::audience($mail);

            self::sendMails($schedulableAudience, $mail, $mailgroup);

            self::addMailToAudience($audience, $mail);

            self::markAsInProgress($mailgroup, $schedulableAudience);
        }

        self::markAsCompleted($mailgroup);
    }

    public static function subscribers(ScheduledMail $mail): Collection
    {
        // Check if scheduled mail should be sent today using the ScheduledMail Model helper method: shouldSendToday()
        if (!$mail->shouldSendToday()) {
            return collect([]);
        }

        return $mail->audience()
            ->reject->alreadyReceived($mail)
            ->reject->tooEarlyFor($mail);
    }

    /**
     * @param MailGroup $mailgroup
     * @param Collection<Subscriber> $schedulableAudience
     * @return void
     */
    public static function markAsInProgress(MailGroup $mailgroup, Collection $schedulableAudience): void
    {

        $mailgroup->subscribers
            ->whereIn('subscriber_id', $schedulableAudience->pluck('id'))
            ->update(['status' => SubscriberStatus::InProgress]);
    }
}