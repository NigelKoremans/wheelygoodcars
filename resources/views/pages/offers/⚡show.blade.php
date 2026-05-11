<?php

use Livewire\Component;
use App\Models\Car;
use Carbon\Carbon;

new class extends Component
{
    public Car $car;

    public function mount(string $id)
    {
        $this->car = Car::findOrFail($id);
        $this->car->views += 1;
        $this->car->save();
    }

    public function markAsSold()
    {
        if (!auth() || auth()->id() != $this->car->user_id) {
            abort(403, 'Unauthorized');
        }

        $this->car->sold_at = Carbon::now();
        $this->car->save();
    }

    public function render()
    {
        return $this->view()->title("{$this->car->make} {$this->car->model} - Wheely Good Cars!");
    }
};
?>

<div class="w-full py-8 px-8 bg-white" x-data="{ zoomOpen: false, toggle() { this.zoomOpen = !this.zoomOpen } }">
    <div class="border w-full px-4 py-4 border-black space-y-4">
        <h1 class="text-3xl font-bold">{{ ucfirst($car->make) }} {{ ucfirst($car->model) }}</h1>
        <div class="mb-4 border-b border-gray-200">
            <p class="text-sm text-gray-600">Verkoop door: {{ $car->user->name ?? 'Unknown' }}</p>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
            @if($car->image)
            <div class="cursor-zoom-in relative" id="imagecontainer" @click="toggle()">
                @if ($car->sold_at)
                <p class="absolute text-red-400 text-shadow-xs text-shadow-black bottom-25 right-0 left-0 top-25 text-6xl text-center font-bold rotate-16 tracking-widest select-none">VERKOCHT</p>
                @endif
                <img src="{{ asset('storage/images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full aspect-video object-cover rounded shadow-sm">
                <p class="absolute bottom-1 right-2 text-xl aspect-square h-7 text-center bg-white rounded">⛶</p>
            </div>
            @else
            <div class="w-full aspect-video bg-gray-200 flex items-center justify-center rounded shadow-sm">
                @if ($car->sold_at)
                <p class="text-red-400 text-6xl font-bold tracking-widest rotate-16">VERKOCHT</p>
                @else
                <span class="text-gray-500">No image available</span>
                @endif
            </div>
            @endif

            <div class="space-y-2">
                <p class="text-xl font-semibold text-green-600">€ {{ number_format($car->price, 2) }}</p>
                <p><strong>Kenteken:</strong> {{ preg_replace('/([a-zA-Z])(?=[0-9])|([0-9])(?=[a-zA-Z])/', '$1$2-', $car->license_plate) }}</p>
                <p><strong>Kilometerstand:</strong> {{ number_format($car->mileage, 0, ',', '.') }} km</p>
                <p><strong>Jaar van productie:</strong> {{ $car->production_year ?? '-' }}</p>
            </div>

            <div class="space-y-2">
                <p><strong>Kleur:</strong> {{ ucfirst($car->color) ?? '-' }}</p>
                <p><strong>Zitplaatsen:</strong> {{ $car->seats ?? '-' }}</p>
                <p><strong>Deuren:</strong> {{ $car->doors ?? '-' }}</p>
                <p><strong>Massa:</strong> {{ $car->weight ? number_format($car->weight, 0, ',', '.') . ' kg' : '-' }}</p>
            </div>
            <div class="flex flex-col justify-end text-center mt-4 lg:mt-0">
                @if (Auth::user() && $car->user->id == Auth::user()->id)
                @if (!$car->sold_at)
                <button wire:click="markAsSold" type="button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded shadow transition-colors">
                    Markeer als verkocht
                </button>
                @else
                <button disabled class="bg-gray-400 text-white font-bold py-3 px-4 rounded cursor-not-allowed shadow">
                    Gemarkeerd als verkocht
                </button>
                @endif
                @else
                @if (!$car->sold_at)
                <a href="#" class="bg-cyan-800 hover:bg-cyan-700 text-white font-bold py-3 px-4 rounded shadow transition-colors">
                    KOPEN KOPEN KOPEN KOPEN
                </a>
                @else
                <div class="bg-black text-red-500 font-black tracking-widest text-2xl py-3 px-4 rounded shadow border-2 border-red-500">
                    VERKOCHT
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
    @if ($car->image)
        <div x-cloak x-show="zoomOpen" class="top-0 left-0 z-50 w-screen h-screen fixed bg-white/90 cursor-zoom-out" id="imagezoom">
        <div class="flex items-center justify-center w-full h-full p-4">
            <img src="{{ asset('storage/images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-contain drop-shadow-2xl"
                x-on:click="toggle()">
        </div>
    </div>
    @endif

    <script>

        }
    </script>
</div>
