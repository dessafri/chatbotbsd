<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $nfaktur = rand(1000000, 5000000);
            $npembayran = rand(50000, 300000);
            $data[] = [
                'kode_order' => 'ORD-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_customer' => 'Customer ' . rand(1,7),
                'nomor_handphone' => '0812345678' . $i,
                'nilai_faktur' => $nfaktur,
                'piutang' => $nfaktur - $npembayran,
                'status' => rand(0, 1),
                'nomorfaktur' => 'F-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'pembayaran' => $npembayran,
                'waktu_upload' => now()->subDays(rand(0, 30)),
                'waktu_kirim' => now()->subDays(rand(0, 30)),
                'kode_cabang' => 'CB-' . rand(1, 10),
            ];
        }

        DB::table('penagihans')->insert($data);
    }
}
