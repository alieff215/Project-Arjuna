<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryModel;

class InventoryController extends BaseController
{
    protected $inventory;

    public function __construct()
    {
        $this->inventory = new InventoryModel();
    }

    // ===========================
    // HALAMAN INDEX INVENTORY
    // ===========================
    public function index()
    {
        $status = $this->request->getGet('status');

        if ($status) {
            $data['inventories'] = $this->inventory->where('status', $status)->findAll();
        } else {
            // Hanya tampilkan data yang tidak dihapus (status != 'deleted')
            $data['inventories'] = $this->inventory->where('status !=', 'deleted')->findAll();
        }

        // Hitung progress per inventory menggunakan total_target dan finishing_qty
        foreach ($data['inventories'] as &$item) {
            $totalTarget = $item['total_target'];
            $totalQty = $item['finishing_qty']; // Menggunakan finishing_qty sebagai perbandingan

            $progress = $totalTarget > 0 ? round(($totalQty / $totalTarget) * 100, 1) : 0;
            if ($progress > 100) $progress = 100;

            $item['progress_percent'] = $progress;
            $item['is_completed'] = $totalQty >= $totalTarget;
        }

        $data['title'] = 'Inventory Management';
        $data['context'] = 'inventory';
        return view('admin/inventory/index', $data);
    }

    // ===========================
    // FORM TAMBAH INVENTORY
    // ===========================
    public function create()
    {
        $data['title'] = 'Tambah Inventory';
        $data['context'] = 'inventory';
        return view('admin/inventory/create', $data);
    }

