<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('layout._head')
</head>
<body id="body_container" style="font-family: Open Sans, sans-serif">
<section  class="min-h-screen flex flex-col bg-gray-300 text-white">
    @include('layout._nav')

    @yield('content')

    @include('layout._footer')

</section>

@yield('script')

</body>

</html>
