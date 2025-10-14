<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3 class="mb-3">Daftar Inventory</h3>
    <a href="/admin/inventory/create" class="btn btn-primary mb-3">Tambah Inventory</a>
    <form method="get" class="mb-3">
      <label for="status" class="me-2">Filter Status:</label>
      <select name="status" id="status" class="form-select d-inline-block w-auto">
        <option value="">Semua</option>
        <option value="onprogress" <?= isset($_GET['status']) && $_GET['status'] == 'onprogress' ? 'selected' : '' ?>>On Progress</option>
        <option value="done" <?= isset($_GET['status']) && $_GET['status'] == 'done' ? 'selected' : '' ?>>Done</option>
      </select>
      <button class="btn btn-secondary btn-sm">Terapkan</button>
    </form>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Brand</th>
          <th>Order</th>
          <th>Progress</th>
          <th>Status</th>
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
              <div class="progress-bar <?= ($inv['is_completed'] ?? false) ? 'bg-success' : 'bg-info' ?>" 
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
            <?php if ($inv['is_completed'] ?? false): ?>
              <span class="badge bg-success fs-6">✅ Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark fs-6">⏳ Progress</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="/admin/inventory/detail/<?= $inv['id'] ?>" class="btn btn-sm btn-info">Detail</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
