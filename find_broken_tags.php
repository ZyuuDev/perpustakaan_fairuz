<?php
$dir = new RecursiveDirectoryIterator('c:/laragon/www/tablebuku');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $filePath = $file->getRealPath();
        if (strpos($filePath, '.git') !== false) continue;
        
        $content = file_get_contents($filePath);
        if (substr(trim($content), 0, 5) !== '<?php' && substr(trim($content), 0, 2) !== '<?') {
            echo "INCORRECT TAG: $filePath\n";
            echo "START: " . substr($content, 0, 20) . "...\n\n";
        }
    }
}
?>
