<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\AdminModel;
use App\Models\KaryawanModel;
use App\Models\PresensiAdminModel;
use App\Models\PresensiKaryawanModel;
use App\Libraries\enums\TipeUser;

class Scan extends BaseController
{
   private bool $WANotificationEnabled;

   protected KaryawanModel $karyawanModel;
   protected AdminModel $adminModel;

   protected PresensiKaryawanModel $presensiKaryawanModel;
   protected PresensiAdminModel $presensiAdminModel;

   public function __construct()
   {
      $this->WANotificationEnabled = getenv('WA_NOTIFICATION') === 'true' ? true : false;

      $this->karyawanModel = new KaryawanModel();
      $this->adminModel = new AdminModel();
      $this->presensiKaryawanModel = new PresensiKaryawanModel();
      $this->presensiAdminModel = new PresensiAdminModel();
   }

   public function index($t = 'Masuk')
   {
      $data = ['waktu' => $t, 'title' => 'Absensi Karyawan dan Admin Berbasis QR Code'];
      return view('scan/scan', $data);
   }

   public function cekKode()
   {
      // ambil variabel POST
      $uniqueCode = $this->request->getVar('unique_code');
      $waktuAbsen = $this->request->getVar('waktu');

      $status = false;
      $type = TipeUser::Karyawan;

      // cek data karyawan di database
      $result = $this->karyawanModel->cekKaryawan($uniqueCode);

      if (empty($result)) {
         // jika cek karyawan gagal, cek data admin
         $result = $this->adminModel->cekAdmin($uniqueCode);

         if (!empty($result)) {
            $status = true;

            $type = TipeUser::Admin;
         } else {
            $status = false;

            $result = NULL;
         }
      } else {
         $status = true;
      }

      if (!$status) { // data tidak ditemukan
         return $this->showErrorView('Data tidak ditemukan');
      }

      // jika data ditemukan
      switch ($waktuAbsen) {
         case 'masuk':
            return $this->absenMasuk($type, $result);
            break;

         case 'pulang':
            return $this->absenPulang($type, $result);
            break;

         default:
            return $this->showErrorView('Data tidak valid');
            break;
      }
   }

   public function absenMasuk($type, $result)
   {
      // data ditemukan
      $data['data'] = $result;
      $data['waktu'] = 'masuk';

      $date = Time::today()->toDateString();
      $time = Time::now()->toTimeString();
      $messageString = " sudah absen masuk pada tanggal $date jam $time";
      // absen masuk
      switch ($type) {
         case TipeUser::Admin:
            $idAdmin =  $result['id_admin'];
            $data['type'] = TipeUser::Admin;

            $sudahAbsen = $this->presensiAdminModel->cekAbsen($idAdmin, $date);

            if ($sudahAbsen) {
               $data['presensi'] = $this->presensiAdminModel->getPresensiById($sudahAbsen);
               return $this->showErrorView('Anda sudah absen hari ini', $data);
            }

            $this->presensiAdminModel->absenMasuk($idAdmin, $date, $time);
            $messageString = $result['nama_admin'] . ' dengan NIP ' . $result['nuptk'] . $messageString;
            $data['presensi'] = $this->presensiAdminModel->getPresensiByIdAdminTanggal($idAdmin, $date);

            break;

         case TipeUser::Karyawan:
            $idKaryawan =  $result['id_karyawan'];
            $idDepartemen =  $result['id_departemen'];
            $data['type'] = TipeUser::Karyawan;

            $sudahAbsen = $this->presensiKaryawanModel->cekAbsen($idKaryawan, Time::today()->toDateString());

            if ($sudahAbsen) {
               $data['presensi'] = $this->presensiKaryawanModel->getPresensiById($sudahAbsen);
               return $this->showErrorView('Anda sudah absen hari ini', $data);
            }

            $this->presensiKaryawanModel->absenMasuk($idKaryawan, $date, $time, $idDepartemen);
            $messageString = 'Karyawan ' . $result['nama_karyawan'] . ' dengan NIS ' . $result['nis'] . $messageString;
            $data['presensi'] = $this->presensiKaryawanModel->getPresensiByIdKaryawanTanggal($idKaryawan, $date);

            break;

         default:
            return $this->showErrorView('Tipe tidak valid');
      }

      // kirim notifikasi ke whatsapp
      if ($this->WANotificationEnabled && !empty($result['no_hp'])) {
         $message = [
            'destination' => $result['no_hp'],
            'message' => $messageString,
            'delay' => 0
         ];
         try {
            $this->sendNotification($message);
         } catch (\Exception $e) {
            log_message('error', 'Error sending notification: ' . $e->getMessage());
         }
      }
      return view('scan/scan-result', $data);
   }

   public function absenPulang($type, $result)
   {
      // data ditemukan
      $data['data'] = $result;
      $data['waktu'] = 'pulang';

      $date = Time::today()->toDateString();
      $time = Time::now()->toTimeString();
      $messageString = " sudah absen pulang pada tanggal $date jam $time";

      // absen pulang
      switch ($type) {
         case TipeUser::Admin:
            $idAdmin =  $result['id_admin'];
            $data['type'] = TipeUser::Admin;

            $sudahAbsen = $this->presensiAdminModel->cekAbsen($idAdmin, $date);

            if (!$sudahAbsen) {
               return $this->showErrorView('Anda belum absen hari ini', $data);
            }

            $this->presensiAdminModel->absenKeluar($sudahAbsen, $time);
            $messageString = $result['nama_admin'] . ' dengan NIP ' . $result['nuptk'] . $messageString;
            $data['presensi'] = $this->presensiAdminModel->getPresensiById($sudahAbsen);

            break;

         case TipeUser::Karyawan:
            $idKaryawan =  $result['id_karyawan'];
            $data['type'] = TipeUser::Karyawan;

            $sudahAbsen = $this->presensiKaryawanModel->cekAbsen($idKaryawan, $date);

            if (!$sudahAbsen) {
               return $this->showErrorView('Anda belum absen hari ini', $data);
            }

            $this->presensiKaryawanModel->absenKeluar($sudahAbsen, $time);
            $messageString = 'Karyawan ' . $result['nama_karyawan'] . ' dengan NIS ' . $result['nis'] . $messageString;
            $data['presensi'] = $this->presensiKaryawanModel->getPresensiById($sudahAbsen);

            break;
         default:
            return $this->showErrorView('Tipe tidak valid');
      }

      // kirim notifikasi ke whatsapp
      if ($this->WANotificationEnabled && !empty($result['no_hp'])) {
         $message = [
            'destination' => $result['no_hp'],
            'message' => $messageString,
            'delay' => 0
         ];
         try {
            $this->sendNotification($message);
         } catch (\Exception $e) {
            log_message('error', 'Error sending notification: ' . $e->getMessage());
         }
      }

      return view('scan/scan-result', $data);
   }

   public function showErrorView(string $msg = 'no error message', $data = NULL)
   {
      $errdata = $data ?? [];
      $errdata['msg'] = $msg;

      return view('scan/error-scan-result', $errdata);
   }

   protected function sendNotification($message)
   {
      $token = getenv('WHATSAPP_TOKEN');
      $provider = getenv('WHATSAPP_PROVIDER');

      if (empty($provider)) {
         return;
      }
      if (empty($token)) {
         return;
      }

      switch ($provider) {
         case 'Fonnte':
            $whatsapp = new \App\Libraries\Whatsapp\Fonnte\Fonnte($token);
            break;
         default:
            return;
      }
      $whatsapp->sendMessage($message);
   }
   
}
