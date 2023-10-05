<?php

namespace App\Http\Web\Controllers\Mail\Blast;

use Domain\Mail\Jobs\Blast\SendBlastJob;
use Domain\Mail\Models\Blast\Blast;
use Illuminate\Http\Response;

class SendBlastController
{
    public function __invoke(Blast $blast): Response
    {
        SendBlastJob::dispatch($blast);

        return response('', Response::HTTP_ACCEPTED);
    }
}
