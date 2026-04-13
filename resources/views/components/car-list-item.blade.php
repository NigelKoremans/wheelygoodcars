<div class="w-full mb-4 py-4 space-y-2">
    <div class="border border-neutral-300 w-full col-span-3"></div>

    <div class="flex justify-between">
        <div>
            <a href="{{ route('offers.show', $car->id)}}" class="text-xl font-bold">{{ ucfirst($car->make) }} {{ ucfirst($car->model) }}</a>
            <p>{{$car->views}} weergaven</p>
        </div>
        @if(request()->routeIs('offers.myoffers'))
        <form action="{{ route('offers.destroy', $car->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class=" text-red-500 hover:text-red-700 cursor-pointer" onclick="return confirm('Weet je zeker dat je dit aanbod wilt verwijderen?')">
                Verwijderen
            </button>
        </form>
        @endif
    </div>
    <div class="grid grid-cols-3 md:grid-cols-3 mt-4">
        <a href="{{ route('offers.show', $car->id)}}">
            @if($car->image)
            <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-auto md:w-auto md:h-28 col-span-2 md:col-span-1 aspect-video object-cover rounded shadow-sm">
            @else
            <div class="w-full h-auto md:w-auto md:h-28 aspect-video bg-gray-200 flex items-center justify-center rounded shadow-sm">
                <span class="text-gray-500">Geen afbeelding</span>
            </div>
            @endif
        </a>

        <div class="">
            <p class="text-xl font-semibold text-green-600">€ {{ number_format($car->price, 2, ',', '.') }}</p>
            <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
            <p><strong>Kilometerstand:</strong> {{ number_format($car->mileage, 0, ',', '.') }} km</p>
            <p><strong>Jaar van productie:</strong> {{ $car->production_year ?? '-' }}</p>
        </div>

        <div class="">
            <p><strong>Kleur:</strong> {{ ucfirst($car->color) ?? '-' }}</p>
            <p><strong>Zitplaatsen:</strong> {{ $car->seats ?? '-' }}</p>
            <p><strong>Deuren:</strong> {{ $car->doors ?? '-' }}</p>
            <p><strong>Massa:</strong> {{ $car->weight ? number_format($car->weight, 0, ',', '.') . ' kg' : '-' }}</p>
        </div>
    </div>
</div>
