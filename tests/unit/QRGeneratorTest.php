<?php

use App\Controllers\Admin\QRGenerator;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class QRGeneratorTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = true;
    protected $namespace   = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->db->table('tb_jabatan')->insert([
            'jabatan' => 'Z',
        ]);

        $this->db->table('tb_departemen')->insert([
            'departemen' => 'Z',
            'id_jabatan' => $this->db->table('tb_jabatan')->get(1)->getRowArray()['id'],
        ]);

        $this->db->table('tb_karyawan')->insert([
            'nis' => '1234567890',
            'nama_karyawan' => 'John Doe',
            'id_departemen' => $departemenId ?? 1,
            'no_hp' => '081234567890',
            'unique_code' => '1234567890',
        ]);
    }

    public function testGenerateQrCode(): void
    {
        $departemen = $this->db->table('tb_departemen')->get(1)->getRowArray();
        $karyawan = $this->db->table('tb_karyawan')
            ->where('id_departemen', $departemen['id_departemen'])
            ->get(1)
            ->getRowArray();

        $generator = new QRGenerator;
        $generator->setQrCodeFilePath(QRGenerator::UPLOADS_PATH . "test/");

        $result = $generator->generate(
            $karyawan['nama_karyawan'],
            $karyawan['nis'],
            $karyawan['unique_code']
        );

        $this->assertIsString($result);
        $this->assertTrue(file_exists($result));
        $this->assertStringContainsString('public/uploads/test/', $result);
        $this->assertStringContainsString('.png', $result);
    }
}
