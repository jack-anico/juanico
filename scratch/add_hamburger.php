<?php

$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/WEB/views');
$iter = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($iter, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$hamburgerHtml = <<<HTML
            <button type="button" class="hamburger-btn" aria-label="Toggle navigation" onclick="document.querySelector('.main-nav').classList.toggle('nav-open')">&#9776;</button>
            <nav class="main-nav">
HTML;

foreach ($files as $file) {
    $path = $file[0];
    
    // Skip admin files as they use a sidebar, not the top-bar main-nav
    if (strpos($path, 'views\admin') !== false || strpos($path, 'views/admin') !== false) {
        continue;
    }

    // Skip partials like _cart.php if it doesn't have the main-nav (it shouldn't)
    if (basename($path) === '_cart.php') {
        continue;
    }

    $content = file_get_contents($path);
    
    if (strpos($content, '<button type="button" class="hamburger-btn"') !== false) {
        // already added
        continue;
    }
    
    if (strpos($content, '<nav class="main-nav">') !== false) {
        $content = str_replace('<nav class="main-nav">', $hamburgerHtml, $content);
        file_put_contents($path, $content);
        echo "Updated $path\n";
    }
}
echo "Done.\n";
