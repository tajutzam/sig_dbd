<?php

namespace App\Database\Seeds;

use App\Models\User;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        //
        $userModel = new User();
        $data = [
            'username' => 'admin',
            'password' => password_hash('rahasia123', PASSWORD_DEFAULT),
            'role'     => 'admin',
        ];

        $userModel->insert($data);
    }
}
