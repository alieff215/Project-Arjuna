<?php
// app/Views/templates/sidebar.php
helper('url');

// Load RoleHelper
$roleHelper = new \App\Libraries\RoleHelper();
$userRole = $roleHelper->getUserRole();
$accessibleMenus = $roleHelper->getAccessibleMenus();

// Jika user role adalah 'user', redirect ke scan
if ($userRole->value === 'user') {
    // User hanya bisa akses scan, tidak perlu menampilkan sidebar admin
    return;
}

/* ======================================================
   1) Deteksi context dari URL (SELALU dipakai)
   ====================================================== */
$routeContext = null;
if (url_is('admin/absen-karyawan*'))             $routeContext = 'absen-karyawan';
elseif (url_is('admin/absen-admin*'))            $routeContext = 'absen-admin';
elseif (url_is('admin/karyawan*'))               $routeContext = 'karyawan';
elseif (url_is('admin/admin*'))                  $routeContext = 'admin';
elseif (url_is('admin/departemen*') || url_is('admin/jabatan*'))
                                                 $routeContext = 'departemen';
elseif (url_is('admin/generate*'))               $routeContext = 'qr';
elseif (url_is('admin/laporan*'))                $routeContext = 'laporan';
elseif (url_is('admin/gaji/rekap'))              $routeContext = 'rekap-gaji';
elseif (url_is('admin/gaji*'))                   $routeContext = 'gaji';
elseif (url_is('admin/petugas*'))                $routeContext = 'petugas';
elseif (url_is('admin/approval*'))               $routeContext = 'approval';
elseif (url_is('admin/general-settings*'))       $routeContext = 'general_settings';
else                                             $routeContext = 'dashboard';

/* ======================================================
   2) Final context (PASTIKAN pakai URL, abaikan $ctx)
   ====================================================== */
$context = $routeContext;

/* ======================================================
   3) Warna sidebar berdasar context
   ====================================================== */
switch ($context) {
  case 'absen-karyawan':
  case 'karyawan':
  case 'departemen':
    $sidebarColor = 'purple';
    break;

  case 'absen-admin': // ✅ Absensi Admin = hijau
  case 'admin':
    $sidebarColor = 'green';
    break;

  case 'qr':
    $sidebarColor = 'danger';
    break;

  case 'approval':
    $sidebarColor = 'warning';
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
    <a class="simple-text logo-normal"><b>Operator<br>Petugas Absensi</b></a>
  </div>

  <div class="sidebar-wrapper">
    <ul class="nav">

      <!-- Dashboard (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['dashboard'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'dashboard',['admin','admin/dashboard']) ?>">
        <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Absensi Karyawan (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_absen_karyawan'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'absen-karyawan',['admin/absen-karyawan*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/absen-karyawan'); ?>">
          <i class="material-icons">checklist</i>
          <p>Absensi Karyawan</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Absensi Admin (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_absen_admin'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'absen-admin',['admin/absen-admin*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/absen-admin'); ?>">
          <i class="material-icons">checklist</i>
          <p>Absensi Admin</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Data Karyawan (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_karyawan'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'karyawan',['admin/karyawan*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/karyawan'); ?>">
          <i class="material-icons">person</i>
          <p>Data Karyawan</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Data Admin (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_admin'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'admin',['admin/admin*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/admin'); ?>">
          <i class="material-icons">person_4</i>
          <p>Data Admin</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Departemen & Jabatan (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_departemen'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'departemen',['admin/departemen*','admin/jabatan*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/departemen'); ?>">
          <i class="material-icons">school</i>
          <p>Data Departemen &amp; Jabatan</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Generate QR Code (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['generate_qr'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'qr',['admin/generate*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/generate'); ?>">
          <i class="material-icons">qr_code</i>
          <p>Generate QR Code</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Generate Laporan (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['generate_laporan'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'laporan',['admin/laporan*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">
          <i class="material-icons">print</i>
          <p>Generate Laporan</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Manajemen Gaji (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_gaji'] ?? false): ?>
      <li class="nav-item <?= nav_active(
            $context,'gaji',
            ['admin/gaji','admin/gaji/add','admin/gaji/edit*','admin/gaji/delete*','admin/gaji/export']
          ) ?>">
        <a class="nav-link" href="<?= base_url('admin/gaji'); ?>">
          <i class="material-icons">payments</i>
          <p>Manajemen Gaji</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Inventory (untuk admin dan super admin) -->
      <?php if ($accessibleMenus['data_inventory'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'inventory',['admin/inventory']) ?>">
        <a class="nav-link" href="<?= base_url('admin/inventory'); ?>">
          <i class="material-icons">inventory</i>
          <p>Inventory</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Data Petugas (hanya untuk super admin) -->
      <?php if ($accessibleMenus['data_petugas'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'petugas',['admin/petugas*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/petugas'); ?>">
          <i class="material-icons">computer</i>
          <p>Data Petugas</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Manajemen Approval (hanya untuk super admin) -->
      <?php if ($accessibleMenus['approval_management'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'approval',['admin/approval*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/approval'); ?>">
          <i class="material-icons">approval</i>
          <p>Manajemen Approval</p>
        </a>
      </li>
      <?php endif; ?>

      <!-- Pengaturan (hanya untuk super admin) -->
      <?php if ($accessibleMenus['general_settings'] ?? false): ?>
      <li class="nav-item <?= nav_active($context,'general_settings',['admin/general-settings*']) ?>">
        <a class="nav-link" href="<?= base_url('admin/general-settings'); ?>">
          <i class="material-icons">settings</i>
          <p>Pengaturan</p>
        </a>
      </li>
      <?php endif; ?>

    </ul>
  </div>
</div>
