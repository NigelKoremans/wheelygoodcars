<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Car::paginate(10);

        return view("offers.index")->with("offers", $offers);
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
        $plate = $request->query('plate').toUpperCase();
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
        $validated = $request->validate([
            'plate' => 'required|string|max:8|unique:cars,license_plate',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|decimal:0,2|min:0',
            'mileage' => 'required|integer|min:0',
            'seats' => 'nullable|integer|min:1',
            'doors' => 'nullable|integer|min:1',
            'weight' => 'nullable|integer|min:0',
            'production_year' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:255',
        ]);

        $request->user()->cars()->create([
            'license_plate' => $validated['plate'].ToUpperCase(),
            'make' => $validated['brand'],
            'model' => $validated['model'],
            'price' => $validated['price'],
            'mileage' => $validated['mileage'],
            'seats' => $validated['seats'],
            'doors' => $validated['doors'],
            'weight' => $validated['weight'],
            'production_year' => $validated['production_year'],
            'color' => $validated['color'],
        ]);

        return redirect()->route("home");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        $poster = $car->user()->get();

        return view("offers.show")->with("car", $car)->with("poster", $poster);
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

    public function myOffers()
    {
        $user = Auth::user();
        $offers = Car::all()->where("user_id", "==", $user->id);

        return view("offers.myoffers")->with("offers", $offers);
    }
}
