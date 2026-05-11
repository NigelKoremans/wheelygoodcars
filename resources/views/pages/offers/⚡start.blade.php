<?php

use Livewire\Component;

new class extends Component
{
    public string $plate = '';

    public function next()
    {
        $plate = strtoupper($this->plate);

        if ($plate == "") {
            $this->addError('plate', 'Vul een kenteken in');
            return;
        }

        return redirect()->route('offers.create', ['plate' => $plate]);
    }
};
?>

<div class="flex-1 px-4 py-2 flex items-center justify-center">
    <form wire:submit="next" class="w-max">
        <livewire:license-plate wire:model="plate" />
        @if ($errors->any())
        <p>{{$errors->first()}}</p>
        @endif
    </form>
</div>
