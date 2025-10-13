<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex h-screen">
    
    {{-- Sidebar --}}
    @include('components.sidebars.seller-sidebar')

    <div class="flex flex-col flex-1 overflow-hidden ml-0 lg:ml-64">
        {{-- Navbar --}}
        @include('components.navbars.seller-navbar')

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

    {{-- Render page-specific scripts --}}
    @yield('scripts')

</body>
</html>
