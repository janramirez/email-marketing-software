<?php

namespace Domain\Mail\Actions\MailGroup;

use Domain\Shared\Models\User;
use Illuminate\Support\Facades\DB;
use Domain\Mail\Models\MailGroup\MailGroup;
use Domain\Mail\DataTransferObjects\MailGroup\MailGroupData;
use Domain\Mail\DataTransferObjects\MailGroup\ScheduledMailData;
use Domain\Subscriber\Models\Subscriber;

class CreateMailGroupAction
{
    public static function execute(MailGroupData $data, User $user): MailGroup
    {
        return DB::transaction( function () use ($data, $user) {
            $mailgroup = MailGroup::create([
                ...$data->all(),
                'user_id' => $user->id,
            ]);


            UpsertScheduledMailAction::execute(
                ScheduledMailData::dummy(),
                $mailgroup,
                $user
            );

            $mailgroup->subscribers()->sync(
                Subscriber::select('id')->pluck('id')
            );

            return $mailgroup;
        });
    }
}