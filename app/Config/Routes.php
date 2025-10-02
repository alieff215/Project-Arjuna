<?php
namespace Config;
use CodeIgniter\Router\RouteCollection;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
   $routes->get('/', 'webprofile::index');
$routes->group('scan', function (RouteCollection $routes) {
   $routes->get('', 'Scan::index');
   $routes->get('masuk', 'Scan::index/Masuk');
   $routes->get('pulang', 'Scan::index/Pulang');
   $routes->post('cek', 'Scan::cekKode');
});
// Admin
$routes->group('admin', function (RouteCollection $routes) {
   // Admin dashboard
   $routes->get('', 'Admin\Dashboard::index');
   $routes->get('dashboard', 'Admin\Dashboard::index');

   // Departemen
   $routes->group('departemen', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('/', 'DepartemenController::index');
      $routes->get('tambah', 'DepartemenController::tambahDepartemen');
      $routes->post('tambahDepartemenPost', 'DepartemenController::tambahDepartemenPost');
      $routes->get('edit/(:any)', 'DepartemenController::editDepartemen/$1');
      $routes->post('editDepartemenPost', 'DepartemenController::editDepartemenPost');
      $routes->post('deleteDepartemenPost', 'DepartemenController::deleteDepartemenPost');
      $routes->post('list-data', 'DepartemenController::listData');
   });

   // Jabatan
   $routes->group('jabatan', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('/', 'JabatanController::index');
      $routes->get('tambah', 'JabatanController::tambahJabatan');
      $routes->post('tambahJabatanPost', 'JabatanController::tambahJabatanPost');
      $routes->get('edit/(:any)', 'JabatanController::editJabatan/$1');
      $routes->post('editJabatanPost', 'JabatanController::editJabatanPost');
      $routes->post('deleteJabatanPost', 'JabatanController::deleteJabatanPost');
      $routes->post('list-data', 'JabatanController::listData');
   });

   // Gaji
   $routes->group('gaji', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('/', 'Gaji::index');
      $routes->get('add', 'Gaji::add');
      $routes->post('add', 'Gaji::add');
      $routes->get('edit/(:num)', 'Gaji::edit/$1');
      $routes->post('edit/(:num)', 'Gaji::edit/$1');
      $routes->get('delete/(:num)', 'Gaji::delete/$1');
      $routes->get('rekap', 'Gaji::rekap');
      $routes->post('rekap', 'Gaji::rekap');
      $routes->get('export', 'Gaji::export');
   });

   // admin lihat data karyawan
   $routes->get('karyawan', 'Admin\DataKaryawan::index');
   $routes->post('karyawan', 'Admin\DataKaryawan::ambilDataKaryawan');
   // admin tambah data karyawan
   $routes->get('karyawan/create', 'Admin\DataKaryawan::formTambahKaryawan');
   $routes->post('karyawan/create', 'Admin\DataKaryawan::saveKaryawan');
   // admin edit data karyawan
   $routes->get('karyawan/edit/(:any)', 'Admin\DataKaryawan::formEditKaryawan/$1');
   $routes->post('karyawan/edit', 'Admin\DataKaryawan::updateKaryawan');
   // admin hapus data karyawan
   $routes->delete('karyawan/delete/(:any)', 'Admin\DataKaryawan::delete/$1');
   $routes->get('karyawan/bulk', 'Admin\DataKaryawan::bulkPostKaryawan');

   // POST Data Karyawan

   $routes->group('karyawan', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->post('downloadCSVFilePost', 'DataKaryawan::downloadCSVFilePost');
      $routes->post('generateCSVObjectPost', 'DataKaryawan::generateCSVObjectPost');
      $routes->post('importCSVItemPost', 'DataKaryawan::importCSVItemPost');
      $routes->post('deleteSelectedKaryawan', 'DataKaryawan::deleteSelectedKaryawan');
   });


   // admin lihat data admin
   $routes->get('admin', 'Admin\DataAdmin::index');
   $routes->post('admin', 'Admin\DataAdmin::ambilDataAdmin');
   // admin tambah data admin
   $routes->get('admin/create', 'Admin\DataAdmin::formTambahAdmin');
   $routes->post('admin/create', 'Admin\DataAdmin::saveAdmin');
   // admin edit data admin
   $routes->get('admin/edit/(:any)', 'Admin\DataAdmin::formEditAdmin/$1');
   $routes->post('admin/edit', 'Admin\DataAdmin::updateAdmin');
   // admin hapus data admin
   $routes->delete('admin/delete/(:any)', 'Admin\DataAdmin::delete/$1');


   // admin lihat data absen karyawan
   $routes->get('absen-karyawan', 'Admin\DataAbsenKaryawan::index');
   $routes->post('absen-karyawan', 'Admin\DataAbsenKaryawan::ambilDataKaryawan'); // ambil Karyawan berdasarkan departemen dan tanggal
   $routes->post('absen-karyawan/kehadiran', 'Admin\DataAbsenKaryawan::ambilKehadiran'); // ambil kehadiran Karyawan
   $routes->post('absen-karyawan/edit', 'Admin\DataAbsenKaryawan::ubahKehadiran'); // ubah kehadiran Karyawan

   // admin lihat data absen admin
   $routes->get('absen-admin', 'Admin\DataAbsenAdmin::index');
   $routes->post('absen-admin', 'Admin\DataAbsenAdmin::ambilDataAdmin'); // ambil admin berdasarkan tanggal
   $routes->post('absen-admin/kehadiran', 'Admin\DataAbsenAdmin::ambilKehadiran'); // ambil kehadiran admin
   $routes->post('absen-admin/edit', 'Admin\DataAbsenAdmin::ubahKehadiran'); // ubah kehadiran admin

   // admin generate QR
   $routes->get('generate', 'Admin\GenerateQR::index');
   $routes->post('generate/karyawan-by-departemen', 'Admin\GenerateQR::getKaryawanByDepartemen'); // ambil Karyawan berdasarkan departemen

   // Generate QR
   $routes->post('generate/karyawan', 'Admin\QRGenerator::generateQrKaryawan');
   $routes->post('generate/admin', 'Admin\QRGenerator::generateQrAdmin');

   // Download QR
   $routes->get('qr/karyawan/download', 'Admin\QRGenerator::downloadAllQrKaryawan');
   $routes->get('qr/karyawan/(:any)/download', 'Admin\QRGenerator::downloadQrKaryawan/$1');
   $routes->get('qr/admin/download', 'Admin\QRGenerator::downloadAllQrAdmin');
   $routes->get('qr/admin/(:any)/download', 'Admin\QRGenerator::downloadQrAdmin/$1');

   // admin buat laporan
   $routes->get('laporan', 'Admin\GenerateLaporan::index');
   $routes->post('laporan/karyawan', 'Admin\GenerateLaporan::generateLaporanKaryawan');
   $routes->post('laporan/admin', 'Admin\GenerateLaporan::generateLaporanAdmin');

   // superadmin lihat data petugas
   $routes->get('petugas', 'Admin\DataPetugas::index');
   $routes->post('petugas', 'Admin\DataPetugas::ambilDataPetugas');
   // superadmin tambah data petugas
   $routes->get('petugas/register', 'Admin\DataPetugas::registerPetugas');
   // superadmin edit data petugas
   $routes->get('petugas/edit/(:any)', 'Admin\DataPetugas::formEditPetugas/$1');
   $routes->post('petugas/edit', 'Admin\DataPetugas::updatePetugas');
   // superadmin hapus data petugas
   $routes->delete('petugas/delete/(:any)', 'Admin\DataPetugas::delete/$1');
   // Settings
   $routes->group('general-settings', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
      $routes->get('/', 'GeneralSettings::index');
      $routes->post('update', 'GeneralSettings::generalSettingsPost');
   });
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
   require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}