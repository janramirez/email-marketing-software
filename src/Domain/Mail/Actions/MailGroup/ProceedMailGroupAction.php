<?php

namespace Domain\Mail\Actions\MailGroup;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\MailGroup\MailGroup;
use Domain\Mail\Models\MailGroup\ScheduledMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class ProceedMailGroupAction
{
    public static function execute(MailGroup $mailgroup): int
    {
        $sentMailCount = 0;

        foreach ($mailgroup->mails()->wherePublished()->get() as $mail) {
            $subscribers = self::subscribers($mail);

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber)->queue(new EchoMail($mail));

                $mail->sent_mails()->create([
                    'subscriber_id' => $subscriber->id,
                    'user_id' => $mailgroup->user->id,
                ]);
            }

            $sentMailCount += $subscribers->count();
        }

        return $sentMailCount;
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
}