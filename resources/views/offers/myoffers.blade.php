<x-app-layout>
    <div class="w-full py-8 px-8">
        <div class="border w-full p-4 space-y-4">
            <h1 class="font-bold text-3xl">Mijn aanbod</h1>
            @foreach ($offers as $car)
                <x-car-list-item :$car/>
            @endforeach
        </div>
    </div>
</x-app-layout>
