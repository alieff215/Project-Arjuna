<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<style>
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

<div class="content">
  <div class="container-fluid" id="export-area">
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
        <h5 class="mb-0">🛠 Update Progres</h5>
      </div>
      <div class="card-body">
        <!-- Alert peringatan jika melebihi target -->
        <?php
          $cuttingExceeded = $inventory['cutting_qty'] > $inventory['cutting_target'];
          $produksiExceeded = $inventory['produksi_qty'] > $inventory['produksi_target'];
          $finishingExceeded = $inventory['finishing_qty'] > $inventory['finishing_target'];
          
          if ($cuttingExceeded || $produksiExceeded || $finishingExceeded):
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <h6 class="alert-heading"> Input sudah Melebihi Target</h6>
          <ul class="mb-0">
            <?php if ($cuttingExceeded): ?>
              <li>Cutting: <?= $inventory['cutting_qty'] ?> (Target: <?= $inventory['cutting_target'] ?>)</li>
            <?php endif; ?>
            <?php if ($produksiExceeded): ?>
              <li>Produksi: <?= $inventory['produksi_qty'] ?> (Target: <?= $inventory['produksi_target'] ?>)</li>
            <?php endif; ?>
            <?php if ($finishingExceeded): ?>
              <li>Finishing: <?= $inventory['finishing_qty'] ?> (Target: <?= $inventory['finishing_target'] ?>)</li>
            <?php endif; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <?php
          // Hitung data hari ini untuk form input
          $today = date('Y-m-d');
          $deltaCut = 0; $deltaProd = 0; $deltaFin = 0;
          
          if (isset($logs) && is_array($logs) && count($logs) > 0) {
            foreach ($logs as $log) {
              if ($log['created_at'] === $today) {
                // Data di logs sudah incremental, langsung ambil
                $deltaCut = (int)$log['cutting_qty'];
                $deltaProd = (int)$log['produksi_qty'];
                $deltaFin = (int)$log['finishing_qty'];
                break; // Hanya ambil data hari ini yang pertama
              }
            }
          }
        ?>
        
        <form method="post" action="/admin/inventory/updateProcess/<?= $inventory['id'] ?>">
          <!-- Informasi Qty Kumulatif Saat Ini -->
          <div class="alert alert-info mb-3">
            <h6 class="alert-heading">📊 Qty Kumulatif Saat Ini:</h6>
            <div class="row">
              <div class="col-md-4">
                <strong>Cutting:</strong> <?= $inventory['cutting_qty'] ?> / <?= $inventory['total_target'] ?>
              </div>
              <div class="col-md-4">
                <strong>Produksi:</strong> <?= $inventory['produksi_qty'] ?> / <?= $inventory['total_target'] ?>
              </div>
              <div class="col-md-4">
                <strong>Finishing:</strong> <?= $inventory['finishing_qty'] ?> / <?= $inventory['total_target'] ?>
              </div>
            </div>
          </div>
          
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold">Cutting (Qty Hari Ini)</label>
              <input type="number" name="cutting_qty" value="<?= $deltaCut ?>" min="0" 
                     class="form-control" placeholder="Masukkan qty cutting hari ini">
              <small class="text-muted">
                <?php if ($deltaCut > 0): ?>
                  Sudah diinput hari ini: <?= $deltaCut ?> | Akan ditambahkan ke: <?= $inventory['cutting_qty'] - $deltaCut ?>
                <?php else: ?>
                  Input: 0 (reset setiap hari) | Akan ditambahkan ke: <?= $inventory['cutting_qty'] ?>
                <?php endif; ?>
              </small>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Produksi (Qty Hari Ini)</label>
              <input type="number" name="produksi_qty" value="<?= $deltaProd ?>" min="0" 
                     class="form-control" placeholder="Masukkan qty produksi hari ini">
              <small class="text-muted">
                <?php if ($deltaProd > 0): ?>
                  Sudah diinput hari ini: <?= $deltaProd ?> | Akan ditambahkan ke: <?= $inventory['produksi_qty'] - $deltaProd ?>
                <?php else: ?>
                  Input: 0 (reset setiap hari) | Akan ditambahkan ke: <?= $inventory['produksi_qty'] ?>
                <?php endif; ?>
              </small>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Finishing (Qty Hari Ini)</label>
              <input type="number" name="finishing_qty" value="<?= $deltaFin ?>" min="0" 
                     class="form-control" placeholder="Masukkan qty finishing hari ini">
              <small class="text-muted">
                <?php if ($deltaFin > 0): ?>
                  Sudah diinput hari ini: <?= $deltaFin ?> | Akan ditambahkan ke: <?= $inventory['finishing_qty'] - $deltaFin ?>
                <?php else: ?>
                  Input: 0 (reset setiap hari) | Akan ditambahkan ke: <?= $inventory['finishing_qty'] ?>
                <?php endif; ?>
              </small>
            </div>
          </div>
          <button class="btn btn-primary mt-4 btn-custom px-4">
            <?= isset($hasTodayLog) && $hasTodayLog ? '✏ Simpan Koreksi Hari Ini' : '💾 Simpan Perubahan' ?>
          </button>
        </form>
      </div>
    </div>

    <?php
      // Untuk capaian keseluruhan, gunakan qty kumulatif dari tabel inventories
      $cuttingQtyToday = (int)$inventory['cutting_qty'];
      $produksiQtyToday = (int)$inventory['produksi_qty'];
      $finishingQtyToday = (int)$inventory['finishing_qty'];

      $cutting_income_today = $deltaCut * (float)$inventory['cutting_price_per_pcs'];
      $produksi_income_today = $deltaProd * (float)$inventory['produksi_price_per_pcs'];
      $finishing_income_today = $deltaFin * (float)$inventory['finishing_price_per_pcs'];
      $total_income_today = $cutting_income_today + $produksi_income_today + $finishing_income_today;

      // Target harian sudah diinput langsung saat create inventory (bukan dibagi 30)
      $target_harian_cutting = (int)$inventory['cutting_target'];
      $target_harian_produksi = (int)$inventory['produksi_target'];
      $target_harian_finishing = (int)$inventory['finishing_target'];

      // Evaluasi capaian HARI INI terhadap target harian per divisi
      // Peringatan jika qty harian (delta) masih di bawah target harian
      $cut_not_meet_daily = ($deltaCut < $target_harian_cutting);
      $prod_not_meet_daily = ($deltaProd < $target_harian_produksi);
      $fin_not_meet_daily  = ($deltaFin < $target_harian_finishing);
    ?>

    <!-- Total Pendapatan per Divisi + Capaian Target -->
