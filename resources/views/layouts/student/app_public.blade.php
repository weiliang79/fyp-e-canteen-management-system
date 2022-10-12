<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ \App\Models\GeneralDesign::where('name', 'app_icon')->count() !== 0 ? (\App\Models\GeneralDesign::where('name', 'app_icon')->first()->path !== null ? asset('/' . \App\Models\GeneralDesign::where('name', 'app_icon')->first()->path) : asset('/storage/defaults/favicon.ico') ) : asset('/storage/defaults/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- laravel file manager select button -->
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main>
            <div class="d-flex" id="wrapper">
                <div id="page-content-wrapper">
                    @include('layouts.student.topnavbar')
                    <div id="content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    @if(Session::get('swal-success'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            SwalWithBootstrap.fire({
                title: 'Success',
                html: '{{ Session::get("swal-success") }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            });
        })
    </script>
    @endif

    @if(Session::get('swal-warning'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            SwalWithBootstrap.fire({
                title: 'Warning',
                html: '{{ Session::pull("swal-warning") }}',
                icon: 'warning',
                showConfirmButton: true,
            });
        })
    </script>
    @endif
</body>

</html>