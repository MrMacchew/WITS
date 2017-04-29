<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('includes.head')
</head>
<body>

    <div id="app">

        @if($sidebar)
            @include('includes.header-sidebar')
        @else
            @include('includes.header')
        @endif

        <div class="container">
            
        <div class="row">
            @yield('content')
        </div>
        </div>



        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
