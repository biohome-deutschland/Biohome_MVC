<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseUrl = 'http://localhost:80';
$visited = [];
$toVisit = ['/'];
$errors = [];

echo "Starte Spider für: $baseUrl\n";
echo "========================================\n";

while (!empty($toVisit)) {
    $currentPath = array_shift($toVisit);
    if (isset($visited[$currentPath])) {
        continue;
    }
    
    $visited[$currentPath] = true;
    $url = rtrim($baseUrl, '/') . '/' . ltrim($currentPath, '/');
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        $errors[] = "FEHLER $httpCode: $currentPath";
        echo "[!] $httpCode Error auf: $currentPath\n";
    } else {
        // Check for PHP warnings or fatal errors in the output
        if (stripos($html, 'Fatal error') !== false || stripos($html, 'Parse error') !== false || stripos($html, 'Warning:') !== false || stripos($html, 'Uncaught') !== false) {
             $errors[] = "PHP ERROR: $currentPath";
             echo "[!] PHP Fehler gefunden auf: $currentPath\n";
        } else {
             echo "[✓] OK: $currentPath\n";
        }
        
        // Extract internal links to spider further
        preg_match_all('/href=["\'](\/[^"\']*)["\']/i', $html, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $link) {
                // Ignore assets
                if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|woff|woff2|ttf|ico|pdf|zip)$/i', $link)) {
                    continue;
                }
                
                // Clean anchor links
                $link = preg_replace('/#.*$/', '', $link);
                if (empty($link)) continue;
                
                if (!isset($visited[$link]) && !in_array($link, $toVisit)) {
                    $toVisit[] = $link;
                }
            }
        }
    }
}

echo "\n========================================\n";
echo "Spider beendet. ".count($visited)." Seiten getestet.\n";
if (empty($errors)) {
    echo "JUHU! Keine Fehler gefunden.\n";
} else {
    echo "GEFUNDENE FEHLER:\n";
    foreach ($errors as $error) {
        echo "- $error\n";
    }
}
