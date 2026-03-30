<x-app-layout>
    <div class="grid grid-cols-3 flex-1 w-full">
        <div class="col-span-2 col-start-2 py-8 px-10 border-l border-black">
            <h1 class="text-3xl text-white text-shadow-black text-border">Nieuw aanbod</h1>
            <form action="{{ route('offers.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="mt-3 rounded border border-red-300 bg-red-100 p-2 text-red-800">
                        <p class="font-semibold">Controleer je invoer:</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <x-license-plate :$plate />
                @error('plate')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <div class="mt-3 flex flex-col">
                    <label for="Brand" class="text-xl text-neutral-200 text-shadow-black text-border">Merk</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="text" name="brand" id="brand" value="{{ old('brand') ?? $brand }}" required>
                    @error('brand')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3 flex flex-col">
                    <label for="model" class="text-xl text-white text-shadow-black text-border">Model</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="text" name="model" id="model" value="{{ old('model') ?? $model }}" required>
                    @error('model')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-3 gap-2 mt-3">
                    <div class="flex flex-col">
                        <label for="seats" class="text-xl text-white text-shadow-black text-border">Zitplaatsen</label>
                        <input class="border border-neutral-400 rounded mt-1 px-1" type="number" name="seats" id="seats" value="{{ old('seats') ?? $seats }}" required>
                        @error('seats')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="doors" class="text-xl text-white text-shadow-black text-border">Aantal deuren</label>
                        <input class="border border-neutral-400 rounded mt-1 px-1" type="number" name="doors" id="doors" value="{{ old('doors') ?? $doors }}" required>
                        @error('doors')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="weight" class="text-xl text-white text-shadow-black text-border">Massa rijklaar</label>
                        <div class="border border-neutral-400 rounded mt-1 flex">
                            <input class="flex-1 px-1" type="number" name="weight" id="weight" value="{{ old('weight') ?? $weight }}" required>
                            <p class="px-1 bg-neutral-200">kg</p>
                        </div>
                        @error('weight')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="production_year" class="text-xl text-white text-shadow-black text-border">Jaar van productie</label>
                        <input class="border border-neutral-400 rounded mt-1 px-1" type="number" name="production_year" id="production_year" value="{{ old('production_year') ?? $production_year }}" required>
                        @error('production_year')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="color" class="text-xl text-white text-shadow-black text-border">Kleur</label>
                        <input class="border border-neutral-400 rounded mt-1 px-1" type="text" name="color" id="color" value="{{ old('color') ?? $color }}" required>
                        @error('color')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 flex flex-col">
                    <label for="mileage" class="text-xl text-white text-shadow-black text-border">Kilometerstand</label>
                    <input class="border border-neutral-400 rounded mt-1 px-1" type="number" name="mileage" id="mileage" value="{{ old('mileage') }}" required>
                    @error('mileage')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3 flex flex-col">
                    <label for="price" class="text-xl text-white text-shadow-black text-border">Vraagprijs</label>
                    <div class="border border-neutral-400 rounded mt-1 flex">
                        <p class="px-1 bg-neutral-200">€</p>
                        <input class="flex-1 px-1" type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" required>
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
</x-app-layout>
