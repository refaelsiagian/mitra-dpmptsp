<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kbli;

class KbliSeeder extends Seeder
{
    public function run(): void
    {
        // The original 10 dummy KBLIs to preserve/ensure they exist
        $existingCodes = [
            '62015' => 'Aktivitas Pemrograman Komputer Lainnya',
            '62029' => 'Aktivitas Konsultasi Komputer Dan Manajemen Fasilitas Komputer Lainnya',
            '47111' => 'Perdagangan Eceran Berbagai Macam Barang Yang Utamanya Makanan, Minuman Atau Tembakau Di Minimarket/Supermarket/Hypermarket',
            '56101' => 'Restoran',
            '56102' => 'Rumah Makan',
            '56103' => 'Kedai Makanan',
            '41011' => 'Konstruksi Gedung Hunian',
            '41012' => 'Konstruksi Gedung Perkantoran',
            '46900' => 'Perdagangan Besar Berbagai Macam Barang',
            '01111' => 'Pertanian Jagung',
        ];

        // Seed the original 10 first
        foreach ($existingCodes as $code => $name) {
            Kbli::firstOrCreate(
                ['code' => (string)$code],
                ['name' => $name]
            );
        }

        // Import the rest from CSV
        $csvFile = database_path('data/kbli.csv');
        if (!file_exists($csvFile)) {
            $this->command->warn("CSV file not found at {$csvFile}. Skipping bulk import.");
            return;
        }

        $handle = fopen($csvFile, "r");
        fgetcsv($handle); // Skip header

        $imported = 0;
        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== FALSE) {
                // We only want the specific 5-digit KBLI codes, which are labeled "Kelompok (Kode KBLI)"
                if (isset($row[1]) && trim($row[1]) === 'Kelompok (Kode KBLI)') {
                    // Try to use Kode_2025, fallback to Kode_2020
                    $code = trim($row[3]);
                    $name = trim($row[4]);
                    
                    if (empty($code)) {
                        $code = trim($row[7]);
                        $name = trim($row[8]);
                    }

                    // Ensure 5 digits if it's missing a leading zero
                    if (strlen($code) === 4) {
                        $code = '0' . $code;
                    }

                    if (!empty($code) && !isset($existingCodes[$code])) {
                        Kbli::firstOrCreate(
                            ['code' => $code],
                            ['name' => substr($name, 0, 255)] // Ensure it fits in DB
                        );
                        $imported++;
                    }
                }
            }
            DB::commit();
            $this->command->info("Successfully imported {$imported} KBLI codes from CSV.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error importing KBLI: " . $e->getMessage());
        }
        
        fclose($handle);
    }
}

