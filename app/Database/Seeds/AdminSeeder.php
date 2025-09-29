<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class AdminSeeder extends Seeder
{
    private \Faker\Generator $faker;

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);
        $this->faker = \Faker\Factory::create('id_ID');
    }

    public function run()
    {
        $this->db->table('tb_admin')->insertBatch(
            $this->createAdmin(20)
        );
    }

    protected function createAdmin($count = 1)
    {
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $gender = $this->faker->randomElement(['Laki-laki', 'Perempuan']);

            array_push($data, [
                'nuptk' => $this->faker->numerify('################'),
                'nama_admin' => $this->faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                'jenis_kelamin' => $gender,
                'alamat' => $this->faker->address(),
                'no_hp' => $this->faker->numerify('08##########'),
                'unique_code' => $this->faker->uuid()
            ]);
        }

        return $data;
    }
}
