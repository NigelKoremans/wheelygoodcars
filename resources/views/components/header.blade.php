<header>
    <nav class="flex items-center px-4 pt-2 pb-3 border-b border-neutral-800 bg-gray-950 text-white">
        <a class="text-xl font-bold" href="{{ route('home') }}" wire:navigate>Wheely <span class="text-border text-shadow-white text-black">Good Cars</span>!</a>
        <a class="ml-6 font-bold" href="{{ route('offers.index') }}" wire:navigate.hover>Alle auto's</a>
        <a class="ml-6 font-bold" href="{{ route('offers.start') }}" wire:navigate>Aanbod plaatsen</a>
        @auth
        <div class="ml-auto flex flex-row space-x-4">
            <a href="{{ route('offers.myoffers') }}" wire:navigate class="font-bold">Mijn aanbod</a>
            <form class="font-bold" action="{{ route('logout') }}" method="post">
                @csrf
                <input class="cursor-pointer" type="submit" value="Uitloggen">
            </form>
        </div>

        @else
        <a class="ml-auto font-bold" href="{{ route('login') }}">Inloggen</a>
        @endauth
    </nav>
</header>
