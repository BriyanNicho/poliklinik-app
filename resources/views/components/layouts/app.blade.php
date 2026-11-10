<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Poliklinik' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="min-h-screen bg-base-200 text-base-content">
    <div class="flex min-h-screen">
        @include('components.partials.sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            @include('components.partials.header', ['title' => $title ?? 'Dashboard'])

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <section class="mx-auto w-full max-w-7xl">
                    @if (session('success') || session('message'))
                        <div class="alert alert-success mb-6 border-0 shadow-sm">
                            <i class="fas fa-circle-check"></i>
                            <span>{{ session('success') ?? session('message') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-error mb-6 border-0 shadow-sm">
                            <i class="fas fa-circle-exclamation"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </section>
            </main>

            @include('components.partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
