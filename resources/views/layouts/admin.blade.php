<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title') - Admin Toko Utama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- WRAPPER UTAMA --}}
    <div class="flex h-screen overflow-hidden">

        {{-- 1. PANGGIL SIDEBAR DI SINI --}}
        @include('components.admin-sidebar')

        {{-- AREA KANAN --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            {{-- 2. PANGGIL NAVBAR DI SINI --}}
            @include('components.admin-navbar')

            {{-- KONTEN UTAMA --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 flex flex-col justify-between">
                <div class="flex-1 p-6">
                    @yield('content')
                </div>
                
                {{-- 3. PANGGIL FOOTER DI SINI --}}
                @include('components.admin-footer')
            </main>

        </div>
    </div>

</body>
</html>