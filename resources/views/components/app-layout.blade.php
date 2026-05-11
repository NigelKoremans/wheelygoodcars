<!DOCTYPE html>
<html>
<x-head :title="$title ?? ''" />

<body class="min-h-screen flex flex-col">
    <x-header />
    <main class="flex-1 flex">
        {{ $slot }}
    </main>
</body>

</html>
