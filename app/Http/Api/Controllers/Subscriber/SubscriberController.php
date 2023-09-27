<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class SubscriberContoller extends Controller
{
    public function store(
        SubscriberData $data,
        Request $request
    ): RedirectResponse {
        UpsertSubscriberAction::execute($data, $request->user());

        return Redirect::route('subscribers.index');
    }
}