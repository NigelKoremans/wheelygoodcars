<?php

use App\Models\Car;
use Livewire\Component;

new class extends Component
{
    public Car $car;
    public bool $featured;
};
?>

<div class="bg-white rounded-lg shadow-md hover:shadow-xl border border-neutral-200 overflow-hidden transform hover:-translate-y-1 transition duration-200 flex flex-col @if($featured) md:col-span-2 @endif">
    <div class="relative h-56 bg-neutral-200 shrink-0">
        @if($car->image)
        <img src="{{ asset('storage/images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover">
        @else
        <div class="w-full h-full flex flex-col items-center justify-center text-neutral-500 bg-neutral-100">
            <svg class="w-12 h-12 mb-2 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Geen afbeelding</span>
        </div>
        @endif

        <div class="absolute bottom-4 left-4 bg-neutral-900 text-white px-4 py-1.5 rounded font-bold shadow-lg border border-neutral-700">
            € {{ number_format($car->price, 2, ',', '.') }}
        </div>
    </div>

    <div class="p-6 flex flex-col grow">
        <div class="mb-4 grow">
            <div class="text-xs text-neutral-500 font-semibold tracking-wider uppercase mb-1">{{ $car->make }}</div>
            <h3 class="text-xl font-bold text-neutral-900 leading-tight">{{ $car->model }}</h3>
        </div>

        <div class="grid grid-cols-2 gap-y-3 text-sm text-neutral-600 mb-6">
            <div class="flex items-center" title="Bouwjaar">
                <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $car->production_year ?: 'N/B' }}
            </div>
            <div class="flex items-center" title="Kilometerstand">
                <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                {{ number_format($car->mileage, 0, ',', '.') }} km
            </div>
            <div class="flex items-center" title="Aantal deuren">
                <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8,15h2M5,21H19a1,1,0,0,0,1-1V11.41a1,1,0,0,0-.29-.7L12.29,3.29a1,1,0,0,0-.7-.29H5A1,1,0,0,0,4,4V20A1,1,0,0,0,5,21ZM4,11H19.9" />
                </svg>
                {{ $car->doors ?: '?' }} deuren
            </div>
            <div class="flex items-center" title="Zitplaatsen">
                <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ $car->seats ?: '?' }} zitplaatsen
            </div>
        </div>
        <a href="{{ route('offers.show', $car->id) }}" wire:navigate class="block w-full text-center bg-neutral-900 border border-black hover:bg-neutral-800 text-white font-semibold py-2.5 rounded transition-colors shadow">
            Bekijk details
        </a>
    </div>
</div>
