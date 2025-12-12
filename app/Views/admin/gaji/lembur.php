<?= $this->extend('templates/admin_page_layout') ?>

<?= $this->section('content') ?>

<style>
/* Page-specific styles untuk lembur - konsisten dengan dashboard */
.content.app-content-bg {
    min-height: calc(100vh - 64px);
    padding: 18px 0 24px !important;
    font-size: var(--fz-body, 14px);
    background:
        radial-gradient(1200px 500px at 15% 0%, var(--bg-accent-2, #f0f7ff) 0%, transparent 60%),
        radial-gradient(900px 360px at 100% -5%, var(--bg-accent-1, #e5efff) 0%, transparent 55%),
        linear-gradient(180deg, var(--bg, #eef3fb), var(--bg, #eef3fb));
}

.container-fluid { padding: 0 14px !important; margin: 0 auto; max-width: var(--container-max, 1280px); width: 100%; }
.row { row-gap: 16px; }

.panel {
    border: 1px solid var(--border, rgba(16, 24, 40, .12));
    border-radius: var(--radius, 18px);
    background: var(--card, #fff);
    box-shadow: var(--shadow-1, 0 10px 30px rgba(12, 20, 40, .08));
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.panel__head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; background: linear-gradient(180deg, var(--card-solid, #fff), transparent); border-bottom: 1px solid var(--border, rgba(16, 24, 40, .12)); }
.panel__title { margin: 0; font-weight: 800; letter-spacing: .2px; color: var(--text, #0b132b); display: flex; align-items: center; gap: 10px; font-size: var(--fz-title, 20px); }
.panel__body { padding: 16px; }
.toolbar { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.btn-icon { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 10px; border: 1px solid var(--border, rgba(16, 24, 40, .12)); background: var(--card, #fff); cursor: pointer; transition: all .15s ease; }
.btn-icon:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(12, 20, 40, .1); }
.btn-icon .material-icons { font-size: 18px; }

.card { background: var(--card, #fff) !important; border: 1px solid var(--border, rgba(16, 24, 40, .12)) !important; border-radius: var(--radius, 18px) !important; box-shadow: var(--shadow-1, 0 10px 30px rgba(12, 20, 40, .08)) !important; overflow: hidden; }
.card-header { padding: 16px 18px !important; border-bottom: 1px solid var(--border, rgba(16, 24, 40, .12)) !important; background: linear-gradient(180deg, var(--card-solid, #fff), transparent); }
.card .card-body { padding: 16px 18px !important; color: var(--text, #0b132b); }
.card.card-stats .card-header.card-header-icon { display: grid; grid-template-columns: 64px 1fr auto; grid-auto-rows: auto; align-items: center; column-gap: 14px; height: 100px; padding: 16px 18px 14px; border-bottom: 1px solid var(--border); background: linear-gradient(180deg, var(--card-solid, #fff), transparent); }
.card.card-stats .card-header .card-icon { grid-column: 1; grid-row: 1 / span 2; width: 64px; height: 64px; border-radius: 12px; display: grid; place-items: center; margin: 0; box-shadow: 0 6px 16px rgba(12, 20, 40, .08); }
.card.card-stats .card-header .card-title { grid-column: 3; grid-row: 1; margin: 0; text-align: right; line-height: 1; font-size: clamp(20px, 1.8vw + 10px, 26px); font-weight: 800; color: var(--text); }
.card.card-stats .card-footer { display: flex; align-items: center; gap: 10px; min-height: 56px; border-top: 1px solid var(--border); padding: 12px 18px !important; background: var(--card, #fff); color: var(--muted, #6b7b93); }
.card.card-stats .stats { display: flex; align-items: center; gap: 8px; font-weight: 600; color: var(--muted); }

table.table { width: 100%; border-collapse: collapse; }
table.table th, table.table td { padding: 12px; border-bottom: 1px solid var(--border, rgba(16, 24, 40, .12)); }
table.table th { background: color-mix(in oklab, var(--card-solid, #fff) 92%, transparent); text-align: left; font-weight: 800; }
table.table tr:hover td { background: color-mix(in oklab, var(--card-solid, #fff) 96%, transparent); }
</style>

<div class="content app-content-bg">
  <div class="container-fluid">
    <div class="row equal-cards-row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon" style="background:#3b82f6;color:#fff;"><i class="material-icons">timer</i></div>
            <div>
              <p class="card-category">Total Jam Lembur</p>
              <h3 class="card-title">
                <?php $totalJam = number_format(array_sum(array_column($report_data, 'total_jam_lembur')), 1, ',', '.'); ?>
                <?= $totalJam; ?> jam
              </h3>
            </div>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons" style="color:var(--primary);font-size:16px;">schedule</i> Akumulasi periode</div></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon" style="background:#ef4444;color:#fff;"><i class="material-icons">payments</i></div>
            <div>
              <p class="card-category">Total Gaji Lembur</p>
              <h3 class="card-title">Rp <?= number_format(array_sum(array_column($report_data, 'total_gaji_lembur')), 0, ',', '.') ?></h3>
            </div>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons" style="color:var(--danger);font-size:16px;">trending_up</i> Gaji lembur</div></div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon" style="background:#10b981;color:#fff;"><i class="material-icons">event</i></div>
            <div>
              <p class="card-category">Hari dengan Lembur</p>
              <h3 class="card-title"><?= array_sum(array_column($report_data, 'hari_lembur')) ?> hari</h3>
            </div>
          </div>
          <div class="card-footer"><div class="stats"><i class="material-icons" style="color:var(--success);font-size:16px;">check_circle</i> Akumulasi hari</div></div>
        </div>
      </div>
    </div>

    <div class="panel" style="margin-top:16px;">
      <div class="panel__head">
        <h4 class="panel__title">Laporan Lembur Karyawan</h4>
      </div>
      <div class="panel__body">
        <form method="get" action="<?= base_url('admin/gaji/lembur'); ?>" style="margin-bottom:12px;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;align-items:end;">
          <div>
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= esc($start_date) ?>">
          </div>
          <div>
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= esc($end_date) ?>">
          </div>
          <div>
            <label for="id_departemen">Departemen</label>
            <select class="form-control" id="id_departemen" name="id_departemen">
              <option value="">Semua Departemen</option>
              <?php foreach ($departemen as $dept): ?>
                <option value="<?= $dept['id_departemen'] ?>" <?= ($id_departemen == $dept['id_departemen']) ? 'selected' : '' ?>><?= esc($dept['departemen']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <button type="submit" class="btn btn-primary" style="margin-top:22px;">Terapkan Filter</button>
          </div>
        </form>

        <div style="overflow:auto;">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Jabatan</th>
                <th>Gaji/Jam (Rp)</th>
                <th>Hari Lembur</th>
                <th>Total Jam Lembur</th>
                <th>Total Gaji Lembur (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($report_data)): ?>
                <tr><td colspan="9" style="text-align:center;color:var(--muted);">Tidak ada data lembur untuk periode ini</td></tr>
              <?php else: ?>
                <?php $no=1; foreach ($report_data as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nis']) ?></td>
                    <td><?= esc($row['nama_karyawan']) ?></td>
                    <td><?= esc($row['departemen'] ?? '-') ?></td>
                    <td><?= esc($row['jabatan'] ?? '-') ?></td>
                    <td>Rp <?= number_format((float)($row['gaji_per_jam'] ?? 0), 3, ',', '.') ?></td>
                    <td><?= (int)($row['hari_lembur'] ?? 0) ?></td>
                    <td><?= number_format((float)($row['total_jam_lembur'] ?? 0.0), 1, ',', '.') ?> jam</td>
                    <td>Rp <?= number_format((int)($row['total_gaji_lembur'] ?? 0), 0, ',', '.') ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
