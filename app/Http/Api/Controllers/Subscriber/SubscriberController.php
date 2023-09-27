<?php

namespace App\Http\Api\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubscriberController
{
    public function store(
        SubscriberData $data,
        Request $request
    ): RedirectResponse {
        UpsertSubscriberAction::execute($data, $request->user());

        return Redirect::route('subscribers.index');
    }

    public function update(
        SubscriberData $data,
        Request $request
    ): RedirectResponse {
        UpsertSubscriberAction::execute($data, $request->user());

        return Redirect::route('subscribers.index');
    }
}