<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiAdminHistoryModel extends Model
{
   protected $table = 'tb_presensi_admin_history';
   protected $primaryKey = 'id';
   protected $allowedFields = [
      'id_presensi',
      'id_admin',
      'tanggal',
      'id_kehadiran_before',
      'id_kehadiran_after',
      'keterangan_before',
      'keterangan_after',
      'created_at'
   ];

   protected $useTimestamps = false;

   public function getByAdminTanggal(int $idAdmin, string $tanggal)
   {
      return $this->where(['id_admin' => $idAdmin, 'tanggal' => $tanggal])
         ->orderBy('created_at', 'DESC')
         ->findAll();
   }

   public function getByTanggal(string $tanggal)
   {
      return $this->select('tb_presensi_admin_history.*, tb_admin.nama_admin')
         ->join('tb_admin', 'tb_admin.id_admin = tb_presensi_admin_history.id_admin', 'left')
         ->where('tb_presensi_admin_history.tanggal', $tanggal)
         ->orderBy('created_at', 'DESC')
         ->findAll();
   }
}


