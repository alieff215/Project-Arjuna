<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class SiswaSeeder extends Seeder
{
    private \Faker\Generator $faker;
    private array $departemen;

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);
        $this->faker = \Faker\Factory::create('id_ID');
        $this->departemen = $this->db->table('tb_departemen')->get()->getResultArray();
    }

    public function run()
    {
        $this->db->table('tb_karyawan')->insertBatch(
            $this->createKaryawan(20)
        );
    }

    protected function createKaryawan($count = 1)
    {
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $gender = $this->faker->randomElement(['Laki-laki', 'Perempuan']);

            array_push($data, [
                'nis' => $this->faker->numerify('#######'),
                'nama_karyawan' => $this->faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                'id_departemen' => $this->faker->randomElement($this->departemen)['id_kelas'],
                'jenis_kelamin' => $gender,
                'no_hp' => $this->faker->numerify('08##########'),
                'unique_code' => $this->faker->uuid()
            ]);
        }

        return $data;
    }
}
