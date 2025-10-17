<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiHistoryModel extends Model
{
    protected $table = 'tb_gaji_history';
    protected $primaryKey = 'id_history';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'id_gaji',
        'id_departemen_old',
        'id_departemen_new',
        'id_jabatan_old',
        'id_jabatan_new',
        'gaji_per_jam_old',
        'gaji_per_jam_new',
        'departemen_old',
        'departemen_new',
        'jabatan_old',
        'jabatan_new',
        'action',
        'updated_by',
        'updated_at'
    ];

    /**
     * Log gaji history
     */
    public function logHistory($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    /**
     * Get gaji history by gaji ID
     */
    public function getGajiHistory($id_gaji)
    {
        return $this->where('id_gaji', $id_gaji)
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get all gaji history with pagination
     */
    public function getAllGajiHistory($limit = 50, $offset = 0)
    {
        return $this->orderBy('updated_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    /**
     * Get gaji history with department and position names
     */
    public function getGajiHistoryWithDetails($id_gaji)
    {
        return $this->db->table('tb_gaji_history gh')
            ->select('gh.*, 
                     d_old.departemen as departemen_old_name,
                     d_new.departemen as departemen_new_name,
                     j_old.jabatan as jabatan_old_name,
                     j_new.jabatan as jabatan_new_name')
            ->join('tb_departemen d_old', 'gh.id_departemen_old = d_old.id_departemen', 'left')
            ->join('tb_departemen d_new', 'gh.id_departemen_new = d_new.id_departemen', 'left')
            ->join('tb_jabatan j_old', 'gh.id_jabatan_old = j_old.id', 'left')
            ->join('tb_jabatan j_new', 'gh.id_jabatan_new = j_new.id', 'left')
            ->where('gh.id_gaji', $id_gaji)
            ->orderBy('gh.updated_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get recent gaji history (last 10 changes)
     */
    public function getRecentGajiHistory($limit = 10)
    {
        return $this->db->table('tb_gaji_history gh')
            ->select('gh.*, g.id_gaji, d_old.departemen as departemen_old_name, d_new.departemen as departemen_new_name, j_old.jabatan as jabatan_old_name, j_new.jabatan as jabatan_new_name')
            ->join('tb_gaji g', 'gh.id_gaji = g.id_gaji')
            ->join('tb_departemen d_old', 'gh.id_departemen_old = d_old.id_departemen', 'left')
            ->join('tb_departemen d_new', 'gh.id_departemen_new = d_new.id_departemen', 'left')
            ->join('tb_jabatan j_old', 'gh.id_jabatan_old = j_old.id', 'left')
            ->join('tb_jabatan j_new', 'gh.id_jabatan_new = j_new.id', 'left')
            ->orderBy('gh.updated_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Get history statistics
     */
    public function getHistoryStats()
    {
        $stats = [];

        // Total history records
        $stats['total_records'] = $this->countAllResults();

        // History by action type
        $stats['by_action'] = $this->select('action, COUNT(*) as count')
            ->groupBy('action')
            ->get()
            ->getResultArray();

        // Recent activity (last 7 days)
        $stats['recent_activity'] = $this->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->countAllResults();

        return $stats;
    }
}

