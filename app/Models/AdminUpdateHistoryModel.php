<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUpdateHistoryModel extends Model
{
   protected $table = 'tb_admin_update_history';

   protected $primaryKey = 'id';

   protected $allowedFields = [
      'id_admin',
      'changed_fields',
      'before_data',
      'after_data',
      'created_at'
   ];

   protected $useTimestamps = false;

   public function getByAdminId(int $idAdmin)
   {
      return $this->where('id_admin', $idAdmin)
         ->orderBy('created_at', 'DESC')
         ->findAll();
   }
}




