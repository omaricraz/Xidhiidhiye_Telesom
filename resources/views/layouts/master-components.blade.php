<!doctype html>
<html lang="en">
  <head>
    <title>@yield('title') | Able Pro Dashboard Template</title>
    @include('layouts/head-page-meta')

    @yield('css')

    @include('layouts/head-css')

    @yield('css2')
  </head>
<!-- [Body] Start -->

<body class="@yield('bodyClass')" data-pc-layout="{{config('app.theme_layout')}}" data-pc-direction="{{config('app.rtlflag')}}" data-pc-theme="{{config('app.dark_layout') ?  config('app.dark_layout') == 'default' ?? 'dark' : 'light'}}" data-pc-preset="{{config('app.preset_theme')}}">
    <!-- component-page -->
    @yield('content')

    <!-- [ Main Content ] end -->

    @include('layouts/footer-component')
    
    @include('layouts/footer-js')

    @yield('scripts')
</body>
<!-- [Body] end -->

</html>