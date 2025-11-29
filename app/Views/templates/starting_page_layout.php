<!DOCTYPE html>
<html lang="en">

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

   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?= $this->include('templates/css'); ?>
   <title>Absensi QR Code</title>
   <style>
      /* ===== Global Design Tokens & Theme ===== */
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

      .bg {
         background: url(<?= base_url('assets/img/bg2.jpg'); ?>) center;
         opacity: 0.1;
         background-size: cover;
         height: 100vh;
         width: 100%;
         position: absolute;
         left: 0;
         top: 0;
      }

      .main-panel {
         position: relative;
         float: left;
         width: calc(100%);
         transition: 0.33s, cubic-bezier(0.685, 0.0473, 0.346, 1);
      }

      video#previewKamera {
         width: 100%;
         height: 400px;
         margin: 0;
      }

      .previewParent {
         width: auto;
         height: auto;
         margin: auto;
         margin: auto;
         border: 2px solid var(--border);
      }

      .unpreview {
         background-color: var(--bg-accent-1);
         text-align: center;
      }

      .form-select {
         min-width: 200px;
      }

      /* Theme button styles */
      .theme-btn{
        display:inline-flex; align-items:center; gap:8px; border-radius:999px;
        border:1px solid var(--border); background:color-mix(in oklab, var(--card-solid) 80%, transparent);
        color:var(--text); padding:10px 14px; cursor:pointer; box-shadow:var(--neon);
      }
      .theme-btn .material-icons{ font-size:20px; }

      /* Mobile floating theme button */
      .theme-fab{
        position:fixed; right:16px; bottom:calc(16px + env(safe-area-inset-bottom));
        width:46px; height:46px; border-radius:999px; display:none; place-items:center;
        background:color-mix(in oklab, var(--card-solid) 88%, transparent);
        color:var(--text); border:1px solid var(--border); box-shadow:var(--shadow-2); z-index:2000;
      }
      .theme-fab .material-icons{ font-size:22px; line-height:1; }

      @media (max-width: 575.98px){
        .theme-btn--desktop{ display:none !important; }
        .theme-fab{ display:grid; }
      }
   </style>
</head>

<body>
   <div class="bg bg-image"></div>
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
      <div class="container-fluid">
         <div class="navbar-wrapper row w-100">
            <div class="col-6">
               <?php if (!isset($hideNavbarTitle) || $hideNavbarTitle !== true): ?>
               <p class="navbar-brand"><b><?= $title ?? 'Login'; ?></b></p>
               <?php endif; ?>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
               <!-- Theme Toggle Button -->
               <button class="theme-btn theme-btn--desktop me-3" type="button" onclick="toggleTheme()" aria-label="Toggle theme">
                  <i class="material-icons" id="themeIcon">dark_mode</i>
                  <span id="themeText">Gelap</span>
               </button>
               <?= $this->renderSection('navaction') ?>
            </div>
         </div>
      </div>
   </nav>
   <!-- End Navbar -->

   <!-- FAB Theme (muncul hanya di HP) -->
   <button class="theme-fab" type="button" onclick="toggleTheme()" aria-label="Toggle theme (mobile)">
     <i class="material-icons" id="themeFabIcon">dark_mode</i>
   </button>
   <?= $this->renderSection('content') ?>
   <?= $this->include('templates/js'); ?>

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
</body>

</html>