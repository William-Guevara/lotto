<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layout.head')
</head>

<body>

    @include('layout.header')

    <main id="main">
        @yield('content')
        @include('layout.modals_const')

        @include('layout.footer')
    </div>
        @include('layout.scripts')

        @yield('scripts')

</body>

</html>