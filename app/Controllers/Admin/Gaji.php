<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GajiModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;
use App\Models\GajiHistoryModel;
use App\Models\ApprovalModel;
use App\Libraries\ApprovalHelper;

class Gaji extends BaseController
{
    protected $gajiModel;
    protected $departemenModel;
    protected $jabatanModel;
    protected $gajiHistoryModel;
    protected ApprovalModel $approvalModel;
    protected ApprovalHelper $approvalHelper;

    public function __construct()
    {
        $this->gajiModel = new GajiModel();
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
        $this->gajiHistoryModel = new GajiHistoryModel();
        $this->approvalModel = new ApprovalModel();
        $this->approvalHelper = new ApprovalHelper();
    }

    /**
     * Display salary management page
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Gaji',
            'gaji' => $this->gajiModel->getAllGaji(),
            'stats' => $this->gajiModel->getSalaryStats()
        ];

        return view('admin/gaji/index', $data);
    }

    /**
     * Show add salary form
     */
    public function add()
    {
        $data = [
            'title' => 'Tambah Konfigurasi Gaji',
            'departemen' => $this->departemenModel->getAllDepartemen(),
            'jabatan' => $this->jabatanModel->getAllJabatan()
        ];

        return view('admin/gaji/add', $data);
    }

    /**
     * Process add salary form
     */
    public function store()
    {
        $rules = [
                'id_departemen' => 'required|integer',
                'id_jabatan' => 'required|integer', 
                'gaji_per_jam' => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
            }

            $data = [
            'id_departemen' => $this->request->getPost('id_departemen'),
            'id_jabatan' => $this->request->getPost('id_jabatan'),
            'gaji_per_jam' => $this->request->getPost('gaji_per_jam'),
            'tanggal_update' => date('Y-m-d H:i:s')
        ];

        // Check if gaji already exists for this department and position
        if ($this->gajiModel->isGajiExists($data['id_departemen'], $data['id_jabatan'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Konfigurasi gaji untuk departemen dan jabatan ini sudah ada');
        }

        // Cek apakah memerlukan approval
        if ($this->approvalHelper->requiresApproval()) {
            // Buat request approval
            $approvalId = $this->approvalHelper->createApprovalRequest(
                'create',
                'tb_gaji',
                null,
                $data
            );

            if ($approvalId) {
                return redirect()->to('admin/gaji')->with('success', 'Request penambahan konfigurasi gaji telah dikirim dan menunggu persetujuan superadmin');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim request approval');
            }
        } else {
            // Langsung simpan (untuk super admin)
            if ($gaji_id = $this->gajiModel->insert($data)) {
                // Log history for creation
                $this->logGajiHistory($gaji_id, null, $data, 'created');
                
                return redirect()->to('admin/gaji')
                    ->with('success', 'Konfigurasi gaji berhasil ditambahkan');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan konfigurasi gaji');
            }
        }
    }

    /**
     * Show edit salary form
     */
    public function edit($id)
    {
        $gaji = $this->gajiModel->getGajiById($id);
        
        if (!$gaji) {
            return redirect()->to('admin/gaji')
                ->with('error', 'Data gaji tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Konfigurasi Gaji',
            'gaji' => $gaji,
            'departemen' => $this->departemenModel->getAllDepartemen(),
            'jabatan' => $this->jabatanModel->getAllJabatan(),
            'history' => $this->gajiHistoryModel->getGajiHistoryWithDetails($id)
        ];

        return view('admin/gaji/edit', $data);
    }

    /**
     * Process edit salary form
     */
    public function update($id)
    {
        $rules = [
                'id_departemen' => 'required|integer',
                'id_jabatan' => 'required|integer', 
                'gaji_per_jam' => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
            }

            $data = [
            'id_departemen' => $this->request->getPost('id_departemen'),
            'id_jabatan' => $this->request->getPost('id_jabatan'),
            'gaji_per_jam' => $this->request->getPost('gaji_per_jam'),
            'tanggal_update' => date('Y-m-d H:i:s')
        ];

        // Check if gaji already exists for this department and position (excluding current record)
        if ($this->gajiModel->isGajiExists($data['id_departemen'], $data['id_jabatan'], $id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Konfigurasi gaji untuk departemen dan jabatan ini sudah ada');
        }

        // Get old data before update
        $old_data = $this->gajiModel->getGajiById($id);

        // Cek apakah memerlukan approval
        if ($this->approvalHelper->requiresApproval()) {
            // Buat request approval
            $approvalId = $this->approvalHelper->createApprovalRequest(
                'update',
                'tb_gaji',
                $id,
                $data,
                $old_data
            );

            if ($approvalId) {
                return redirect()->to('admin/gaji')->with('success', 'Request perubahan konfigurasi gaji telah dikirim dan menunggu persetujuan superadmin');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim request approval');
            }
        } else {
            // Langsung update (untuk super admin)
            if ($this->gajiModel->update($id, $data)) {
                // Log history for update
                $this->logGajiHistory($id, $old_data, $data, 'updated');
                
                return redirect()->to('admin/gaji')
                    ->with('success', 'Konfigurasi gaji berhasil diperbarui');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui konfigurasi gaji');
            }
        }
    }

    /**
     * Delete salary configuration
     */
    public function delete($id)
    {
        // Get data before delete
        $old_data = $this->gajiModel->getGajiById($id);
        
        // Cek apakah memerlukan approval
        if ($this->approvalHelper->requiresApproval()) {
            // Buat request approval untuk delete
            $approvalId = $this->approvalHelper->createApprovalRequest(
                'delete',
                'tb_gaji',
                $id,
                null,
                $old_data
            );

            if ($approvalId) {
                return redirect()->to('admin/gaji')->with('success', 'Request penghapusan konfigurasi gaji telah dikirim dan menunggu persetujuan superadmin');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim request approval');
            }
        } else {
            // Langsung hapus (untuk super admin)
            if ($this->gajiModel->softDelete($id)) {
                // Log history for deletion
                $this->logGajiHistory($id, $old_data, null, 'deleted');
                
                return redirect()->to('admin/gaji')
                    ->with('success', 'Konfigurasi gaji berhasil dihapus');
            } else {
                return redirect()->to('admin/gaji')
                    ->with('error', 'Gagal menghapus konfigurasi gaji');
            }
        }
    }

    /**
     * Restore salary configuration
     */
    public function restore($id)
    {
        if ($this->gajiModel->restore($id)) {
            return redirect()->to('admin/gaji')
                ->with('success', 'Konfigurasi gaji berhasil dipulihkan');
        } else {
            return redirect()->to('admin/gaji')
                ->with('error', 'Gagal memulihkan konfigurasi gaji');
        }
    }

    /**
     * Show salary report page
     */
    public function report()
    {
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-t');
        $id_departemen = $this->request->getGet('id_departemen');

        $data = [
            'title' => 'Laporan Gaji Karyawan',
            'report_data' => $this->gajiModel->getSalaryReport($start_date, $end_date, $id_departemen),
            'departemen' => $this->departemenModel->getAllDepartemen(),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'id_departemen' => $id_departemen
        ];

        return view('admin/gaji/report', $data);
    }

    /**
     * Export salary report to CSV
     */
    public function export()
    {
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-t');
        $id_departemen = $this->request->getGet('id_departemen');

        $report_data = $this->gajiModel->getSalaryReport($start_date, $end_date, $id_departemen);

        // Company info
        $gs = \Config\Company::$generalSettings ?? null;
        $companyName = ($gs && isset($gs->company_name) && !empty($gs->company_name)) ? $gs->company_name : 'Perusahaan Garment';
        $printedAt = date('Y-m-d H:i:s');
        $periodeText = date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date));
        $deptName = 'Semua Departemen';
        if (!empty($id_departemen)) {
            $deptRow = $this->departemenModel->where('id_departemen', $id_departemen)->first();
            if (!empty($deptRow) && !empty($deptRow['departemen'])) {
                $deptName = $deptRow['departemen'];
            }
        }

        $filename = 'Laporan_Gaji_' . date('Ym', strtotime($start_date)) . '_' . preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '-', $deptName)) . '_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Use semicolon delimiter for better Excel parsing in ID locale
        $delimiter = ';';
        // Professional header
        fputcsv($output, [$companyName], $delimiter);
        fputcsv($output, ['LAPORAN GAJI KARYAWAN (GARMENT)'], $delimiter);
        fputcsv($output, ['Periode Gaji', $periodeText], $delimiter);
        fputcsv($output, ['Departemen', $deptName], $delimiter);
        fputcsv($output, ['Tanggal Cetak', date('d/m/Y H:i', strtotime($printedAt))], $delimiter);
        fputcsv($output, [''], $delimiter);

        // Siapkan grouping per departemen agar rapi & ada subtotal
        $grouped = [];
        foreach ($report_data as $row) {
            $dept = $row['departemen'] ?? 'Tanpa Departemen';
            if (!isset($grouped[$dept])) {
                $grouped[$dept] = [];
            }
            $grouped[$dept][] = $row;
        }

        $grandTotalJam = 0;
        $grandTotalGaji = 0;
        $grandTotalKehadiran = 0;

        $firstSection = true;
        foreach ($grouped as $deptNameKey => $rows) {
            // Spasi antar section
            if ($firstSection) {
                $firstSection = false;
            } else {
                fputcsv($output, [''], $delimiter);
            }

        // Sub-header per departemen
        fputcsv($output, ['DEPARTEMEN', $deptNameKey], $delimiter);
            fputcsv($output, [''], $delimiter);
        // Standard header row
        fputcsv($output, [
            'No',
            'NIS',
            'Nama Karyawan',
            'Jabatan',
            'Gaji/Jam (Rp)',
            'Kehadiran (hari)',
            'Total Jam (jam)',
            'Total Gaji (Rp)'
        ], $delimiter);

            $no = 1;
            $subTotalJam = 0;
            $subTotalGaji = 0;
            $subTotalKehadiran = 0;

            foreach ($rows as $row) {
                $subTotalJam += (int)($row['total_jam_kerja'] ?? 0);
                $subTotalGaji += (int)($row['total_gaji'] ?? 0);
                $subTotalKehadiran += (int)($row['total_kehadiran'] ?? 0);
                fputcsv($output, [
                    $no++,
                    $row['nis'],
                    $row['nama_karyawan'],
                    $row['jabatan'],
                    (int)($row['gaji_per_jam'] ?? 0),
                    (int)($row['total_kehadiran'] ?? 0),
                    (int)($row['total_jam_kerja'] ?? 0),
                    (int)($row['total_gaji'] ?? 0)
                ], $delimiter);
            }

            // Subtotal per departemen
            fputcsv($output, [''], $delimiter);
            fputcsv($output, [
                '',
                '',
                'SUBTOTAL ' . strtoupper($deptNameKey),
                '',
                '',
                $subTotalKehadiran,
                $subTotalJam,
                (int)$subTotalGaji
            ], $delimiter);

            $grandTotalJam += $subTotalJam;
            $grandTotalGaji += $subTotalGaji;
            $grandTotalKehadiran += $subTotalKehadiran;
        }

        // Footer grand total
        fputcsv($output, [''], $delimiter);
        fputcsv($output, [''], $delimiter);
        fputcsv($output, [
            '',
            '',
            'TOTAL KESELURUHAN',
            '',
            '',
            $grandTotalKehadiran,
            $grandTotalJam,
            (int)$grandTotalGaji
        ], $delimiter);

        fclose($output);
        exit;
    }

