<x-app-layout>
    <div class="mx-auto my-auto h-full flex flex-col">
        <form class="mx-auto my-auto flex flex-col h-full flex-1" action="{{ url('/register') }}" method="POST">
            <div class="border border-neutral-500 py-8 px-8">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-300 bg-red-100 p-2 text-red-800">
                        <p class="font-semibold">Controleer je invoer:</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="py-2">
                    <label for="name">Naam</label>
                    <input placeholder="Voer je naam in" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <div class="py-2">
                    <label for="email">E-mail</label>
                    <input placeholder="Voer je e-mailadres in" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                    <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <div class="py-2">
                    <label for="phonenumber">Telefoonnummer</label>
                    <input placeholder="Voer je telefoonnummer in" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="tel" name="phonenumber" id="phonenumber" required>
                </div>

                <div class="py-2">
                    <label for="password">Wachtwoord</label>
                    <input placeholder="Voer je wachtwoord in" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="password" name="password" id="password" required>
                    @error('password')
                    <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <div class="py-2">
                    <label for="password_confirmation">Bevestig wachtwoord</label>
                    <input placeholder="Bevestig je wachtwoord" class="block p-1 w-64 bg-white shadow-sm border border-gray-300" type="password" name="password_confirmation" id="password_confirmation" required>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <a class="text-sm text-white underline" href="{{ url('/login') }}">Heb je al een account?</a>
                    <input class="cursor-pointer text-black px-4 py-1 text-lg" type="submit" value="Registreren">
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
