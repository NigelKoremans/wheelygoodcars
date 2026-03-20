<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name("home");

Route::middleware("auth")->group(function () {
    Route::get('/nieuw_aanbod', [OfferController::class, "start"])->name("offers.start")->middleware('auth');
    Route::get('/aanbod_plaatsen', [OfferController::class, "create"])->name("offers.create")->middleware('auth');
    Route::post('/aanbod_plaatsen', [OfferController::class, "store"])->name("offers.store")->middleware('auth');
});
