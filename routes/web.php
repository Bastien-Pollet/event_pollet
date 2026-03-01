<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicEventController;

Route::get('/', [PublicEventController::class, 'home'])->name('home');
Route::get('/events/{event:slug}', [PublicEventController::class, 'show'])->name('events.show');
Route::post('/events/{event:slug}/register', [PublicEventController::class, 'register'])->name('events.register');