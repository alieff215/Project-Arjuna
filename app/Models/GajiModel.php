<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends BaseModel
{
   protected $builder;
   protected $builderKaryawan;
   protected $builderKehadiran;
   protected $table = 'tb_gaji'; // ganti dengan nama tabelmu
   protected $primaryKey = 'id_gaji'; // ganti dengan primary key tabel
   protected $returnType = 'object';

    protected $allowedFields = [
        'id_departemen',
        'id_jabatan',
        'gaji_per_jam',
        'tanggal_update',
    ];

   public function __construct()
   {
      parent::__construct();
      $this->builder = $this->db->table('tb_gaji');
      $this->builderKaryawan = $this->db->table('tb_karyawan');
      $this->builderKehadiran = $this->db->table('tb_kehadiran');
   }

   //input values
   public function inputValues()
   {
      return [
         'id_departemen' => inputPost('id_departemen'),
         'id_jabatan' => inputPost('id_jabatan'),
         'gaji_per_jam' => inputPost('gaji_per_jam'),
         'tanggal_update' => date('Y-m-d H:i:s')
      ];
   }

   public function addGaji()
   {
      $data = $this->inputValues();
      return $this->builder->insert($data);
   }

  // opsi B (builder baru, tidak reuse $this->builder)
  public function editGaji(int $id, array $data): int
  {
      if (empty($data['tanggal_update'])) {
          $data['tanggal_update'] = date('Y-m-d H:i:s');
      }

      if (!$this->find($id)) {
          return -1; // tidak ketemu
      }

      $this->db->table('tb_gaji')
          ->where('id_gaji', $id)
          ->update($data);

      return $this->db->affectedRows(); // 0 kalau nilainya sama
  }


   public function getDataGaji()
   {
      return $this->builder
         ->join('tb_departemen', 'tb_gaji.id_departemen = tb_departemen.id_departemen')
         ->join('tb_jabatan', 'tb_gaji.id_jabatan = tb_jabatan.id')
         ->orderBy('tb_gaji.id_gaji')
         ->get()
         ->getResult('array');
   }

   public function getGaji($id)
    {
        return $this->db->table('tb_gaji')
            ->join('tb_departemen','tb_gaji.id_departemen=tb_departemen.id_departemen')
            ->join('tb_jabatan','tb_gaji.id_jabatan=tb_jabatan.id')
            ->where('tb_gaji.id_gaji', (int)$id)
            ->get()->getRow(); // object
    }

   public function getGajiByDepartemenJabatan($id_departemen, $id_jabatan)
   {
      return $this->builder
         ->where('id_departemen', cleanNumber($id_departemen))
         ->where('id_jabatan', cleanNumber($id_jabatan))
         ->get()
         ->getRow();
   }

   public function deleteGaji($id)
   {
      $gaji = $this->getGaji($id);
      if (!empty($gaji)) {
         return $this->builder->where('id_gaji', $gaji->id_gaji)->delete();
      }
      return false;
   }

   public function getRekapGaji($filter = 'day', $start_date = null, $end_date = null)
   {
      if ($start_date === null) {
         $start_date = date('Y-m-d');
      }
      
      if ($end_date === null) {
         $end_date = date('Y-m-d');
      }

      // Adjust date range based on filter
      if ($filter === 'week') {
         // Get the start and end of the week
         $start_date = date('Y-m-d', strtotime('monday this week', strtotime($start_date)));
         $end_date = date('Y-m-d', strtotime('sunday this week', strtotime($start_date)));
      } elseif ($filter === 'month') {
         // Get the start and end of the month
         $start_date = date('Y-m-01', strtotime($start_date));
         $end_date = date('Y-m-t', strtotime($start_date));
      }

      $query = $this->db->query("
         SELECT 
            k.id_karyawan,
            k.nis,
            k.nama_karyawan,
            d.departemen,
            j.jabatan,
            COUNT(pk.id_presensi) as jumlah_kehadiran,
            SUM(TIMESTAMPDIFF(HOUR, pk.jam_masuk, pk.jam_keluar)) as total_jam,
            g.gaji_per_jam,
            (SUM(TIMESTAMPDIFF(HOUR, pk.jam_masuk, pk.jam_keluar)) * g.gaji_per_jam) as total_gaji
         FROM 
            tb_karyawan k
         JOIN 
            tb_departemen d ON k.id_departemen = d.id_departemen
         JOIN 
            tb_jabatan j ON d.id_jabatan = j.id
         LEFT JOIN 
            tb_presensi_karyawan pk ON k.id_karyawan = pk.id_karyawan
            AND DATE(pk.tanggal) BETWEEN ? AND ?
            AND pk.id_kehadiran = 1
         LEFT JOIN 
            tb_gaji g ON d.id_departemen = g.id_departemen AND j.id = g.id_jabatan
         GROUP BY 
            k.id_karyawan, k.nama_karyawan, d.departemen, j.jabatan, g.gaji_per_jam
         ORDER BY 
            d.departemen, k.nama_karyawan
      ", [$start_date, $end_date]);

      return $query->getResult('array');
   }

   public function exportToCSV($filter = 'day', $start_date = null, $end_date = null)
   {
      $data = $this->getRekapGaji($filter, $start_date, $end_date);
      
      // Create a file pointer
      $f = fopen('php://memory', 'w');
      
      // Set column headers
      $fields = array('ID', 'Nama Karyawan', 'Departemen', 'Jabatan', 'Jumlah Kehadiran', 'Total Jam', 'Gaji Per Jam', 'Total Gaji');
      fputcsv($f, $fields);
      
      // Output each row of the data
      foreach ($data as $row) {
         $lineData = array(
            $row['id_karyawan'],
            $row['nama_karyawan'],
            $row['departemen'],
            $row['jabatan'],
            $row['jumlah_kehadiran'],
            $row['total_jam'],
            $row['gaji_per_jam'],
            $row['total_gaji']
         );
         fputcsv($f, $lineData);
      }
      
      // Move back to beginning of file
      fseek($f, 0);
      
      // Set headers to download file
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="rekap_gaji_' . $filter . '_' . date('Y-m-d') . '.csv";');
      
      // Output all remaining data on a file pointer
      fpassthru($f);
      exit;
   }
}