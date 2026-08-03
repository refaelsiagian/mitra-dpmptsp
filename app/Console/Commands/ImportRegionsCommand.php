<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportRegionsCommand extends Command
{
    protected $signature = 'import:regions';
    protected $description = 'Import lite region data from CSVs into database';

    public function handle()
    {
        $this->info('Starting Region Import...');

        $this->importData('provinsi_rows_lite.csv', 'provinces', function ($row) {
            return [
                'id' => $row[0],
                'name' => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        $this->importData('kabupaten_rows_lite.csv', 'regencies', function ($row) {
            return [
                'id' => $row[0],
                'province_id' => $row[1],
                'name' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        $this->importData('kecamatan_rows_lite.csv', 'districts', function ($row) {
            return [
                'id' => $row[0],
                'regency_id' => $row[1],
                'name' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        $this->importData('kelurahan_desa_rows_lite.csv', 'villages', function ($row) {
            // Note: type/jenis column was requested to be removed
            return [
                'id' => $row[0],
                'district_id' => $row[1],
                'name' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        $this->info("\nAll region data imported successfully!");
    }

    private function importData($filename, $table, $callback)
    {
        $path = base_path($filename);
        if (!file_exists($path)) {
            $this->error("File not found: $filename");
            return;
        }

        $this->info("Importing $table from $filename...");

        $file = fopen($path, 'r');
        fgetcsv($file); // Skip header

        $data = [];
        $count = 0;
        
        $this->output->progressStart();

        while (($row = fgetcsv($file)) !== false) {
            // Skip invalid rows gracefully
            if (empty($row[0])) continue;

            $data[] = $callback($row);
            $count++;

            // Chunk inserts
            if (count($data) >= 500) {
                DB::table($table)->insertOrIgnore($data);
                $data = [];
                $this->output->progressAdvance(500);
            }
        }

        // Insert remaining
        if (count($data) > 0) {
            DB::table($table)->insertOrIgnore($data);
            $this->output->progressAdvance(count($data));
        }

        fclose($file);
        $this->output->progressFinish();
        $this->info("Inserted $count records into $table");
    }
}
