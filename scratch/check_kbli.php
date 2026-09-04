<?php
$file = 'C:\laragon\www\mitra-dpmptsp\Sandingan_KBLI_2025_vs_2020.xlsx - Sandingan_KBLI_2025_vs_2020 (1).csv';
$handle = fopen($file, "r");
$header = fgetcsv($handle);
$levels = [];
$counts = [];
while (($data = fgetcsv($handle)) !== FALSE) {
    $level = trim($data[1]);
    if (!isset($levels[$level])) {
        $levels[$level] = [];
        $counts[$level] = 0;
    }
    if (count($levels[$level]) < 2) {
        $levels[$level][] = $data[2] . " - " . $data[4]; // Kode_Acuan - Judul_2025
    }
    $counts[$level]++;
}
fclose($handle);

echo "Unique Levels and Example Data:\n";
foreach ($levels as $level => $examples) {
    echo strtoupper($level) . " (Total: " . $counts[$level] . " rows)\n";
    foreach ($examples as $ex) {
        echo "  - $ex\n";
    }
    echo "\n";
}
