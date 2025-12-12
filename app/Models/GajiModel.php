<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table = 'tb_gaji';
    protected $primaryKey = 'id_gaji';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'id_departemen',
        'id_jabatan',
        'gaji_per_jam',
        'tanggal_update'
    ];

    protected $validationRules = [
        'id_departemen' => 'required|integer',
        'id_jabatan' => 'required|integer',
        'gaji_per_jam' => 'required|numeric|greater_than[0]'
    ];

    protected $validationMessages = [
        'id_departemen' => [
            'required' => 'Departemen harus dipilih',
            'integer' => 'Departemen tidak valid'
        ],
        'id_jabatan' => [
            'required' => 'Jabatan harus dipilih',
            'integer' => 'Jabatan tidak valid'
        ],
        'gaji_per_jam' => [
            'required' => 'Gaji per jam harus diisi',
            'numeric' => 'Gaji per jam harus berupa angka',
            'greater_than' => 'Gaji per jam harus lebih dari 0'
        ]
    ];

    /**
     * Get all gaji data with department and position information
     */
    public function getAllGaji()
    {
        return $this->db->table('tb_gaji g')
            ->select('g.*, d.departemen, j.jabatan')
            ->join('tb_departemen d', 'g.id_departemen = d.id_departemen')
            ->join('tb_jabatan j', 'g.id_jabatan = j.id')
            ->orderBy('g.id_gaji', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get gaji by ID with department and position information
     */
    public function getGajiById($id)
    {
        return $this->db->table('tb_gaji g')
            ->select('g.*, d.departemen, j.jabatan')
            ->join('tb_departemen d', 'g.id_departemen = d.id_departemen')
            ->join('tb_jabatan j', 'g.id_jabatan = j.id')
            ->where('g.id_gaji', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Get gaji by department and position
     */
    public function getGajiByDeptJabatan($id_departemen, $id_jabatan)
    {
        return $this->where([
            'id_departemen' => $id_departemen,
            'id_jabatan' => $id_jabatan
        ])->first();
    }

    /**
     * Check if gaji exists for department and position combination
     */
    public function isGajiExists($id_departemen, $id_jabatan, $exclude_id = null)
    {
        $builder = $this->where([
            'id_departemen' => $id_departemen,
            'id_jabatan' => $id_jabatan
        ]);

        if ($exclude_id) {
            $builder->where('id_gaji !=', $exclude_id);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Ambil laporan gaji dengan sistem setengah jam dan pembulatan 15 menit
     */
    public function getSalaryReport($start_date = null, $end_date = null, $id_departemen = null)
    {
        if (!$start_date) {
            $start_date = date('Y-m-01');
        }
        if (!$end_date) {
            $end_date = date('Y-m-t');
        }
        $presensiModel = new PresensiKaryawanModel();
        $startDateObj = new \DateTime($start_date);
        $endDateObj = new \DateTime($end_date);
        $isFullMonthRange = $startDateObj->format('Y-m') === $endDateObj->format('Y-m')
            && $startDateObj->format('Y-m-d') === $startDateObj->format('Y-m-01')
            && $endDateObj->format('Y-m-d') === $endDateObj->format('Y-m-t');
        $builder = $this->db->table('tb_karyawan as k')
            ->select('k.id_karyawan, k.nis, k.nama_karyawan, d.departemen, j.jabatan, g.gaji_per_jam')
            ->join('tb_departemen as d', 'k.id_departemen = d.id_departemen', 'left')
            ->join('tb_jabatan as j', 'd.id_jabatan = j.id', 'left')
            ->join('tb_gaji as g', 'd.id_departemen = g.id_departemen AND j.id = g.id_jabatan', 'left');
        if ($id_departemen) {
            $builder->where('k.id_departemen', $id_departemen);
        }
        $karyawanList = $builder->get()->getResultArray();
        $results = [];
        foreach ($karyawanList as $kar) {
            $total_kehadiran = 0;
            $total_menit_kerja = 0;
            $reportJamPerHari = [];
            $reportJamPerHariRegular = [];
            
            // Hitung total hari kerja (Senin-Sabtu) dalam periode
            $totalHariKerjaDalamPeriode = 0;
            $currentDate = new \DateTime($start_date);
            $endDateTime = new \DateTime($end_date);
            while ($currentDate <= $endDateTime) {
                $dayOfWeek = (int)$currentDate->format('N'); // 1=Senin, 7=Minggu
                if ($dayOfWeek <= 6) { // Senin-Sabtu
                    $totalHariKerjaDalamPeriode++;
                }
                $currentDate->modify('+1 day');
            }
            
            // Ambil presensi selama rentang tanggal
            $presensis = $this->db->table('tb_presensi_karyawan')
                ->where('id_karyawan', $kar['id_karyawan'])
                ->where('id_kehadiran', 1)
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->orderBy('tanggal', 'ASC')
                ->get()->getResultArray();
            foreach ($presensis as $presensi) {
                // Ambil waktu/hari
                $jam_masuk = $presensi['jam_masuk'];
                $jam_keluar = $presensi['jam_keluar'];
                $tanggal = $presensi['tanggal'];
                if (!$jam_masuk || !$jam_keluar) continue;
                // Parsing waktu
                $dt_masuk = strtotime($tanggal.' '.substr($jam_masuk,0,5));
                $dt_keluar = strtotime($tanggal.' '.substr($jam_keluar,0,5));
                // Cek bila keluar < masuk (shift malam?)
                if ($dt_keluar < $dt_masuk) continue;
                // Dapatkan hari dalam format angka 1 (Senin) s/d 6 (Sabtu)
                $hari = date('N', strtotime($tanggal));
                // Jam kerja efektif
                if ($hari == 6) { // Sabtu: 07:45-13:00 semua dihitung, tidak ada istirahat
                    $jam_kerja_mulai = strtotime($tanggal.' 07:45');
                    $jam_kerja_selesai = strtotime($tanggal.' 13:00');
                    // Batasi jika datang sebelum/jam kerja mulai atau keluar setelah kerja selesai
                    $masuk = max($dt_masuk, $jam_kerja_mulai);
                    $keluar = min($dt_keluar, $jam_kerja_selesai);
                } else {
                    // Senin-Jumat: 07:45-16:45, istirahat 12:00-13:00 tidak dihitung
                    $jam_kerja_mulai = strtotime($tanggal.' 07:45');
                    $jam_istirahat_mulai = strtotime($tanggal.' 12:00');
                    $jam_istirahat_selesai = strtotime($tanggal.' 13:00');
                    $jam_kerja_selesai = strtotime($tanggal.' 16:45');
                    $masuk = max($dt_masuk, $jam_kerja_mulai);
                    $keluar = min($dt_keluar, $jam_kerja_selesai);
                }
                // Koreksi range (jika absen keluar sebelum absen masuk, skip)
                if ($keluar <= $masuk) continue;
                // Apakah hari Sabtu?
                if ($hari == 6) {
                    $menit_kerja = ($keluar - $masuk) / 60;
                } else {
                    // Senin-Jumat: pecah jadi sebelum istirahat & sesudah istirahat
                    if ($masuk < $jam_istirahat_mulai && $keluar > $jam_istirahat_selesai) {
                        // Kerja dari sebelum istirahat sampai sesudah istirahat
                        $menit_pagi = ($jam_istirahat_mulai - $masuk) / 60;
                        $menit_siang = ($keluar - $jam_istirahat_selesai) / 60;
                        $menit_kerja = max($menit_pagi,0) + max($menit_siang,0);
                    } elseif ($keluar <= $jam_istirahat_mulai) {
                        // Hanya pagi
                        $menit_kerja = ($keluar - $masuk) / 60;
                    } elseif ($masuk >= $jam_istirahat_selesai) {
                        // Hanya siang
                        $menit_kerja = ($keluar - $masuk) / 60;
                    } else {
                        // Shift tidak normal, misal masuk saat istirahat, skip
                        $menit_kerja = 0;
                    }
                }
                
                // Kurangi 1 jam (60 menit) sebagai punishment wajib yang tidak dibayar
                $menit_kerja = max(0, $menit_kerja - 60);
                
                // Pembulatan kelipatan 30 menit dengan toleransi 15 menit (jam normal)
                $blocks30 = 0;
                if ($menit_kerja > 0) {
                    $sisa = $menit_kerja % 30;
                    if ($sisa >= 15) {
                        $blocks30 = ceil($menit_kerja/30);
                    } else {
                        $blocks30 = floor($menit_kerja/30);
                    }
                }
                $total_menit_kerja += $blocks30 * 30;
                if ($blocks30 > 0) $total_kehadiran++;
                $reportJamPerHari[$tanggal] = ($reportJamPerHari[$tanggal] ?? 0) + ($blocks30 * 0.5); // 1 blok 30menit = 0.5 jam
                // Catat jam reguler per hari (tanpa lembur) untuk perhitungan minus jam
                $reportJamPerHariRegular[$tanggal] = ($reportJamPerHariRegular[$tanggal] ?? 0) + ($blocks30 * 0.5);

                // Lembur: dihitung jika absen keluar lebih dari 17:00, rate sama dengan regular
                $lembur_mulai = strtotime($tanggal.' 17:00');
                if ($dt_keluar > $lembur_mulai) {
                    $startLembur = max($lembur_mulai, $dt_masuk);
                    $menit_lembur = max(0, ($dt_keluar - $startLembur) / 60);

                    $blocks30Lembur = 0;
                    if ($menit_lembur > 0) {
                        $sisaL = $menit_lembur % 30;
                        if ($sisaL >= 15) {
                            $blocks30Lembur = ceil($menit_lembur/30);
                        } else {
                            $blocks30Lembur = floor($menit_lembur/30);
                        }
                    }

                    if ($blocks30Lembur > 0) {
                        // Tetap catat lembur ke total_menit_kerja dan report harian,
                        // namun tidak memengaruhi perhitungan minus jam (minus hanya dari jam reguler)
                        $total_menit_kerja += $blocks30Lembur * 30;
                        $reportJamPerHari[$tanggal] = ($reportJamPerHari[$tanggal] ?? 0) + ($blocks30Lembur * 0.5);
                    }
                }
            }
            $gaji_per_jam = $kar['gaji_per_jam'] ?? 0;
            $blok_30menit_total = $total_menit_kerja / 30;
            $total_jam_kerja = $blok_30menit_total * 0.5;

            // Logika baru: Total jam bulanan dipatok 173 jam,
            // lalu dikurangi akumulasi "minus jam" harian (telat, pulang cepat, atau absen).
            // Minus jam dihitung dari selisih antara jam reguler ideal per hari
            // dengan jam reguler aktual yang tercatat (tanpa lembur).

            $minus_jam_total = 0.0;
            $curDateForMinus = new \DateTime($start_date);
            $endDateForMinus = new \DateTime($end_date);
            while ($curDateForMinus <= $endDateForMinus) {
                $dow = (int)$curDateForMinus->format('N'); // 1=Senin..6=Sabtu, 7=Minggu
                if ($dow <= 6) {
                    // Jam ideal reguler per hari: Senin-Jumat = 7.0 jam, Sabtu = 4.5 jam
                    // Diselaraskan ke kelipatan 0.5 agar konsisten dengan pembulatan blok 30 menit
                    $expectedJam = ($dow === 6) ? 4.5 : 7.0;
                    $tglKey = $curDateForMinus->format('Y-m-d');
                    $actualRegularJam = (float)($reportJamPerHariRegular[$tglKey] ?? 0.0);
                    // Batasi actual ke maksimum expected (lembur tidak mengurangi minus)
                    $actualCapped = min($actualRegularJam, $expectedJam);
                    $minusHariIni = max(0.0, $expectedJam - $actualCapped);
                    $minus_jam_total += $minusHariIni;
                }
                $curDateForMinus->modify('+1 day');
            }

            // Total jam akhir: 173 dikurangi minus jam total, tidak kurang dari 0 dan tidak lebih dari 173
            $total_jam_kerja = max(0.0, 173.0 - $minus_jam_total);
            // Untuk konsistensi gaji, gunakan total_jam_kerja yang sudah dipatok
            $blok_30menit_total = $total_jam_kerja * 2; // 1 jam = 2 blok 30 menit
            
            $gaji_per_30menit = $gaji_per_jam / 2;
            $total_gaji = $blok_30menit_total * $gaji_per_30menit;
            $results[] = [
                'id_karyawan' => $kar['id_karyawan'],
                'nis' => $kar['nis'],
                'nama_karyawan' => $kar['nama_karyawan'],
                'departemen' => $kar['departemen'],
                'jabatan' => $kar['jabatan'],
                'gaji_per_jam' => $gaji_per_jam,
                'total_kehadiran' => $total_kehadiran,
                'total_jam_kerja' => $total_jam_kerja,
                'total_gaji' => $total_gaji,
            ];
        }
        return $results;
    }

    /**
     * Ambil laporan lembur saja untuk periode tertentu
     * - Lembur dihitung jika absen pulang > 17:00
     * - Pembulatan tetap 15 menit ke kelipatan 30 menit
     * - Rate lembur sama dengan gaji reguler per jam
     */
    public function getOvertimeReport($start_date = null, $end_date = null, $id_departemen = null)
    {
        if (!$start_date) {
            $start_date = date('Y-m-01');
        }
        if (!$end_date) {
            $end_date = date('Y-m-t');
        }

        $builder = $this->db->table('tb_karyawan as k')
            ->select('k.id_karyawan, k.nis, k.nama_karyawan, d.departemen, j.jabatan, g.gaji_per_jam')
            ->join('tb_departemen as d', 'k.id_departemen = d.id_departemen', 'left')
            ->join('tb_jabatan as j', 'd.id_jabatan = j.id', 'left')
            ->join('tb_gaji as g', 'd.id_departemen = g.id_departemen AND j.id = g.id_jabatan', 'left');

        if ($id_departemen) {
            $builder->where('k.id_departemen', $id_departemen);
        }

        $karyawanList = $builder->get()->getResultArray();

        $results = [];
        foreach ($karyawanList as $kar) {
            $total_lembur_menit = 0;
            $hari_lembur = 0;

            // Ambil presensi hadir selama rentang tanggal
            $presensis = $this->db->table('tb_presensi_karyawan')
                ->where('id_karyawan', $kar['id_karyawan'])
                ->where('id_kehadiran', 1)
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->orderBy('tanggal', 'ASC')
                ->get()->getResultArray();

            foreach ($presensis as $presensi) {
                $jam_masuk = $presensi['jam_masuk'];
                $jam_keluar = $presensi['jam_keluar'];
                $tanggal = $presensi['tanggal'];
                if (!$jam_masuk || !$jam_keluar) continue;

                $dt_masuk = strtotime($tanggal.' '.substr($jam_masuk,0,5));
                $dt_keluar = strtotime($tanggal.' '.substr($jam_keluar,0,5));
                if ($dt_keluar <= $dt_masuk) continue;

                // Lembur mulai pukul 17:00
                $lembur_mulai = strtotime($tanggal.' 17:00');
                if ($dt_keluar > $lembur_mulai) {
                    $startLembur = max($lembur_mulai, $dt_masuk);
                    $menit_lembur = max(0, ($dt_keluar - $startLembur) / 60);

                    // Pembulatan ke blok 30 menit, toleransi 15 menit
                    $blocks30Lembur = 0;
                    if ($menit_lembur > 0) {
                        $sisaL = $menit_lembur % 30;
                        if ($sisaL >= 15) {
                            $blocks30Lembur = (int)ceil($menit_lembur / 30);
                        } else {
                            $blocks30Lembur = (int)floor($menit_lembur / 30);
                        }
                    }

                    if ($blocks30Lembur > 0) {
                        $total_lembur_menit += $blocks30Lembur * 30;
                        $hari_lembur++;
                    }
                }
            }

            $gaji_per_jam = (float)($kar['gaji_per_jam'] ?? 0);
            $blok_30menit_lembur = $total_lembur_menit / 30;
            $total_jam_lembur = $blok_30menit_lembur * 0.5; // 1 blok = 0.5 jam
            $gaji_per_30menit = $gaji_per_jam / 2.0;
            $total_gaji_lembur = (int)round($blok_30menit_lembur * $gaji_per_30menit);

            $results[] = [
                'id_karyawan' => $kar['id_karyawan'],
                'nis' => $kar['nis'],
                'nama_karyawan' => $kar['nama_karyawan'],
                'departemen' => $kar['departemen'],
                'jabatan' => $kar['jabatan'],
                'gaji_per_jam' => $gaji_per_jam,
                'hari_lembur' => $hari_lembur,
                'total_jam_lembur' => $total_jam_lembur,
                'total_gaji_lembur' => $total_gaji_lembur,
            ];
        }

        return $results;
    }

    /**
     * Get attendance breakdown (hadir/sakit/izin/alpa) per karyawan in period
     */
    public function getAttendanceBreakdown($start_date, $end_date, $id_departemen = null)
    {
        $query = "
            SELECT 
                k.id_karyawan,
                SUM(CASE WHEN pk.id_kehadiran = 1 THEN 1 ELSE 0 END) AS hadir,
                SUM(CASE WHEN pk.id_kehadiran = 2 THEN 1 ELSE 0 END) AS sakit,
                SUM(CASE WHEN pk.id_kehadiran = 3 THEN 1 ELSE 0 END) AS izin,
                SUM(CASE WHEN pk.id_kehadiran = 4 THEN 1 ELSE 0 END) AS alpa
            FROM tb_karyawan k
            LEFT JOIN tb_presensi_karyawan pk 
                ON pk.id_karyawan = k.id_karyawan 
                AND DATE(pk.tanggal) BETWEEN ? AND ?
            ";

        $params = [$start_date, $end_date];

        if ($id_departemen) {
            $query .= " WHERE k.id_departemen = ?";
            $params[] = $id_departemen;
        }

        $query .= " GROUP BY k.id_karyawan";

        $rows = $this->db->query($query, $params)->getResultArray();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['id_karyawan']] = [
                'hadir' => (int) ($r['hadir'] ?? 0),
                'sakit' => (int) ($r['sakit'] ?? 0),
                'izin' => (int) ($r['izin'] ?? 0),
                'alpa' => (int) ($r['alpa'] ?? 0),
            ];
        }
        return $map;
    }

    /**
     * Get salary statistics
     */
    public function getSalaryStats()
    {
        $stats = [];

        // Total salary configurations
        $stats['total_config'] = $this->countAllResults();

        // Average salary per hour
        $avg_result = $this->selectAvg('gaji_per_jam')
            ->get()
            ->getRowArray();
        $stats['avg_salary'] = $avg_result['gaji_per_jam'] ?? 0;

        // Highest salary per hour
        $max_result = $this->selectMax('gaji_per_jam')
            ->get()
            ->getRowArray();
        $stats['max_salary'] = $max_result['gaji_per_jam'] ?? 0;

        // Lowest salary per hour
        $min_result = $this->selectMin('gaji_per_jam')
            ->get()
            ->getRowArray();
        $stats['min_salary'] = $min_result['gaji_per_jam'] ?? 0;

        return $stats;
    }

    /**
     * Delete gaji
     */
    public function softDelete($id)
    {
        return $this->delete($id);
    }

    /**
     * Restore gaji (not applicable for hard delete)
     */
    public function restore($id)
    {
        return false; // Cannot restore hard deleted records
    }
}
