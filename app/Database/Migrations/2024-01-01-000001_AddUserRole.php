<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserRole extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'user_role' => [
                'type'           => 'ENUM',
                'constraint'     => ['super_admin', 'admin', 'user'],
                'null'           => false,
                'default'        => 'user',
                'after'          => 'is_superadmin'
            ]
        ]);

        // Update existing users based on is_superadmin
        $this->forge->getConnection()->query(
            "UPDATE users SET user_role = CASE 
                WHEN is_superadmin = 1 THEN 'super_admin'
                ELSE 'admin'
            END"
        );
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'user_role');
    }
}
