<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Toko Utama - Fresh & Modern</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        // Maroon / Premium red palette (primary must not be transparent)
                        primary: {
                            DEFAULT: '#6B0F0F', // deep maroon
                            50: '#FFF5F5',
                            100: '#FCEAEA',
                            200: '#F3D6D6',
                            700: '#4A0A0A', // darker shade for emphasis
                        },
                        // Supporting accents
                        accent: '#E1B56A', // warm gold
                        dark: '#0F172A', // keep dark for text/contrast
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Paksa body jadi flexbox berdiri */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Paksa footer ke bawah */
        main,
        section.content {
            flex: 1;
        }
    </style>
</head>

<body class="bg-gray-50 text-slate-800 antialiased">

    @include('components.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')

</body>

</html>
