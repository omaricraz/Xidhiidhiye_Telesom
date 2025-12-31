<!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item d-none d-md-inline-flex">
      <form class="form-search">
        <i class="search-icon">
          <svg class="pc-icon">
            <use xlink:href="#custom-search-normal-1"></use>
          </svg>
        </i>
        <input type="search" class="form-control" placeholder="Ctrl + K" />
      </form>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="pc-h-item">
      <a class="pc-head-link me-0" href="#" role="button" onclick="toggleTheme(); return false;" id="theme-toggle-btn">
        <svg class="pc-icon" id="theme-toggle-icon">
          <use xlink:href="#custom-sun-1"></use>
        </svg>
      </a>
    </li>
    <li class="dropdown pc-h-item">
      @php
        $recentNotices = \App\Models\Notice::with('creator')->latest()->take(5)->get();
        $noticeCount = \App\Models\Notice::count();
      @endphp
      <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <svg class="pc-icon">
          <use xlink:href="#custom-notification"></use>
        </svg>
        @if($noticeCount > 0)
          <span class="badge bg-success pc-h-badge">{{ $noticeCount > 9 ? '9+' : $noticeCount }}</span>
        @endif
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
          <h5 class="m-0">Announcements</h5>
          <a href="{{ route('noticeboard.index') }}" class="btn btn-link btn-sm">View all</a>
        </div>
        <div class="dropdown-body text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
          @if($recentNotices->count() > 0)
            @foreach($recentNotices as $notice)
              <a href="{{ route('noticeboard.index') }}" class="text-decoration-none d-block">
                <div class="card mb-2">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="flex-shrink-0">
                        <div class="avtar bg-light-primary">
                          <i class="ti ti-bell f-20"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <span class="float-end text-sm text-muted">{{ $notice->created_at->diffForHumans() }}</span>
                        <h5 class="text-body mb-2">{{ $notice->title }}</h5>
                        <p class="mb-0 text-muted">{{ \Illuminate\Support\Str::limit($notice->content, 100) }}</p>
                        <small class="text-muted d-block mt-1">
                          <i class="ti ti-user"></i> {{ $notice->creator->name ?? 'Unknown' }}
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            @endforeach
          @else
            <div class="text-center py-4">
              <p class="text-muted mb-0">No announcements at this time.</p>
            </div>
          @endif
        </div>
        <div class="text-center py-2">
          <a href="{{ route('noticeboard.index') }}" class="link-primary">View all Announcements</a>
        </div>
      </div>
    </li>
    <li class="dropdown pc-h-item header-user-profile">
      <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
        <img src="/build/images/user/avatar-2.jpg" alt="user-image" class="user-avtar" />
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
          <h5 class="m-0">Profile</h5>
        </div>
        <div class="dropdown-body">
          <div class="d-flex mb-3">
            <div class="flex-shrink-0">
              <img src="/build/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35" />
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1">{{ Auth::user()->full_name ?? Auth::user()->name }}</h6>
              <span>{{ Auth::user()->email }}</span>
            </div>
          </div>
          <hr class="border-secondary border-opacity-50" />
          <a href="{{ route('profile.show') }}" class="dropdown-item">
            <i class="ti ti-user"></i>
            <span>My Account</span>
          </a>
          <hr class="border-secondary border-opacity-50" />
          <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
            <i class="ti ti-power"></i>
            <span>Logout</span>
          </a>
          <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </li>
  </ul>
</div>