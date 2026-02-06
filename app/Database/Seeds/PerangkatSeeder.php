<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PerangkatSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('perangkat')->insert([
            'nama'=>'Fortigate40F',
            'noreg'=>'B2WN0012MA0009',
            'serial_number'=>'8892317246641',
        ]);
    }
}
