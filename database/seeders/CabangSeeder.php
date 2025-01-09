<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'kode_cabang' => 'CB-' . $i,
                'nama_cabang' => 'Cabang ' . $i,
                'nomor_rekening' => '12345679' . $i . '9746' . $i,
                'nama_rekening' => 'Rekening ' . $i, // Nilai faktur acak
            ];
        }

        DB::table('cabangs')->insert($data);
    }
}
