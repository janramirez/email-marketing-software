<?php

namespace App\Http\Web\Controllers\Mail\Blast;

use Domain\Mail\Actions\Blast\UpsertBlastAction;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Domain\Mail\DataTransferObjects\Blast\BlastData;
use Domain\Mail\ViewModels\Blast\GetBlastsViewModel;
use Domain\Mail\ViewModels\Blast\UpsertBlastViewModel;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class BlastController
{

    public function index(): Response
    {
        return Inertia::render('Blast/List', [
            'model' => new GetBlastsViewModel(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Blast/Form',[
            'model' => new UpsertBlastViewModel(),
        ]);
    }

    public function store(
        BlastData $data,
        Request $request
        ): RedirectResponse {
            UpsertBlastAction::execute($data, $request->user());

            return Redirect::route('blasts.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(
        BlastData $data,
        Request $request
    ): RedirectResponse {
        UpsertBlastAction::execute($data, $request->user());

        return Redirect::route('blasts.index');
    }

    public function destroy(string $id)
    {
        //
    }
}
