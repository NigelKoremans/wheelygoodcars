<header>
    <nav class="flex items-center px-4 pt-2 pb-3 border-b border-black">
        <a class="text-xl font-bold" href="{{ route('home') }}"><span class="text-white text-shadow-black text-border">Wheely</span> Good Cars<span class="text-white text-shadow-black text-border">!</span></a>
        <a class="ml-6 font-bold" href="">Alle auto's</a>
        <a class="ml-6 font-bold" href="{{ route('offers.start') }}">Aanbod plaatsen</a>
        @auth
        <div class="ml-auto flex flex-row space-x-4">
            <a href="{{ route('offers.myoffers') }}" class="font-bold">Mijn aanbod</a>
            <form class="font-bold" action="{{ route('logout') }}" method="post">
                @csrf
                <input class="cursor-pointer hover:underline" type="submit" value="Uitloggen">
            </form>
        </div>

        @else
        <a class="ml-auto font-bold" href="{{ route('login') }}">Inloggen</a>
        @endauth
    </nav>
</header>
