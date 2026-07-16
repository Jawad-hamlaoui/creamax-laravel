<?php

use App\Http\Controllers\CalendarFeedController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\PublicController;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/mentions-legales', [PublicController::class, 'mentionsLegales'])->name('mentions-legales');

Route::get('/calendrier/{token}.ics', [CalendarFeedController::class, 'show'])->name('calendrier.feed');

Route::post('/contact', [ContactMessageController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:5,1');

Route::get('/admin/contact-messages/{contactMessage}/audio', function (ContactMessage $contactMessage) {
    abort_unless($contactMessage->audio_path, 404);

    return Storage::disk('local')->response($contactMessage->audio_path);
})
    ->middleware(['web', 'auth'])
    ->name('admin.contact-messages.audio');
