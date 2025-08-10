<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-white text-gray-900 overflow-x-hidden">
    @include('layouts.partials.headerProfile')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.partials.footer')
</body>

<script>



</script>
</html>