<div class="card border-info">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0">📈 Total Pendapatan per Divisi (Hari Ini)</h5>
  </div>
  <div class="card-body p-0">
    <?php 
      // Hitung persentase capaian berdasarkan qty harian (delta) terhadap target harian
      $cutting_progress   = $target_harian_cutting > 0 ? round(($deltaCut / $target_harian_cutting) * 100, 2) : 0;
      $produksi_progress  = $target_harian_produksi > 0 ? round(($deltaProd / $target_harian_produksi) * 100, 2) : 0;
      $finishing_progress = $target_harian_finishing > 0 ? round(($deltaFin / $target_harian_finishing) * 100, 2) : 0;
      
      // Batasi progress maksimal 100%
      if ($cutting_progress > 100) $cutting_progress = 100;
      if ($produksi_progress > 100) $produksi_progress = 100;
      if ($finishing_progress > 100) $finishing_progress = 100;
    ?>
    <?php if ($cut_not_meet_daily || $prod_not_meet_daily || $fin_not_meet_daily): ?>
    <div class="alert alert-danger m-3">
      Beberapa divisi belum mencapai target pada hari ini:
      <b>
        <?= $cut_not_meet_daily ? 'Cutting ' : '' ?>
        <?= $prod_not_meet_daily ? 'Produksi ' : '' ?>
        <?= $fin_not_meet_daily ? 'Finishing' : '' ?>
      </b>
    </div>
    <?php endif; ?>
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
          <td class="<?= $cut_not_meet_daily ? 'table-danger' : '' ?>">
            <?= $deltaCut ?>
            <?php if ($cut_not_meet_daily): ?><span class="badge bg-danger ms-2">Belum capai target harian</span><?php endif; ?>
          </td>
          <td><?= $target_harian_cutting ?></td>
          <td>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $cutting_progress ?>%;" aria-valuenow="<?= $cutting_progress ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $cutting_progress ?>%
              </div>
            </div>
          </td>
          <td><?= number_format($inventory['cutting_price_per_pcs'], 0, ',', '.') ?></td>
          <td class="<?= $cut_not_meet_daily ? 'table-danger' : '' ?>"><?= number_format($cutting_income_today, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td>Produksi</td>
          <td class="<?= $prod_not_meet_daily ? 'table-danger' : '' ?>">
            <?= $deltaProd ?>
            <?php if ($prod_not_meet_daily): ?><span class="badge bg-danger ms-2">Belum capai target harian</span><?php endif; ?>
          </td>
          <td><?= $target_harian_produksi ?></td>
          <td>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: <?= $produksi_progress ?>%;" aria-valuenow="<?= $produksi_progress ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $produksi_progress ?>%
              </div>
            </div>
          </td>
          <td><?= number_format($inventory['produksi_price_per_pcs'], 0, ',', '.') ?></td>
          <td class="<?= $prod_not_meet_daily ? 'table-danger' : '' ?>"><?= number_format($produksi_income_today, 0, ',', '.') ?></td>
        </tr>
        <tr>
          <td>Finishing</td>
          <td class="<?= $fin_not_meet_daily ? 'table-danger' : '' ?>">
            <?= $deltaFin ?>
            <?php if ($fin_not_meet_daily): ?><span class="badge bg-danger ms-2">Belum capai target harian</span><?php endif; ?>
          </td>
          <td><?= $target_harian_finishing ?></td>
          <td>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: <?= $finishing_progress ?>%;" aria-valuenow="<?= $finishing_progress ?>" aria-valuemin="0" aria-valuemax="100">
                <?= $finishing_progress ?>%
              </div>
            </div>
          </td>
          <td><?= number_format($inventory['finishing_price_per_pcs'], 0, ',', '.') ?></td>
          <td class="<?= $fin_not_meet_daily ? 'table-danger' : '' ?>"><?= number_format($finishing_income_today, 0, ',', '.') ?></td>
        </tr>
        <tr class="table-dark text-white">
          <td colspan="5"><b>Total Keseluruhan</b></td>
          <td><b><?= number_format($total_income_today, 0, ',', '.') ?></b></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Progress Keseluruhan Proyek -->
<div class="card border-warning">
  <div class="card-header bg-warning text-dark">
    <h5 class="mb-0">📊 Progress Keseluruhan Proyek</h5>
  </div>
  <div class="card-body p-0">
    <?php
      // Hitung progress keseluruhan berdasarkan qty kumulatif vs total_target
      $total_target = (int)$inventory['total_target'];
      $total_cutting_progress = $total_target > 0 ? round(($cuttingQtyToday / $total_target) * 100, 2) : 0;
      $total_produksi_progress = $total_target > 0 ? round(($produksiQtyToday / $total_target) * 100, 2) : 0;
      $total_finishing_progress = $total_target > 0 ? round(($finishingQtyToday / $total_target) * 100, 2) : 0;
      
      // Batasi progress maksimal 100%
      if ($total_cutting_progress > 100) $total_cutting_progress = 100;
      if ($total_produksi_progress > 100) $total_produksi_progress = 100;
      if ($total_finishing_progress > 100) $total_finishing_progress = 100;
      
      // Status selesai per divisi berdasarkan total_target
      $cutting_done = $total_target > 0 && $cuttingQtyToday >= $total_target;
      $produksi_done = $total_target > 0 && $produksiQtyToday >= $total_target;
      $finishing_done = $total_target > 0 && $finishingQtyToday >= $total_target;
    ?>
    <table class="table table-bordered text-center mb-0">
      <thead>
        <tr>
          <th>Divisi</th>
          <th>Qty Saat Ini</th>
          <th>Target Total</th>
          <th>Progress (%)</th>
          <th>Status</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Cutting</strong></td>
          <td class="<?= $cutting_done ? 'table-success' : 'table-warning' ?>">
            <strong><?= $cuttingQtyToday ?></strong>
          </td>
          <td><?= $total_target ?></td>
          <td>
            <div class="progress" style="height: 25px;">
              <div class="progress-bar <?= $cutting_done ? 'bg-success' : 'bg-primary' ?>" 
                   role="progressbar" 
                   style="width: <?= $total_cutting_progress ?>%;" 
                   aria-valuenow="<?= $total_cutting_progress ?>" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
                <strong><?= $total_cutting_progress ?>%</strong>
              </div>
            </div>
          </td>
          <td>
            <?php if ($cutting_done): ?>
              <span class="badge bg-success fs-6">✅ Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark fs-6">⏳ Progress</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($cutting_done): ?>
              <span class="text-success">Target tercapai!</span>
            <?php else: ?>
              <span class="text-warning">Kurang <?= $total_target - $cuttingQtyToday ?> pcs</span>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td><strong>Produksi</strong></td>
          <td class="<?= $produksi_done ? 'table-success' : 'table-warning' ?>">
            <strong><?= $produksiQtyToday ?></strong>
          </td>
          <td><?= $total_target ?></td>
          <td>
            <div class="progress" style="height: 25px;">
              <div class="progress-bar <?= $produksi_done ? 'bg-success' : 'bg-success' ?>" 
                   role="progressbar" 
                   style="width: <?= $total_produksi_progress ?>%;" 
                   aria-valuenow="<?= $total_produksi_progress ?>" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
                <strong><?= $total_produksi_progress ?>%</strong>
              </div>
            </div>
          </td>
          <td>
            <?php if ($produksi_done): ?>
              <span class="badge bg-success fs-6">✅ Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark fs-6">⏳ Progress</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($produksi_done): ?>
              <span class="text-success">Target tercapai!</span>
            <?php else: ?>
              <span class="text-warning">Kurang <?= $total_target - $produksiQtyToday ?> pcs</span>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td><strong>Finishing</strong></td>
          <td class="<?= $finishing_done ? 'table-success' : 'table-warning' ?>">
            <strong><?= $finishingQtyToday ?></strong>
          </td>
          <td><?= $total_target ?></td>
          <td>
            <div class="progress" style="height: 25px;">
              <div class="progress-bar <?= $finishing_done ? 'bg-success' : 'bg-warning text-dark' ?>" 
                   role="progressbar" 
                   style="width: <?= $total_finishing_progress ?>%;" 
                   aria-valuenow="<?= $total_finishing_progress ?>" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
                <strong><?= $total_finishing_progress ?>%</strong>
              </div>
            </div>
          </td>
          <td>
            <?php if ($finishing_done): ?>
              <span class="badge bg-success fs-6">✅ Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark fs-6">⏳ Progress</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($finishing_done): ?>
              <span class="text-success">Target tercapai!</span>
            <?php else: ?>
              <span class="text-warning">Kurang <?= $total_target - $finishingQtyToday ?> pcs</span>
            <?php endif; ?>
          </td>
        </tr>
        <tr class="table-dark text-white">
          <td><strong>Total Keseluruhan</strong></td>
          <td><strong><?= $finishingQtyToday ?></strong></td>
          <td><strong><?= $total_target ?></strong></td>
          <td>
            <?php
              // Hitung progress keseluruhan berdasarkan rata-rata progress ketiga divisi
              $total_progress = ($total_cutting_progress + $total_produksi_progress + $total_finishing_progress) / 3;
              $overall_progress = round($total_progress, 2);
              if ($overall_progress > 100) $overall_progress = 100;
            ?>
            <div class="progress" style="height: 25px;">
              <div class="progress-bar bg-info" 
                   role="progressbar" 
                   style="width: <?= $overall_progress ?>%;" 
                   aria-valuenow="<?= $overall_progress ?>" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
                <strong><?= $overall_progress ?>%</strong>
              </div>
            </div>
          </td>
          <td>
            <?php if ($overall_progress >= 100): ?>
              <span class="badge bg-success fs-6">🎉 Proyek Selesai!</span>
            <?php else: ?>
              <span class="badge bg-info fs-6">📈 Dalam Progress</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($overall_progress >= 100): ?>
              <span class="text-success">Semua target tercapai!</span>
            <?php else: ?>
              <span class="text-info">Progress rata-rata: <?= $overall_progress ?>%</span>
            <?php endif; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

    <!-- Rekapan Harian -->
    <div class="card border-0 shadow-sm" id="rekapan-harian">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📅 Rekapan Harian</h5>
        <button id="exportPDF" class="btn btn-sm btn-light text-dark btn-custom">⬇ Ekspor PDF</button>
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
              $cumulativeCut = $cumulativeProd = $cumulativeFin = 0;
              $sumCutIncome = $sumProdIncome = $sumFinIncome = 0;
              
              // Balik urutan untuk tampilan (terbaru di atas)
              $reversedLogs = array_reverse($logs);
              
              // Hitung cumulative untuk setiap tanggal (masih dalam urutan ASC untuk perhitungan)
              $cumulativeByDate = [];
              foreach ($logs as $log):
                $tambahHariIniCut = $log['cutting_qty'];
                $tambahHariIniProd = $log['produksi_qty'];
                $tambahHariIniFin = $log['finishing_qty'];
                
                // Simpan cumulative saat ini (SEBELUM ditambahkan tambah hari ini)
                $cumulativeByDate[$log['created_at']] = [
                  'cut' => $cumulativeCut,
                  'prod' => $cumulativeProd,
                  'fin' => $cumulativeFin
                ];
                
                // Tambahkan ke cumulative setelah menyimpan
                $cumulativeCut += $tambahHariIniCut;
                $cumulativeProd += $tambahHariIniProd;
                $cumulativeFin += $tambahHariIniFin;
              endforeach;
              
              // Tampilkan data dalam urutan terbaru ke terlama
              foreach ($reversedLogs as $log): 
                // Data di logs sekarang adalah incremental (tambah hari ini)
                $tambahHariIniCut = $log['cutting_qty'];
                $tambahHariIniProd = $log['produksi_qty'];
                $tambahHariIniFin = $log['finishing_qty'];

                // Ambil cumulative dari tanggal tersebut (nilai sebelum ditambah hari ini)
                $qtySaatIni = $cumulativeByDate[$log['created_at']];

                $incomeCut = $tambahHariIniCut * $inventory['cutting_price_per_pcs'];
                $incomeProd = $tambahHariIniProd * $inventory['produksi_price_per_pcs'];
                $incomeFin = $tambahHariIniFin * $inventory['finishing_price_per_pcs'];
                $totalIncomeToday = $incomeCut + $incomeProd + $incomeFin;

                $sumCutIncome += $incomeCut;
                $sumProdIncome += $incomeProd;
                $sumFinIncome += $incomeFin;
            ?>
            <?php 
              // Check apakah baris tidak mencapai target (paling tidak satu divisi tidak mencapai target)
              $cutRowNotMeetTarget  = ($qtySaatIni['cut'] < (int)$inventory['cutting_target']);
              $prodRowNotMeetTarget = ($qtySaatIni['prod'] < (int)$inventory['produksi_target']);
              $finRowNotMeetTarget  = ($qtySaatIni['fin'] < (int)$inventory['finishing_target']);
              $rowNotMeetTarget = $cutRowNotMeetTarget || $prodRowNotMeetTarget || $finRowNotMeetTarget;
            ?>
            <tr class="<?= $rowNotMeetTarget ? 'table-danger' : '' ?>">
              <td><?= $log['created_at'] ?></td>
              <td><?= $qtySaatIni['cut'] ?></td>
              <td><?= $qtySaatIni['prod'] ?></td>
              <td><?= $qtySaatIni['fin'] ?></td>
              <td><?= $tambahHariIniCut ?></td>
              <td><?= $tambahHariIniProd ?></td>
              <td><?= $tambahHariIniFin ?></td>
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
  </div>

  <!-- Riwayat Koreksi -->
  <?php if (!empty($histories)): ?>
  <div class="container mt-4">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">🕘 Riwayat Koreksi</h5>
      </div>
      <div class="card-body p-0">
        <table class="table table-bordered text-center mb-0">
          <thead class="table-light">
            <tr>
              <th width="16%">Waktu Perubahan</th>
              <th>Prev Cutting</th>
              <th>Prev Produksi</th>
              <th>Prev Finishing</th>
              <th>New Cutting</th>
              <th>New Produksi</th>
              <th>New Finishing</th>
              <th>Δ Cutting</th>
              <th>Δ Produksi</th>
              <th>Δ Finishing</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($histories as $h): 
              $dCut = (int)$h['new_cutting_qty'] - (int)$h['previous_cutting_qty'];
              $dProd = (int)$h['new_produksi_qty'] - (int)$h['previous_produksi_qty'];
              $dFin = (int)$h['new_finishing_qty'] - (int)$h['previous_finishing_qty'];
            ?>
            <tr>
              <td><?= esc($h['changed_at']) ?></td>
              <td><?= (int)$h['previous_cutting_qty'] ?></td>
              <td><?= (int)$h['previous_produksi_qty'] ?></td>
              <td><?= (int)$h['previous_finishing_qty'] ?></td>
              <td><?= (int)$h['new_cutting_qty'] ?></td>
              <td><?= (int)$h['new_produksi_qty'] ?></td>
              <td><?= (int)$h['new_finishing_qty'] ?></td>
              <td class="<?= $dCut>=0?'text-success':'text-danger' ?>"><?= $dCut ?></td>
              <td class="<?= $dProd>=0?'text-success':'text-danger' ?>"><?= $dProd ?></td>
              <td class="<?= $dFin>=0?'text-success':'text-danger' ?>"><?= $dFin ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php endif; ?>
  </div>
</div>

<?= $this->section('scripts'); ?>
<!-- Load libraries with fallback -->
<script>
// Function to load script with fallback
function loadScript(src, onError) {
  return new Promise((resolve, reject) => {
    const script = document.createElement('script');
    script.src = src;
    script.onload = resolve;
    script.onerror = () => {
      console.error('Failed to load:', src);
      if (onError) onError();
      reject(new Error('Failed to load: ' + src));
    };
    document.head.appendChild(script);
  });
}

// Load libraries with fallback
async function loadLibraries() {
  try {
    // Try primary CDN
    await loadScript('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js');
    await loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    console.log('Libraries loaded from primary CDN');
  } catch (error) {
    console.log('Primary CDN failed, trying alternative...');
    try {
      // Try alternative CDN
      await loadScript('https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.min.js');
      await loadScript('https://unpkg.com/jspdf@2.5.1/dist/jspdf.umd.min.js');
      console.log('Libraries loaded from alternative CDN');
    } catch (error2) {
      console.error('All CDN sources failed:', error2);
      alert('Error: Required libraries could not be loaded. Please check your internet connection and try again.');
    }
  }
}

// Load libraries when page loads
loadLibraries();
</script>

<script>

// PDF Export Function
function createPDF() {
  console.log('Creating PDF...');
  
  // Check if jsPDF is available
  if (typeof window.jspdf === 'undefined') {
    alert('Error: jsPDF library tidak tersedia. Silakan refresh halaman.');
    return;
  }
  
  try {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();
    
    // Set font
    pdf.setFont("helvetica");
    
    // Header
    pdf.setFontSize(20);
    pdf.text("LAPORAN DETAIL INVENTORY", 20, 30);
    
    pdf.setFontSize(12);
    pdf.text("Order: <?= esc($inventory['order_name']) ?>", 20, 50);
    pdf.text("Brand: <?= esc($inventory['brand']) ?>", 20, 65);
    pdf.text("Status: <?= ucfirst($inventory['status']) ?>", 20, 80);
    pdf.text("Tanggal: " + new Date().toLocaleDateString('id-ID'), 20, 95);
    
    // Line separator
    pdf.line(20, 105, 190, 105);
    
    // Informasi Harga
    pdf.setFontSize(14);
    pdf.text("INFORMASI HARGA", 20, 120);
    
    pdf.setFontSize(10);
    let yPos = 135;
    pdf.text("Total per PCS: Rp <?= number_format($inventory['price_per_pcs'], 0, ',', '.') ?>", 20, yPos);
    yPos += 10;
    pdf.text("Cutting: Rp <?= number_format($inventory['cutting_price_per_pcs'], 0, ',', '.') ?>", 20, yPos);
    yPos += 10;
    pdf.text("Produksi: Rp <?= number_format($inventory['produksi_price_per_pcs'], 0, ',', '.') ?>", 20, yPos);
    yPos += 10;
    pdf.text("Finishing: Rp <?= number_format($inventory['finishing_price_per_pcs'], 0, ',', '.') ?>", 20, yPos);
    yPos += 10;
    pdf.text("Total Income: Rp <?= number_format($inventory['total_income'], 0, ',', '.') ?>", 20, yPos);
    
    yPos += 20;
    pdf.line(20, yPos, 190, yPos);
    
    // Progress
    pdf.setFontSize(14);
    pdf.text("PROGRESS KESELURUHAN", 20, yPos + 15);
    
    pdf.setFontSize(10);
    yPos += 30;
    
    const cuttingProgress = <?= round(($inventory['cutting_qty'] / $inventory['total_target']) * 100, 1) ?>;
    const produksiProgress = <?= round(($inventory['produksi_qty'] / $inventory['total_target']) * 100, 1) ?>;
    const finishingProgress = <?= round(($inventory['finishing_qty'] / $inventory['total_target']) * 100, 1) ?>;
    
    pdf.text("Cutting: <?= $inventory['cutting_qty'] ?> / <?= $inventory['total_target'] ?> (" + cuttingProgress + "%)", 20, yPos);
    yPos += 10;
    pdf.text("Produksi: <?= $inventory['produksi_qty'] ?> / <?= $inventory['total_target'] ?> (" + produksiProgress + "%)", 20, yPos);
    yPos += 10;
    pdf.text("Finishing: <?= $inventory['finishing_qty'] ?> / <?= $inventory['total_target'] ?> (" + finishingProgress + "%)", 20, yPos);
    
    // Footer
    yPos += 30;
    pdf.line(20, yPos, 190, yPos);
    pdf.setFontSize(8);
    pdf.text("Dibuat pada: " + new Date().toLocaleString('id-ID'), 20, yPos + 10);
    pdf.text("Halaman 1", 170, yPos + 10);
    
    // Save PDF
    const filename = "Laporan_<?= esc($inventory['order_name']) ?>_" + new Date().toISOString().split('T')[0] + ".pdf";
    pdf.save(filename);
    
    console.log('PDF saved successfully');
    alert('PDF berhasil dibuat dan didownload!');
    
  } catch (error) {
    console.error('PDF generation error:', error);
    alert('Error membuat PDF: ' + error.message);
  }
}

// Initialize PDF export with multiple attempts
function initPDFExport() {
  console.log('Initializing PDF export...');
  
  // Try multiple times to find the button
  let attempts = 0;
  const maxAttempts = 10;
  
  function tryInit() {
    attempts++;
    console.log('Attempt', attempts, 'to find export button...');
    
    const exportBtn = document.getElementById("exportPDF");
    if (exportBtn) {
      console.log('Export button found on attempt', attempts);
      
      // Remove any existing event listeners
      const newBtn = exportBtn.cloneNode(true);
      exportBtn.parentNode.replaceChild(newBtn, exportBtn);
      
      // Add click handler
      newBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('PDF export button clicked!');
        createPDF();
      });
      
      console.log('PDF export initialized successfully');
      return;
    }
    
    if (attempts < maxAttempts) {
      setTimeout(tryInit, 500); // Try again in 500ms
    } else {
      console.error('Export button not found after', maxAttempts, 'attempts');
      alert('Error: Tombol export PDF tidak ditemukan. Silakan refresh halaman.');
    }
  }
  
  tryInit();
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, starting PDF export init...');
  setTimeout(initPDFExport, 1000); // Wait 1 second for all content to load
});

// Also try on window load as backup
window.addEventListener('load', function() {
  console.log('Window loaded, trying PDF export init...');
  setTimeout(initPDFExport, 500);
});
</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>