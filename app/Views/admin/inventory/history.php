<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>History Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3>History Order Selesai</h3>

    <table class="table table-bordered table-striped">
      <thead class="table-success">
        <tr>
          <th>#</th>
          <th>Brand</th>
          <th>Order</th>
          <th>Cutting Income</th>
          <th>Produksi Income</th>
          <th>Finishing Income</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($histories as $i => $inv): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= esc($inv['brand']) ?></td>
          <td><?= esc($inv['order_name']) ?></td>
          <td>Rp<?= number_format($inv['cutting_income'], 0, ',', '.') ?></td>
          <td>Rp<?= number_format($inv['produksi_income'], 0, ',', '.') ?></td>
          <td>Rp<?= number_format($inv['finishing_income'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
