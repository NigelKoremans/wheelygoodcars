<x-app-layout>
    <div class="mx-auto my-auto h-full flex flex-col">
        <form class="mx-auto my-auto flex flex-col h-full flex-1" action="{{ route('login.store') }}" method="POST">
            <div class="border border-neutral-500 py-8 px-8">
                @csrf
                <div class="py-2">
                    <label for="email">E-mail</label>
                    <input placeholder="Enter your emailaddress" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="text" name="email" id="email">
                </div>
                <div class="py-2">
                    <label for="password">Password</label>
                    <input placeholder="Enter your password" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="password" name="password" id="password">
                </div>
                <input class="cursor-pointer text-black px-4 py-1 mt-4 text-lg" type="submit" value="Login">
            </div>
        </form>
    </div>
</x-app-layout>
