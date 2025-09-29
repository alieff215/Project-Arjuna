<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends BaseModel
{
   protected $builder;

   public function __construct()
   {
      parent::__construct();
      $this->builder = $this->db->table('tb_departemen');
   }

   //input values
   public function inputValues()
   {
      return [
         'departemen' => inputPost('departemen'),
         'id_jabatan' => inputPost('id_jabatan'),
      ];
   }

   public function addDepartemen()
   {
      $data = $this->inputValues();
      return $this->builder->insert($data);
   }

   public function editDepartemen($id)
   {
      $departemen = $this->getDepartemen($id);
      if (!empty($departemen)) {
         $data = $this->inputValues();
         return $this->builder->where('id_departemen', $departemen->id_departemen)->update($data);
      }
      return false;
   }

   public function getDataDepartemen()
   {
      return $this->builder->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id')->orderBy('tb_departemen.id_departemen')->get()->getResult('array');
   }

   public function get  ($id)
   {
      return $this->builder->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id')->where('id_departemen', cleanNumber($id))->get()->getRow();
   }

   public  function getCategoryTree($categoryId, $categories)
   {
      $tree = array();
      $categoryId = cleanNumber($categoryId);
      if (!empty($categoryId)) {
         array_push($tree, $categoryId);
      }
      return $tree;
   }

   public function getDepartemenCountByJabatan($jabatanId)
   {
      $tree = array();
      $jabatanId = cleanNumber($jabatanId);
      if (!empty($jabatanId)) {
         array_push($tree, $jabatanId);
      }

      $jabatanIds = $tree;
      if (countItems($jabatanIds) < 1) {
         return array();
      }

      return $this->builder->whereIn('tb_departemen.id_jabatan', $jabatanIds, false)->countAllResults();
   }

   public function deleteDepartemen($id)
   {
      $departemen = $this->getDepartemen($id);
      if (!empty($departemen)) {
         return $this->builder->where('id_departemen', $departemen->id_departemen)->delete();
      }
      return false;
   }

   public function getAllDepartemen()
   {
      return $this->join('tb_jabatan', 'tb_departemen.id_jabatan = tb_jabatan.id', 'left')->findAll();
   }
}
