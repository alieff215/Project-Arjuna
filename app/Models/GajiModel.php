<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table = 'tb_gaji';
    protected $primaryKey = 'id_gaji';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'id_departemen',
        'id_jabatan',
        'gaji_per_jam',
        'tanggal_update'
    ];

    protected $validationRules = [
        'id_departemen' => 'required|integer',
        'id_jabatan' => 'required|integer',
        'gaji_per_jam' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'id_departemen' => [
            'required' => 'Departemen harus dipilih',
            'integer' => 'Departemen tidak valid'
        ],
        'id_jabatan' => [
            'required' => 'Jabatan harus dipilih',
            'integer' => 'Jabatan tidak valid'
        ],
        'gaji_per_jam' => [
            'required' => 'Gaji per jam harus diisi',
            'numeric' => 'Gaji per jam harus berupa angka',
            'greater_than' => 'Gaji per jam harus lebih dari 0'
        ]
    ];

    /**
     * Get all gaji data with department and position information
     */
    public function getAllGaji()
    {
        return $this->db->table('tb_gaji g')
            ->select('g.*, d.departemen, j.jabatan')
            ->join('tb_departemen d', 'g.id_departemen = d.id_departemen')
            ->join('tb_jabatan j', 'g.id_jabatan = j.id')
            ->orderBy('g.id_gaji', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get gaji by ID with department and position information
     */
    public function getGajiById($id)
    {
        return $this->db->table('tb_gaji g')
            ->select('g.*, d.departemen, j.jabatan')
            ->join('tb_departemen d', 'g.id_departemen = d.id_departemen')
            ->join('tb_jabatan j', 'g.id_jabatan = j.id')
            ->where('g.id_gaji', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Get gaji by department and position
     */
    public function getGajiByDeptJabatan($id_departemen, $id_jabatan)
    {
        return $this->where([
            'id_departemen' => $id_departemen,
            'id_jabatan' => $id_jabatan
        ])->first();
    }

    /**
     * Check if gaji exists for department and position combination
     */
    public function isGajiExists($id_departemen, $id_jabatan, $exclude_id = null)
    {
        $builder = $this->where([
            'id_departemen' => $id_departemen,
            'id_jabatan' => $id_jabatan
        ]);

        if ($exclude_id) {
            $builder->where('id_gaji !=', $exclude_id);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Get salary report data
     */
    public function getSalaryReport($start_date = null, $end_date = null, $id_departemen = null)
    {
        if (!$start_date) {
            $start_date = date('Y-m-01'); // First day of current month
        }
        if (!$end_date) {
            $end_date = date('Y-m-t'); // Last day of current month
        }

        $query = "
            SELECT 
                k.id_karyawan,
                k.nis,
                k.nama_karyawan,
                d.departemen,
                j.jabatan,
                g.gaji_per_jam,
                COUNT(pk.id_presensi) as total_kehadiran,
                COALESCE(SUM(TIMESTAMPDIFF(HOUR, pk.jam_masuk, pk.jam_keluar)), 0) as total_jam_kerja,
                (COALESCE(SUM(TIMESTAMPDIFF(HOUR, pk.jam_masuk, pk.jam_keluar)), 0) * g.gaji_per_jam) as total_gaji
            FROM tb_karyawan k
            LEFT JOIN tb_departemen d ON k.id_departemen = d.id_departemen
            LEFT JOIN tb_jabatan j ON d.id_jabatan = j.id
            LEFT JOIN tb_gaji g ON d.id_departemen = g.id_departemen AND j.id = g.id_jabatan
            LEFT JOIN tb_presensi_karyawan pk ON k.id_karyawan = pk.id_karyawan 
                AND DATE(pk.tanggal) BETWEEN ? AND ?
                AND pk.id_kehadiran = 1
        ";

        $params = [$start_date, $end_date];

        if ($id_departemen) {
            $query .= " WHERE k.id_departemen = ?";
            $params[] = $id_departemen;
        }

        $query .= " GROUP BY k.id_karyawan, k.nis, k.nama_karyawan, d.departemen, j.jabatan, g.gaji_per_jam
                   ORDER BY d.departemen, k.nama_karyawan";

        return $this->db->query($query, $params)->getResultArray();
    }

    /**
     * Get attendance breakdown (hadir/sakit/izin/alpa) per karyawan in period
     */
    public function getAttendanceBreakdown($start_date, $end_date, $id_departemen = null)
    {
        $query = "
            SELECT 
                k.id_karyawan,
                SUM(CASE WHEN pk.id_kehadiran = 1 THEN 1 ELSE 0 END) AS hadir,
                SUM(CASE WHEN pk.id_kehadiran = 2 THEN 1 ELSE 0 END) AS sakit,
                SUM(CASE WHEN pk.id_kehadiran = 3 THEN 1 ELSE 0 END) AS izin,
                SUM(CASE WHEN pk.id_kehadiran = 4 THEN 1 ELSE 0 END) AS alpa
            FROM tb_karyawan k
            LEFT JOIN tb_presensi_karyawan pk 
                ON pk.id_karyawan = k.id_karyawan 
                AND DATE(pk.tanggal) BETWEEN ? AND ?
            ";

        $params = [$start_date, $end_date];

        if ($id_departemen) {
            $query .= " WHERE k.id_departemen = ?";
            $params[] = $id_departemen;
        }

        $query .= " GROUP BY k.id_karyawan";

        $rows = $this->db->query($query, $params)->getResultArray();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['id_karyawan']] = [
                'hadir' => (int) ($r['hadir'] ?? 0),
                'sakit' => (int) ($r['sakit'] ?? 0),
                'izin' => (int) ($r['izin'] ?? 0),
                'alpa' => (int) ($r['alpa'] ?? 0),
            ];
        }
        return $map;
    }

    /**
     * Get salary statistics
     */
    public function getSalaryStats()
    {
        $stats = [];

        // Total salary configurations
        $stats['total_config'] = $this->countAllResults();

        // Average salary per hour
        $avg_result = $this->selectAvg('gaji_per_jam')
            ->get()
            ->getRowArray();
        $stats['avg_salary'] = $avg_result['gaji_per_jam'] ?? 0;

        // Highest salary per hour
        $max_result = $this->selectMax('gaji_per_jam')
            ->get()
            ->getRowArray();
        $stats['max_salary'] = $max_result['gaji_per_jam'] ?? 0;

        // Lowest salary per hour
        $min_result = $this->selectMin('gaji_per_jam')
            ->get()
            ->getRowArray();
        $stats['min_salary'] = $min_result['gaji_per_jam'] ?? 0;

        return $stats;
    }

    /**
     * Delete gaji
     */
    public function softDelete($id)
    {
        return $this->delete($id);
    }

    /**
     * Restore gaji (not applicable for hard delete)
     */
    public function restore($id)
    {
        return false; // Cannot restore hard deleted records
    }
}
