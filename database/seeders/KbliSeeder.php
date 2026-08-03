<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KbliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kblis = [
            ['code' => '62015', 'name' => 'Aktivitas Pemrograman Komputer Lainnya'],
            ['code' => '62029', 'name' => 'Aktivitas Konsultasi Komputer Dan Manajemen Fasilitas Komputer Lainnya'],
            ['code' => '47111', 'name' => 'Perdagangan Eceran Berbagai Macam Barang Yang Utamanya Makanan, Minuman Atau Tembakau Di Minimarket/Supermarket/Hypermarket'],
            ['code' => '56101', 'name' => 'Restoran'],
            ['code' => '56102', 'name' => 'Rumah Makan'],
            ['code' => '56103', 'name' => 'Kedai Makanan'],
            ['code' => '41011', 'name' => 'Konstruksi Gedung Hunian'],
            ['code' => '41012', 'name' => 'Konstruksi Gedung Perkantoran'],
            ['code' => '46900', 'name' => 'Perdagangan Besar Berbagai Macam Barang'],
            ['code' => '01111', 'name' => 'Pertanian Jagung'],
        ];

        foreach ($kblis as $kbli) {
            \App\Models\Kbli::updateOrCreate(
                ['code' => $kbli['code']],
                ['name' => $kbli['name']]
            );
        }
    }
}
