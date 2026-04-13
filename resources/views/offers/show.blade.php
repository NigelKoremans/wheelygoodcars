<x-app-layout>
    <div class="w-full py-8 px-8">
        <div class="border w-full px-4 py-4 border-black space-y-4">
            <h1 class="text-3xl font-bold">{{ ucfirst($car->make) }} {{ ucfirst($car->model) }}</h1>
            <div class="mb-4 border-b border-gray-200">
                <p class="text-sm text-gray-600">Verkoop door: {{ $car->user->name ?? 'Unknown' }}</p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
                @if($car->image)
                <div class="cursor-zoom-in relative"  id="imagecontainer">
                    <img src="{{ asset('storage/images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full aspect-video object-cover rounded shadow-sm">
                    <p class="absolute bottom-1 right-2 text-xl aspect-square h-7 text-center bg-white rounded">⛶</p>
                </div>
                @else
                <div class="w-full aspect-video bg-gray-200 flex items-center justify-center rounded shadow-sm">
                    <span class="text-gray-500">No image available</span>
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
                <a href="" class="bg-cyan-800 text-white">KOPEN KOPEN KOPEN KOPEN</a>
            </div>
        </div>
    </div>
    @if ($car->image)
    <div class="hidden top-0 left-0 z-50 w-screen h-screen fixed bg-white/90 cursor-zoom-out" id="imagezoom">
        <div class="flex items-center justify-center w-full h-full p-4">
            <img src="{{ asset('storage/images/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-contain drop-shadow-2xl">
        </div>
    </div>
    @endif

    <script>
        const image = document.getElementById("imagecontainer");
        const imagezoom = document.getElementById("imagezoom")

        if (image) {
            imagezoom.onclick = () => imagezoom.classList.toggle("hidden");
            image.onclick = () => imagezoom.classList.toggle("hidden");
        }
    </script>
</x-app-layout>
