<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head :title="$title ?? ''"/>

<body class="min-h-screen flex flex-col">
    <x-header />
    <main class="flex-1 flex bg-neutral-200">
        {{ $slot }}
    </main>
    @livewireScripts
</body>

</html>
