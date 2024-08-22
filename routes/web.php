<?php

use App\Http\Controllers\BlockController;
use App\Http\Controllers\ImageBlockFieldController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UpdateBlockOrderController;
use App\Http\Middleware\OnboardingRequired;
use App\Http\Middleware\PageNotPublished;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/pages/{page}', [PageController::class, 'show'])->name('pages.show')->middleware(PageNotPublished::class);

Route::get('/page-not-published', function () {
    return Inertia::render('Pages/NotPublished');
})->name('pages.not.published');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /*
    * Onboarding
    */
    Route::resource('onboarding', OnboardingController::class)->only(['index', 'store']);

    /*
    * Dashboard
    */
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'pages' => Auth::user()->pages()->with('blocks')->get(),
        ]);
    })->name('dashboard')->middleware(OnboardingRequired::class);


    /*
    * Pages and Blocks
    */
    Route::resource('pages', PageController::class)->only(['create', 'edit', 'show']);
    Route::resource('pages.blocks', BlockController::class)->only(['update', 'edit', 'store']);
    Route::put('/pages/{page}/blocks/{block}/settings', [BlockController::class, 'updateSettings'])->name('pages.blocks.update-settings');
    Route::post('pages.blocks.order', UpdateBlockOrderController::class)->name('blocks.order.update');
    // Theme
    Route::put('/pages/{page}/update-theme', [PageController::class, 'updateTheme'])->name('pages.update-theme');
    // Images
    Route::post('pages.blocks.upload-image', [ImageBlockFieldController::class, 'store'])->name('blocks.upload-image');
    Route::delete('pages.blocks.delete-image', [ImageBlockFieldController::class, 'destroy'])->name('blocks.delete-image');
});