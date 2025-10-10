<?php

namespace App\Controllers\Admin;

use App\Models\InventoryModel;
use CodeIgniter\Controller;

class InventoryController extends Controller
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
            $data['inventories'] = $this->inventory->findAll();
        }

        // Hitung progress per inventory
        foreach ($data['inventories'] as &$item) {
            $totalTarget = max(1, $item['cutting_target'] + $item['produksi_target'] + $item['finishing_target']);
            $totalQty = $item['cutting_qty'] + $item['produksi_qty'] + $item['finishing_qty'];

            $progress = round(($totalQty / $totalTarget) * 100, 1);
            if ($progress > 100) $progress = 100;

            $item['progress_percent'] = $progress;
        }

        return view('admin/inventory/index', $data);
    }

    // ===========================
    // FORM TAMBAH INVENTORY
    // ===========================
    public function create()
    {
        return view('admin/inventory/create');
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

            'total_target'            => (int)$this->request->getPost('cutting_target')
                                        + (int)$this->request->getPost('produksi_target')
                                        + (int)$this->request->getPost('finishing_target'),

            'created_at'              => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/inventory')->with('success', 'Data inventory berhasil ditambahkan.');
    }

    // ===========================
    // DETAIL INVENTORY
    // ===========================
    public function detail($id)
    {
        $inventory = $this->inventory->find($id);

        $db = db_connect();
        $logs = $db->table('inventory_logs')
            ->where('inventory_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Hitung progress
        $totalTarget = max(1, $inventory['cutting_target'] + $inventory['produksi_target'] + $inventory['finishing_target']);
        $totalQty = $inventory['cutting_qty'] + $inventory['produksi_qty'] + $inventory['finishing_qty'];
        $progressPercent = round(($totalQty / $totalTarget) * 100, 1);
        if ($progressPercent > 100) $progressPercent = 100;

        $data = [
            'inventory'        => $inventory,
            'logs'             => $logs,
            'progress_percent' => $progressPercent
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

        // Ambil input harian
        $cuttingInput   = (int)$this->request->getPost('cutting_qty');
        $produksiInput  = (int)$this->request->getPost('produksi_qty');
        $finishingInput = (int)$this->request->getPost('finishing_qty');

        // Hitung total baru
        $newCutting   = min($cuttingInput, $inventory['cutting_target']);
        $newProduksi  = min($produksiInput, $inventory['produksi_target']);
        $newFinishing = min($finishingInput, $inventory['finishing_target']);


        // Hitung delta (selisih harian)
        $cuttingDelta   = $newCutting - $inventory['cutting_qty'];
        $produksiDelta  = $newProduksi - $inventory['produksi_qty'];
        $finishingDelta = $newFinishing - $inventory['finishing_qty'];

        // Hitung income kumulatif
        $cuttingIncome   = $newCutting * $inventory['cutting_price_per_pcs'];
        $produksiIncome  = $newProduksi * $inventory['produksi_price_per_pcs'];
        $finishingIncome = $newFinishing * $inventory['finishing_price_per_pcs'];
        $totalIncome     = $cuttingIncome + $produksiIncome + $finishingIncome;

        // Hitung progress %
        $totalTarget = max(1, $inventory['cutting_target'] + $inventory['produksi_target'] + $inventory['finishing_target']);
        $totalQty = $newCutting + $newProduksi + $newFinishing;
        $progressPercent = round(($totalQty / $totalTarget) * 100, 1);
        if ($progressPercent > 100) $progressPercent = 100;

        // Tentukan status
        $isCuttingDone   = $inventory['cutting_target'] > 0 && $newCutting >= $inventory['cutting_target'];
        $isProduksiDone  = $inventory['produksi_target'] > 0 && $newProduksi >= $inventory['produksi_target'];
        $isFinishingDone = $inventory['finishing_target'] > 0 && $newFinishing >= $inventory['finishing_target'];
        $status = ($isCuttingDone && $isProduksiDone && $isFinishingDone) ? 'done' : 'onprogress';

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

        // Simpan log harian (delta/selisih)
        $db = db_connect();
        $db->table('inventory_logs')->insert([
            'inventory_id' => $id,
            'cutting_qty'  => $newCutting,
            'produksi_qty' => $newProduksi,
            'finishing_qty'=> $newFinishing,

            'created_at'   => date('Y-m-d'),
        ]);

        return redirect()->to('/admin/inventory/detail/' . $id)
                         ->with('success', 'Progress berhasil diperbarui. Total progress: ' . $progressPercent . '%');
    }

    // ===========================
    // HISTORY INVENTORY SELESAI
    // ===========================
    public function history()
    {
        $data['histories'] = $this->inventory->where('status', 'done')->findAll();
        return view('admin/inventory/history', $data);
    }
}
