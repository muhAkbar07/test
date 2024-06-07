<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Outlet::create([
            'name' => 'GJB-001-Merdeka',
            'company_name' => 'Nama PT Anda', // Isi sesuai nama PT
            'outlet_code' => 'KodeOutlet', // Isi sesuai kode outlet yang unik
        ]);
    }
}