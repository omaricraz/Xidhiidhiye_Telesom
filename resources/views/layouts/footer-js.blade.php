<!-- Required Js -->
<script src="/build/js/plugins/popper.min.js"></script>
<script src="/build/js/plugins/simplebar.min.js"></script>
<script src="/build/js/plugins/bootstrap.min.js"></script>
<script src="/build/js/plugins/i18next.min.js"></script>
<script src="/build/js/plugins/i18nextHttpBackend.min.js"></script>
<script src="/build/js/icon/custom-font.js"></script>
<script src="/build/js/script.js"></script>
<script src="/build/js/theme.js"></script>
<script src="/build/js/multi-lang.js"></script>
<script src="/build/js/plugins/feather.min.js"></script>
@if (config('app.dark_layout') != "")
<script>
  // Only apply config theme if no user preference is stored in localStorage
  if (typeof Storage !== 'undefined' && !localStorage.getItem('theme')) {
    layout_change("{{config('app.dark_layout')}}");
  }
</script>
@endif
@if (config('app.theme_contrast') != '')
<script>
  layout_theme_contrast_change("{{config('app.theme_contrast')}}");
</script>
@endif
@if (config('app.box_container') != '')
<script>
  change_box_container("{{config('app.box_container')}}");
</script>
@endif
@if (config('app.caption_show') != '')
<script>
  layout_caption_change("{{config('app.caption_show')}}");
</script>
@endif
@if (config('app.rtl_layout') != '')
<script>
  layout_rtl_change("{{config('app.rtl_layout')}}");
</script>
@endif
@if (config('app.preset_theme') != "")
<script>
  preset_change("{{config('app.preset_theme')}}");
</script>
@endif
@if (config('app.theme_layout') == 'default')
<script>
  // #region agent log
  fetch('http://127.0.0.1:7250/ingest/4c46ff09-2365-4ec6-80d2-9b8f68ecc527',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'footer-js.blade.php:46',message:'footer script: default layout',data:{configValue:'{{config('app.theme_layout')}}'},sessionId:'debug-session',runId:'run1',hypothesisId:'D'})}).catch(()=>{});
  // #endregion
  main_layout_change('default');
</script>
@elseif(config('app.theme_layout') != "")
<script>
  // #region agent log
  fetch('http://127.0.0.1:7250/ingest/4c46ff09-2365-4ec6-80d2-9b8f68ecc527',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'footer-js.blade.php:50',message:'footer script: calling main_layout_change',data:{configValue:'{{config('app.theme_layout')}}',calledWith:'{{config('app.theme_layout')}}'},sessionId:'debug-session',runId:'post-fix',hypothesisId:'D'})}).catch(()=>{});
  // #endregion
  main_layout_change('{{config('app.theme_layout')}}');
</script>
@endif