<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Detail Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    body {
      background-color: #f5f6fa;
      font-family: 'Segoe UI', sans-serif;
      color: #2f3640;
    }
    .container {
      max-width: 1200px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      margin-bottom: 2rem;
    }
    .card-header {
      font-weight: 600;
      letter-spacing: 0.3px;
    }
    .table th {
      background-color: #f1f2f6;
      font-weight: 600;
    }
    .table td {
      vertical-align: middle;
    }
    .table-dark th {
      background-color: #2f3640 !important;
    }
    .badge {
      font-size: 0.85rem;
      padding: 0.5em 0.8em;
    }
    h3 {
      color: #273c75;
      font-weight: 700;
    }
    .btn-custom {
      border-radius: 8px;
      font-weight: 500;
    }
    #exportPDF {
      background-color: #fff;
      border: 1px solid #ced6e0;
    }
    #exportPDF:hover {
      background-color: #f1f2f6;
    }
  </style>
</head>

<body class="p-4">
  <div class="container" id="export-area">
    <!-- Header -->
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">📦 Detail Inventory: <?= esc($inventory['order_name']) ?></h3>
        <p><b>Brand:</b> <?= esc($inventory['brand']) ?></p>
        <p><b>Status:</b> 
          <span class="badge bg-<?= $inventory['status'] == 'done' ? 'success' : 'warning' ?>">
            <?= ucfirst($inventory['status']) ?>
          </span>
        </p>
      </div>
    </div>

    <!-- Informasi Harga -->
    <div class="card border-primary">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">💰 Informasi Harga</h5>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered text-center mb-0">
          <thead>
            <tr>
              <th>Total per PCS</th>
              <th>Cutting</th>
              <th>Produksi</th>
              <th>Finishing</th>
              <th>Total Income</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= number_format($inventory['price_per_pcs'], 0, ',', '.') ?></td>
              <td><?= number_format($inventory['cutting_price_per_pcs'], 0, ',', '.') ?></td>
              <td><?= number_format($inventory['produksi_price_per_pcs'], 0, ',', '.') ?></td>
              <td><?= number_format($inventory['finishing_price_per_pcs'], 0, ',', '.') ?></td>
              <td><b><?= number_format($inventory['total_income'], 0, ',', '.') ?></b></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Form Update -->
    <div class="card border-success">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">🛠️ Update Progres</h5>
      </div>
      <div class="card-body">
        <form method="post" action="/admin/inventory/updateProcess/<?= $inventory['id'] ?>">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Cutting (Qty)</label>
              <input type="number" name="cutting_qty" value="<?= $inventory['cutting_qty'] ?>" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Produksi (Qty)</label>
              <input type="number" name="produksi_qty" value="<?= $inventory['produksi_qty'] ?>" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Finishing (Qty)</label>
              <input type="number" name="finishing_qty" value="<?= $inventory['finishing_qty'] ?>" class="form-control">
            </div>
          </div>
          <button class="btn btn-primary mt-4 btn-custom px-4">💾 Simpan Perubahan</button>
        </form>
      </div>
    </div>

    <?php
      $cutting_income = $inventory['cutting_qty'] * $inventory['cutting_price_per_pcs'];
      $produksi_income = $inventory['produksi_qty'] * $inventory['produksi_price_per_pcs'];
      $finishing_income = $inventory['finishing_qty'] * $inventory['finishing_price_per_pcs'];
      $total_income = $cutting_income + $produksi_income + $finishing_income;
    ?>

    <!-- Total Pendapatan per Divisi + Capaian Target -->
