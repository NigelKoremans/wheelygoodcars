<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

new #[Title('Aanbod plaatsen - Wheely Good Cars')]  class extends Component
{
    use WithFileUploads;

    #[Url]
    #[Validate('required|string|min:6|max:6|unique:cars,license_plate')]
    public string $plate = "";
    #[Validate('required|string|max:255')]
    public string $brand = "";
    #[Validate('required|string|max:255')]
    public string $model = "";
    #[Validate('nullable|integer|min:1')]
    public ?int $seats = null;
    #[Validate("nullable|integer|min:1")]
    public ?int $doors = null;
    #[Validate("nullable|integer|min:0")]
    public ?int $weight = null;
    #[Validate('nullable|integer|min:0')]
    public ?int $production_year = null;
    #[Validate('nullable|string|max:255')]
    public string $color = "";
    #[Validate('nullable|integer|min:0')]
    public ?int $mileage = null;
    #[Validate('required|decimal:0,2|min:0|max:99999999')]
    public ?int $price = null;
    #[Validate('nullable|image')]
    public $image;

    public function with(): array
    {
        $response = Http::get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=" . $this->plate);

        if ($response->ok() && !empty($response->json())) {
            $car = $response->json()[0];

            $this->brand = $this->brand ?: ucfirst(strtolower($car["merk"] ?? ''));
            $this->model = $this->model ?: ucfirst(strtolower($car["handelsbenaming"] ?? ''));
            $this->seats = $this->seats ?: ($car["aantal_zitplaatsen"] ?? null);
            $this->doors = $this->doors ?: ($car["aantal_deuren"] ?? null);
            $this->weight = $this->weight ?: ($car["massa_rijklaar"] ?? null);
            $this->production_year = $this->production_year ?: substr($car["datum_eerste_toelating"] ?? '', 0, 4);
            $this->color = $this->color ?: strtolower($car["eerste_kleur"] ?? '');
        }

        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'seats' => $this->seats,
            'doors' => $this->doors,
            'weight' => $this->weight,
            'production_year' => $this->production_year,
            'color' => $this->color,
            'mileage' => $this->mileage,
            'price' => $this->price,
        ];
    }

    public function store()
    {
        $this->validate();

        $filename = null;
        if (isset($this->image)) {
            $filename = str_replace(
                ' ',
                '_',
                $this->image->hashName()
            );

            $this->image->storeAs('images', $filename, 'public');
        }

        auth()->user()->cars()->create([
            'license_plate' => strtoupper($this->plate),
            'image' => $filename,
            'make' => $this->brand,
            'model' => $this->model,
            'price' => $this->price,
            'mileage' => $this->mileage,
            'seats' => $this->seats,
            'doors' => $this->doors,
            'weight' => $this->weight,
            'production_year' => $this->production_year,
            'color' => $this->color,
        ]);

        return redirect()->route("home");
    }
};
?>

<div class="grid grid-cols-3 flex-1 w-full bg-white">
    <div class="col-span-2 col-start-2 py-8 px-10 border-l border-black">
        <h1 class="text-3xl text-white text-shadow-black text-border">Nieuw aanbod</h1>
        <form wire:submit="store" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
            <div wire:key="error-summary" class="mt-3 rounded border border-red-300 bg-red-100 p-2 text-red-800">
                <p class="font-semibold">Controleer je invoer:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="flex justify-between">
                <div>
                    <livewire:license-plate wire:model="plate" :plate="$plate" wire:key="license-plate" />
                    @error('plate')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div x-data="{ imageUrl: null, textVisible: true, errorMsg: null }">
                    <label for="image" class="cursor-pointer">
                        <div class="w-full h-auto md:w-auto md:h-28 aspect-video bg-gray-200 flex items-center justify-center rounded shadow-sm overflow-hidden flex-col">
                            <p x-show="textVisible && !errorMsg" class="px-6 text-center">Afbeelding uploaden</p>
                            <p x-show="errorMsg" x-text="errorMsg" class="px-6 text-center text-red-500 font-semibold"></p>
                            <img x-show="!textVisible && !errorMsg" :src="imageUrl" class="w-full h-full object-contain" alt="Image Preview">
                        </div>
                    </label>
                    <input type="file" wire:model="image" name="image" id="image" accept="image/*" class="h-0 w-0 absolute"
                        x-on:change="
                            const file = $event.target.files[0];
                            if (file) {
                                if (!file.type.startsWith('image/')) {
                                    errorMsg = 'Ongeldig bestand. Kies een afbeelding.';
                                    textVisible = true;
                                    imageUrl = null;
                                    $event.target.value = '';
                                } else {
                                    errorMsg = null;
                                    imageUrl = URL.createObjectURL(file);
                                    textVisible = false;
                                }
                            }
                        "
                    >
                    @error('image')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-3 flex flex-col">
                <label for="Brand" class="text-xl text-neutral-200 text-shadow-black text-border">Merk</label>
                <input class="border border-neutral-400 rounded mt-1 px-1" type="text" wire:model="brand" name="brand" id="brand" required>
                @error('brand')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 flex flex-col">
                <label for="model" class="text-xl text-white text-shadow-black text-border">Model</label>
                <input class="border border-neutral-400 rounded mt-1 px-1" type="text" wire:model="model" name="model" id="model" required>
                @error('model')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-3 gap-2 mt-3">
                <div class="flex flex-col">
                    <label for="seats" class="text-xl text-white text-shadow-black text-border">Zitplaatsen</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="number" wire:model="seats" name="seats" id="seats" required>
                    @error('seats')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label for="doors" class="text-xl text-white text-shadow-black text-border">Aantal deuren</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="number" wire:model="doors" name="doors" id="doors" required>
                    @error('doors')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label for="weight" class="text-xl text-white text-shadow-black text-border">Massa rijklaar</label>
                    <div class="border border-neutral-400 rounded mt-1 flex bg-white">
                        <input class="flex-1 px-1 rounded-l" type="number" wire:model="weight" name="weight" id="weight" required>
                        <p class="px-1 bg-neutral-200 rounded-r">kg</p>
                    </div>
                    @error('weight')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2">
                <div class="flex flex-col">
                    <label for="production_year" class="text-xl text-white text-shadow-black text-border">Jaar van productie</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="number" wire:model="production_year" name="production_year" id="production_year" required>
                    @error('production_year')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label for="color" class="text-xl text-white text-shadow-black text-border">Kleur</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="text" wire:model="color" name="color" id="color" required>
                    @error('color')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-3 flex flex-col">
                <label for="mileage" class="text-xl text-white text-shadow-black text-border">Kilometerstand</label>
                <input class="border border-neutral-400 rounded mt-1 px-1" type="number" wire:model="mileage" name="mileage" id="mileage" required>
                @error('mileage')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 flex flex-col">
                <label for="price" class="text-xl text-white text-shadow-black text-border">Vraagprijs</label>
                <div class="border border-neutral-400 rounded mt-1 flex bg-white">
                    <p class="px-1 bg-neutral-200 rounded-l">€</p>
                    <input class="flex-1 px-1 rounded-r" type="number" wire:model="price" name="price" id="price" step="0.01" required>
                </div>
                @error('price')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 flex flex-col">
                <input class="border rounded p-2 border-neutral-400 text-white text-shadow-black text-border" type="submit" value="Aanbod afronden">
            </div>
        </form>
    </div>
</div>
