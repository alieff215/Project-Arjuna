<?php if (!empty($data)): ?>
  <div class="card-body table-responsive">
    <table class="table table-hover">
      <thead class="text-primary">
        <th><b>No</b></th>
        <th><b>Jabatan</b></th>
        <th><b>Aksi</b></th>
      </thead>
      <tbody>
        <?php $i = 1;
        foreach ($data as $value) : ?>
          <tr>
            <td><?= $i; ?></td>
            <td><?= $value['jabatan']; ?></td>
            <td>
              <a href="<?= base_url('admin/jabatan/edit/' . $value['id']); ?>" type="button" class="btn btn-primary p-2">
                <i class="material-icons">edit</i>
                Edit
              </a>
              <button type="button" class="btn btn-danger p-2" onclick="deleteJabatan(<?= $value['id']; ?>)" title="Hapus">
                <i class="material-icons">delete_forever</i>
                Delete
              </button>
            </td>
          </tr>
        <?php $i++;
        endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <div class="card-body text-center py-4">
    <i class="material-icons text-muted" style="font-size: 48px;">inbox</i>
    <p class="text-muted mt-2">Belum ada data jabatan</p>
  </div>
<?php endif; ?>

<script>
function deleteJabatan(id) {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    $.ajax({
      url: '<?= base_url('admin/jabatan/deleteJabatanPost') ?>',
      type: 'POST',
      data: {
        id: id,
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
      },
      success: function(response) {
        if (response.success) {
          refreshSection('jabatan', '#dataJabatan');
          showAlert('success', response.message);
        } else {
          showAlert('error', response.message);
        }
      },
      error: function() {
        showAlert('error', 'Terjadi kesalahan saat menghapus data');
      }
    });
  }
}
</script>