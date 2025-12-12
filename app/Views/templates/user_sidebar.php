<?php
// app/Views/templates/user_sidebar.php
helper('url');

/* ======================================================
   1) Deteksi context dari URL (SELALU dipakai)
   ====================================================== */
$routeContext = null;
if (url_is('scan*'))                              $routeContext = 'scan';
else                                              $routeContext = 'dashboard';

/* ======================================================
   2) Final context (PASTIKAN pakai URL, abaikan $ctx)
   ====================================================== */
$context = $routeContext;

/* ======================================================
   3) Warna sidebar berdasar context
   ====================================================== */
switch ($context) {
  case 'scan':
    $sidebarColor = 'info';
    break;

  default:
    $sidebarColor = 'azure';
    break;
}

/* ======================================================
   4) Helper nav active
   ====================================================== */
function nav_active(string $current, string $key, array $patterns = []): string {
    if ($current === $key) return 'active';
    foreach ($patterns as $p) {
        if (url_is($p)) return 'active';
    }
    return '';
}
?>

<div class="sidebar"
     data-color="<?= esc($sidebarColor) ?>"
     data-background-color="black"
     data-image="<?= base_url('assets/img/sidebar/sidebar-1.jpg'); ?>">

  <div class="logo">
    <a class="simple-text logo-normal"><b>User<br>Absensi</b></a>
  </div>

  <div class="sidebar-wrapper">
    <ul class="nav">

      <!-- Menu Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
          <i class="material-icons">dashboard</i>
          <p>Kembali ke Dashboard</p>
        </a>
      </li>

      <!-- Menu Scan (untuk user) -->
      <li class="nav-item <?= nav_active($context,'scan',['scan*']) ?>">
        <a class="nav-link" href="<?= base_url('scan'); ?>">
          <i class="material-icons">qr_code_scanner</i>
          <p>Scan QR Code</p>
        </a>
      </li>

      <!-- Menu Scan Masuk -->
      <li class="nav-item <?= nav_active($context,'scan-masuk',['scan/masuk']) ?>">
        <a class="nav-link" href="<?= base_url('scan/masuk'); ?>">
          <i class="material-icons">login</i>
          <p>Absen Masuk</p>
        </a>
      </li>

      <!-- Menu Scan Pulang -->
      <li class="nav-item <?= nav_active($context,'scan-pulang',['scan/pulang']) ?>">
        <a class="nav-link" href="<?= base_url('scan/pulang'); ?>">
          <i class="material-icons">logout</i>
          <p>Absen Pulang</p>
        </a>
      </li>

      <!-- Button Logout -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
          <i class="material-icons">exit_to_app</i>
          <p>Logout</p>
        </a>
      </li>

    </ul>
  </div>
</div>
