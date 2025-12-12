<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<a href="<?= base_url('/'); ?>" class="btn btn-outline-light ms-auto d-inline-flex align-items-center gap-2 rounded-xl px-3 py-2 fw-medium">
   <i class="material-icons">qr_code</i>
   <span class="d-none d-sm-inline">Scan QR</span>
</a>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<style>
   :root {
      /* ===== Theme tokens ===== */
      --bg1: rgba(14, 165, 233, .30);
      --bg2: rgba(139, 92, 246, .28);
      --bg3: rgba(34, 197, 94, .26);
      --card: #0f1720e6;
      --text-strong: #e6edf4;
      --text-soft: #b8c2cf;
      --label: #cbd5e1;
      --ring: #5b8def;
      --border: rgba(148, 163, 184, .25);
      --input-bg: #0a0f1a;
      --placeholder: #94a3b8;
      --btn1: #5b8def;
      --btn2: #6cc2f6;
      --radius: 18px;

      /* ===== Responsive type/spacing ===== */
      --fz-title: clamp(20px, 4.2vw, 26px);
      --fz-body: clamp(14px, 1.2vw + 12px, 16px);
      --fz-micro: clamp(12px, .6vw + 10px, 13.5px);
      --card-w: clamp(320px, 92vw, 420px);
      --pad-x: clamp(16px, 4vw, 24px);
      --pad-y: clamp(14px, 3.2vw, 22px);
   }

   @media (prefers-color-scheme: light) {
      :root {
         /* tetap gelas-gelasan, tapi lebih terang jika layout utamanya light */
         --card: #ffffffee;
         --text-strong: #0f172a;
         --text-soft: #475569;
         --input-bg: #f8fafc;
         --border: rgba(2, 6, 23, .10);
         --placeholder: #64748b;
      }
   }

   html,
   body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
      font-size: var(--fz-body);
   }

   /* ===== Background responsif (pakai safe-area) ===== */
   .auth-bg {
      min-height: 100dvh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: max(20px, env(safe-area-inset-top)) max(20px, env(safe-area-inset-right)) max(24px, env(safe-area-inset-bottom)) max(20px, env(safe-area-inset-left));
      background:
         radial-gradient(1200px 600px at 10% 10%, var(--bg1) 0%, transparent 60%),
         radial-gradient(1000px 500px at 90% 15%, var(--bg2) 0%, transparent 60%),
         radial-gradient(900px 600px at 50% 100%, var(--bg3) 0%, transparent 60%),
         linear-gradient(180deg, #f6f7fb 0%, #eef2f7 100%);
      background-attachment: fixed;
      position: relative;
      overflow: hidden;
   }

   .auth-bg:before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(255, 255, 255, .55), rgba(255, 255, 255, .35));
      pointer-events: none;
   }

   /* ===== Card responsif ===== */
   .auth-card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: var(--card-w);
      border-radius: var(--radius);
      border: 1px solid var(--border);
      background: var(--card);
      -webkit-backdrop-filter: blur(10px);
      backdrop-filter: blur(10px);
      box-shadow: 0 14px 34px rgba(2, 6, 23, .22), 0 2px 10px rgba(2, 6, 23, .18);
   }

   .auth-card-header {
      padding: calc(var(--pad-y) + 4px) var(--pad-x) 6px var(--pad-x);
      text-align: center;
   }

   .brand-badge {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: linear-gradient(135deg, #7aa6ff, #71d1ff);
      display: inline-grid;
      place-items: center;
      color: white;
      margin-bottom: 10px;
      box-shadow: 0 6px 18px rgba(2, 6, 23, .28);
   }

   .auth-title {
      margin: 2px 0 6px;
      font-weight: 800;
      color: var(--text-strong);
      font-size: var(--fz-title);
      letter-spacing: .2px;
      line-height: 1.2;
   }

   .auth-sub {
      margin: 0 0 14px;
      color: var(--text-soft);
      font-size: var(--fz-micro);
      line-height: 1.5;
   }

   .auth-body {
      padding: var(--pad-y) var(--pad-x) calc(var(--pad-y) + 4px);
   }

   /* ===== Field responsif & touch-friendly ===== */
   .field {
      margin: 14px 0 16px;
   }

   .label {
      display: block;
      font-size: var(--fz-micro);
      color: var(--label);
      margin: 0 0 8px 2px;
      font-weight: 700;
      letter-spacing: .1px;
   }

   .control {
      position: relative;
   }

   .control i.icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #8aa0b7;
      pointer-events: none;
      font-size: 20px;
   }

   .input {
      width: 100%;
      border-radius: 14px;
      border: 1px solid var(--border);
      outline: none;
      padding: clamp(12px, 1.6vw, 14px) 44px clamp(12px, 1.6vw, 14px) 40px;
      font-size: clamp(15px, 1.4vw, 15.5px);
      background: var(--input-bg);
      color: var(--text-strong);
      transition: border-color .15s ease, box-shadow .15s ease;
   }

   .input::placeholder {
      color: var(--placeholder);
   }

   .input:focus {
      border-color: var(--ring);
      box-shadow: 0 0 0 3px color-mix(in oklab, var(--ring) 25%, transparent);
   }

   .toggle {
      position: absolute;
      right: 6px;
      top: 50%;
      transform: translateY(-50%);
      border: none;
      background: transparent;
      cursor: pointer;
      color: #9fb1c6;
      padding: 8px;
      border-radius: 10px;
      line-height: 0;
      touch-action: manipulation;
   }

   .toggle:hover {
      background: rgba(148, 163, 184, .12);
   }

   .toggle .material-icons {
      font-size: 20px;
   }

   /* CapsLock info */
   .caps {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 8px 2px 0;
      font-size: 12.5px;
      color: #ffd166;
   }

   .caps i {
      font-size: 16px;
   }

   .caps[hidden] {
      display: none;
   }

   .helper {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-top: 6px;
      flex-wrap: wrap;
   }

   .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: var(--text-soft);
   }

   .auth-actions {
      margin-top: 18px;
   }

   .btn-primary-modern {
      width: 100%;
      border: none;
      border-radius: 14px;
      padding: clamp(12px, 1.6vw, 13px) 16px;
      font-weight: 800;
      font-size: clamp(15px, 1.4vw, 16px);
      background: linear-gradient(135deg, var(--btn1), var(--btn2));
      color: #fff;
      cursor: pointer;
      box-shadow: 0 10px 18px rgba(91, 141, 239, .26);
      transition: transform .06s ease, box-shadow .2s ease;
      touch-action: manipulation;
   }

   .btn-primary-modern:active {
      transform: translateY(1px);
      box-shadow: 0 6px 12px rgba(91, 141, 239, .22);
   }

   .links {
      margin-top: 12px;
      text-align: center;
   }

   .links a {
      color: #86b3ff;
      text-decoration: none;
      font-size: 14px;
   }

   .links a:hover {
      text-decoration: underline;
   }

   .is-invalid {
      border-color: #ef4444 !important;
   }

   .invalid-feedback {
      color: #ef9a9a;
      font-size: 12.5px;
      margin-top: 6px;
      min-height: 16px;
   }

   /* ===== Small devices tweaks ===== */
   @media (max-width: 575.98px) {
      .brand-badge {
         width: 40px;
         height: 40px;
      }

      .auth-sub {
         margin-bottom: 10px;
      }

      .toggle {
         right: 4px;
      }
   }

   @media (max-width: 420px) {
      :root {
         --card-w: clamp(300px, 94vw, 360px);
      }

      .auth-body {
         padding: 14px 14px 18px;
      }

      .auth-card-header {
         padding: 18px 14px 6px;
      }

      .links a {
         font-size: 13.5px;
      }
   }

   /* ===== Reduce motion ===== */
   @media (prefers-reduced-motion: reduce) {
      .btn-primary-modern {
         transition: none;
      }

      .toggle {
         transition: none;
      }
   }
