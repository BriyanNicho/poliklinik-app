<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Poliklinik' }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-950 p-4 sm:p-6">
    <div class="w-full py-8">
        {{ $slot }}
    </div>

    @stack('scripts')
</body>
</html>
