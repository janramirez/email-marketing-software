<?php

use App\Http\Web\Controllers\Mail\Blast\BlastController;
use App\Http\Web\Controllers\Mail\Blast\PreviewBlastController;
use App\Http\Web\Controllers\Mail\Blast\SendBlastController;
use App\Http\Web\Controllers\ProfileController;
use App\Http\Web\Controllers\Subscriber\ImportSubscribersController;
use App\Http\Web\Controllers\Subscriber\SubscriberController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('subscribers', SubscriberController::class);
    Route::post('subscribers/import', ImportSubscribersController::class);

    Route::patch('blasts/{blast}/send', SendBlastController::class);
    Route::get('blasts/{blast}/preview', PreviewBlastController::class);
    Route::resource('blasts', BlastController::class);
});

require __DIR__ . '/auth.php';
