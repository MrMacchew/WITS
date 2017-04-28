<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('includes.head')
</head>
<body>

    <div id="app">

        @include('includes.header')

        <div id="main" class="container">
            @yield('content')
        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
