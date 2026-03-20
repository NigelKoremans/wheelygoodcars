<x-app-layout>
    <div class="flex-1 px-4 py-2 flex items-center justify-center">
        <form action="{{ route('offers.create') }}" class="w-max">
            <x-license-plate />
            @if ($errors->any())
                <p>{{$errors->first()}}</p>
            @endif
        </form>
    </div>
</x-app-layout>
