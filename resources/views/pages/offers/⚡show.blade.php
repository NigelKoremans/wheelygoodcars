<?php

use Livewire\Component;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\Validate;

new class extends Component
{
    public Car $car;
    #[Validate('required|decimal:0,2|min:0|max:99999999')]
    public float $price;
    public int $recentViews;

    public function mount(string $id)
    {
        $this->car = Car::findOrFail($id);

        RateLimiter::attempt(
            'register-view:' . $this->car->id . ":" . request()->ip(),
            1,
            function () {
                $this->car->views += 1;
                $this->car->save();

                Redis::incr('views:' . $this->car->id);

                if (Redis::ttl('views:' . $this->car->id) == -1) {
                    Redis::expire('views:' . $this->car->id, 86400);
                }
            },
            3600 // 1 view per car per user (ip) per hour
        );
        $this->recentViews = Redis::get('views:' . $this->car->id);
        $this->price = $this->car->price;
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

    public function changePrice()
    {
        if (!auth() || auth()->id() != $this->car->user_id) {
            $this->addError('price', "You are not authorized to change the price");
        }

        if ($this->car->sold_at) {
            $this->addError('price', 'You cannot change the price of a sold car.');
            return;
        }

        $this->validate();
        $this->car->price = $this->price;
        $this->car->save();
        $this->dispatch('price-saved');
    }
};
?>

<div class="w-full py-8 px-8 bg-white" x-data="{ zoomOpen: false, toggleZoom() { this.zoomOpen = !this.zoomOpen } }">

    <div class="border border-black w-full px-4 py-4 space-y-4">
        <div class="flex space-x-5">
            <h1 class="text-4xl font-bold">{{ ucfirst($car->make) }} {{ ucfirst($car->model) }}</h1>
            <div x-data="{show: false}"
                x-init="setTimeout(() => show = true, 1000)"
                x-show="show"
                x-cloak
                class="border border-amber-400 flex-1 px-4 py-1 text-xl text-amber-400 bg-amber-50">
                <span class="font-bold">{{ $recentViews }}</span>{{ " klanten bekeken deze auto vandaag!" }}
            </div>
        </div>
        <div class="mb-4 border-b border-gray-200">
            <p class="text-sm text-gray-600">Verkoop door: {{ $car->user->name ?? 'Unknown' }}</p>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
            @if($car->image)
            <div class="cursor-zoom-in relative" id="imagecontainer" @click="toggleZoom()">
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

            <div class="space-y-2" x-data="
            {
            editOpen: false,
            saved: false,
            toggleEdit()
            {
                this.saved = false;
                this.editOpen = !this.editOpen;
                setTimeout(function() {document.getElementById('price').focus()},0);
            }
            }"
                x-on:price-saved.window="saved = true; editOpen = false">
                <div class="text-xl font-semibold text-green-600">
                    @if (Auth::user() && $car->user->id == Auth::user()->id && !$car->sold_at)
                    <button class="cursor-pointer text-gray-500 text-sm" @click="toggleEdit()">✎</button>
                    @endif
                    €
                    <span x-show="!editOpen" id="pricedisplay">{{ number_format($car->price, 2, ',', '.') }}</span>
                    <span x-cloak x-show="saved" class="ml-2 text-sm font-medium text-green-700">Saved</span>
                    <div x-cloak x-show="editOpen" class="inline">
                        <input class="rounded border border-black w-32 text-xl font-semibold text-green-600" wire:model="price" type="number" name="price" id="price" step="0.01">
                        <button class="text-green-600 cursor-pointer" wire:click="changePrice()">✓</button>
                        <button class="text-red-600 cursor-pointer" @click="toggleEdit()">✗</button>
                    </div>
                    @error('price')
                    <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>



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
                x-on:click="toggleZoom()">
        </div>
    </div>
    @endif
</div>
