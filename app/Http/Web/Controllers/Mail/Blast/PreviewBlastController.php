<?php

namespace App\Http\Web\Controllers\Mail\Blast;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Blast\Blast;
use Domain\Mail\ViewModels\Blast\PreviewBlastViewModel;
use Inertia\Inertia;
use Inertia\Response;

class PreviewBlastController
{
    public function __invoke(Blast $blast): Response
    {
        return Inertia::render('Blast/Preview', [
            'model' => new PreviewBlastViewModel(new EchoMail($blast)),
        ]);
    }
}