<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevCo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet"href="{{ asset('css/dark-mode.css') }}">@yield('styles')
</head>

<body style="background-color: #f8f9fa;">
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        const body = document.body;

        function applyDarkMode(isDark) {
            if (isDark) {
                html.setAttribute('data-theme', 'dark');
                body.style.backgroundColor = '#1a1a1a';
            } else {
                html.removeAttribute('data-theme');
                body.style.backgroundColor = '#f8f9fa';
            }
        }

        // Check saved preference
        const savedDarkMode = localStorage.getItem('darkMode') === 'true';
        if (savedDarkMode) {
            darkModeToggle.checked = true;
            applyDarkMode(true);
        }

        // Toggle dark mode
        darkModeToggle.addEventListener('change', () => {
            applyDarkMode(darkModeToggle.checked);
            localStorage.setItem('darkMode', darkModeToggle.checked);
        });
    </script>
    @yield('scripts')
</body>

</html>