<div class="card border-info">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0">📈 Total Pendapatan per Divisi</h5>
  </div>
  <div class="card-body p-0">
    <?php 
      // Hitung persentase capaian tiap divisi
      $cutting_progress   = $inventory['cutting_target'] > 0 ? round(($inventory['cutting_qty'] / $inventory['cutting_target']) * 100, 2) : 0;
      $produksi_progress  = $inventory['produksi_target'] > 0 ? round(($inventory['produksi_qty'] / $inventory['produksi_target']) * 100, 2) : 0;
      $finishing_progress = $inventory['finishing_target'] > 0 ? round(($inventory['finishing_qty'] / $inventory['finishing_target']) * 100, 2) : 0;
    ?>
    <table class="table table-bordered text-center mb-0">
      <thead>
        <tr>
          <th>Divisi</th>
          <th>Qty</th>
          <th>Target</th>
          <th>Capaian (%)</th>
          <th>Harga per PCS</th>
          <th>Total Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Cutting</td>
          <td><?= $inventory['cutting_qty'] ?></td>
          <td><?= $inventory['cutting_target'] ?></td>
          <td>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $cutting_progress ?>%;" aria-valuenow="<?= $cutting_progress ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $cutting_progress ?>%
              </div>
            </div>
          </td>
          <td><?= number_format($inventory['cutting_price_per_pcs'], 0, ',', '.') ?></td>
          <td><?= number_format($cutting_income, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td>Produksi</td>
          <td><?= $inventory['produksi_qty'] ?></td>
          <td><?= $inventory['produksi_target'] ?></td>
          <td>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $produksi_progress ?>%;" aria-valuenow="<?= $produksi_progress ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $produksi_progress ?>%
              </div>
            </div>
          </td>
          <td><?= number_format($inventory['produksi_price_per_pcs'], 0, ',', '.') ?></td>
          <td><?= number_format($produksi_income, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td>Finishing</td>
          <td><?= $inventory['finishing_qty'] ?></td>
          <td><?= $inventory['finishing_target'] ?></td>
          <td>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: <?= $finishing_progress ?>%;" aria-valuenow="<?= $finishing_progress ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $finishing_progress ?>%
              </div>
            </div>
          </td>
          <td><?= number_format($inventory['finishing_price_per_pcs'], 0, ',', '.') ?></td>
          <td><?= number_format($finishing_income, 0, ',', '.') ?></td>
        </tr>
        <tr class="table-dark text-white">
          <td colspan="5"><b>Total Keseluruhan</b></td>
          <td><b><?= number_format($total_income, 0, ',', '.') ?></b></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


    <!-- Rekapan Harian -->
    <div class="card border-0 shadow-sm" id="rekapan-harian">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📅 Rekapan Harian</h5>
        <button id="exportPDF" class="btn btn-sm btn-light text-dark btn-custom">⬇️ Ekspor PDF</button>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered text-center mb-0">
          <thead class="table-secondary">
            <tr>
              <th rowspan="2">Tanggal</th>
              <th colspan="3">Qty Saat Ini</th>
              <th colspan="3">Tambah Hari Ini</th>
              <th colspan="3">Pendapatan Hari Ini</th>
              <th rowspan="2">Total Pendapatan</th>
            </tr>
            <tr>
              <th>Cutting</th>
              <th>Produksi</th>
              <th>Finishing</th>
              <th>Cut</th>
              <th>Prod</th>
              <th>Fin</th>
              <th>Cut</th>
              <th>Prod</th>
              <th>Fin</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $prevCut = $prevProd = $prevFin = 0;
              $sumCutIncome = $sumProdIncome = $sumFinIncome = 0;
              foreach ($logs as $log): 
                $selisihCut = $log['cutting_qty'] - $prevCut;
                $selisihProd = $log['produksi_qty'] - $prevProd;
                $selisihFin = $log['finishing_qty'] - $prevFin;

                $incomeCut = $selisihCut * $inventory['cutting_price_per_pcs'];
                $incomeProd = $selisihProd * $inventory['produksi_price_per_pcs'];
                $incomeFin = $selisihFin * $inventory['finishing_price_per_pcs'];
                $totalIncomeToday = $incomeCut + $incomeProd + $incomeFin;

                $sumCutIncome += $incomeCut;
                $sumProdIncome += $incomeProd;
                $sumFinIncome += $incomeFin;

                $prevCut = $log['cutting_qty'];
                $prevProd = $log['produksi_qty'];
                $prevFin = $log['finishing_qty'];
            ?>
            <tr>
              <td><?= $log['created_at'] ?></td>
              <td><?= $log['cutting_qty'] ?></td>
              <td><?= $log['produksi_qty'] ?></td>
              <td><?= $log['finishing_qty'] ?></td>
              <td class="text-primary"><?= $selisihCut ?></td>
              <td class="text-primary"><?= $selisihProd ?></td>
              <td class="text-primary"><?= $selisihFin ?></td>
              <td><?= number_format($incomeCut, 0, ',', '.') ?></td>
              <td><?= number_format($incomeProd, 0, ',', '.') ?></td>
              <td><?= number_format($incomeFin, 0, ',', '.') ?></td>
              <td><b><?= number_format($totalIncomeToday, 0, ',', '.') ?></b></td>
            </tr>
            <?php endforeach; ?>

            <tr class="table-dark text-white">
              <td colspan="7"><b>Total Akumulasi Pendapatan</b></td>
              <td><b><?= number_format($sumCutIncome, 0, ',', '.') ?></b></td>
              <td><b><?= number_format($sumProdIncome, 0, ',', '.') ?></b></td>
              <td><b><?= number_format($sumFinIncome, 0, ',', '.') ?></b></td>
              <td><b><?= number_format($sumCutIncome + $sumProdIncome + $sumFinIncome, 0, ',', '.') ?></b></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
      <a href="/admin/inventory" class="btn btn-outline-secondary btn-custom px-4">⬅️ Kembali</a>
    </div>
  </div>

  <!-- Script Ekspor PDF -->
  <script>
    document.getElementById("exportPDF").addEventListener("click", async () => {
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF("p", "pt", "a4");
      const element = document.getElementById("export-area");

      await html2canvas(element, { scale: 2, useCORS: true }).then((canvas) => {
        const imgData = canvas.toDataURL("image/png");
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.setFontSize(16);
        pdf.text("Laporan Detail Inventory", pdfWidth / 2, 30, { align: "center" });
        pdf.text("<?= esc($inventory['order_name']) ?>", pdfWidth / 2, 50, { align: "center" });
        pdf.addImage(imgData, "PNG", 0, 60, pdfWidth, pdfHeight);
        pdf.save("Detail_Inventory_<?= esc($inventory['order_name']) ?>.pdf");
      });
    });
  </script>
</body>
</html>
