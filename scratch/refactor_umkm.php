<?php

$dir = dirname(__DIR__);
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$pattern1 = "/in_array\(\s*strtolower\(\s*\\\$company->skala_usaha\s*\?\?\s*['\"]{2}\s*\),\s*\[\s*['\"]mikro['\"]\s*,\s*['\"]kecil['\"]\s*,\s*['\"]menengah['\"]\s*\]\s*\)/";
$pattern2 = "/in_array\(\s*strtolower\(\s*auth\(\)->user\(\)->company->skala_usaha\s*\?\?\s*['\"]{2}\s*\),\s*\[\s*['\"]mikro['\"]\s*,\s*['\"]kecil['\"]\s*,\s*['\"]menengah['\"]\s*\]\s*\)/";
$pattern3 = "/in_array\(\s*strtolower\(\s*\\\$project->company->skala_usaha\s*\?\?\s*['\"]{2}\s*\),\s*\[\s*['\"]mikro['\"]\s*,\s*['\"]kecil['\"]\s*,\s*['\"]menengah['\"]\s*\]\s*\)/";
$pattern4 = "/in_array\(\s*strtolower\(\s*\\\$c->skala_usaha\s*\?\?\s*['\"]{2}\s*\),\s*\[\s*['\"]mikro['\"]\s*,\s*['\"]kecil['\"]\s*,\s*['\"]menengah['\"]\s*\]\s*\)/";
$pattern5 = "/in_array\(\s*\\\$userScale\s*,\s*\[\s*['\"]mikro['\"]\s*,\s*['\"]kecil['\"]\s*,\s*['\"]menengah['\"]\s*\]\s*\)/";

foreach ($iterator as $file) {
    if ($file->isFile() && in_array($file->getExtension(), ['php', 'blade'])) {
        $path = $file->getPathname();
        
        // Skip vendor and node_modules
        if (strpos($path, 'vendor') !== false || strpos($path, 'node_modules') !== false || strpos($path, 'scratch') !== false) continue;
        
        $content = file_get_contents($path);
        $original = $content;
        
        $content = preg_replace($pattern1, '$company->isUMKM()', $content);
        $content = preg_replace($pattern2, 'auth()->user()->company?->isUMKM()', $content);
        $content = preg_replace($pattern3, '$project->company?->isUMKM()', $content);
        $content = preg_replace($pattern4, '$c->isUMKM()', $content);
        
        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "Updated $path\n";
        }
    }
}
