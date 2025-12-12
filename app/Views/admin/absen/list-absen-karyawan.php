<div class="card-body">
    <div class="row">
        <div class="col-auto me-auto">
            <div class="pt-3 pl-3">
                <h4><b>Absen Karyawan</b></h4>
                <p>Daftar karyawan muncul disini</p>
            </div>
        </div>
        <div class="col">
            <a href="#" class="btn btn-primary pl-3 mr-3 mt-3" onclick="departemen = onDateChange()" data-toggle="tab">
                <i class="material-icons mr-2">refresh</i> Refresh
            </a>
        </div>
        <div class="col-auto">
            <div class="px-4">
                <h3 class="text-end">
                    <b class="text-primary"><?= $departemen; ?></b>
                </h3>
            </div>
        </div>
    </div>

    <div id="dataKaryawan" class="card-body table-responsive pb-5">
        <?php if (!empty($data)) : ?>
            <!-- Total Karyawan Info -->
            <div class="mb-3" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border-radius: 8px; border-left: 4px solid #2196f3;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="material-icons" style="color: #2196f3; font-size: 24px;">people</i>
                    <span style="font-weight: 700; color: #1976d2; font-size: 16px;">Total Karyawan: <span style="background: #1976d2; color: white; padding: 4px 8px; border-radius: 12px; font-size: 14px;"><?= $total_karyawan; ?></span></span>
                </div>
                <div style="color: #666; font-size: 14px;">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">schedule</i>
                    <?= date('d M Y H:i'); ?>
                </div>
            </div>

            <!-- Bulk Update Bar -->
            <div class="mb-3" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; border:1px solid #e0e0e0; border-radius:10px; padding:12px; background:#fafafa">
                <div>
                    <label class="mb-1"><b>Status Kehadiran</b></label>
                    <select id="bulkIdKehadiran" class="form-control" style="min-width:180px">
                        <?php if (isset($listKehadiran) && is_array($listKehadiran)) : ?>
                            <?php foreach ($listKehadiran as $kh) : ?>
                                <option value="<?= $kh['id_kehadiran']; ?>"><?= $kh['kehadiran']; ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="1">Hadir</option>
                            <option value="2">Sakit</option>
                            <option value="3">Izin</option>
                            <option value="4">Tanpa keterangan</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="mb-1"><b>Jam Masuk</b></label>
                    <input id="bulkJamMasuk" type="time" class="form-control" placeholder="HH:MM">
                </div>
                <div>
                    <label class="mb-1"><b>Jam Keluar</b></label>
                    <input id="bulkJamKeluar" type="time" class="form-control" placeholder="HH:MM">
                </div>
                <div style="margin-left:auto; display:flex; gap:8px;">
                    <?php if (!$lewat) : ?>
                        <button type="button" class="btn btn-success" onclick="ubahSemuaKehadiran()">
                            <i class="material-icons mr-1">update</i> Ubah Semua
                        </button>
                    <?php else : ?>
                        <button type="button" class="btn btn-disabled" disabled>
                            Tidak bisa ubah massal untuk tanggal mendatang
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <table class="table table-hover">
                <thead class="text-primary">
                    <th><b>No.</b></th>
                    <th><b>NIP</b></th>
                    <th><b>Nama Karyawan</b></th>
                    <th><b>Kehadiran</b></th>
                    <th><b>Jam masuk</b></th>
                    <th><b>Jam pulang</b></th>
                    <th><b>Keterangan</b></th>
                    <th><b>Aksi</b></th>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $value) : ?>
                        <?php
                        $idKehadiran = intval($value['id_kehadiran'] ?? ($lewat ? 5 : 4));
                        $kehadiran = kehadiran($idKehadiran);
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $value['nis']; ?></td>
                            <td><b><?= $value['nama_karyawan']; ?></b></td>
                            <td>
                                <p class="p-2 w-100 btn btn-<?= $kehadiran['color']; ?> text-center">
                                    <b><?= $kehadiran['text']; ?></b>
                                </p>
                            </td>
                            <td><b><?= $value['jam_masuk'] ?? '-'; ?></b></td>
                            <td><b><?= $value['jam_keluar'] ?? '-'; ?></b></td>
                            <td><?= $value['keterangan'] ?? '-'; ?></td>
                            <td>
                                <?php if (!$lewat) : ?>
                                    <button data-toggle="modal" data-target="#ubahModal" onclick="getDataKehadiran(<?= $value['id_presensi'] ?? '-1'; ?>, <?= $value['id_karyawan']; ?>)" class="btn btn-info p-2" id="<?= $value['nis']; ?>">
                                        <i class="material-icons">edit</i>
                                        Edit
                                    </button>
                                <?php else : ?>
                                    <button class="btn btn-disabled p-2">No Action</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php $no++;
                    endforeach ?>
                </tbody>
            </table>
        <?php
        else :
        ?>
            <div class="row">
                <div class="col">
                    <h4 class="text-center text-danger">Data tidak ditemukan</h4>
                </div>
            </div>
        <?php
        endif; ?>
    </div>
</div>

<?php
function kehadiran($kehadiran): array
{
    $text = '';
    $color = '';
    switch ($kehadiran) {
        case 1:
            $color = 'success';
            $text = 'Hadir';
            break;
        case 2:
            $color = 'warning';
            $text = 'Sakit';
            break;
        case 3:
            $color = 'info';
            $text = 'Izin';
            break;
        case 4:
            $color = 'danger';
            $text = 'Tanpa keterangan';
            break;
        case 5:
        default:
            $color = 'disabled';
            $text = 'Belum tersedia';
            break;
    }

    return ['color' => $color, 'text' => $text];
}
?>
