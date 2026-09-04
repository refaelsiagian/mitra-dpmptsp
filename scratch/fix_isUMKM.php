<?php
$files = [
    'resources/views/components/dashboard/tabs/completed-projects.blade.php',
    'resources/views/components/dashboard/tabs/drafts.blade.php',
    'resources/views/components/dashboard/tabs/incoming-proposals.blade.php',
    'resources/views/components/dashboard/tabs/published-projects.blade.php',
    'resources/views/components/dashboard/tabs/sent-proposals.blade.php',
];

$baseDir = dirname(__DIR__); // Should be C:\laragon\www\mitra-dpmptsp

foreach ($files as $file) {
    $path = $baseDir . '/' . $file;
    if (!file_exists($path)) {
        echo "Missing $path\n";
        continue;
    }
    
    $content = file_get_contents($path);
    
    // Remove public $isUMKM = false;
    $content = preg_replace('/^\s*public\s+\$isUMKM\s*=\s*false;\s*$/m', '', $content);
    
    // Replace $this->isUMKM = ... with $isUMKM = ...
    $content = preg_replace('/\$this->isUMKM\s*=\s*/', '$isUMKM = ', $content);
    
    // Replace if ($this->isUMKM) with if ($isUMKM)
    $content = str_replace('if ($this->isUMKM)', 'if ($isUMKM)', $content);
    
    // If we're missing 'isUMKM' => $isUMKM, in the return array, add it.
    if (strpos($content, "'isUMKM' => \$isUMKM,") === false) {
        $content = preg_replace('/(return\s*\[\s*)/', "$1\n            'isUMKM' => \$isUMKM,", $content);
    }
    
    file_put_contents($path, $content);
    echo "Updated $file\n";
}
