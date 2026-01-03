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
  // Apply theme from localStorage, but always use server config for layout
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
      
      // Always use the layout from body attribute (server config) and update localStorage to match
      // This ensures the config value takes precedence over any stored localStorage value
      var configLayout = document.body.getAttribute('data-pc-layout');
      if (configLayout) {
        localStorage.setItem('layout', configLayout);
        // Ensure body attribute is set (in case it was overridden)
        document.body.setAttribute('data-pc-layout', configLayout);
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

    @include('layouts/footer-js')

    @hasSection('scripts')
        @yield('scripts')
    @else
        <script>
            // Always set layout from config to ensure all pages use the configured default
            // #region agent log
            fetch('http://127.0.0.1:7250/ingest/4c46ff09-2365-4ec6-80d2-9b8f68ecc527',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'master.blade.php:56',message:'Inline script executing - forcing config layout',data:{configValue:'{{config('app.theme_layout')}}'},sessionId:'debug-session',runId:'post-fix',hypothesisId:'B'})}).catch(()=>{});
            // #endregion
            if (typeof Storage !== 'undefined') {
                // Always use config value to ensure consistency across all pages
                localStorage.setItem('layout', '{{config('app.theme_layout')}}');
                // #region agent log
                fetch('http://127.0.0.1:7250/ingest/4c46ff09-2365-4ec6-80d2-9b8f68ecc527',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'master.blade.php:60',message:'Forcing localStorage to config value',data:{setValue:'{{config('app.theme_layout')}}'},sessionId:'debug-session',runId:'post-fix',hypothesisId:'B'})}).catch(()=>{});
                // #endregion
            }
        </script>
    @endif
</body>
<!-- [Body] end -->

</html>