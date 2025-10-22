<!-- Navbar untuk User -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top custom-navbar-line">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <p class="navbar-brand mb-0"><b><?= $title; ?></b></p>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav align-items-center">
        <!-- Toggle Theme -->
        <li class="nav-item d-flex align-items-center mr-lg-2">
          <button class="theme-btn theme-btn--desktop" type="button" onclick="toggleTheme()" aria-label="Toggle theme">
            <i class="material-icons" id="themeIcon">dark_mode</i>
            <span id="themeText">Gelap</span>
          </button>
        </li>

        <!-- User Info dan Logout -->
        <li class="nav-item dropdown">
          <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">Account</p>
            <span>User : <?= session()->get('username') ?? 'User'; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="<?= base_url('/logout'); ?>">
              <i class="material-icons mr-2">logout</i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>

  <!-- Garis pemisah modern -->
  <style>
    .custom-navbar-line{ 
      background:transparent!important; 
      border:0!important; 
      box-shadow:none!important; 
      position:fixed; 
      top:0; 
      left:0; 
      right:0; 
      z-index:1050; 
    }
    .custom-navbar-line .container-fluid{ 
      position:relative; 
    }
    
    .custom-navbar-line .container-fluid::after{
      content:""; 
      position:absolute; 
      left:0; 
      right:0; 
      bottom:-7px; 
      height:2px; 
      border-radius:2px;
      background:linear-gradient(180deg, color-mix(in oklab, var(--primary) 60%, var(--bg)) 0%, color-mix(in oklab, var(--primary) 45%, var(--bg)) 100%);
      box-shadow:0 1px 0 rgba(255,255,255,.14) inset, 0 2px 8px -2px color-mix(in oklab, var(--primary) 34%, transparent), 0 8px 18px -10px rgba(12,20,40,.18);
      pointer-events:none;
    }
    .custom-navbar-line .container-fluid::before{
      content:""; 
      position:absolute; 
      left:0; 
      right:0; 
      bottom:-21px; 
      height:14px;
      background:linear-gradient(180deg, color-mix(in oklab, var(--primary) 20%, transparent) 0%, transparent 80%);
      filter:blur(8px); 
      opacity:.36; 
      pointer-events:none;
    }
    [data-theme="dark"] .custom-navbar-line .container-fluid::after{
      background:linear-gradient(180deg, color-mix(in oklab, var(--primary) 72%, var(--bg)) 0%, color-mix(in oklab, var(--primary) 58%, var(--bg)) 100%);
      box-shadow:0 1px 0 rgba(0,0,0,.35) inset, 0 3px 10px -3px color-mix(in oklab, var(--primary) 32%, transparent), 0 10px 22px -12px rgba(0,0,0,.55);
    }
    [data-theme="dark"] .custom-navbar-line .container-fluid::before{ 
      opacity:.28; 
    }

    /* Responsif */
    @media (max-width: 991.98px){
      .navbar .nav-link, .navbar .dropdown-item{ 
        padding:10px 12px; 
        border-radius:10px; 
      }
      .custom-navbar-line .dropdown-menu{ 
        position:static!important; 
        float:none; 
        width:100%; 
        margin:4px 0 0; 
        box-shadow:none; 
        border:0; 
        background:transparent; 
      }
    }
    @media (max-width: 575.98px){
      .navbar .navbar-nav .nav-item{ 
        margin-left:4px; 
        margin-right:4px; 
      }
    }
  </style>
</nav>
<!-- End Navbar -->

<!-- FAB Theme (muncul hanya di HP) -->
<button class="theme-fab" type="button" onclick="toggleTheme()" aria-label="Toggle theme (mobile)">
  <i class="material-icons" id="themeFabIcon">dark_mode</i>
</button>
