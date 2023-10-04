<?php

namespace App\Http\Web\Controllers\Mail\Blast;

use Domain\Mail\Actions\Blast\UpsertBlastAction;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Domain\Mail\DataTransferObjects\Blast\BlastData;
use Domain\Mail\ViewModels\Blast\UpsertBlastViewModel;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class BlastController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Blast/List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Blast/Form',[
            'model' => new UpsertBlastViewModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        BlastData $data,
        Request $request
        ): RedirectResponse {
            UpsertBlastAction::execute($data, $request->user());

            return Redirect::route('blasts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BlastData $data,
        Request $request
    ): RedirectResponse {
        UpsertBlastAction::execute($data, $request->user());

        return Redirect::route('blasts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
