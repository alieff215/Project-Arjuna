<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<style>
  /* ===================== CLEAN MODERN FORM THEME ===================== */
  .content {
    --bg: #f8fafc;
    --card: #ffffff;
    --text: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --border-hover: #cbd5e1;
    --ring: #3b82f6;
    --primary: #3b82f6;
    --primary-hover: #2563eb;
    --primary-light: #dbeafe;
    --success: #10b981;
    --success-light: #d1fae5;
    --radius: 12px;
    --radius-lg: 16px;
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-xl: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    position: relative;
    padding: 24px 0 40px !important;
    color: var(--text);
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: 100vh;
    width: 100%;
    display: block;
    visibility: visible;
  }

  html[data-theme="dark"] .content {
    --bg: #0f172a;
    --card: #1e293b;
    --text: #f1f5f9;
    --muted: #94a3b8;
    --border: #334155;
    --border-hover: #475569;
    --ring: #60a5fa;
    --primary: #60a5fa;
    --primary-hover: #3b82f6;
    --primary-light: #1e3a8a;
    --success: #34d399;
    --success-light: #064e3b;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  }

  .content .page-wrap {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 24px;
    width: 100%;
    display: block;
    visibility: visible;
  }

  .content .toolbar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 32px;
    padding: 24px 0;
  }

  .content .toolbar h3 {
    margin: 0;
    font-weight: 700;
    font-size: 1.875rem;
    letter-spacing: -0.025em;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 12px;
    text-align: center;
  }

  .content .toolbar h3::before {
    content: "➕";
    font-size: 1.5rem;
    color: var(--primary);
  }

  .content .form-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    transition: all 0.2s ease;
    padding: 32px;
  }

  .content .form-card:hover {
    box-shadow: var(--shadow-xl);
  }

  .content .form-group {
    margin-bottom: 24px;
  }

  .content .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text);
    font-size: 0.9rem;
  }

  .content .form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--card);
    color: var(--text);
    font-size: 0.9rem;
    transition: all 0.2s ease;
  }

  .content .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .content .form-control:hover {
    border-color: var(--border-hover);
  }

  .content .form-control::placeholder {
    color: var(--muted);
  }

  .content .section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text);
    margin: 32px 0 20px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--border);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .content .section-title::before {
    content: "🏭";
    font-size: 1.1rem;
    color: var(--primary);
  }

  /* ===== Department Card ===== */
  .content .dept-group {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 32px;
    margin-bottom: 32px;
    transition: all 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow);
  }

  .content .dept-group:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
  }

  .content .dept-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 24px;
    text-align: center;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--border);
    letter-spacing: 0.5px;
  }

  .content .dept-group .form-group {
    margin-bottom: 24px;
  }

  .content .dept-group .form-group:last-child {
    margin-bottom: 0;
  }

  .content .btn {
    border-radius: var(--radius);
    line-height: 1.5;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.85rem;
    border: 1px solid transparent;
    transition: all 0.2s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }

  .content .btn:focus-visible {
    outline: 2px solid var(--ring);
    outline-offset: 2px;
  }

  .content .btn:active {
    transform: translateY(1px);
  }

  .content .btn-success {
    background: var(--success);
    color: #fff;
    border-color: var(--success);
    box-shadow: var(--shadow);
  }

  .content .btn-success:hover {
    background: #059669;
    border-color: #059669;
    box-shadow: var(--shadow-lg);
  }

  .content .btn-secondary {
    background: var(--card);
    color: var(--text);
    border-color: var(--border);
    box-shadow: var(--shadow);
  }

  .content .btn-secondary:hover {
    background: var(--primary-light);
    border-color: var(--primary);
    color: var(--primary);
  }

  .content .btn-group {
    display: flex;
    gap: 12px;
    margin-top: 32px;
    flex-wrap: wrap;
    justify-content: center;
  }

  /* Department Cards Layout */
  .content .row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -16px;
    /* ← was -12px : tambah jarak horizontal */
  }

  .content .col-md-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
    padding: 0 16px;
    /* ← was 0 12px */
  }

  .content .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 12px;
  }

  /* Dark Mode Styles */
  html[data-theme="dark"] .content .form-card {
    background: var(--card);
    border-color: var(--border);
  }

  html[data-theme="dark"] .content .form-control {
    background: var(--card);
    border-color: var(--border);
    color: var(--text);
  }

  html[data-theme="dark"] .content .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
  }

  html[data-theme="dark"] .content .dept-group {
    background: var(--card);
    border-color: var(--border);
  }

  html[data-theme="dark"] .content .dept-group:hover {
    border-color: var(--primary);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .content .page-wrap {
      padding: 0 20px;
    }

    .content .toolbar h3 {
      font-size: 1.5rem;
    }

    .content .form-card {
      padding: 24px;
    }

    .content .col-md-4 {
      flex: 0 0 100%;
      max-width: 100%;
      margin-bottom: 16px;
      padding: 0 12px;
      /* kembalikan padding default di mobile */
    }

    .content .col-md-6 {
      flex: 0 0 100%;
      max-width: 100%;
      margin-bottom: 16px;
    }

    .content .dept-group {
      padding: 24px;
      margin-bottom: 20px;
    }

    .content .dept-title {
      font-size: 1rem;
      margin-bottom: 20px;
      padding-bottom: 10px;
    }

    .content .dept-group .form-group {
      margin-bottom: 20px;
    }

    .content .btn-group {
      flex-direction: column;
      gap: 12px;
    }

    .content .btn {
      width: 100%;
      justify-content: center;
    }
  }

  @media (max-width: 576px) {
    .content {
      padding: 16px 0 24px !important;
    }

    .content .page-wrap {
      padding: 0 16px;
    }

    .content .toolbar {
      margin-bottom: 20px;
      padding: 16px 0;
    }

    .content .toolbar h3 {
      font-size: 1.25rem;
    }

    .content .form-card {
      padding: 20px;
    }

    .content .form-group {
      margin-bottom: 20px;
    }

    .content .form-control {
      padding: 10px 14px;
      font-size: 0.85rem;
    }

    .content .section-title {
      font-size: 1.1rem;
      margin: 24px 0 16px 0;
    }

    .content .col-md-4 {
      margin-bottom: 12px;
    }

    .content .col-md-6 {
      margin-bottom: 12px;
    }

    .content .dept-group {
      padding: 20px;
      margin-bottom: 16px;
    }

    .content .dept-title {
      font-size: 0.95rem;
      margin-bottom: 18px;
      padding-bottom: 8px;
    }

    .content .dept-group .form-group {
      margin-bottom: 18px;
    }

    .content .btn {
      padding: 8px 16px;
      font-size: 0.8rem;
    }
  }
