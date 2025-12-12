<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
   protected $allowedFields = [
      'nuptk',
      'nama_admin',
      'id_departemen',
      'jenis_kelamin',
      'alamat',
      'no_hp',
      'tanggal_join',
      'unique_code'
   ];

   protected $table = 'tb_admin';

   protected $primaryKey = 'id_admin';

   public function cekAdmin(string $unique_code)
   {
      return $this->where(['unique_code' => $unique_code])->first();
   }

   public function getAllAdmin()
   {
      return $this->select('tb_admin.*, tb_departemen.departemen, tb_jabatan.jabatan')
         ->join('tb_departemen', 'tb_admin.id_departemen = tb_departemen.id_departemen', 'left')
         ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
         ->orderBy('nama_admin')
         ->findAll();
   }

   public function getAdminById($id)
   {
      return $this->select('tb_admin.*, tb_departemen.departemen, tb_jabatan.jabatan')
         ->join('tb_departemen', 'tb_admin.id_departemen = tb_departemen.id_departemen', 'left')
         ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
         ->where([$this->primaryKey => $id])
         ->first();
   }

   public function createAdmin($nuptk, $nama, $jenisKelamin, $alamat, $noHp, $tanggalJoin = null, $idDepartemen = null)
   {
      return $this->save([
         'nuptk' => $nuptk,
         'nama_admin' => $nama,
         'id_departemen' => $idDepartemen,
         'jenis_kelamin' => $jenisKelamin,
         'alamat' => $alamat,
         'no_hp' => $noHp,
         'tanggal_join' => $tanggalJoin,
         'unique_code' => sha1($nama . md5($nuptk . $nama . $noHp)) . substr(sha1($nuptk . rand(0, 100)), 0, 24)
      ]);
   }

   public function updateAdmin($id, $nuptk, $nama, $jenisKelamin, $alamat, $noHp, $tanggalJoin = null, $idDepartemen = null)
   {
      return $this->save([
         $this->primaryKey => $id,
         'nuptk' => $nuptk,
         'nama_admin' => $nama,
         'id_departemen' => $idDepartemen,
         'jenis_kelamin' => $jenisKelamin,
         'alamat' => $alamat,
         'no_hp' => $noHp,
         'tanggal_join' => $tanggalJoin,
      ]);
   }
}
