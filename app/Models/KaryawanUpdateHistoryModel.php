<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanUpdateHistoryModel extends Model
{
   protected $table = 'tb_karyawan_update_history';

   protected $primaryKey = 'id';

   protected $allowedFields = [
      'id_karyawan',
      'changed_fields',
      'before_data',
      'after_data',
      'created_at'
   ];

   protected $useTimestamps = false;

   public function getByKaryawanId(int $idKaryawan)
   {
      return $this->where('id_karyawan', $idKaryawan)
         ->orderBy('created_at', 'DESC')
         ->findAll();
   }
}