</style>

<div class="content">
  <div class="page-wrap">
    <div class="toolbar">
      <h3>Tambah Inventory Baru</h3>
    </div>

    <div class="form-card">
      <form method="post" action="/admin/inventory/store">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="brand">🏷️ Brand</label>
              <input type="text" name="brand" id="brand" class="form-control" placeholder="Masukkan nama brand" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="order_name">📋 Nama Order</label>
              <input type="text" name="order_name" id="order_name" class="form-control" placeholder="Masukkan nama order" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="total_target">🎯 Total Target (pcs)</label>
          <input type="number" name="total_target" id="total_target" class="form-control" placeholder="Masukkan total target" required>
        </div>

        <h5 class="section-title">Target & Harga per Departemen</h5>

        <div class="row">
          <div class="col-md-4">
            <div class="dept-group">
              <h6 class="dept-title">Cutting</h6>
              <div class="form-group">
                <label for="cutting_target">Target harian</label>
                <input type="number" name="cutting_target" id="cutting_target" class="form-control" placeholder="Target harian" required>
              </div>
              <div class="form-group">
                <label for="cutting_price_per_pcs">Harga per pcs</label>
                <input type="number" name="cutting_price_per_pcs" id="cutting_price_per_pcs" class="form-control" placeholder="Harga per pcs" required>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="dept-group">
              <h6 class="dept-title">Produksi</h6>
              <div class="form-group">
                <label for="produksi_target">Target harian</label>
                <input type="number" name="produksi_target" id="produksi_target" class="form-control" placeholder="Target harian" required>
              </div>
              <div class="form-group">
                <label for="produksi_price_per_pcs">Harga per pcs</label>
                <input type="number" name="produksi_price_per_pcs" id="produksi_price_per_pcs" class="form-control" placeholder="Harga per pcs" required>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="dept-group">
              <h6 class="dept-title">Finishing</h6>
              <div class="form-group">
                <label for="finishing_target">Target harian</label>
                <input type="number" name="finishing_target" id="finishing_target" class="form-control" placeholder="Target harian" required>
              </div>
              <div class="form-group">
                <label for="finishing_price_per_pcs">Harga per pcs</label>
                <input type="number" name="finishing_price_per_pcs" id="finishing_price_per_pcs" class="form-control" placeholder="Harga per pcs" required>
              </div>
            </div>
          </div>
        </div>

        <div class="btn-group">
          <button type="submit" class="btn btn-success">
            <span>💾</span>
            simpan
          </button>
          <a href="/admin/inventory" class="btn btn-secondary">
            <span>↩️</span>
            kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>