<?= $this->extend('templates/admin_page_layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Card -->
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Gaji</h6>
                    <div class="dropdown">
                        <a class="text-gray-400" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="<?= base_url('admin/gaji/add'); ?>">
                                <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i> Tambah Gaji
                            </a>
                            <a class="dropdown-item" href="<?= base_url('admin/gaji/rekap'); ?>">
                                <i class="fas fa-file-alt fa-sm fa-fw mr-2 text-gray-400"></i> Rekap Gaji
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <?= view('admin/_message_block') ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
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
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('admin/gaji/delete/' . $g['id_gaji']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Card Body -->
            </div>
            <!-- End Card -->
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
