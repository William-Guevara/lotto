<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layout.head')
    </head>
    <body data-background-color="bg3">
        <div class="wrapper">

            @include('layout.header')

            @include('layout.sidebar')

            @yield('content')

        </div>
        <!-- ./wrapper -->

        @include('layout.scripts')

    </body>
</html>
