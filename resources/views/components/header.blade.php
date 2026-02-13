<header>
    <nav class="flex items-center px-4 pt-2 pb-3 border-b border-black">
        <a class="text-xl font-bold" href=""><span class="text-white text-shadow-[0_0_2px_black,0_0_2px_black,0_0_2px_black]">Wheely</span> Good Cars<span class="text-white text-shadow-[0_0_2px_black,0_0_2px_black,0_0_2px_black]">!</span></a>
        <a class="ml-6 font-bold" href="">Alle auto's</a>
        <a class="ml-6 font-bold" href="">Mijn aanbod</a>
        <a class="ml-6 font-bold" href="">Aanbod plaatsen</a>
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
