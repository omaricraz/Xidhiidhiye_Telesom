<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="/dashboard/index" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="/build/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo" />
        <span class="badge bg-light-success rounded-pill ms-2 theme-version">{{ config('app.APP_VERSION') }}</span>
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        @include('layouts.menu-list')
      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
