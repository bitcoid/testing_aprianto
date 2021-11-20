<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Barang::factory()
            ->count(5)
            ->hasPosts(1)
            ->create();
    }
}
