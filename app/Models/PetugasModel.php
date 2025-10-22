<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
   protected function initialize()
   {
      $this->allowedFields = [
         'email',
         'username',
         'password_hash',
         'is_superadmin',
         'user_role'
      ];
   }

   protected $table = 'users';

   protected $primaryKey = 'id';

   public function getAllPetugas()
   {
      return $this->findAll();
   }

   public function getPetugasById($id)
   {
      return $this->where([$this->primaryKey => $id])->first();
   }

   public function savePetugas($idPetugas, $email, $username, $passwordHash, $role)
   {
      // Tentukan is_superadmin berdasarkan role
      $isSuperadmin = '0';
      if ($role === 'super_admin') {
         $isSuperadmin = '1';
      }
      
      return $this->save([
         $this->primaryKey => $idPetugas,
         'email' => $email,
         'username' => $username,
         'password_hash' => $passwordHash,
         'is_superadmin' => $isSuperadmin,
         'user_role' => $role ?? 'user',
      ]);
   }
}
