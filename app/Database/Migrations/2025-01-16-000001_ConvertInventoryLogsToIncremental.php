<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConvertInventoryLogsToIncremental extends Migration
{
    public function up()
    {
        // Script untuk mengkonversi data kumulatif menjadi incremental
        $db = \Config\Database::connect();
        
        // Ambil semua inventory_logs yang perlu dikonversi
        $logs = $db->table('inventory_logs')
            ->orderBy('inventory_id, created_at')
            ->get()
            ->getResultArray();
        
        $inventoryGroups = [];
        foreach ($logs as $log) {
            $inventoryGroups[$log['inventory_id']][] = $log;
        }
        
        foreach ($inventoryGroups as $inventoryId => $inventoryLogs) {
            $prevCut = 0;
            $prevProd = 0;
            $prevFin = 0;
            
            foreach ($inventoryLogs as $log) {
                // Hitung incremental
                $incrementalCut = $log['cutting_qty'] - $prevCut;
                $incrementalProd = $log['produksi_qty'] - $prevProd;
                $incrementalFin = $log['finishing_qty'] - $prevFin;
                
                // Update dengan data incremental
                $db->table('inventory_logs')
                    ->where('id', $log['id'])
                    ->update([
                        'cutting_qty' => $incrementalCut,
                        'produksi_qty' => $incrementalProd,
                        'finishing_qty' => $incrementalFin
                    ]);
                
                // Update previous values untuk iterasi berikutnya
                $prevCut = $log['cutting_qty'];
                $prevProd = $log['produksi_qty'];
                $prevFin = $log['finishing_qty'];
            }
        }
    }

    public function down()
    {
        // Script untuk mengembalikan data incremental menjadi kumulatif
        $db = \Config\Database::connect();
        
        // Ambil semua inventory_logs yang perlu dikonversi kembali
        $logs = $db->table('inventory_logs')
            ->orderBy('inventory_id, created_at')
            ->get()
            ->getResultArray();
        
        $inventoryGroups = [];
        foreach ($logs as $log) {
            $inventoryGroups[$log['inventory_id']][] = $log;
        }
        
        foreach ($inventoryGroups as $inventoryId => $inventoryLogs) {
            $cumulativeCut = 0;
            $cumulativeProd = 0;
            $cumulativeFin = 0;
            
            foreach ($inventoryLogs as $log) {
                // Hitung kumulatif
                $cumulativeCut += $log['cutting_qty'];
                $cumulativeProd += $log['produksi_qty'];
                $cumulativeFin += $log['finishing_qty'];
                
                // Update dengan data kumulatif
                $db->table('inventory_logs')
                    ->where('id', $log['id'])
                    ->update([
                        'cutting_qty' => $cumulativeCut,
                        'produksi_qty' => $cumulativeProd,
                        'finishing_qty' => $cumulativeFin
                    ]);
            }
        }
    }
}











