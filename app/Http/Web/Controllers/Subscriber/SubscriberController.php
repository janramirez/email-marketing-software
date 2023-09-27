<?php

namespace App\Http\Web\Controllers\Subscriber;

use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\ViewModels\UpsertSubscriberViewModel;
use Inertia\Inertia;
use Inertia\Response;

class SubscriberController
{
    public function create(): Response
    {
        return Inertia::render('Subscriber/Form', [
            'model' => new UpsertSubscriberViewModel(),
        ]);
    }

    public function edit(Subscriber $subscriber): Response
    {
        return Inertia::render('Subscriber/Form', [
            'model' => new UpsertSubscriberViewModel($subscriber),
        ]);
    }
}