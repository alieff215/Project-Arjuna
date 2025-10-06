<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<style>
/* ===========================
   CUSTOM STYLING - GAJI INDEX
   =========================== */

.card-header {
    background: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.card-footer {
    background: #f8f9fc;
    border-top: 1px solid #e3e6f0;
    font-size: 0.875rem;
    color: #6c757d;
}

.table thead th {
    background-color: #f1f1f1;
    font-weight: 600;
    color: #4e73df;
    text-align: center;
    vertical-align: middle;
}

.table tbody td {
    vertical-align: middle;
}

.table tbody td:first-child {
    text-align: center;
    font-weight: 500;
}

.btn-sm {
    border-radius: 30px;
    padding: 6px 14px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

.btn-sm i {
    font-size: 0.9rem;
}

.btn-warning:hover {
    background-color: #f59f00;
    border-color: #f59f00;
    color: #fff;
}

.btn-danger:hover {
    background-color: #d6336c;
    border-color: #d6336c;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0069d9;
}

.skeleton {
    background-color: #e2e5e7;
    background-image: linear-gradient(
        90deg,
        #e2e5e7,
        #f8f9fa,
        #e2e5e7
    );
    background-size: 200px 100%;
    background-repeat: no-repeat;
    display: inline-block;
    width: 100%;
    height: 40px;
    border-radius: 4px;
    animation: shine 1.2s infinite linear;
    margin-bottom: 8px;
}

@keyframes shine {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}

.placeholder {
    padding: 40px;
    text-align: center;
    color: #888;
    font-size: 0.95rem;
}
</style>

<div class="content" id="pageGaji">
   <div class="container-fluid">
      <!-- ========== HEAD ACTIONS ========== -->
      <div class="actions-bar mb-3">
         <a class="btn btn-primary btn-rounded" href="<?= base_url('admin/gaji/add'); ?>">
            <i class="material-icons mr-2">add</i> Tambah Data Gaji
         </a>
         <a class="btn btn-success btn-rounded" href="<?= base_url('admin/gaji/rekap'); ?>">
            <i class="material-icons mr-2">summarize</i> Rekap Gaji
         </a>
      </div>

      <!-- ========== DATA LIST ========== -->
      <div class="card shadow">
         <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="material-icons">payments</i> Manajemen Gaji</h6>
            <button class="btn btn-sm btn-outline-primary" type="button" onclick="loadGaji()">
               <i class="material-icons">refresh</i> Refresh
            </button>
         </div>

         <div class="card-body" id="dataGaji">
            <div class="table-responsive">
               <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th style="width:5%">No</th>
                        <th style="width:20%">Departemen</th>
                        <th style="width:20%">Jabatan</th>
                        <th style="width:15%">Gaji Per Jam</th>
                        <th style="width:20%">Tanggal Update</th>
                        <th style="width:20%">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $i = 1; ?>
                     <?php foreach ($gaji as $g) : ?>
                        <tr>
                           <td><?= $i++; ?></td>
                           <td><?= esc($g['departemen']); ?></td>
                           <td><?= esc($g['jabatan']); ?></td>
                           <td>Rp <?= number_format($g['gaji_per_jam'], 0, ',', '.'); ?></td>
                           <td><?= date('d-m-Y H:i', strtotime($g['tanggal_update'])); ?></td>
                           <td>
                              <a href="<?= base_url('admin/gaji/edit/' . $g['id_gaji']); ?>" class="btn btn-warning btn-sm">
                                 <i class="material-icons">edit</i>
                              </a>
                              <a href="<?= base_url('admin/gaji/delete/' . $g['id_gaji']); ?>" 
                                 class="btn btn-danger btn-sm" 
                                 onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                 <i class="material-icons">delete</i>
                              </a>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>

         <div class="card-footer">
            <span><i class="material-icons text-primary">info</i> Data gaji terakhir diperbarui sesuai database.</span>
         </div>
      </div>
   </div>
</div>

<script>
   function loadGaji() {
      $("#dataGaji").html(`
         <div class="skeleton"></div>
         <div class="skeleton" style="height:64px"></div>
         <div class="skeleton" style="height:64px"></div>
      `);

      $.ajax({
         url: "<?= base_url('/admin/gaji'); ?>",
         type: 'get',
         success: function(res) {
            $('#dataGaji').html($(res).find('#dataGaji').html());
         },
         error: function(xhr, status, err) {
            $('#dataGaji').html(`<div class="placeholder">Gagal memuat data.<br><small class="text-danger">${err}</small></div>`);
         }
      });
   }
</script>

<?= $this->endSection() ?>
