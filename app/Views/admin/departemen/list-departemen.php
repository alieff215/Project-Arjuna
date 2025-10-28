<?php if (!empty($data)): ?>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Departemen</th>
          <th>Jabatan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $index => $item): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= esc($item['departemen']) ?></td>
            <td><?= esc($item['jabatan']) ?></td>
            <td>
              <a href="<?= base_url('admin/departemen/edit/' . $item['id_departemen']) ?>" type="button" class="btn btn-primary p-2" title="Edit">
                <i class="material-icons">edit</i>
                Edit
              </a>
              <button type="button" class="btn btn-danger p-2" onclick="deleteDepartemen(<?= $item['id_departemen'] ?>)" title="Hapus">
                <i class="material-icons">delete_forever</i>
                Delete
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <div class="text-center py-4">
    <i class="material-icons text-muted" style="font-size: 48px;">inbox</i>
    <p class="text-muted mt-2">Belum ada data departemen</p>
  </div>
<?php endif; ?>

<script>
function deleteDepartemen(id) {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    $.ajax({
      url: '<?= base_url('admin/departemen/delete') ?>',
      type: 'POST',
      data: {
        id: id,
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
      },
      success: function(response) {
        if (response.success) {
          refreshSection('departemen', '#dataDepartemen');
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