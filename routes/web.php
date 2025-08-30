<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckinController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/events', [PublicController::class, 'events'])->name('events');
Route::get('/events/{id}', [PublicController::class, 'showEvent'])->name('events.show');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

// Public Registration Routes
Route::get('/events/{eventId}/register', [RegistrationController::class, 'register'])->name('events.register');
Route::post('/events/{eventId}/register', [RegistrationController::class, 'storePublic'])->name('events.register.store');
Route::get('/registration/success/{registrationId}', [RegistrationController::class, 'success'])->name('registration.success');

// Auth Routes
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Events Management
    Route::resource('events', EventController::class);
    Route::patch('events/{id}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::patch('events/{id}/unpublish', [EventController::class, 'unpublish'])->name('events.unpublish');
    
    // Event Participants
    Route::get('events/{eventId}/participants', [AdminController::class, 'eventParticipants'])->name('events.participants');
    Route::get('events/{eventId}/participants/print', [AdminController::class, 'printParticipants'])->name('events.participants.print');

    // Check-in Management
    Route::get('checkin', [CheckinController::class, 'index'])->name('checkin.index');
    Route::get('checkin/{eventId}', [CheckinController::class, 'event'])->name('checkin.event');
    Route::post('checkin/{eventId}/search', [CheckinController::class, 'search'])->name('checkin.search');
    Route::post('checkin/{eventId}/checkin', [CheckinController::class, 'checkIn'])->name('checkin.checkin');
    Route::get('checkin/{eventId}/stats', [CheckinController::class, 'stats'])->name('checkin.stats');

    // Registrations Management
    Route::delete('registrations/bulk-delete', [RegistrationController::class, 'bulkDelete'])->name('registrations.bulk-delete');
    Route::resource('registrations', RegistrationController::class);
    Route::patch('registrations/{id}/confirm', [RegistrationController::class, 'confirm'])->name('registrations.confirm');
    Route::patch('registrations/{id}/cancel', [RegistrationController::class, 'cancel'])->name('registrations.cancel');
    
    // WhatsApp Management
    Route::get('whatsapp', [App\Http\Controllers\Admin\WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::get('whatsapp/event/{event}/messages', [App\Http\Controllers\Admin\WhatsAppController::class, 'eventMessages'])->name('whatsapp.event.messages');
    Route::post('whatsapp/registration/{registration}/confirm', [App\Http\Controllers\Admin\WhatsAppController::class, 'sendConfirmation'])->name('whatsapp.confirm');
    Route::post('whatsapp/event/{event}/reminders', [App\Http\Controllers\Admin\WhatsAppController::class, 'sendReminders'])->name('whatsapp.reminders');
    Route::post('whatsapp/message/{message}/retry', [App\Http\Controllers\Admin\WhatsAppController::class, 'retryMessage'])->name('whatsapp.retry');
    Route::get('whatsapp/stats', [App\Http\Controllers\Admin\WhatsAppController::class, 'stats'])->name('whatsapp.stats');
    Route::get('whatsapp/fonnte-info', [App\Http\Controllers\Admin\WhatsAppController::class, 'getFonnteInfo'])->name('whatsapp.fonnte.info');
});

require __DIR__.'/auth.php';
