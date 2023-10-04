<?php

namespace Domain\Mail\Actions\Blast;

use Domain\Mail\DataTransferObjects\Blast\BlastData;
use Domain\Mail\Models\Blast\Blast;
use Domain\Shared\Models\User;

class UpsertBlastAction
{
    public static function execute(BlastData $data, User $user): Blast
    {
        return Blast::updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->all(),
                'user_id' => $user->id,
            ],
        );
    }
}