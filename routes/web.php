<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name("home");

Route::middleware("auth")->group(function () {
    Route::get('/nieuw_aanbod', [OfferController::class, "start"])->name("offers.start");
    Route::get('/aanbod_plaatsen', [OfferController::class, "create"])->name("offers.create");
    Route::post('/aanbod_plaatsen', [OfferController::class, "store"])->name("offers.store");
    Route::get('/mijn_aanbod', [OfferController::class, "myOffers"])->name("offers.myoffers");
    Route::delete('/aanbod/{id}', [OfferController::class, "destroy"])->name("offers.destroy");
});

Route::get('/aanbod_lijst', [OfferController::class, "index"])->name("offers.index");
Route::get('/aanbod/{id}', [OfferController::class, "show"])->name("offers.show");
