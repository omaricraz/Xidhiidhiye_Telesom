@extends('layouts.master-auth')

@section('title', 'Login')

@section('content')

    @include('layouts/loader')
    <div class="auth-main">
      <div class="auth-wrapper v1">
        <!-- Theme Toggle Button -->
        <div class="theme-toggle-container">
            <button id="theme-toggle" class="btn btn-theme-toggle" aria-label="Toggle theme">
                <i class="ph ph-sun" id="theme-icon"></i>
            </button>
        </div>
        <div class="auth-form">
          <div class="card my-5">
            <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="text-center">
                <a href="{{ route('homepage') }}"><img id="login-logo" src="/build/images/xidhiidhiye-logo.svg" alt="Xidhiidhiye Logo" style="max-width: 300px; height: auto;" /></a>
                <div class="d-grid my-3">
                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="/build/images/authentication/facebook.svg" alt="img" /> <span> Sign In with Facebook</span>
                  </button>
                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="/build/images/authentication/twitter.svg" alt="img" /> <span> Sign In with Twitter</span>
                  </button>
                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="/build/images/authentication/google.svg" alt="img" /> <span> Sign In with Google</span>
                  </button>
                </div>
              </div>
              <div class="saprator my-3">
                <span>OR</span>
              </div>
              <h4 class="text-center f-w-500 mb-3">Login with your email</h4>
              <div class="mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" value="admin@phoenixcoded.com" id="floatingInput" name="email" placeholder="Email Address" />
                @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              </div>
              <div class="mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingInput1" placeholder="Password" name="password" required autocomplete="current-password" value="12345678"/>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" {{ old('remember') ? 'checked' : '' }} />
                  <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                </div>
                <h6 class="text-secondary f-w-400 mb-0">
                  @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}"> Forgot Password? </a>
                  @endif
                  
                </h6>
              </div>
              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary login-submit-btn">Login</button>
              </div>
              <div class="d-flex justify-content-between align-items-end mt-4">
                <h6 class="f-w-500 mb-0">Don't have an Account?</h6>
                <a href="{{ route('register') }}" class="link-primary">Create Account</a>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Main Content ] end -->

    <style>
        /* Theme Toggle */
        .theme-toggle-container {
            position: absolute;
            top: 30px;
            right: 30px;
            z-index: 10;
        }

        .btn-theme-toggle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 2px solid rgba(0, 0, 0, 0.1);
            color: #2d3748;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        [data-pc-theme="dark"] .btn-theme-toggle {
            background: #2d3748;
            color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .btn-theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        [data-pc-theme="dark"] .btn-theme-toggle:hover {
            background: #374151;
        }

        /* Auth Background - Light Theme */
        [data-pc-theme="light"] .auth-main .auth-wrapper.v1 .auth-form {
            background-image: none !important;
            background: linear-gradient(to bottom, #f7fafc 0%, #ffffff 100%) !important;
            background-size: cover;
        }

        /* Auth Background - Dark Theme */
        [data-pc-theme="dark"] .auth-main .auth-wrapper.v1 .auth-form {
            background-image: none !important;
            background: linear-gradient(to bottom, #1a202c 0%, #2d3748 100%) !important;
            background-size: cover;
        }

        /* Login Button - Light Theme (Green) */
        [data-pc-theme="light"] .login-submit-btn {
            background-color: #008000 !important;
            border-color: #008000 !important;
            color: #ffffff !important;
        }

        [data-pc-theme="light"] .login-submit-btn:hover {
            background-color: #006600 !important;
            border-color: #006600 !important;
            box-shadow: 0 4px 12px rgba(0, 128, 0, 0.3);
        }

        /* Login Button - Dark Theme (Purple) */
        [data-pc-theme="dark"] .login-submit-btn {
            background-color: #9BB5FF !important;
            border-color: #9BB5FF !important;
            color: #1a202c !important;
        }

        [data-pc-theme="dark"] .login-submit-btn:hover {
            background-color: #7A9FFF !important;
            border-color: #7A9FFF !important;
            box-shadow: 0 4px 12px rgba(155, 181, 255, 0.3);
        }

        /* Link Colors - Light Theme (Green) */
        [data-pc-theme="light"] .link-primary {
            color: #008000 !important;
        }

        [data-pc-theme="light"] .link-primary:hover {
            color: #006600 !important;
        }

        /* Link Colors - Dark Theme (Purple) */
        [data-pc-theme="dark"] .link-primary {
            color: #9BB5FF !important;
        }

        [data-pc-theme="dark"] .link-primary:hover {
            color: #7A9FFF !important;
        }

        /* Card Styling */
        [data-pc-theme="light"] .auth-form .card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        [data-pc-theme="dark"] .auth-form .card {
            background: #1a202c;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Text Colors */
        [data-pc-theme="light"] .auth-form h4,
        [data-pc-theme="light"] .auth-form h6 {
            color: #2d3748;
        }

        [data-pc-theme="dark"] .auth-form h4,
        [data-pc-theme="dark"] .auth-form h6 {
            color: #9BB5FF;
        }

        /* Form Input Styling */
        [data-pc-theme="dark"] .form-control {
            background-color: #2d3748;
            border-color: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }

        [data-pc-theme="dark"] .form-control:focus {
            background-color: #2d3748;
            border-color: #9BB5FF;
            color: #e2e8f0;
        }

        /* Social Login Buttons */
        [data-pc-theme="light"] .btn-light-primary {
            background: #f7fafc !important;
            border-color: rgba(0, 0, 0, 0.1) !important;
        }

        [data-pc-theme="dark"] .btn-light-primary {
            background: #2d3748 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
        }

        /* Separator */
        [data-pc-theme="light"] .saprator:after {
            background: rgba(0, 0, 0, 0.1);
        }

        [data-pc-theme="dark"] .saprator:after {
            background: rgba(255, 255, 255, 0.2);
        }

        [data-pc-theme="light"] .saprator span {
            background: #ffffff;
            color: #4a5568;
        }

        [data-pc-theme="dark"] .saprator span {
            background: #1a202c;
            color: #a0aec0;
        }
    </style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get theme from localStorage or default to light
        var currentTheme = localStorage.getItem('theme') || 'light';
        
        // Handle default theme (system preference)
        if (currentTheme === 'default') {
            var dark_layout = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            currentTheme = dark_layout;
        }
        
        // Apply theme immediately
        applyTheme(currentTheme);
        
        // Theme toggle button
        var themeToggle = document.getElementById('theme-toggle');
        var themeIcon = document.getElementById('theme-icon');
        var loginLogo = document.getElementById('login-logo');
        
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                var body = document.body;
                var currentThemeAttr = body.getAttribute('data-pc-theme') || 'light';
                var newTheme = currentThemeAttr === 'light' ? 'dark' : 'light';
                applyTheme(newTheme);
            });
        }
        
        function applyTheme(theme) {
            var body = document.body;
            body.setAttribute('data-pc-theme', theme);
            localStorage.setItem('theme', theme);
            
            // Update logo based on theme - using same logos as homepage
            if (loginLogo) {
                if (theme === 'dark') {
                    loginLogo.src = '/build/images/xidhiidhiye-logo-purple.svg';
                } else {
                    loginLogo.src = '/build/images/xidhiidhiye-logo.svg';
                }
            }
            
            // Update icon
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.className = 'ph ph-moon';
                } else {
                    themeIcon.className = 'ph ph-sun';
                }
            }
        }
    });
</script>
@endsection