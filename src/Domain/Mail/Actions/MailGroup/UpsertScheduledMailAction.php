<?php

namespace Domain\Mail\Actions\MailGroup;

use Domain\Mail\DataTransferObjects\MailGroup\ScheduledMailData;
use Domain\Mail\Models\MailGroup\MailGroup;
use Domain\Shared\Models\User;

class UpsertScheduledMailAction
{
    public static function execute(ScheduledMailData $data, MailGroup $mailgroup, User $user): MailGroup
    {
        $mail = $mailgroup->mails()->updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->toArray(),
                'user_id' => $user->id,
            ]
        );

        $mail->schedule()->updateOrCreate(
            [
                'id' => $data->schedule->id,
            ],
            [
                ...$data->schedule->toArray(),
                'user_id' => $user->id,
            ]
        );
        
        return $mail->load(['mailgroup', 'schedule']);
    }
}