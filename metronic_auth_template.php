<?php

require_once __DIR__ . '/_core/theme_helpers.php';

function render_metronic_auth_page($mainContent, $templatePath, $pageTitle = null)
{
    $html = @file_get_contents($templatePath);
    if ($html === false) {
        http_response_code(500);
        echo 'Metronic auth template is unavailable.';
        exit;
    }

    $html = preg_replace('/<!--\s*Product: Metronic[\s\S]*?-->\s*/', '', $html);

    $baseHref = km_asset_prefix();
    $baseTag = '<base href="' . htmlspecialchars($baseHref, ENT_QUOTES, 'UTF-8') . '">';
    $themeScript = '<script>try{localStorage.setItem("kt-theme","light");}catch(e){}</script>';
    $html = preg_replace('/data-kt-theme-mode="[^"]*"/', 'data-kt-theme-mode="light"', $html, 1);

    if (stripos($html, '<head>') !== false) {
        $html = preg_replace('/<head>/i', '<head>' . $baseTag . $themeScript, $html, 1);
    }

    $companyName = km_company_name();
    $companyEsc = htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8');
    $title = $pageTitle ?: ($companyName . ' | Sign In');
    $html = preg_replace('/<title>.*?<\\/title>/i', '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>', $html, 1);
    $html = str_replace(['Metronic', 'Keenthemes Inc.'], $companyName, $html);

    $favicon = htmlspecialchars(km_favicon_url(), ENT_QUOTES, 'UTF-8');
    $html = preg_replace(
        '/<link href="assets\/media\/app\/apple-touch-icon[^"]*"[^>]*>\s*<link href="assets\/media\/app\/favicon[^"]*"[^>]*>\s*<link href="assets\/media\/app\/favicon[^"]*"[^>]*>\s*<link href="assets\/media\/app\/favicon\.ico"[^>]*>/i',
        '<link href="' . $favicon . '" rel="icon" type="image/svg+xml"/>'
        . "\n  " . '<link href="' . $favicon . '" rel="shortcut icon"/>'
        . "\n  " . '<link href="' . $favicon . '" rel="apple-touch-icon" sizes="any"/>',
        $html,
        1
    );

    $html = preg_replace('/<form[^>]*>.*?<\\/form>/s', $mainContent, $html, 1);

    $assetPrefix = km_asset_prefix();
    $html = preg_replace(
        '/<style>\\s*\\.page-bg\\s*\\{[\\s\\S]*?\\}\\s*\\.dark\\s*\\.page-bg\\s*\\{[\\s\\S]*?\\}\\s*<\\/style>/',
        '',
        $html,
        1
    );
    $html = preg_replace('/(href|src)=([\'"])assets\\//', '$1=$2' . $assetPrefix . 'assets/', $html);

    $bgLight = $assetPrefix . 'assets/media/images/2600x1200/bg-10.png';
    $bgDark = $assetPrefix . 'assets/media/images/2600x1200/bg-10-dark.png';
    $authStyles = '<style>'
        . 'html{font-size:87.5%;height:100%}'
        . 'body{min-height:100vh}'
        . '.page-bg{'
        . 'background-color:#eef1f6;'
        . 'background-image:url("' . $bgLight . '");'
        . 'background-position:center;'
        . 'background-repeat:no-repeat;'
        . 'background-size:cover;'
        . 'min-height:100vh;'
        . '}'
        . '.dark .page-bg{background-color:#0f172a;background-image:url("' . $bgDark . '")}'
        . '.page-bg .kt-card{'
        . 'box-shadow:0 22px 60px rgba(15,23,42,.10);'
        . 'border:1px solid rgba(148,163,184,.18);'
        . 'backdrop-filter:blur(2px);'
        . '}'
        . '.login-db-dot{display:inline-block;width:8px;height:8px;border-radius:50%;flex-shrink:0;vertical-align:middle}'
        . '.login-db-dot--ok{background:#22c55e;box-shadow:0 0 0 2px rgba(34,197,94,.3)}'
        . '.login-db-dot--err{background:#ef4444;box-shadow:0 0 0 2px rgba(239,68,68,.3)}'
        . '</style>';
    $html = preg_replace('/<\/head>/i', $authStyles . '</head>', $html, 1);

    $html = preg_replace('/<script src="[^"]*apexcharts[^"]*"[^>]*>\\s*<\\/script>/i', '', $html);
    $html = preg_replace('/<link href="[^"]*apexcharts[^"]*"[^>]*>/i', '', $html);

    $focusScript = '<script>document.addEventListener("DOMContentLoaded",function(){var f=document.querySelector("input:not([type=hidden]):not([disabled]), select:not([disabled]), textarea:not([disabled])");if(f){try{f.focus();}catch(e){}}});</script>';
    $html = preg_replace('/<\/body>/i', $focusScript . '</body>', $html, 1);

    echo $html;
}
