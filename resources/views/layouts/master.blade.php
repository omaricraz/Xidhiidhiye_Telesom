<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('title') | Telesom Dashboard</title>
    @include('layouts/head-page-meta')

    @yield('css')

    @include('layouts/head-css')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->
<body data-pc-preset="{{config('app.preset_theme')}}" data-pc-sidebar-caption="{{config('app.caption_show')}}" data-pc-layout="{{config('app.theme_layout')}}" data-pc-direction="{{config('app.rtlflag')}}" data-pc-theme="{{config('app.dark_layout') ?  config('app.dark_layout') == 'default' ?? 'dark' : 'light'}}">
<script>
  // Apply theme and layout from localStorage immediately to prevent flash of wrong theme
  (function() {
    if (typeof Storage !== 'undefined') {
      var savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
        if (savedTheme === 'default') {
          var dark_layout = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
          document.body.setAttribute('data-pc-theme', dark_layout);
        } else {
          document.body.setAttribute('data-pc-theme', savedTheme);
        }
      }
      
      // Apply layout from localStorage if available
      var savedLayout = localStorage.getItem('layout');
      if (savedLayout) {
        document.body.setAttribute('data-pc-layout', savedLayout);
      }
    }
  })();
</script>

    @include('layouts/layout-vertical')

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @include('layouts/footer-block')
    @include('layouts/customizer')

    @include('layouts/footer-js')

    @hasSection('scripts')
        @yield('scripts')
    @else
        <script>
            // Only set layout from config if no user preference exists in localStorage
            if (typeof Storage !== 'undefined') {
                var savedLayout = localStorage.getItem('layout');
                if (!savedLayout || savedLayout === '') {
                    localStorage.setItem('layout', '{{config('app.theme_layout')}}');
                }
            }
        </script>
    @endif
</body>
<!-- [Body] end -->

</html>