<!DOCTYPE html>
<html>
<x-head />

<body class="min-h-screen flex flex-col">
    <x-header />
    <main class="flex-1 px-4 py-2 flex flex-col">
        {{ $slot }}
    </main>
</body>

</html>
