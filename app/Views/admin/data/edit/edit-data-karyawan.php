<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title"><b>Form Edit Karyawan</b></h4>

               </div>
               <div class="card-body mx-5 my-3">

                  <form action="<?= base_url('admin/karyawan/edit'); ?>" method="post">
                     <?= csrf_field() ?>
                     <?php $validation = \Config\Services::validation(); ?>

                     <?php if (session()->getFlashdata('msg')) : ?>
                        <div class="pb-2">
                           <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success'  ?> ">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <i class="material-icons">close</i>
                              </button>
                              <?= session()->getFlashdata('msg') ?>
                           </div>
                        </div>
                     <?php endif; ?>

                     <input type="hidden" name="id" value="<?= $data['id_karyawan']; ?>">

                     <div class="form-group mt-4">
                        <label for="nis">NIS</label>
                        <input type="text" id="nis" class="form-control <?= $validation->getError('nis') ? 'is-invalid' : ''; ?>" name="nis" placeholder="1234" value="<?= old('nis') ?? $oldInput['nis'] ?? $data['nis'] ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('nis'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-4">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" class="form-control <?= $validation->getError('nama') ? 'is-invalid' : ''; ?>" name="nama" placeholder="Your Name" value="<?= old('nama') ?? $oldInput['nama'] ?? $data['nama_karyawan'] ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama'); ?>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="departemen">Departemen</label>
                           <select class="custom-select <?= $validation->getError('id_departemen') ? 'is-invalid' : ''; ?>" id="departemen" name="id_departemen">
                              <option value="">--Pilih departemen--</option>
                              <?php foreach ($departemen as $value) : ?>
                                 <option value="<?= $value['id_departemen']; ?>" <?= old('id_departemen') ?? $oldInput['id_departemen'] ?? $value['id_departemen'] == $data['id_departemen'] ? 'selected' : ''; ?>>
                                    <?= $value['departemen'] . ' ' . $value['jabatan']; ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                           <div class="invalid-feedback">
                              <?= $validation->getError('id_departemen'); ?>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label for="jk">Jenis Kelamin</label>
                           <?php
                           $jenisKelamin = (old('jk') ?? $oldInput['jk'] ?? $data['jenis_kelamin']);
                           $l = $jenisKelamin == 'Laki-laki' || $jenisKelamin == '1' ? 'checked' : '';
                           $p = $jenisKelamin == 'Perempuan' || $jenisKelamin == '2' ? 'checked' : '';
                           ?>
                           <div class="form-check form-control pt-0 mb-1 <?= $validation->getError('jk') ? 'is-invalid' : ''; ?>" id="jk">
                              <div class="row">
                                 <div class="col-auto">
                                    <div class="row">
                                       <div class="col-auto pr-1">
                                          <input class="form-check" type="radio" name="jk" id="laki" value="1" <?= $l; ?>>
                                       </div>
                                       <div class="col">
                                          <label class="form-check-label pl-0 pt-1" for="laki">
                                             <h6 class="text-dark">Laki-laki</h6>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col">
                                    <div class="row">
                                       <div class="col-auto pr-1">
                                          <input class="form-check" type="radio" name="jk" id="perempuan" value="2" <?= $p; ?>>
                                       </div>
                                       <div class="col">
                                          <label class="form-check-label pl-0 pt-1" for="perempuan">
                                             <h6 class="text-dark">Perempuan</h6>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="invalid-feedback">
                              <?= $validation->getError('jk'); ?>
                           </div>
                        </div>
                     </div>

                     <div class="form-group mt-5">
                        <label for="hp">No HP</label>
                        <input type="number" id="hp" name="no_hp" class="form-control <?= $validation->getError('no_hp') ? 'is-invalid' : ''; ?>" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? $data['no_hp'] ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('no_hp'); ?>
                        </div>
                     </div>

                     <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                  </form>

                  <hr>

                  <div class="mt-4">
                     <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#historyUpdate" aria-expanded="<?= session()->getFlashdata('show_history') ? 'true' : 'false'; ?>" aria-controls="historyUpdate">
                        <i class="material-icons">history</i> History Update
                     </button>
                     <div class="collapse mt-3" id="historyUpdate">
                        <style>
                           .hist-item{position:relative;border:1px solid #e5e7eb;border-radius:12px;padding:16px 16px 10px 20px;margin-bottom:14px}
                           .hist-time{font-weight:700;color:#6b7280;font-size:13px;margin-bottom:8px}
                           .hist-badges .badge{display:inline-block;background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;border-radius:999px;padding:4px 10px;font-weight:700;margin:0 6px 6px 0;font-size:12px}
                           .hist-table{width:100%;margin-top:6px}
                           .hist-table th,.hist-table td{padding:8px 10px;border-top:1px solid #f3f4f6;vertical-align:top}
                           .hist-new{color:#065f46;font-weight:700}
                           .hist-old{color:#b91c1c}
                           .hist-arrow{color:#6b7280;font-weight:700;padding:0 6px}
                        </style>
                        <?php if (!empty($histories)) : ?>
                           <?php 
                           // map label field
                           $labels = [
                              'nis' => 'NIS',
                              'nama_karyawan' => 'Nama',
                              'id_departemen' => 'Departemen',
                              'jenis_kelamin' => 'Jenis Kelamin',
                              'no_hp' => 'No HP',
                           ];
                           // map departemen id -> text
                           $deptMap = [];
                           if (!empty($departemen)) {
                              foreach ($departemen as $d) { $deptMap[$d['id_departemen']] = ($d['departemen'] . ' ' . $d['jabatan']); }
                           }
                           $fmtJK = function($v){ return ($v==='1'||$v===1)?'Laki-laki':(($v==='2'||$v===2)?'Perempuan':$v); };
                           ?>
                           <?php foreach ($histories as $h) : ?>
                              <?php
                              $before = json_decode($h['before_data'] ?? '[]', true) ?: [];
                              $after = json_decode($h['after_data'] ?? '[]', true) ?: [];
                              $changed = array_filter(array_map('trim', explode(',', (string)($h['changed_fields'] ?? ''))));
                              ?>
                              <div class="hist-item">
                                 <div class="hist-time"><?= date('d M Y H:i:s', strtotime($h['created_at'] ?? 'now')) ?></div>
                                 <div class="hist-badges">
                                    <?php if (!empty($changed)) : foreach ($changed as $field) : ?>
                                       <span class="badge"><?= esc($labels[$field] ?? $field) ?></span>
                                    <?php endforeach; else : ?>
                                       <span class="badge">Tidak ada perubahan terdeteksi</span>
                                    <?php endif; ?>
                                 </div>
                                 <table class="hist-table">
                                    <thead>
                                       <tr>
                                          <th style="width:220px">Field</th>
                                          <th>Perubahan</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                                       $fieldsToShow = !empty($changed) ? $changed : array_keys($after);
                                       foreach ($fieldsToShow as $f) :
                                          $old = $before[$f] ?? '';
                                          $new = $after[$f] ?? '';
                                          if ($f === 'id_departemen') { $old = $deptMap[$old] ?? $old; $new = $deptMap[$new] ?? $new; }
                                          if ($f === 'jenis_kelamin') { $old = $fmtJK($old); $new = $fmtJK($new); }
                                       ?>
                                          <tr>
                                             <td><b><?= esc($labels[$f] ?? $f) ?></b></td>
                                             <td><span class="hist-old"><?= esc((string)$old) ?></span><span class="hist-arrow">→</span><span class="hist-new"><?= esc((string)$new) ?></span></td>
                                          </tr>
                                       <?php endforeach; ?>
                                    </tbody>
                                 </table>
                              </div>
                           <?php endforeach; ?>
                        <?php else : ?>
                           <div class="alert alert-secondary">Belum ada riwayat perubahan.</div>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>