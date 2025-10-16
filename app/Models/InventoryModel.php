<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventories';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'brand', 'order_name', 'price_per_pcs',
        'total_target',
        'cutting_price_per_pcs', 'cutting_target', 'cutting_income', 'cutting_qty',
        'produksi_price_per_pcs', 'produksi_target', 'produksi_income', 'produksi_qty',
        'finishing_price_per_pcs', 'finishing_target', 'finishing_income', 'finishing_qty',
        'target_per_day', 'total_income', 'status',
        'created_at', 'updated_at', 'deleted_at'
    ];
}
