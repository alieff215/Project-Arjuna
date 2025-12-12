<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiKaryawanHistoryModel extends Model
{
   protected $table = 'tb_presensi_karyawan_history';
   protected $primaryKey = 'id';
   protected $allowedFields = [
      'id_presensi',
      'id_karyawan',
      'tanggal',
      'id_kehadiran_before',
      'id_kehadiran_after',
      'keterangan_before',
      'keterangan_after',
      'jam_masuk_before',
      'jam_masuk_after',
      'jam_keluar_before',
      'jam_keluar_after',
      'created_at'
   ];

   protected $useTimestamps = false;

   public function getByKaryawanTanggal(int $idKaryawan, string $tanggal)
   {
      return $this->where(['id_karyawan' => $idKaryawan, 'tanggal' => $tanggal])
         ->orderBy('created_at', 'DESC')
         ->findAll();
   }

   public function getByTanggal(string $tanggal)
   {
      return $this->select('tb_presensi_karyawan_history.*, tb_karyawan.nama_karyawan')
         ->join('tb_karyawan', 'tb_karyawan.id_karyawan = tb_presensi_karyawan_history.id_karyawan', 'left')
         ->where('tb_presensi_karyawan_history.tanggal', $tanggal)
         ->orderBy('created_at', 'DESC')
         ->findAll();
   }
}




