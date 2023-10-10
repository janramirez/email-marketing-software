<?php

namespace Domain\Mail\Actions\MailGroup;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\MailGroup\MailGroup;
use Domain\Mail\Models\MailGroup\ScheduledMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
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
     * return [
     *          array $audience = array of all audience of the scheduled mail,
     *          array $schedulableAudience = array of subscribers, filtered from $audience, who should receive the scheduled mail today.
     *        ]
     */
    private static function audience(ScheduledMail $mail): array
    {
        $audience = $mail->audience();

        if(!$mail->shouldSendToday()) {
            return [$audience, collect([])];
        }

        $schedulableAudience = $audience
            ->reject->alreadyReceived($mail)
            ->reject->tooEarlyFor($mail);
        
        return [$audience, $schedulableAudience];
    }

    /**
     * Sends scheduled mail to each subscriber in $schedulableAudience collection
     */
    private static function sendMails(
        Collection $schedulableAudience, 
        ScheduledMail $mail, 
        MailGroup $mailgroup
    ): void {
        foreach ($schedulableAudience as $subscriber) {
            Mail::to($subscriber)->queue(new EchoMail($mail));

            $mail->sent_mails()->create([
                'subscriber_id' => $subscriber->id,
                'user_id' => $mailgroup->user->id,
            ]);
        }
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

    /**
     * This maintains a record of which scheduled mails are sent to which subscribers
     * $mailsBySubscribers = [
     *                          'subscriber_id' => [mail1_id, mail2_id]
     *                          '1' => [1, 2],
     *                          '4' => [1, 3, 4],
     *                      ]
     */
    private static function addMailToAudience(
        Collection $audience, 
        ScheduledMail $mail
    ): void {
        foreach($audience as $subscriber) {
            if(!Arr::get(self::$mailsBySubscribers, $subscriber->id)) {
                self::$mailsBySubscribers[$subscriber->id] = [];
            }

            self::$mailsBySubscribers[$subscriber->id][] = $mail->id;
        }
    }
}