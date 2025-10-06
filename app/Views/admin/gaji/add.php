<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Gaji</h6>
                </div>
                <div class="card-body">
                    <?= view('admin/_message_block') ?>
                    <form action="<?= base_url('admin/gaji/save'); ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="id_departemen">Departemen</label>
                            <select name="id_departemen" id="id_departemen" class="form-control" required>
                                <option value="">Pilih Departemen</option>
                                <?php foreach ($departemen as $d) : ?>
                                    <option value="<?= $d['id_departemen']; ?>"><?= $d['departemen']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_jabatan">Jabatan</label>
                            <select name="id_jabatan" id="id_jabatan" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                <?php foreach ($jabatan as $j) : ?>
                                    <option value="<?= $j->id; ?>"><?= $j->jabatan; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gaji_per_jam">Gaji Per Jam (Rp)</label>
                            <input type="number" class="form-control" id="gaji_per_jam" name="gaji_per_jam" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('admin/gaji'); ?>" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>