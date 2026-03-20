<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function start()
    {
        return view('offers.start');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $plate = $request->query('plate');
        $response = Http::get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=" . $plate);

        if ($response->ok() && !empty($response->json())) {
            $car = $response->json()[0];

            $brand = strtolower($car["merk"]);
            $model = $car["handelsbenaming"];
            $seats = $car["aantal_zitplaatsen"];
            $doors = $car["aantal_deuren"];
            $weight = $car["massa_rijklaar"];
            $production_year = substr($car["datum_eerste_toelating"], 0, 4);
            $color = strtolower($car["eerste_kleur"]);

            return view('offers.create', compact('plate', 'brand', 'model', 'seats', 'doors', 'weight', 'production_year', 'color'));
        }
        else if ($response->notFound()) {
            return back()->withErrors(['message' => "Kenteken niet gevonden"]);
        }
        else {
            return redirect()->route("offers.start");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
