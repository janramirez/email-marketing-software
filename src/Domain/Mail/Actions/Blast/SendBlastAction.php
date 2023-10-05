<?php

namespace Domain\Mail\Actions\Blast;

use Domain\Mail\Exceptions\CannotSendBlast;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Blast\Blast;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBlastAction
{
    public static function execute(Blast $blast): int
    {
        /**
         * check if email blast already sent,
         * throw an exception if so
         */
        if (!$blast->status->canSend()) {
            throw CannotSendBlast::because(
                "Email blast already sent at {$blast->sent_at}"
            );
        }

        /**
         * filter subscribers based on blast filters,
         * then send email
         */
        $subscribers = FilterSubscribersAction::execute($blast)
            ->each(fn (Subscriber $subscriber) =>
                Mail::to($subscriber)->queue(new EchoMail($blast))
            );
        
        /**
         * Mark email as sent
         */
        $blast->markAsSent();

        /**
         * create a record for each mail that has been sent to sent_mails table
         */
        return $subscribers->each(fn (Subscriber $subscriber) =>
            $blast->sent_mails()->create([
                'subscriber_id' => $subscriber->id,
                'user_id' => $blast->user->id,
            ])
        )->count();
    }
}