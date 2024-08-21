<?php

use App\Http\Controllers\BlockController;
use App\Http\Controllers\ImageBlockFieldController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UpdateBlockOrderController;
use App\Http\Middleware\OnboardingRequired;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    //
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'pages' => Auth::user()->pages()->with('blocks')->get(),
        ]);
    })->name('dashboard')->middleware(OnboardingRequired::class);

    Route::resource('pages', PageController::class);
    Route::resource('onboarding', OnboardingController::class);
    Route::resource('pages.blocks', BlockController::class)->only(['update', 'edit', 'store']);
    Route::post('pages.blocks.order', UpdateBlockOrderController::class)->name('blocks.order.update');
    Route::post('pages.blocks.upload-image', [ImageBlockFieldController::class, 'store'])->name('blocks.upload-image');
    Route::delete('pages.blocks.delete-image', [ImageBlockFieldController::class, 'destroy'])->name('blocks.delete-image');
    Route::put('/pages/{page}/blocks/{block}/settings', [BlockController::class, 'updateSettings'])
        ->name('pages.blocks.update-settings');
    Route::put('/pages/{page}/update-theme', [PageController::class, 'updateTheme'])->name('pages.update-theme');
});