    // ===========================
    // SIMPAN INVENTORY BARU
    // ===========================
    public function store()
    {
        $cutting  = (float) $this->request->getPost('cutting_price_per_pcs');
        $produksi = (float) $this->request->getPost('produksi_price_per_pcs');
        $finishing = (float) $this->request->getPost('finishing_price_per_pcs');

        // Hitung total harga per pcs
        $total = $cutting + $produksi + $finishing;

        $this->inventory->save([
            'brand'                   => $this->request->getPost('brand'),
            'order_name'              => $this->request->getPost('order_name'),
            'price_per_pcs'           => $total,
            'status'                  => 'onprogress',

            // Target & harga per divisi
            'cutting_target'          => (int)$this->request->getPost('cutting_target'),
            'produksi_target'         => (int)$this->request->getPost('produksi_target'),
            'finishing_target'        => (int)$this->request->getPost('finishing_target'),
            'cutting_price_per_pcs'   => $cutting,
            'produksi_price_per_pcs'  => $produksi,
            'finishing_price_per_pcs' => $finishing,

            // Data awal qty dan income
            'cutting_qty'             => 0,
            'produksi_qty'            => 0,
            'finishing_qty'           => 0,
            'cutting_income'          => 0,
            'produksi_income'         => 0,
            'finishing_income'        => 0,
            'total_income'            => 0,

            'total_target'            => (int)$this->request->getPost('total_target'),

            'created_at'              => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/inventory')->with('success', 'Data inventory berhasil ditambahkan.');
    }

    // ===========================
    // DETAIL INVENTORY
    // ===========================
    public function detail($id)
    {
        $inventory = $this->inventory->where('id', $id)->where('status !=', 'deleted')->first();

        $db = db_connect();
        $logs = $db->table('inventory_logs')
            ->where('inventory_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Ambil riwayat koreksi (jika ada)
        $histories = $db->table('inventory_log_histories')
            ->where('inventory_id', $id)
            ->orderBy('changed_at', 'DESC')
            ->get()
            ->getResultArray();

        // Cek apakah sudah ada log untuk hari ini (untuk opsi edit/koreksi)
        $hasTodayLog = $db->table('inventory_logs')
            ->where('inventory_id', $id)
            ->where('created_at', date('Y-m-d'))
            ->countAllResults() > 0;

        // Hitung progress
        $totalTarget = max(1, $inventory['cutting_target'] + $inventory['produksi_target'] + $inventory['finishing_target']);
        $totalQty = $inventory['cutting_qty'] + $inventory['produksi_qty'] + $inventory['finishing_qty'];
        $progressPercent = round(($totalQty / $totalTarget) * 100, 1);
        if ($progressPercent > 100) $progressPercent = 100;

        $data = [
            'inventory'        => $inventory,
            'logs'             => $logs,
            'progress_percent' => $progressPercent,
            'hasTodayLog'      => $hasTodayLog,
            'histories'        => $histories,
            'title'            => 'Detail Inventory: ' . $inventory['order_name'],
            'context'          => 'inventory',
        ];

        return view('admin/inventory/detail', $data);
    }

    // ===========================
    // UPDATE PROGRESS PER DIVISI
    // ===========================
    public function updateProcess($id)
    {
        $inventory = $this->inventory->find($id);
        if (!$inventory) {
            return redirect()->back()->with('error', 'Data inventory tidak ditemukan.');
        }

        // Ambil input harian (bisa berupa update dari data hari ini yang sudah ada)
        $cuttingInput   = (int)$this->request->getPost('cutting_qty');
        $produksiInput  = (int)$this->request->getPost('produksi_qty');
        $finishingInput = (int)$this->request->getPost('finishing_qty');

        // Cek apakah sudah ada data hari ini
        $db = db_connect();
        $today = date('Y-m-d');
        $existingToday = $db->table('inventory_logs')
            ->where('inventory_id', $id)
            ->where('created_at', $today)
            ->get()
            ->getRowArray();

        if ($existingToday) {
            // Jika sudah ada data hari ini, hitung selisih dari data hari ini yang sudah ada
            $cuttingDelta = $cuttingInput - (int)$existingToday['cutting_qty'];
            $produksiDelta = $produksiInput - (int)$existingToday['produksi_qty'];
            $finishingDelta = $finishingInput - (int)$existingToday['finishing_qty'];
        } else {
            // Jika belum ada data hari ini, input adalah incremental baru
            $cuttingDelta = $cuttingInput;
            $produksiDelta = $produksiInput;
            $finishingDelta = $finishingInput;
        }

        // Update qty kumulatif dengan delta
        $newCutting   = $inventory['cutting_qty'] + $cuttingDelta;
        $newProduksi  = $inventory['produksi_qty'] + $produksiDelta;
        $newFinishing = $inventory['finishing_qty'] + $finishingDelta;

        // Cek apakah ada yang melebihi target (berdasarkan qty kumulatif)
        $cuttingExceeded = $newCutting > $inventory['cutting_target'];
        $produksiExceeded = $newProduksi > $inventory['produksi_target'];
        $finishingExceeded = $newFinishing > $inventory['finishing_target'];

        // Hitung income kumulatif
        $cuttingIncome   = $newCutting * $inventory['cutting_price_per_pcs'];
        $produksiIncome  = $newProduksi * $inventory['produksi_price_per_pcs'];
        $finishingIncome = $newFinishing * $inventory['finishing_price_per_pcs'];
        $totalIncome     = $cuttingIncome + $produksiIncome + $finishingIncome;

        // Hitung progress % berdasarkan rata-rata progress ketiga divisi
        $cuttingProgress = $inventory['cutting_target'] > 0 ? round(($newCutting / $inventory['cutting_target']) * 100, 1) : 0;
        $produksiProgress = $inventory['produksi_target'] > 0 ? round(($newProduksi / $inventory['produksi_target']) * 100, 1) : 0;
        $finishingProgress = $inventory['finishing_target'] > 0 ? round(($newFinishing / $inventory['finishing_target']) * 100, 1) : 0;
        
        $progressPercent = round(($cuttingProgress + $produksiProgress + $finishingProgress) / 3, 1);
        if ($progressPercent > 100) $progressPercent = 100;

        // Tentukan status
        $isCuttingDone   = $inventory['cutting_target'] > 0 && $newCutting >= $inventory['cutting_target'];
        $isProduksiDone  = $inventory['produksi_target'] > 0 && $newProduksi >= $inventory['produksi_target'];
        $isFinishingDone = $inventory['finishing_target'] > 0 && $newFinishing >= $inventory['finishing_target'];
        $status = ($isCuttingDone && $isProduksiDone && $isFinishingDone) ? 'done' : 'onprogress';

        // Buat pesan peringatan jika ada yang melebihi target
        $warningMessages = [];
        if ($cuttingExceeded) {
            $warningMessages[] = "Cutting melebihi target ({$inventory['cutting_target']}) dengan total kumulatif {$newCutting} (tambah hari ini: {$cuttingInput})";
        }
        if ($produksiExceeded) {
            $warningMessages[] = "Produksi melebihi target ({$inventory['produksi_target']}) dengan total kumulatif {$newProduksi} (tambah hari ini: {$produksiInput})";
        }
        if ($finishingExceeded) {
            $warningMessages[] = "Finishing melebihi target ({$inventory['finishing_target']}) dengan total kumulatif {$newFinishing} (tambah hari ini: {$finishingInput})";
        }

        // Update data kumulatif ke tabel inventories
        $this->inventory->update($id, [
            'cutting_qty'      => $newCutting,
            'produksi_qty'     => $newProduksi,
            'finishing_qty'    => $newFinishing,
            'cutting_income'   => $cuttingIncome,
            'produksi_income'  => $produksiIncome,
            'finishing_income' => $finishingIncome,
            'total_income'     => $totalIncome,
            'status'           => $status,
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        // Simpan/update log harian: simpan data incremental (tambah hari ini), bukan kumulatif
        // Data incremental sudah dihitung di atas

        if ($existingToday) {
            // Catat history perubahan sebelum update
            $db->table('inventory_log_histories')->insert([
                'inventory_id'            => $id,
                'previous_cutting_qty'    => (int)$existingToday['cutting_qty'],
                'previous_produksi_qty'   => (int)$existingToday['produksi_qty'],
                'previous_finishing_qty'  => (int)$existingToday['finishing_qty'],
                'new_cutting_qty'         => (int)$cuttingInput,
                'new_produksi_qty'        => (int)$produksiInput,
                'new_finishing_qty'       => (int)$finishingInput,
                'changed_at'              => date('Y-m-d H:i:s'),
            ]);

            // Update baris log hari ini dengan data input hari ini
            $db->table('inventory_logs')
                ->where('id', $existingToday['id'])
                ->update([
                    'cutting_qty'   => $cuttingInput,
                    'produksi_qty'  => $produksiInput,
                    'finishing_qty' => $finishingInput,
                ]);
        } else {
            // Insert pertama kali untuk hari ini dengan data input hari ini
            $db->table('inventory_logs')->insert([
                'inventory_id' => $id,
                'cutting_qty'  => $cuttingInput,
                'produksi_qty' => $produksiInput,
                'finishing_qty'=> $finishingInput,
                'created_at'   => $today,
            ]);
        }

        // Gabungkan pesan sukses dengan peringatan
        $successMessage = 'Progress berhasil diperbarui. Total progress: ' . $progressPercent . '%';
        
        if (!empty($warningMessages)) {
            $warningText = implode(', ', $warningMessages);
            $successMessage .= ' | ⚠️ PERINGATAN: ' . $warningText;
        }

        return redirect()->to('/admin/inventory/detail/' . $id)
                         ->with('success', $successMessage);
    }

    // ===========================
    // HISTORY INVENTORY SELESAI
    // ===========================
    public function history()
    {
        $data['histories'] = $this->inventory->where('status', 'done')->findAll();
        $data['title'] = 'History Inventory';
        $data['context'] = 'inventory';
        return view('admin/inventory/history', $data);
    }

    // ===========================
    // RECALCULATE TOTAL INCOME
    // ===========================
    public function recalculateIncome($id)
    {
        $inventory = $this->inventory->find($id);
        if (!$inventory) {
            return redirect()->back()->with('error', 'Data inventory tidak ditemukan.');
        }

        // Hitung ulang income berdasarkan qty terbaru
        $cuttingIncome = $inventory['cutting_qty'] * $inventory['cutting_price_per_pcs'];
        $produksiIncome = $inventory['produksi_qty'] * $inventory['produksi_price_per_pcs'];
        $finishingIncome = $inventory['finishing_qty'] * $inventory['finishing_price_per_pcs'];
        $totalIncome = $cuttingIncome + $produksiIncome + $finishingIncome;

        // Update income di database
        $this->inventory->update($id, [
            'cutting_income' => $cuttingIncome,
            'produksi_income' => $produksiIncome,
            'finishing_income' => $finishingIncome,
            'total_income' => $totalIncome,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/inventory/detail/' . $id)
                         ->with('success', 'Total pendapatan berhasil dihitung ulang.');
    }

    // ===========================
    // FIX DAILY INCOME CALCULATION
    // ===========================
    public function fixDailyIncome($id)
    {
        $inventory = $this->inventory->find($id);
        if (!$inventory) {
            return redirect()->back()->with('error', 'Data inventory tidak ditemukan.');
        }

        $db = db_connect();
        $logs = $db->table('inventory_logs')
            ->where('inventory_id', $id)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($logs)) {
            return redirect()->back()->with('error', 'Tidak ada data log untuk inventory ini.');
        }

        // Hitung total income berdasarkan logs
        $totalCuttingIncome = 0;
        $totalProduksiIncome = 0;
        $totalFinishingIncome = 0;
        $prevCut = $prevProd = $prevFin = 0;

        foreach ($logs as $log) {
            $selisihCut = max(0, $log['cutting_qty'] - $prevCut);
            $selisihProd = max(0, $log['produksi_qty'] - $prevProd);
            $selisihFin = max(0, $log['finishing_qty'] - $prevFin);

            $totalCuttingIncome += $selisihCut * $inventory['cutting_price_per_pcs'];
            $totalProduksiIncome += $selisihProd * $inventory['produksi_price_per_pcs'];
            $totalFinishingIncome += $selisihFin * $inventory['finishing_price_per_pcs'];

            $prevCut = $log['cutting_qty'];
            $prevProd = $log['produksi_qty'];
            $prevFin = $log['finishing_qty'];
        }

        $totalIncome = $totalCuttingIncome + $totalProduksiIncome + $totalFinishingIncome;

        // Update income di database
        $this->inventory->update($id, [
            'cutting_income' => $totalCuttingIncome,
            'produksi_income' => $totalProduksiIncome,
            'finishing_income' => $totalFinishingIncome,
            'total_income' => $totalIncome,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/inventory/detail/' . $id)
                         ->with('success', 'Perhitungan pendapatan harian berhasil diperbaiki.');
    }

    // ===========================
    // DELETE INVENTORY (SOFT DELETE)
    // ===========================
    public function delete($id)
    {
        // Gunakan query builder untuk memastikan data ditemukan
        $db = db_connect();
        $inventory = $db->table('inventories')->where('id', $id)->get()->getRowArray();
        
        if (!$inventory) {
            return redirect()->back()->with('error', 'Data inventory tidak ditemukan.');
        }

        // Cek apakah data sudah dihapus sebelumnya
        if ($inventory['status'] == 'deleted') {
            return redirect()->back()->with('error', 'Data inventory sudah dihapus sebelumnya.');
        }

        // Soft delete - update status menjadi 'deleted' dan tambahkan deleted_at
        $result = $db->table('inventories')->where('id', $id)->update([
            'status' => 'deleted',
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($result) {
            return redirect()->to('/admin/inventory')
                             ->with('success', 'Data inventory berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data inventory.');
        }
    }

    // ===========================
    // RESTORE DELETED INVENTORY
    // ===========================
    public function restore($id)
    {
        $inventory = $this->inventory->find($id);
        if (!$inventory) {
            return redirect()->back()->with('error', 'Data inventory tidak ditemukan.');
        }

        // Restore - update status menjadi 'onprogress' dan hapus deleted_at
        $this->inventory->update($id, [
            'status' => 'onprogress',
            'deleted_at' => null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/inventory')
                         ->with('success', 'Data inventory berhasil dipulihkan.');
    }

    // ===========================
    // PERMANENT DELETE INVENTORY
    // ===========================
    public function permanentDelete($id)
    {
        $inventory = $this->inventory->find($id);
        if (!$inventory) {
            return redirect()->back()->with('error', 'Data inventory tidak ditemukan.');
        }

        // Hapus data logs terkait
        $db = db_connect();
        $db->table('inventory_logs')->where('inventory_id', $id)->delete();
        $db->table('inventory_log_histories')->where('inventory_id', $id)->delete();

        // Hapus data inventory secara permanen
        $this->inventory->delete($id);

        return redirect()->to('/admin/inventory/trash')
                         ->with('success', 'Data inventory berhasil dihapus secara permanen.');
    }

    // ===========================
    // TRASH/TRASHED INVENTORY
    // ===========================
    public function trash()
    {
        $data['inventories'] = $this->inventory->where('status', 'deleted')->findAll();
        $data['title'] = 'Inventory Terhapus';
        $data['context'] = 'inventory-trash';
        return view('admin/inventory/trash', $data);
    }

    // ===========================
    // FIX INVENTORY STATUS
    // ===========================
    public function fixStatus()
    {
        $db = db_connect();
        
        // Update status untuk data yang sudah dihapus
        $result = $db->query("UPDATE inventories SET status = 'deleted' WHERE deleted_at IS NOT NULL AND (status IS NULL OR status = '')");
        
        if ($result) {
            return redirect()->to('/admin/inventory')
                             ->with('success', 'Status inventory berhasil diperbaiki.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbaiki status inventory.');
        }
    }
}
