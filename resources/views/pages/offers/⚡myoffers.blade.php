<?php

use App\Models\Car;
use Livewire\Component;

new class extends Component
{
    public function with(): array
    {
        $user = Auth::user();
        return [
            'offers' => Car::where('user_id', $user->id)->latest()->paginate(10),
        ];
    }
};
?>

<div class="w-full py-8 px-8">
    <h1 class="font-bold text-3xl py-4">Mijn aanbod</h1>
    <div class="border w-full bg-white">
        @foreach ($offers as $car)
        <x-car-list-item :$car />
        @endforeach
        @if ($offers->isEmpty())
        <div class="p-6 text-center text-gray-600">
            <p class="text-lg font-medium">Je hebt nog geen auto's geplaatst.</p>
            <a class="mt-4 inline-block rounded bg-neutral-500 px-4 py-2 font-bold text-white" href="{{ route('offers.start') }}">Plaats je eerste auto</a>
        </div>
        @endif
    </div>
    {{ $offers->links() }}
</div>
