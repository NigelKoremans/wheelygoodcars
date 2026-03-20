<header>
    <nav class="flex items-center px-4 pt-2 pb-3 border-b border-black">
        <a class="text-xl font-bold" href="{{ route('home') }}"><span class="text-white text-shadow-black text-border">Wheely</span> Good Cars<span class="text-white text-shadow-black text-border">!</span></a>
        <a class="ml-6 font-bold" href="">Alle auto's</a>
        <a class="ml-6 font-bold" href="">Mijn aanbod</a>
        <a class="ml-6 font-bold" href="{{ route('offers.start') }}">Aanbod plaatsen</a>
        @auth
        <form class="ml-auto font-bold" action="{{ route('logout') }}" method="post">
            @csrf
            <input class="cursor-pointer hover:underline" type="submit" value="uitloggen">
        </form>
        @else
        <a class="ml-auto font-bold" href="{{ route('login') }}">Inloggen</a>
        @endauth
    </nav>
</header>
