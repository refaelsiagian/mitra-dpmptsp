<?php
$file = 'C:\laragon\www\mitra-dpmptsp\Sandingan_KBLI_2025_vs_2020.xlsx - Sandingan_KBLI_2025_vs_2020 (1).csv';
$handle = fopen($file, "r");
$header = fgetcsv($handle);

$codes = ['62015', '62029', '47111', '56101', '56102', '56103', '41011', '41012', '46900', '01111', '1111'];
$found = [];

while (($row = fgetcsv($handle)) !== FALSE) {
    if (isset($row[3]) && in_array($row[3], $codes)) $found[] = $row[3];
    if (isset($row[7]) && in_array($row[7], $codes)) $found[] = $row[7];
}
fclose($handle);

print_r(array_unique($found));