    /**
     * Get salary data for AJAX requests
     */
    public function getData()
    {
        $data = $this->gajiModel->getAllGaji();
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get salary by department and position for AJAX requests
     */
    public function getByDeptJabatan()
    {
        $id_departemen = $this->request->getPost('id_departemen');
        $id_jabatan = $this->request->getPost('id_jabatan');

        $gaji = $this->gajiModel->getGajiByDeptJabatan($id_departemen, $id_jabatan);

        return $this->response->setJSON([
            'success' => true,
            'data' => $gaji
        ]);
    }

    /**
     * Show gaji history page
     */
    public function history($id)
    {
        $gaji = $this->gajiModel->getGajiById($id);
        
        if (!$gaji) {
            return redirect()->to('admin/gaji')
                ->with('error', 'Data gaji tidak ditemukan');
        }

        $data = [
            'title' => 'Riwayat Perubahan Gaji',
            'gaji' => $gaji,
            'history' => $this->gajiHistoryModel->getGajiHistoryWithDetails($id)
        ];

        return view('admin/gaji/history', $data);
    }

    /**
     * Log gaji history
     */
    private function logGajiHistory($id_gaji, $old_data, $new_data, $action)
    {
        $history_data = [
            'id_gaji' => $id_gaji,
            'action' => $action,
            'updated_by' => session()->get('user_id') ?? 'System'
        ];

        if ($old_data) {
            $history_data['id_departemen_old'] = $old_data['id_departemen'];
            $history_data['id_jabatan_old'] = $old_data['id_jabatan'];
            $history_data['gaji_per_jam_old'] = $old_data['gaji_per_jam'];
            $history_data['departemen_old'] = $old_data['departemen'];
            $history_data['jabatan_old'] = $old_data['jabatan'];
        }

        if ($new_data) {
            $history_data['id_departemen_new'] = $new_data['id_departemen'];
            $history_data['id_jabatan_new'] = $new_data['id_jabatan'];
            $history_data['gaji_per_jam_new'] = $new_data['gaji_per_jam'];
            
            // Get department and position names for new data
            $dept = $this->departemenModel->where('id_departemen', $new_data['id_departemen'])->first();
            $jab = $this->jabatanModel->where('id', $new_data['id_jabatan'])->first();
            
            $history_data['departemen_new'] = $dept ? $dept['departemen'] : '';
            $history_data['jabatan_new'] = $jab ? $jab['jabatan'] : '';
        }

        return $this->gajiHistoryModel->logHistory($history_data);
    }
}
