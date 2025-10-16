<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<div class="content">
  <div class="container-fluid">
    <h3 class="mb-3">🗑️ Inventory Terhapus</h3>
    <div class="d-flex gap-2 mb-3">
      <a href="/admin/inventory" class="btn btn-primary">← Kembali ke Inventory</a>
    </div>

    <?php if (empty($inventories)): ?>
      <div class="alert alert-info">
        <h5>Tidak ada data inventory yang dihapus</h5>
        <p>Semua data inventory masih aktif atau belum ada yang dihapus.</p>
      </div>
    <?php else: ?>
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Brand</th>
            <th>Order</th>
            <th>Progress</th>
            <th>Status</th>
            <th>Dihapus Pada</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($inventories as $i => $inv): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= esc($inv['brand']) ?></td>
            <td><?= esc($inv['order_name']) ?></td>
            <td>
              <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-secondary" 
                     role="progressbar" 
                     style="width: <?= $inv['progress_percent'] ?? 0 ?>%;" 
                     aria-valuenow="<?= $inv['progress_percent'] ?? 0 ?>" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                  <strong><?= $inv['progress_percent'] ?? 0 ?>%</strong>
                </div>
              </div>
              <small class="text-muted">
                <?= $inv['finishing_qty'] ?? 0 ?> / <?= $inv['total_target'] ?? 0 ?> pcs
              </small>
            </td>
            <td>
              <span class="badge bg-danger fs-6">🗑️ Terhapus</span>
            </td>
            <td>
              <small class="text-muted">
                <?= $inv['deleted_at'] ? date('d/m/Y H:i', strtotime($inv['deleted_at'])) : '-' ?>
              </small>
            </td>
            <td>
              <div class="d-flex gap-1">
                <a href="/admin/inventory/restore/<?= $inv['id'] ?>" 
                   class="btn btn-sm btn-success" 
                   onclick="return confirm('Apakah Anda yakin ingin memulihkan inventory <?= esc($inv['order_name']) ?>?')">
                  Pulihkan
                </a>
                <a href="/admin/inventory/permanent-delete/<?= $inv['id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('PERINGATAN: Tindakan ini akan menghapus data secara permanen dan tidak dapat dibatalkan!\n\nApakah Anda yakin ingin menghapus inventory <?= esc($inv['order_name']) ?> secara permanen?')">
                  Hapus Permanen
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection(); ?>