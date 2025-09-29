<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
   protected function initialize()
   {
      $this->allowedFields = [
         'nis',
         'nama_karyawan',
         'id_departemen',
         'jenis_kelamin',
         'no_hp',
         'unique_code'
      ];
   }

   protected $table = 'tb_karyawan';

   protected $primaryKey = 'id_karyawan';

   public function cekKaryawan(string $unique_code)
   {
      $this->join(
         'tb_departemen',
         'tb_departemen.id_departemen = tb_karyawan.id_departemen',
         'LEFT'
      )->join(
         'tb_jabatan',
         'tb_jabatan.id = tb_departemen.id_jabatan',
         'LEFT'
      );
      return $this->where(['unique_code' => $unique_code])->first();
   }

   public function getKaryawanById($id)
   {
      return $this->where([$this->primaryKey => $id])->first();
   }

   public function getAllKaryawanWithDepartemen($departemen = null, $jabatan = null)
   {
      $query = $this->join(
         'tb_departemen',
         'tb_departemen.id_departemen = tb_karyawan.id_departemen',
         'LEFT'
      )->join(
         'tb_jabatan',
         'tb_departemen.id_jabatan = tb_jabatan.id',
         'LEFT'
      );

      if (!empty($departemen) && !empty($jabatan)) {
         $query = $this->where(['departemen' => $departemen, 'jabatan' => $jabatan]);
      } else if (empty($departemen) && !empty($jabatan)) {
         $query = $this->where(['jabatan' => $jabatan]);
      } else if (!empty($departemen) && empty($jabatan)) {
         $query = $this->where(['departemen' => $departemen]);
      } else {
         $query = $this;
      }

      return $query->orderBy('nama_karyawan')->findAll();
   }

   public function getKaryawanByDepartemen($id_departemen)
   {
      return $this->join(
         'tb_departemen',
         'tb_departemen.id_departemen = tb_karyawan.id_departemen',
         'LEFT'
      )
         ->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')
         ->where(['tb_karyawan.id_departemen' => $id_departemen])
         ->orderBy('nama_karyawan')
         ->findAll();
   }

   public function createKaryawan($nis, $nama, $idDepartemen, $jenisKelamin, $noHp)
   {
      return $this->save([
         'nis' => $nis,
         'nama_karyawan' => $nama,
         'id_departemen' => $idDepartemen,
         'jenis_kelamin' => $jenisKelamin,
         'no_hp' => $noHp,
         'unique_code' => generateToken()
      ]);
   }

   public function updateKaryawan($id, $nis, $nama, $idDepartemen, $jenisKelamin, $noHp)
   {
      return $this->save([
         $this->primaryKey => $id,
         'nis' => $nis,
         'nama_karyawan' => $nama,
         'id_departemen' => $idDepartemen,
         'jenis_kelamin' => $jenisKelamin,
         'no_hp' => $noHp,
      ]);
   }

   public function getKaryawanCountByDepartemen($departemenId)
   {
      $tree = array();
      $departemenId = cleanNumber($departemenId);
      if (!empty($departemenId)) {
         array_push($tree, $departemenId);
      }

      $departemenIds = $tree;
      if (countItems($departemenIds) < 1) {
         return array();
      }

      return $this->whereIn('tb_karyawan.id_departemen', $departemenIds, false)->countAllResults();
   }

   //generate CSV object
   public function generateCSVObject($filePath)
   {
      $array = array();
      $fields = array();
      $txtName = uniqid() . '.txt';
      $i = 0;
      $handle = fopen($filePath, 'r');
      if ($handle) {
         while (($row = fgetcsv($handle)) !== false) {
            if (empty($fields)) {
               $fields = $row;
               continue;
            }
            foreach ($row as $k => $value) {
               $array[$i][$fields[$k]] = $value;
            }
            $i++;
         }
         if (!feof($handle)) {
            return false;
         }
         fclose($handle);
         if (!empty($array)) {
            $txtFile = fopen(FCPATH . 'uploads/tmp/' . $txtName, 'w');
            fwrite($txtFile, serialize($array));
            fclose($txtFile);
            $obj = new \stdClass();
            $obj->numberOfItems = countItems($array);
            $obj->txtFileName = $txtName;
            @unlink($filePath);
            return $obj;
         }
      }
      return false;
   }

   //import csv item
   public function importCSVItem($txtFileName, $index)
   {
      $filePath = FCPATH . 'uploads/tmp/' . $txtFileName;
      $file = fopen($filePath, 'r');
      $content = fread($file, filesize($filePath));
      $array = @unserialize($content);
      if (!empty($array)) {
         $i = 1;
         foreach ($array as $item) {
            if ($i == $index) {
               $data = array();
               $data['nis'] = getCSVInputValue($item, 'nis', 'int');
               $data['nama_karyawan'] = getCSVInputValue($item, 'nama_karyawan');
               $data['id_departemen'] = getCSVInputValue($item, 'id_departemen', 'int');
               $data['jenis_kelamin'] = getCSVInputValue($item, 'jenis_kelamin');
               $data['no_hp'] = getCSVInputValue($item, 'no_hp');
               $data['unique_code'] = generateToken();

               $this->insert($data);
               return $data;
            }
            $i++;
         }
      }
   }

   public function getKaryawan($id)
   {
      return $this->where('id_karyawan', cleanNumber($id))->get()->getRow();
   }

   //delete post
   public function deleteKaryawan($id)
   {
      $karyawan = $this->getKaryawan($id);
      if (!empty($karyawan)) {
         //delete karyawan
         return $this->where('id_karyawan', $karyawan->id_karyawan)->delete();
      }
      return false;
   }

   //delete multi post
   public function deleteMultiSelected($karyawanIds)
   {
      if (!empty($karyawanIds)) {
         foreach ($karyawanIds as $id) {
            $this->deletekaryawan($id);
         }
      }
   }
}
