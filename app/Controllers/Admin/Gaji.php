<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GajiModel;
use App\Models\DepartemenModel;
use App\Models\JabatanModel;

class Gaji extends BaseController
{
    protected $gajiModel;
    protected $departemenModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->gajiModel = new GajiModel();
        $this->departemenModel = new DepartemenModel();
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data['title'] = 'Manajemen Gaji';
        $data['gaji'] = $this->gajiModel->getDataGaji();
        $data['departemen'] = $this->departemenModel->getAllDepartemen();
        $data['jabatan'] = $this->jabatanModel->getAllJabatan();

        return view('admin/gaji/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $this->gajiModel->addGaji();
            session()->setFlashdata('success', 'Gaji berhasil ditambahkan');
            return redirect()->to(base_url('admin/gaji'));
        }

        $data['title'] = 'Tambah Gaji';
        $data['departemen'] = $this->departemenModel->getAllDepartemen();
        $data['jabatan'] = $this->jabatanModel->getAllJabatan();

        return view('admin/gaji/add', $data);
    }

    public function edit($id)
{
    if ($this->request->getMethod() === 'post') {
        $payload = [
            'id_departemen'  => (int)$this->request->getPost('id_departemen'),
            'id_jabatan'     => (int)$this->request->getPost('id_jabatan'),
            'gaji_per_jam'   => $this->request->getPost('gaji_per_jam'),
            'tanggal_update' => date('Y-m-d H:i:s'),
        ];

        $affected = $this->gajiModel->editGaji((int)$id, $payload);

        if ($affected === -1) {
            session()->setFlashdata('error', 'Data gaji tidak ditemukan.');
            return redirect()->to(base_url('admin/gaji'));
        }
        if ($affected === 0) {
            // tidak ada nilai yang berubah (sama persis) — ini bukan error DB
            session()->setFlashdata('info', 'Tidak ada perubahan (nilai sama seperti sebelumnya).');
            return redirect()->to(base_url('admin/gaji'));
        }

        session()->setFlashdata('success', 'Gaji berhasil diperbarui');
        return redirect()->to(base_url('admin/gaji'));
    }

    // GET: tampilkan form
    $data['title']      = 'Edit Gaji';
    $data['gaji']       = $this->gajiModel->getGaji($id);         // object
    $data['departemen'] = $this->departemenModel->getAllDepartemen(); // sebaiknya object (getResult())
    $data['jabatan']    = $this->jabatanModel->getAllJabatan();      // sebaiknya object (getResult())

    if (empty($data['gaji'])) {
        session()->setFlashdata('error', 'Gaji tidak ditemukan');
        return redirect()->to(base_url('admin/gaji'));
    }

    return view('admin/gaji/edit', $data);
}


    public function delete($id)
    {
        $this->gajiModel->deleteGaji($id);
        session()->setFlashdata('success', 'Gaji berhasil dihapus');
        return redirect()->to(base_url('admin/gaji'));
    }

    public function rekap()
    {
        $filter      = $this->request->getGet('filter') ?? 'day';
        $start_date  = $this->request->getGet('start_date') ?? date('Y-m-d');
        $end_date    = $this->request->getGet('end_date') ?? date('Y-m-d');
        $min_percentage = $this->request->getGet('min_percentage');

        // default 0 kalau null/kosong
        if ($min_percentage === null || $min_percentage === '') {
            $min_percentage = 0;
        } else {
            $min_percentage = (float)$min_percentage;
        }

        $data['title']        = 'Rekap Gaji Karyawan';
        $data['rekap_gaji']   = $this->gajiModel->getRekapGaji($filter, $start_date, $end_date);
        $data['filter']       = $filter;
        $data['start_date']   = $start_date;
        $data['end_date']     = $end_date;
        $data['min_percentage'] = $min_percentage; // ⬅️ kirim ke view

        return view('admin/gaji/rekap', $data);
    }

    public function export()
    {
        $filter = $this->request->getGet('filter') ?? 'day';
        $start_date = $this->request->getGet('start_date') ?? '';
        $end_date = $this->request->getGet('end_date') ?? '';
        $min_percentage = $this->request->getGet('min_percentage') ?? 100;

        // ambil data rekap dari model sesuai filter
        $rekap_gaji = $this->gajiModel->getRekapGaji($filter, $start_date, $end_date);

        // siapkan nama file
        $filename = "rekap_gaji_" . date('Ymd_His') . ".csv";

        // set header untuk download CSV
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // buka output buffer untuk menulis CSV
        $file = fopen('php://output', 'w');

        // header kolom CSV
        $header = ["No", "Nama Karyawan", "Departemen", "Jabatan", "Jumlah Kehadiran", "Total Jam", "Gaji Per Jam", "Total Gaji (setelah potongan)", "Persentase"];
        fputcsv($file, $header);

        $i = 1;
        foreach ($rekap_gaji as $rg) {
            $gaji_setelah_persen = $rg['total_gaji'] * ($min_percentage / 100);

            $row = [
                $i++,
                $rg['nama_karyawan'],
                $rg['departemen'],
                $rg['jabatan'],
                $rg['jumlah_kehadiran'],
                $rg['total_jam'] . " jam",
                $rg['gaji_per_jam'],
                $gaji_setelah_persen,
                $min_percentage . "%"
            ];

            fputcsv($file, $row);
        }

        fclose($file);
        exit;
    }

    public function save()
    {
        $id_departemen = $this->request->getPost('id_departemen');
        $id_jabatan    = $this->request->getPost('id_jabatan');
        $gaji_per_jam  = $this->request->getPost('gaji_per_jam');

        $data = [
            'id_departemen' => $id_departemen,
            'id_jabatan'    => $id_jabatan,
            'gaji_per_jam'  => $gaji_per_jam,
            'tanggal_update' => date('Y-m-d H:i:s')
        ];

        $this->gajiModel->insert($data);

        return redirect()->to(base_url('admin/gaji'))
            ->with('message', 'Data gaji berhasil ditambahkan.');
    }
}