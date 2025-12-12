<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryLogModel extends Model
{
    protected $table = 'inventory_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['inventory_id', 'cutting_qty', 'produksi_qty', 'finishing_qty', 'created_at'];
}
