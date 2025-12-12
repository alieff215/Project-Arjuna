<head>
  <!-- === Theme bootstrapper: set data-theme lebih awal & persist === -->
  <script>
    (function () {
      var KEY = 'ui-theme';
      try {
        var saved = localStorage.getItem(KEY);
        if (saved !== 'light' && saved !== 'dark') {
          var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
          saved = prefersDark ? 'dark' : 'light';
          localStorage.setItem(KEY, saved);
        }
        document.documentElement.setAttribute('data-theme', saved);
      } catch (e) {
        document.documentElement.setAttribute('data-theme', 'light');
      }
    })();
  </script>

  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <?= csrf_meta(); ?>
  <?= $this->include('templates/css'); ?>
  <title><?= $title ?></title>
  <?= $this->include('templates/js') ?>

  <!-- ===== Global Design Tokens & Theme ===== -->
  <style>
    :root{
      --bg:#eef3fb; --bg-accent-1:#e5efff; --bg-accent-2:#f0f7ff;
      --card:#ffffffcc; --card-solid:#ffffff;
      --text:#0b132b; --muted:#6b7b93; --border:rgba(16,24,40,.12); --ring:#2563eb;
      --primary:#3b82f6; --success:#10b981; --warning:#f59e0b; --danger:#ef4444;
      --radius:18px; --shadow-1:0 10px 30px rgba(12,20,40,.08); --shadow-2:0 18px 60px rgba(12,20,40,.12);
      --glass-blur:8px; --neon:0 0 0 1px color-mix(in oklab, var(--ring) 20%, transparent), 0 10px 30px rgba(37,99,235,.08);
    }
    [data-theme="dark"]{
      --bg:#070d1a; --bg-accent-1:#0a1731; --bg-accent-2:#0f213f;
      --card:rgba(12,18,36,.55); --card-solid:#0f182d;
      --text:#e6ecff; --muted:#9fb1cc; --border:rgba(200,210,230,.14); --ring:#7dd3fc;
      --primary:#7aa8ff; --success:#34d399; --warning:#fbbf24; --danger:#fb7185;
      --shadow-1:0 16px 36px rgba(0,0,0,.45); --shadow-2:0 25px 70px rgba(0,0,0,.55);
      --glass-blur:12px; --neon:0 0 0 1px color-mix(in oklab, var(--ring) 35%, transparent), 0 10px 40px rgba(0,186,255,.12);
    }

    /* Global overrides */
    html,body{ background:var(--bg)!important; color:var(--text)!important; }
    .main-panel,.content{ background:var(--bg)!important; color:var(--text)!important; }
    .card,.u-card{ background:var(--card)!important; color:var(--text)!important; border-color:var(--border)!important; }
    a,.link{ color:var(--primary); }

    /* Background util */
    .app-content-bg{ position:relative;
      background:
        radial-gradient(1100px 420px at 8% -10%, var(--bg-accent-2) 0%, transparent 60%),
        radial-gradient(900px 380px at 98% -5%, var(--bg-accent-1) 0%, transparent 55%),
        linear-gradient(180deg, var(--bg), var(--bg));
    }
    .app-content-bg::before{ content:""; position:absolute; inset:0;
      background-image:radial-gradient(color-mix(in oklab, var(--border) 40%, transparent) 1px,transparent 1px);
      background-size:12px 12px; opacity:.18; pointer-events:none;
    }

    /* Desktop theme button (di navbar) */
    .theme-btn{
      display:inline-flex; align-items:center; gap:8px; border-radius:999px;
      border:1px solid var(--border); background:color-mix(in oklab, var(--card-solid) 80%, transparent);
      color:var(--text); padding:10px 14px; cursor:pointer; box-shadow:var(--neon);
    }
    .theme-btn .material-icons{ font-size:20px; }

    /* Mobile floating theme button (ikon saja) */
    .theme-fab{
      position:fixed; right:16px; bottom:calc(16px + env(safe-area-inset-bottom));
      width:46px; height:46px; border-radius:999px; display:none; place-items:center;
      background:color-mix(in oklab, var(--card-solid) 88%, transparent);
      color:var(--text); border:1px solid var(--border); box-shadow:var(--shadow-2); z-index:2000;
    }
    .theme-fab .material-icons{ font-size:22px; line-height:1; }

    /* ======== RESPONSIVE TWEAKS ======== */
    .navbar-toggler{ border:1px solid var(--border); border-radius:12px; padding:6px 8px; }
    .navbar-toggler .icon-bar{ display:block; width:22px; height:2px; margin:4px 0; border-radius:999px; background:var(--text); }
    .dropdown-menu{ background:var(--card); border:1px solid var(--border); box-shadow:var(--shadow-2); }

    .footer{ border-top:1px solid var(--border); background:color-mix(in oklab, var(--card-solid) 92%, transparent); }
    .footer .container-fluid{ display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .footer nav ul{ display:flex; gap:12px; padding:0; margin:0; list-style:none; }
    .footer a{ color:var(--text); font-weight:600; }

    @media (max-width: 991.98px){
      .navbar.custom-navbar-line .navbar-collapse{
        background:color-mix(in oklab, var(--card-solid) 92%, transparent);
        border:1px solid var(--border); border-radius:14px; padding:8px 10px; margin-top:8px; box-shadow:var(--shadow-2);
      }
      .navbar .navbar-brand{ font-size:18px; }
      .navbar .nav-link p{ display:none; }
      .theme-btn{ padding:8px 10px; }
    }
    @media (max-width: 575.98px){
      .navbar .container-fluid{ padding-left:12px!important; padding-right:12px!important; }
      .theme-btn--desktop{ display:none !important; }   /* sembunyikan tombol besar di HP */
      .theme-fab{ display:grid; }                       /* tampilkan FAB kecil di HP */
      .footer .container-fluid{ flex-direction:column; text-align:center; }
      .footer{ padding-bottom:calc(10px + env(safe-area-inset-bottom)); font-size:13px; }
    }
  </style>

  <!-- ===== Toggle & sinkron label (global) ===== -->
  <script>
    (function () {
      var KEY = 'ui-theme';
      window.toggleTheme = function () {
        var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
        var next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        try { localStorage.setItem(KEY, next); } catch(e){}

        // sinkron icon/label di navbar & FAB
        var icon = document.getElementById('themeIcon');
        var text = document.getElementById('themeText');
        var fab  = document.getElementById('themeFabIcon');
        if (icon && text){
          if (next === 'dark'){ icon.textContent='light_mode'; text.textContent='Terang'; }
          else { icon.textContent='dark_mode'; text.textContent='Gelap'; }
        }
        if (fab){
          fab.textContent = (next === 'dark') ? 'light_mode' : 'dark_mode';
        }
      };
      document.addEventListener('DOMContentLoaded', function(){
        var mode = document.documentElement.getAttribute('data-theme') || 'light';
        var icon = document.getElementById('themeIcon');
        var text = document.getElementById('themeText');
        var fab  = document.getElementById('themeFabIcon');
        if (icon && text){
          if (mode === 'dark'){ icon.textContent='light_mode'; text.textContent='Terang'; }
          else { icon.textContent='dark_mode'; text.textContent='Gelap'; }
        }
        if (fab){
          fab.textContent = (mode === 'dark') ? 'light_mode' : 'dark_mode';
        }
      });
    })();
  </script>

  <script>
    var BaseConfig = {
      baseURL: '<?= base_url(); ?>',
      csrfTokenName: '<?= csrf_token() ?>',
      textOk: "Ok",
      textCancel: "Batalkan"
    };
  </script>

  <!-- FAB Theme (muncul hanya di HP) -->
  <button class="theme-fab" type="button" onclick="toggleTheme()" aria-label="Toggle theme (mobile)">
    <i class="material-icons" id="themeFabIcon">dark_mode</i>
  </button>
</head>
