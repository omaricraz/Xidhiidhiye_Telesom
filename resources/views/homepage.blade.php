<!doctype html>
<html lang="en">
  <head>
    <title>Xidhiidhiye | Smart Connections for Modern Teams</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Xidhiidhiye - A professional networking and collaboration platform that connects co-workers, teams, and organizations through smart digital connections." />
    <meta name="keywords" content="Xidhiidhiye, Team Collaboration, Professional Networking, Digital Platform" />
    <meta name="author" content="Xidhiidhiye" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="/build/images/favicon.svg" type="image/x-icon" />
    <!-- [Font] Family -->
    <link rel="stylesheet" href="/build/fonts/inter/inter.css" id="main-font-link" />
    <!-- [phosphor Icons] -->
    <link rel="stylesheet" href="/build/fonts/phosphor/duotone/style.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="/build/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="/build/css/style-preset.css" />
  </head>

  <body
    data-pc-preset="preset-1"
    data-pc-sidebar-caption="true"
    data-pc-direction="ltr"
    data-pc-theme_contrast=""
    data-pc-theme="light"
    class="xidhiidhiye-homepage"
  >
    <script>
      // Apply theme from localStorage immediately to prevent flash of wrong theme
      (function() {
        if (typeof Storage !== 'undefined') {
          var savedTheme = localStorage.getItem('theme');
          if (savedTheme && savedTheme !== 'default') {
            document.body.setAttribute('data-pc-theme', savedTheme);
          }
        }
      })();
    </script>

    <!-- Theme Toggle Button -->
    <div class="theme-toggle-container">
      <button id="theme-toggle" class="btn-theme-toggle" aria-label="Toggle theme">
        <svg id="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="5"></circle>
          <line x1="12" y1="1" x2="12" y2="3"></line>
          <line x1="12" y1="21" x2="12" y2="23"></line>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
          <line x1="1" y1="12" x2="3" y2="12"></line>
          <line x1="21" y1="12" x2="23" y2="12"></line>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
      </button>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container">
        <div class="hero-content">
          <div class="hero-text">
            <div class="hero-logo">
              <img id="hero-logo" src="/build/images/xidhiidhiye-logo.svg" alt="Xidhiidhiye Logo" class="logo-image" />
            </div>
            <h1 class="hero-headline">
              Smart Connections for <span class="text-primary">Modern Teams</span>
            </h1>
            <p class="hero-subtext">
              Xidhiidhiye is a professional networking and collaboration platform that connects co-workers, teams, and organizations through smart digital connections.
            </p>
            <div class="hero-cta">
              <a href="{{ route('login') }}" class="btn btn-primary btn-hero-primary">
                Get Started
              </a>
              <a href="#about" class="btn btn-outline btn-hero-secondary">
                Learn More
              </a>
            </div>
          </div>
          <div class="hero-visual">
            <div class="hero-image-wrapper">
              <img 
                src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop&q=80" 
                alt="Team collaboration in modern office" 
                class="hero-image"
              />
              <div class="image-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- What is Xidhiidhiye? -->
    <section id="about" class="about-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">What is Xidhiidhiye?</h2>
          <p class="section-description">
            A professional networking platform designed to bring teams together, improve communication, and enhance collaboration across organizations.
          </p>
        </div>
        <div class="about-grid">
          <div class="about-card">
            <div class="about-image">
              <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop&q=80" alt="Team meeting" />
            </div>
            <div class="about-card-content">
              <div class="about-icon">
                <i class="ph ph-users"></i>
              </div>
              <h3>Connect Co-Workers</h3>
              <p>Build meaningful professional relationships within your organization and beyond.</p>
            </div>
          </div>
          <div class="about-card">
            <div class="about-image">
              <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400&h=300&fit=crop&q=80" alt="Team communication" />
            </div>
            <div class="about-card-content">
              <div class="about-icon">
                <i class="ph ph-chat-circle"></i>
              </div>
              <h3>Improve Communication</h3>
              <p>Streamline team communication with smart tools designed for modern workplaces.</p>
            </div>
          </div>
          <div class="about-card">
            <div class="about-image">
              <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=300&fit=crop&q=80" alt="Team collaboration" />
            </div>
            <div class="about-card-content">
              <div class="about-icon">
                <i class="ph ph-handshake"></i>
              </div>
              <h3>Enhance Collaboration</h3>
              <p>Work together seamlessly with tools that make collaboration natural and efficient.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Key Features -->
    <section class="features-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Built for Modern Teams</h2>
          <p class="section-description">
            Everything you need to connect, communicate, and collaborate effectively.
          </p>
        </div>
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-image">
              <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=400&h=250&fit=crop&q=80" alt="Fast onboarding" />
            </div>
            <div class="feature-content">
              <div class="feature-icon">
                <i class="ph ph-lightning"></i>
              </div>
              <h3>Fast Onboarding</h3>
              <p>Get your team up and running in minutes, not days. Simple setup, immediate value.</p>
            </div>
          </div>
          <div class="feature-card">
            <div class="feature-image">
              <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=250&fit=crop&q=80" alt="Secure connections" />
            </div>
            <div class="feature-content">
              <div class="feature-icon">
                <i class="ph ph-shield-check"></i>
              </div>
              <h3>Secure Connections</h3>
              <p>Enterprise-grade security to keep your data and communications safe and private.</p>
            </div>
          </div>
          <div class="feature-card">
            <div class="feature-image">
              <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=250&fit=crop&q=80" alt="Team-friendly design" />
            </div>
            <div class="feature-content">
              <div class="feature-icon">
                <i class="ph ph-users-three"></i>
              </div>
              <h3>Team-Friendly Design</h3>
              <p>Intuitive interface that your team will actually enjoy using every day.</p>
            </div>
          </div>
          <div class="feature-card">
            <div class="feature-image">
              <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400&h=250&fit=crop&q=80" alt="Scalable organizations" />
            </div>
            <div class="feature-content">
              <div class="feature-icon">
                <i class="ph ph-graph-up"></i>
              </div>
              <h3>Scalable for Organizations</h3>
              <p>Grows with your organization, from small teams to large enterprises.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">How It Works</h2>
          <p class="section-description">
            Get started in three simple steps.
          </p>
        </div>
        <div class="steps-container">
          <div class="step-item">
            <div class="step-number">1</div>
            <div class="step-content">
              <h3>Sign Up</h3>
              <p>Create your account and set up your profile in minutes.</p>
            </div>
          </div>
          <div class="step-item">
            <div class="step-number">2</div>
            <div class="step-content">
              <h3>Connect Your Team</h3>
              <p>Invite co-workers and start building your professional network.</p>
            </div>
          </div>
          <div class="step-item">
            <div class="step-number">3</div>
            <div class="step-content">
              <h3>Start Collaborating</h3>
              <p>Begin communicating and working together seamlessly.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Who It's For -->
    <section class="audience-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Who It's For</h2>
          <p class="section-description">
            Xidhiidhiye serves professionals, teams, and organizations of all sizes.
          </p>
        </div>
        <div class="audience-grid">
          <div class="audience-card">
            <div class="audience-icon">
              <i class="ph ph-users-three"></i>
            </div>
            <h3>Teams</h3>
            <p>Small to medium teams looking to improve internal communication and collaboration.</p>
          </div>
          <div class="audience-card">
            <div class="audience-icon">
              <i class="ph ph-buildings"></i>
            </div>
            <h3>Organizations</h3>
            <p>Large enterprises needing scalable solutions for cross-department collaboration.</p>
          </div>
          <div class="audience-card">
            <div class="audience-icon">
              <i class="ph ph-user"></i>
            </div>
            <h3>Professionals</h3>
            <p>Individual professionals building their network and connecting with peers.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
      <div class="cta-background-image">
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1200&h=600&fit=crop&q=80" alt="Modern office workspace" />
        <div class="cta-overlay"></div>
      </div>
      <div class="container">
        <div class="cta-content">
          <h2 class="cta-headline">Ready to Get Started?</h2>
          <p class="cta-description">
            Join Xidhiidhiye today and start building stronger connections with your team.
          </p>
          <a href="{{ route('login') }}" class="btn btn-primary btn-cta">
            Join Xidhiidhiye
          </a>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer-section">
      <div class="container">
        <div class="footer-content">
          <div class="footer-brand">
            <img id="footer-logo" src="/build/images/xidhiidhiye-logo.svg" alt="Xidhiidhiye Logo" class="footer-logo" />
            <p class="footer-mission">
              Connecting co-workers, teams, and organizations through smart digital connections.
            </p>
          </div>
          <div class="footer-links">
            <div class="footer-link-group">
              <h4>Company</h4>
              <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div>
            <div class="footer-link-group">
              <h4>Legal</h4>
              <ul>
                <li><a href="#privacy">Privacy</a></li>
                <li><a href="#terms">Terms</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; {{ date('Y') }} Xidhiidhiye. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="/build/js/plugins/popper.min.js"></script>
    <script src="/build/js/plugins/bootstrap.min.js"></script>
    <script src="/build/js/script.js"></script>
    <script src="/build/js/theme.js"></script>

    <script>
      // Theme toggle functionality
      document.addEventListener('DOMContentLoaded', function() {
        var themeToggle = document.getElementById('theme-toggle');
        var themeIcon = document.getElementById('theme-icon');
        var heroLogo = document.getElementById('hero-logo');
        var footerLogo = document.getElementById('footer-logo');
        
        // Get current theme from body attribute (set by inline script) or localStorage
        var body = document.body;
        var currentTheme = body.getAttribute('data-pc-theme') || localStorage.getItem('theme') || 'light';
        if (currentTheme && currentTheme !== 'default') {
          applyTheme(currentTheme);
        } else {
          applyTheme('light');
        }
        
        // Initialize icon and logos based on current theme
        if (themeIcon) {
          updateIcon(currentTheme);
        }
        updateLogos(currentTheme);
        
        if (themeToggle) {
          themeToggle.addEventListener('click', function() {
            var body = document.body;
            var currentThemeAttr = body.getAttribute('data-pc-theme') || 'light';
            var newTheme = currentThemeAttr === 'light' ? 'dark' : 'light';
            applyTheme(newTheme);
          });
        }
        
        function updateIcon(theme) {
          if (themeIcon) {
            // Update SVG icon based on theme
            if (theme === 'dark') {
              // Moon icon
              themeIcon.innerHTML = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>';
            } else {
              // Sun icon
              themeIcon.innerHTML = '<circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>';
            }
          }
        }
        
        function updateLogos(theme) {
          // Update hero logo
          if (heroLogo) {
            heroLogo.src = theme === 'dark' 
              ? '/build/images/xidhiidhiye-logo-purple.svg' 
              : '/build/images/xidhiidhiye-logo.svg';
          }
          
          // Update footer logo
          if (footerLogo) {
            footerLogo.src = theme === 'dark' 
              ? '/build/images/xidhiidhiye-logo-purple.svg' 
              : '/build/images/xidhiidhiye-logo.svg';
          }
        }
        
        function applyTheme(theme) {
          var body = document.body;
          body.setAttribute('data-pc-theme', theme);
          localStorage.setItem('theme', theme);
          
          // Update icon
          updateIcon(theme);
          
          // Update logos
          updateLogos(theme);
          
          if (typeof layout_change === 'function') {
            layout_change(theme);
          }
        }
      });
    </script>

    <style>
      /* Reset and Base Styles */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body.xidhiidhiye-homepage {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        line-height: 1.6;
        color: #2d3748;
        background: #ffffff;
        overflow-x: hidden;
      }

      [data-pc-theme="dark"] body.xidhiidhiye-homepage {
        background: #1a202c;
        color: #e2e8f0;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
      }

      /* Theme Toggle */
      .theme-toggle-container {
        position: fixed;
        top: 32px;
        right: 32px;
        z-index: 1000;
      }

      .btn-theme-toggle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: 2px solid rgba(0, 0, 0, 0.1);
        background: #ffffff;
        color: #2d3748;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-size: 24px;
      }

      [data-pc-theme="dark"] .btn-theme-toggle {
        background: #2d3748;
        color: #e2e8f0;
        border-color: rgba(255, 255, 255, 0.15);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      }

      .btn-theme-toggle:hover {
        transform: scale(1.1) rotate(15deg);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        background: #f7fafc;
      }

      [data-pc-theme="dark"] .btn-theme-toggle:hover {
        background: #374151;
      }

      .btn-theme-toggle:active {
        transform: scale(0.95);
      }

      .btn-theme-toggle svg {
        width: 24px;
        height: 24px;
        transition: transform 0.3s ease;
      }

      .btn-theme-toggle:hover svg {
        transform: rotate(15deg);
      }

      /* Hero Section */
      .hero-section {
        min-height: 90vh;
        display: flex;
        align-items: center;
        padding: 120px 0 80px;
        background: linear-gradient(to bottom, #f7fafc 0%, #ffffff 100%);
      }

      [data-pc-theme="dark"] .hero-section {
        background: linear-gradient(to bottom, #1a202c 0%, #2d3748 100%);
      }

      .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
      }

      .hero-logo {
        margin-bottom: 32px;
      }

      .logo-image {
        max-width: 350px;
        height: auto;
        display: block;
      }

      .hero-headline {
        font-size: 56px;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 24px;
        letter-spacing: -0.02em;
      }

      .hero-headline .text-primary {
        color: #008000;
      }

      [data-pc-theme="dark"] .hero-headline .text-primary {
        color: #9BB5FF;
      }

      [data-pc-theme="dark"] .hero-headline {
        color: #9BB5FF;
      }

      [data-pc-theme="dark"] h1,
      [data-pc-theme="dark"] h2,
      [data-pc-theme="dark"] h3,
      [data-pc-theme="dark"] h4,
      [data-pc-theme="dark"] h5,
      [data-pc-theme="dark"] h6 {
        color: #9BB5FF;
      }

      .hero-subtext {
        font-size: 20px;
        line-height: 1.6;
        color: #4a5568;
        margin-bottom: 40px;
        max-width: 540px;
      }

      [data-pc-theme="dark"] .hero-subtext {
        color: #a0aec0;
      }

      .hero-cta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
      }

      .btn {
        padding: 14px 32px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
      }

      .btn-primary {
        background: #008000;
        color: #ffffff;
      }

      [data-pc-theme="dark"] .btn-primary {
        background: #9BB5FF;
        color: #1a202c;
      }

      .btn-primary:hover {
        background: #006600;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 128, 0, 0.3);
      }

      [data-pc-theme="dark"] .btn-primary:hover {
        background: #7A9FFF;
        box-shadow: 0 4px 12px rgba(155, 181, 255, 0.3);
      }

      .btn-outline {
        background: transparent;
        color: #008000;
        border: 2px solid #008000;
      }

      [data-pc-theme="dark"] .btn-outline {
        color: #9BB5FF;
        border-color: #9BB5FF;
      }

      .btn-outline:hover {
        background: #008000;
        color: #ffffff;
        transform: translateY(-2px);
      }

      [data-pc-theme="dark"] .btn-outline:hover {
        background: #9BB5FF;
        color: #1a202c;
      }

      .hero-visual {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
      }

      .hero-image-wrapper {
        position: relative;
        width: 100%;
        max-width: 600px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      }

      .hero-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
      }

      .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 128, 0, 0.1) 0%, rgba(0, 102, 0, 0.1) 100%);
        pointer-events: none;
      }

      [data-pc-theme="dark"] .image-overlay {
        background: linear-gradient(135deg, rgba(155, 181, 255, 0.1) 0%, rgba(122, 159, 255, 0.1) 100%);
      }

      /* Section Styles */
      section {
        padding: 100px 0;
      }

      .section-header {
        text-align: center;
        margin-bottom: 64px;
      }

      .section-title {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 16px;
        letter-spacing: -0.01em;
      }

      [data-pc-theme="dark"] .section-title {
        color: #9BB5FF;
      }

      .section-description {
        font-size: 18px;
        color: #4a5568;
        max-width: 600px;
        margin: 0 auto;
      }

      [data-pc-theme="dark"] .section-description {
        color: #a0aec0;
      }

      /* About Section */
      .about-section {
        background: #ffffff;
      }

      [data-pc-theme="dark"] .about-section {
        background: #1a202c;
      }

      .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 32px;
      }

      .about-card {
        text-align: center;
        padding: 0;
        border-radius: 12px;
        background: #f7fafc;
        transition: all 0.2s ease;
        overflow: hidden;
      }

      [data-pc-theme="dark"] .about-card {
        background: #2d3748;
      }

      .about-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      }

      .about-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
      }

      .about-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
      }

      .about-card:hover .about-image img {
        transform: scale(1.05);
      }

      .about-icon {
        font-size: 48px;
        color: #008000;
        margin: 24px 0;
      }

      [data-pc-theme="dark"] .about-icon {
        color: #9BB5FF;
      }

      .about-card-content {
        padding: 24px;
      }

      .about-card h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 12px;
      }

      [data-pc-theme="dark"] .about-card h3 {
        color: #9BB5FF;
      }

      .about-card p {
        color: #4a5568;
        line-height: 1.6;
      }

      [data-pc-theme="dark"] .about-card p {
        color: #a0aec0;
      }

      /* Features Section */
      .features-section {
        background: #f7fafc;
      }

      [data-pc-theme="dark"] .features-section {
        background: #2d3748;
      }

      .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 32px;
      }

      .feature-card {
        padding: 0;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        overflow: hidden;
      }

      [data-pc-theme="dark"] .feature-card {
        background: #1a202c;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      }

      .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      }

      .feature-image {
        width: 100%;
        height: 180px;
        overflow: hidden;
      }

      .feature-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
      }

      .feature-card:hover .feature-image img {
        transform: scale(1.05);
      }

      .feature-content {
        padding: 32px;
      }

      .feature-icon {
        font-size: 40px;
        color: #008000;
        margin-bottom: 20px;
      }

      [data-pc-theme="dark"] .feature-icon {
        color: #9BB5FF;
      }

      .feature-content h3 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 12px;
      }

      [data-pc-theme="dark"] .feature-content h3 {
        color: #9BB5FF;
      }

      .feature-content p {
        color: #4a5568;
        line-height: 1.6;
      }

      [data-pc-theme="dark"] .feature-content p {
        color: #a0aec0;
      }

      /* How It Works Section */
      .how-it-works-section {
        background: #ffffff;
      }

      [data-pc-theme="dark"] .how-it-works-section {
        background: #1a202c;
      }

      .steps-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 48px;
        max-width: 900px;
        margin: 0 auto;
      }

      .step-item {
        display: flex;
        gap: 24px;
        align-items: flex-start;
      }

      .step-number {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #008000;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
        flex-shrink: 0;
      }

      [data-pc-theme="dark"] .step-number {
        background: #9BB5FF;
        color: #1a202c;
      }

      .step-content h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 8px;
      }

      [data-pc-theme="dark"] .step-content h3 {
        color: #9BB5FF;
      }

      .step-content p {
        color: #4a5568;
        line-height: 1.6;
      }

      [data-pc-theme="dark"] .step-content p {
        color: #a0aec0;
      }

      /* Audience Section */
      .audience-section {
        background: #f7fafc;
      }

      [data-pc-theme="dark"] .audience-section {
        background: #2d3748;
      }

      .audience-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 32px;
      }

      .audience-card {
        padding: 40px 32px;
        background: #ffffff;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
      }

      [data-pc-theme="dark"] .audience-card {
        background: #1a202c;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      }

      .audience-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      }

      .audience-icon {
        font-size: 48px;
        color: #008000;
        margin-bottom: 24px;
      }

      [data-pc-theme="dark"] .audience-icon {
        color: #9BB5FF;
      }

      .audience-card h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 12px;
      }

      [data-pc-theme="dark"] .audience-card h3 {
        color: #9BB5FF;
      }

      .audience-card p {
        color: #4a5568;
        line-height: 1.6;
      }

      [data-pc-theme="dark"] .audience-card p {
        color: #a0aec0;
      }

      /* CTA Section */
      .cta-section {
        position: relative;
        padding: 100px 0;
        overflow: hidden;
      }

      .cta-background-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
      }

      .cta-background-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .cta-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 128, 0, 0.85) 0%, rgba(0, 102, 0, 0.85) 100%);
        z-index: 1;
      }

      [data-pc-theme="dark"] .cta-overlay {
        background: linear-gradient(135deg, rgba(155, 181, 255, 0.85) 0%, rgba(122, 159, 255, 0.85) 100%);
      }

      .cta-content {
        position: relative;
        text-align: center;
        max-width: 700px;
        margin: 0 auto;
        z-index: 2;
      }

      .cta-headline {
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 16px;
      }

      [data-pc-theme="dark"] .cta-headline {
        color: #1a202c;
      }

      .cta-description {
        font-size: 20px;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 40px;
        line-height: 1.6;
      }

      [data-pc-theme="dark"] .cta-description {
        color: rgba(26, 32, 44, 0.8);
      }

      .btn-cta {
        background: #ffffff;
        color: #008000;
        font-size: 18px;
        padding: 16px 40px;
      }

      [data-pc-theme="dark"] .btn-cta {
        background: #1a202c;
        color: #9BB5FF;
      }

      .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      }

      /* Footer */
      .footer-section {
        background: #1a202c;
        padding: 80px 0 32px;
        color: #e2e8f0;
      }

      [data-pc-theme="dark"] .footer-section {
        background: #0f1419;
      }

      .footer-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 64px;
        margin-bottom: 48px;
      }

      .footer-logo {
        max-width: 250px;
        height: auto;
        margin-bottom: 16px;
      }

      .footer-mission {
        color: #a0aec0;
        line-height: 1.6;
        max-width: 400px;
      }

      .footer-links {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
      }

      .footer-link-group h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
      }

      .footer-link-group ul {
        list-style: none;
      }

      .footer-link-group ul li {
        margin-bottom: 12px;
      }

      .footer-link-group ul li a {
        color: #a0aec0;
        text-decoration: none;
        transition: color 0.2s ease;
      }

      .footer-link-group ul li a:hover {
        color: #ffffff;
      }

      .footer-bottom {
        padding-top: 32px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        color: #a0aec0;
      }

      /* Responsive Design */
      @media (max-width: 968px) {
        .hero-content {
          grid-template-columns: 1fr;
          gap: 48px;
        }

        .hero-headline {
          font-size: 42px;
        }

        .section-title {
          font-size: 36px;
        }

        .footer-content {
          grid-template-columns: 1fr;
          gap: 48px;
        }
      }

      @media (max-width: 640px) {
        .hero-headline {
          font-size: 32px;
        }

        .hero-subtext {
          font-size: 18px;
        }

        .section-title {
          font-size: 28px;
        }

        .theme-toggle-container {
          top: 20px;
          right: 20px;
        }

        .btn-theme-toggle {
          width: 40px;
          height: 40px;
        }

        section {
          padding: 64px 0;
        }

        .hero-cta {
          flex-direction: column;
        }

        .btn {
          width: 100%;
          text-align: center;
        }
      }
    </style>
  </body>
</html>
