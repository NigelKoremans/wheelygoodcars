<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Car;

new #[Title('Alle Auto\'s - Wheely Good Cars!')] class extends Component
{
    use WithPagination;

    public function with(): array
    {
        return [
            'offers' => Car::whereNull("sold_at")->latest()->paginate(10),
        ];
    }
};
?>

<div class="w-full py-8 px-8">
    <h1 class="font-bold text-3xl py-4">Alle Auto's</h1>
    <div class="border w-full bg-white">
        @forelse ($offers as $car)
        <x-car-list-item :$car />
        @empty
        <div class="p-6 text-center text-gray-600">
            <p class="text-lg font-medium">Er zijn nog geen auto's toegevoegd.</p>
        </div>
        @endforelse
    </div>
    {{ $offers->links() }}
</div>
