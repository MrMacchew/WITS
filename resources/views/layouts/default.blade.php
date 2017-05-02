<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('includes.head')
</head>
<body>

    <div id="app">

        @unless(isset($sidebar))
            @include('includes.header-sidebar')
        @else
            @include('includes.header')
        @endif

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading')</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                @yield('content')
            </div>
        </div>
            <!-- /#page-wrapper -->

        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
