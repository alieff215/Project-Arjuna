<div class="card-body table-responsive">
  <table class="table table-hover">
    <thead class="text-primary">
      <th><b>No</b></th>
      <th><b>Departemen</b></th>
      <th><b>Jabatan</b></th>
      <th><b>Aksi</b></th>
    </thead>
    <tbody>
      <?php $i = 1;
      foreach ($data as $value) : ?>
        <tr>
          <td><?= $i; ?></td>
          <td><b><?= $value['departemen']; ?></b></td>
          <td><?= $value['jabatan']; ?></td>
          <td>
            <a href="<?= base_url('admin/departemen/edit/' .  $value['id_departemen']); ?>" type="button" class="btn btn-primary p-2" id="<?= $value['id_departemen']; ?>">
              <i class="material-icons">edit</i>
              Edit
            </a>
            <button onclick='deleteItem("admin/departemen/deleteDepartemenPost","<?= $value["id_departemen"]; ?>","Konfirmasi untuk menghapus data");' class="btn btn-danger p-2" id="<?= $value['id_departemen']; ?>">
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