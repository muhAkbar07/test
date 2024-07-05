<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html class="dark">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Laporan</title>
    @livewireStyles
</head>
<body class="bg-white dark:bg-gray-900">
    <div class="container">
        @yield('content')
    </div>
    @livewireScripts
</body>
</html>