</style>

<div class="auth-bg">
   <div class="auth-card" role="region" aria-labelledby="authTitle">
      <div class="auth-card-header">
         <div class="brand-badge" aria-hidden="true"><i class="material-icons">lock</i></div>
         <h1 id="authTitle" class="auth-title">Login Petugas</h1>
         <p class="auth-sub">Silakan masukkan username/email dan kata sandi Anda</p>
      </div>

      <div class="auth-body">
         <?= view('\\App\\Views\\admin\\_message_block') ?>
         <form action="<?= url_to('login') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="field">
               <?php if ($config->validFields === ['email']) : ?>
                  <label for="loginInput" class="label"><?= lang('Auth.email') ?></label>
                  <div class="control">
                     <i class="material-icons icon">mail</i>
                     <input id="loginInput" type="email" name="login" autocomplete="username" autofocus
                        class="input form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        placeholder="nama@contoh.com" />
                  </div>
                  <div class="invalid-feedback"><?= session('errors.login') ?></div>
               <?php else : ?>
                  <label for="loginInput" class="label"><?= lang('Auth.emailOrUsername') ?></label>
                  <div class="control">
                     <i class="material-icons icon">person</i>
                     <input id="loginInput" type="text" name="login" autocomplete="username" autofocus
                        class="input form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                        placeholder="email atau username" />
                  </div>
                  <div class="invalid-feedback"><?= session('errors.login') ?></div>
               <?php endif; ?>
            </div>

            <div class="field">
               <label for="passwordInput" class="label">Password</label>
               <div class="control">
                  <i class="material-icons icon">vpn_key</i>
                  <input id="passwordInput" type="password" name="password" autocomplete="current-password"
                     class="input form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="••••••••" aria-describedby="capsMsg" />
                  <button type="button" class="toggle" aria-label="Tampilkan/Sembunyikan password"
                     onclick="(function(btn){ const i=document.getElementById('passwordInput'); const icon=btn.firstElementChild; if(i.type==='password'){ i.type='text'; icon.textContent='visibility_off'; } else { i.type='password'; icon.textContent='visibility'; } })(this)">
                     <i class="material-icons">visibility</i>
                  </button>
               </div>
               <div id="capsMsg" class="caps" hidden aria-live="polite">
                  <i class="material-icons" aria-hidden="true">keyboard_capslock</i>
                  <span>Caps Lock aktif</span>
               </div>
               <div class="invalid-feedback"><?= session('errors.password') ?></div>
            </div>

            <?php if ($config->allowRemembering) : ?>
               <div class="helper">
                  <label class="remember">
                     <input type="checkbox" name="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
                     <span><?= lang('Auth.rememberMe') ?></span>
                  </label>
                  <?php if ($config->activeResetter) : ?>
                     <a href="<?= url_to('forgot') ?>" class="small">Lupa password?</a>
                  <?php endif; ?>
               </div>
            <?php endif; ?>

            <div class="auth-actions">
               <button type="submit" class="btn-primary-modern"><?= lang('Auth.loginAction') ?></button>
            </div>

            <?php if (!$config->allowRemembering && $config->activeResetter) : ?>
               <div class="links"><a href="<?= url_to('forgot') ?>">Lupa password?</a></div>
            <?php endif; ?>
         </form>
      </div>
   </div>
</div>

<script>
   // Submit guard & CapsLock sensor (tetap ringan, aman di mobile)
   (function() {
      const container = document.currentScript.previousElementSibling; // .auth-bg
      const form = container.querySelector('form');
      const pwd = container.querySelector('#passwordInput');
      const caps = container.querySelector('#capsMsg');

      if (form) {
         form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
               btn.disabled = true;
               btn.style.opacity = .9;
               btn.textContent = 'Memproses…';
            }
         });
      }

      function updateCaps(e) {
         if (!pwd) return;
         const on = e && e.getModifierState ? e.getModifierState('CapsLock') : false;
         caps.hidden = !on;
      }
      if (pwd) {
         ['keydown', 'keyup', 'focus'].forEach(ev => pwd.addEventListener(ev, updateCaps));
         pwd.addEventListener('blur', () => {
            caps.hidden = true;
         });
      }
   })();
</script>
<?= $this->endSection(); ?>