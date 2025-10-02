<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Gaji</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="<?= base_url('admin/gaji/add'); ?>">Tambah Gaji</a>
                            <a class="dropdown-item" href="<?= base_url('admin/gaji/rekap'); ?>">Rekap Gaji</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= view('admin/_message_block') ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Departemen</th>
                                    <th>Jabatan</th>
                                    <th>Gaji Per Jam</th>
                                    <th>Tanggal Update</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($gaji as $g) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $g['departemen']; ?></td>
                                        <td><?= $g['jabatan']; ?></td>
                                        <td>Rp <?= number_format($g['gaji_per_jam'], 0, ',', '.'); ?></td>
                                        <td><?= date('d-m-Y H:i', strtotime($g['tanggal_update'])); ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/gaji/edit/' . $g['id_gaji']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="<?= base_url('admin/gaji/delete/' . $g['id_gaji']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>