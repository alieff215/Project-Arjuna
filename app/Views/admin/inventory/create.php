<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h3 class="mb-3">Tambah Inventory Baru</h3>
    <form method="post" action="/admin/inventory/store">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Brand</label>
          <input type="text" name="brand" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Nama Order</label>
          <input type="text" name="order_name" class="form-control" required>
        </div>
      </div>

      <div class="mb-3">
        <label>Total Target (pcs)</label>
        <input type="number" name="total_target" class="form-control" required>
      </div>

      <h5 class="mt-4">Target & Harga per Departemen</h5>
      <div class="row">
        <div class="col-md-4">
          <h6>Cutting</h6>
          <input type="number" name="cutting_target" class="form-control mb-2" placeholder="Target per Hari" required>
          <input type="number" name="cutting_price_per_pcs" class="form-control" placeholder="Harga per pcs" required>
        </div>
        <div class="col-md-4">
          <h6>Produksi</h6>
          <input type="number" name="produksi_target" class="form-control mb-2" placeholder="Target per Hari" required>
          <input type="number" name="produksi_price_per_pcs" class="form-control" placeholder="Harga per pcs" required>
        </div>
        <div class="col-md-4">
          <h6>Finishing</h6>
          <input type="number" name="finishing_target" class="form-control mb-2" placeholder="Target per Hari" required>
          <input type="number" name="finishing_price_per_pcs" class="form-control" placeholder="Harga per pcs" required>
        </div>
      </div>

      <button type="submit" class="btn btn-success mt-4">Simpan</button>
      <a href="/admin/inventory" class="btn btn-secondary mt-4">Kembali</a>
    </form>
  </div>
</body>
</html>
