<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name("home");

Route::middleware("auth")->group(function () {
    Route::livewire('/nieuw_aanbod', 'pages::offers.start')->name("offers.start");
    Route::livewire('/aanbod_plaatsen', 'pages::offers.create')->name("offers.create");
    Route::post('/aanbod_plaatsen', [OfferController::class, "store"])->name("offers.store");
    Route::livewire('/mijn_aanbod', 'pages::offers.myoffers')->name("offers.myoffers");
    Route::delete('/aanbod/{id}', [OfferController::class, "destroy"])->name("offers.destroy");
});

Route::livewire('/aanbod_lijst', 'pages::offers.index')->name("offers.index");
Route::livewire('/aanbod/{id}', 'pages::offers.show')->name("offers.show");
