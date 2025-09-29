<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GeneralSettings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'logo' => [
                'type'           => 'VARCHAR',
                'constraint'     => 225,
                'null'           => true
            ],
            'company_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 225,
                'null'           => true,
                'default'        => 'PT ARjuna Wijaya Perkasa',
            ],
            'company_year' => [
                'type'           => 'VARCHAR',
                'constraint'     => 225,
                'null'           => true,
                'default'        => '2024/2025',
            ],
            'copyright' => [
                'type'           => 'VARCHAR',
                'constraint'     => 225,
                'null'           => true,
                'default'        => '© 2025 All rights reserved.',
            ],
        ]);

        // primary key
        $this->forge->addKey('id', primary: TRUE);


        $this->forge->createTable('general_settings', TRUE);

        // Insert Default Data
        $default['company_name'] = 'PT Arjuna Wijaya Perkasa';
        $default['company_year'] = '2024/2025';
        $this->db->table('general_settings')->insert($default);
    }

    public function down()
    {
        $this->forge->dropTable('general_settings');
    }
}
