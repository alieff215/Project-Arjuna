<?php

namespace App\Models;

class JabatanModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('tb_jabatan');
    }

    //input values
   public function inputValues()
   {
      $session = \Config\Services::session();
      
      // Cek apakah ada data dari approval system
      $jabatan = $session->get('approval_input_jabatan');
      
      // Jika tidak ada data dari approval, gunakan inputPost biasa
      if ($jabatan === null) {
         $jabatan = inputPost('jabatan');
      }
      
      // Bersihkan data approval dari session setelah digunakan
      $session->remove('approval_input_jabatan');
      
      return [
         'jabatan' => $jabatan,
      ];
   }

   public function addJabatan()
   {
      $data = $this->inputValues();
      return $this->builder->insert($data);
   }

   public function editJabatan($id)
   {
      $jabatan = $this->getJabatan($id);
      if (!empty($jabatan)) {
         $data = $this->inputValues();
         return $this->builder->where('id', $jabatan->id)->update($data);
      }
      return false;
   }

    public function getDataJabatan()
    {
        return $this->builder->orderBy('id')->get()->getResult('array');
    }

    public function getJabatan($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }


    public function deleteJabatan($id)
   {
       $jabatan = $this->getJabatan($id);
       if (!empty($jabatan)) {
           return $this->builder->where('id', $jabatan->id)->delete();
       }
       return false;
   }

   public function getAllJabatan()
   {
       return $this->builder->get()->getResultArray();
   }
}
