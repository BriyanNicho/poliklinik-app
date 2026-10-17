<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Poliklinik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 text-base-content">
    <div class="flex min-h-screen">
        @include('components.partials.sidebar')
        <div class="flex min-w-0 flex-1 flex-col">
            @include('components.partials.header', ['title' => trim($__env->yieldContent('title'))])
            <main class="flex-1 p-4 lg:p-8">
                <section class="mx-auto max-w-5xl">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold">@yield('heading')</h1>
                        <p class="mt-2 text-base-content/70">@yield('description')</p>
                    </div>
                    @yield('content')
                </section>
            </main>
            @include('components.partials.footer')
        </div>
    </div>
</body>
</html>
