<x-app-layout>
    <div class="w-full py-8 px-8">
        <div class="border w-full px-4 py-4 border-black space-y-4">
            <h1 class="text-3xl font-bold">{{ ucfirst($car->make) }} {{ ucfirst($car->model) }}</h1>
            <div class="mb-4 border-b border-gray-200">
                <p class="text-sm text-gray-600">Listed by: {{ $car->user->name ?? 'Unknown' }}</p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
                @if($car->image)
                <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full aspect-video object-cover rounded shadow-sm">
                @else
                <div class="w-full aspect-video bg-gray-200 flex items-center justify-center rounded shadow-sm">
                    <span class="text-gray-500">No image available</span>
                </div>
                @endif

                <div class="space-y-2">
                    <p class="text-xl font-semibold text-green-600">€ {{ number_format($car->price, 2) }}</p>
                    <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
                    <p><strong>Kilometerstand:</strong> {{ number_format($car->mileage) }} km</p>
                    <p><strong>Jaar van productie:</strong> {{ $car->production_year ?? '-' }}</p>
                </div>

                <div class="space-y-2">
                    <p><strong>Kleur:</strong> {{ ucfirst($car->color) ?? '-' }}</p>
                    <p><strong>Zitplaatsen:</strong> {{ $car->seats ?? '-' }}</p>
                    <p><strong>Deuren:</strong> {{ $car->doors ?? '-' }}</p>
                    <p><strong>Massa:</strong> {{ $car->weight ? $car->weight . ' kg' : '-' }}</p>
                </div>
                <a href="" class="bg-cyan-800 text-white">KOPEN KOPEN KOPEN KOPEN</a>
            </div>
        </div>
    </div>
</x-app-layout>
