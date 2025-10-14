<?php
$context = $ctx ?? 'dashboard';
switch ($context) {
   case 'absen-karyawan':
   case 'karyawan':
   case 'departemen':
      $sidebarColor = 'purple';
      break;
   case 'gaji':
      $sidebarColor = 'purple';
      break;   
   case 'absen-admin':
   case 'admin':
      $sidebarColor = 'green';
      break;

   case 'qr':
      $sidebarColor = 'danger';
      break;

   default:
      $sidebarColor = 'azure';
      break;
}
?>
<div class="sidebar" data-color="<?= $sidebarColor; ?>" data-background-color="black" data-image="<?= base_url('assets/img/sidebar/sidebar-1.jpg'); ?>">
   <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
   <div class="logo">
      <a class="simple-text logo-normal">
         <b>Operator<br>Petugas Absensi</b>
      </a>
   </div>
   <div class="sidebar-wrapper">
      <ul class="nav">
         <li class="nav-item <?= $context == 'dashboard' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
               <i class="material-icons">dashboard</i>
               <p>Dashboard</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'absen-karyawan' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/absen-karyawan'); ?>">
               <i class="material-icons">checklist</i>
               <p>Absensi Karyawan</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'absen-admin' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/absen-admin'); ?>">
               <i class="material-icons">checklist</i>
               <p>Absensi Admin</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'karyawan' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/karyawan'); ?>">
               <i class="material-icons">person</i>
               <p>Data Karyawan</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'admin' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/admin'); ?>">
               <i class="material-icons">person_4</i>
               <p>Data Admin</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'departemen' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/departemen'); ?>">
               <i class="material-icons">business</i>
               <p>Data Departemen & Jabatan</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'qr' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/generate'); ?>">
               <i class="material-icons">qr_code</i>
               <p>Generate QR Code</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'laporan' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">
               <i class="material-icons">print</i>
               <p>Generate Laporan</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'gaji' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/gaji'); ?>">
               <i class="material-icons">payments</i>
               <p>Manajemen Gaji</p>
            </a>
         </li>
         <?php if (user()->toArray()['is_superadmin'] ?? '0' == '1') : ?>
            <li class="nav-item <?= $context == 'petugas' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/petugas'); ?>">
                  <i class="material-icons">computer</i>
                  <p>Data Petugas</p>
               </a>
            </li>
            <li class="nav-item <?= $context == 'inventory' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/inventory'); ?>">
               <i class="material-icons">inventory</i>
               <p>Inventory</p>
            </a>
         </li>
            <li class="nav-item <?= $context == 'general_settings' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/general-settings'); ?>">
                  <i class="material-icons">settings</i>
                  <p>Pengaturan</p>
               </a>
            </li>
         <?php endif; ?>
         <!-- <li class="nav-item active-pro mb-3">
            <a class="nav-link" href="./upgrade.html">
               <i class="material-icons">unarchive</i>
               <p>Bottom sidebar</p>
            </a>
         </li> -->
      </ul>
   </div>
</div>