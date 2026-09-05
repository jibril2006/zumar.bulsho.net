<?php

require_once __DIR__ . '/i18n.php';

function km_site_config()
{
    static $config = null;
    if ($config === null) {
        $path = __DIR__ . '/site_config.php';
        $config = file_exists($path) ? require $path : array();
    }
    return $config;
}

function km_site_config_value($key, $default = '')
{
    $config = km_site_config();
    return isset($config[$key]) ? $config[$key] : $default;
}

function km_base_path()
{
    return rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
}

function km_asset_prefix()
{
    $base = km_base_path();
    return $base !== '' ? rtrim($base, '/') . '/' : '/';
}

function km_company_name()
{
    return km_site_config_value('company_name', 'Template Site');
}

function km_brand_short()
{
    return km_site_config_value('brand_short', 'TS');
}

function km_asset_url($path)
{
    $path = ltrim((string) $path, '/');
    $url = km_asset_prefix() . $path;
    $full = dirname(__DIR__) . '/' . $path;
    if (is_file($full)) {
        $url .= '?v=' . filemtime($full);
    }
    return $url;
}

function km_logo_url($dark = false)
{
    $key = $dark ? 'logo_dark' : 'logo';
    $path = km_site_config_value($key, 'assets/media/app/default-logo.svg');
    return km_asset_url($path);
}

function km_mini_logo_url()
{
    $path = km_site_config_value('mini_logo', 'assets/media/app/mini-logo.svg');
    return km_asset_url($path);
}

function km_favicon_url()
{
    $path = km_site_config_value('favicon', 'assets/media/app/favicon.svg');
    return km_asset_url($path);
}

function km_mysql_port()
{
    $port = Config::get('mysql/port');
    if ($port === null || $port === false || $port === '' || is_array($port)) {
        return null;
    }
    return (string) $port;
}

function km_check_db_connection()
{
    try {
        $dsn = 'mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db');
        $port = km_mysql_port();
        if ($port !== null) {
            $dsn .= ';port=' . $port;
        }
        new PDO(
            $dsn,
            Config::get('mysql/username'),
            Config::get('mysql/password'),
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function km_login_db_status_html($connected)
{
    $class = $connected ? 'login-db-dot login-db-dot--ok' : 'login-db-dot login-db-dot--err';
    $title = $connected ? km_t('db_ok') : km_t('db_err');

    return '<div class="flex items-center justify-center gap-2 pt-1">'
        . '<span class="' . $class . '" title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '"></span>'
        . '</div>';
}

function km_login_attribution_footer_html($connected)
{
    $dotClass = $connected ? 'login-db-dot login-db-dot--ok' : 'login-db-dot login-db-dot--err';
    $dotTitle = $connected ? km_t('db_ok') : km_t('db_err');

    return '<div class="flex items-center justify-center gap-2 text-xs text-muted-foreground pt-2">'
        . '<span class="' . $dotClass . '" title="' . htmlspecialchars($dotTitle, ENT_QUOTES, 'UTF-8') . '"></span>'
        . '<span>' . htmlspecialchars(km_t('system_by'), ENT_QUOTES, 'UTF-8') . '</span>'
        . '</div>';
}

function km_menu_icon_class($icon)
{
    $icon = trim((string)$icon);
    if ($icon === '') {
        return 'icon-notebook';
    }
    if (strpos($icon, 'icon-') === 0) {
        return $icon;
    }
    if (strpos($icon, 'fas ') === 0 || strpos($icon, 'far ') === 0 || strpos($icon, 'fab ') === 0) {
        return $icon;
    }
    if (strpos($icon, 'fa ') === 0) {
        return 'fas ' . trim(substr($icon, 3));
    }
    if (strpos($icon, 'fa-') === 0) {
        return 'fas ' . $icon;
    }
    if (strpos($icon, 'ki-') !== false) {
        return 'menu-bullet ki-outline ' . $icon;
    }
    return 'icon-' . ltrim($icon, 'icon-');
}

function km_page_sidebar_icon($page)
{
    $href = strtolower(trim((string) ($page->href ?? '')));
    $byHref = [
        'dashboard' => 'icon-home',
        'changepassword' => 'icon-lock',
        'example-page' => 'icon-list',
        'countries' => 'icon-globe',
        'locations' => 'icon-pin',
        'sectors' => 'icon-layers',
        'partners' => 'icon-users',
        'projects' => 'icon-folder-alt',
        'orphans' => 'icon-user',
        'orphan-education' => 'icon-graduation',
        'orphan-support' => 'icon-heart',
        'sponsors' => 'icon-like',
        'school-distributions' => 'icon-basket-loaded',
        'education-items' => 'icon-list',
        'scholarships' => 'icon-trophy',
        'water-points' => 'icon-drop',
        'water-maintenance' => 'icon-wrench',
        'health-visits' => 'icon-home',
        'maternal-health' => 'icon-symbol-female',
        'disease-control' => 'icon-shield',
        'health-campaigns' => 'icon-speech',
        'mental-health' => 'icon-emoticon-smile',
        'eye-care' => 'icon-eye',
        'infrastructure' => 'icon-drawer',
        'livelihood-trainings' => 'icon-users',
        'livelihood-assets' => 'icon-present',
        'seed-grants' => 'icon-wallet',
        'relief-distributions' => 'icon-basket',
        'mediation-cases' => 'icon-equalizer',
        'dialogue-sessions' => 'icon-bubble',
        'legal-aid' => 'icon-book-open',
        'budgets' => 'icon-calculator',
        'expenses' => 'icon-credit-card',
        'donor-funding' => 'icon-diamond',
        'disbursements' => 'icon-share',
        'staff' => 'icon-badge',
        'staff-assignments' => 'icon-user-following',
        'recruitments' => 'icon-briefcase',
        'policy-acknowledgements' => 'icon-docs',
        'vendors' => 'icon-handbag',
        'purchase-requests' => 'icon-note',
        'purchase-orders' => 'icon-doc',
        'goods-received' => 'icon-check',
        'indicators' => 'icon-graph',
        'monitoring-visits' => 'icon-map',
        'evaluations' => 'icon-bar-chart',
        'complaints' => 'icon-bubbles',
        'research-studies' => 'icon-eyeglasses',
        'reports' => 'icon-pie-chart',
    ];

    if ($href !== '' && isset($byHref[$href])) {
        return $byHref[$href];
    }

    $stored = trim((string) ($page->fa ?? ''));
    if ($stored !== '' && strpos($stored, 'icon-') === 0) {
        return $stored;
    }

    return km_menu_icon_class($stored !== '' ? $stored : 'icon-arrow-right');
}

function km_format_money($amount)
{
    $formatted = number_format((float)$amount, 2, '.', ',');
    $formatted = str_replace('.', '#', $formatted);
    $formatted = str_replace(',', '.', $formatted);
    return str_replace('#', ',', $formatted);
}

function km_init_language()
{
    if (Input::get('clang')) {
        $clang = strtolower(trim((string) Input::get('clang')));
        if (in_array($clang, ['en', 'so'], true)) {
            Session::put('km_lang', $clang);
        }
    }

    if (!Session::exists('km_lang')) {
        Session::put('km_lang', km_site_config_value('default_language', 'so'));
    }
}

function km_current_language()
{
    km_init_language();

    if (!Session::exists('km_lang')) {
        return 'so';
    }

    $lang = Session::get('km_lang');
    return in_array($lang, ['en', 'so'], true) ? $lang : 'so';
}

function km_language_url($lang)
{
    $lang = in_array($lang, ['en', 'so'], true) ? $lang : 'so';
    $uri = $_SERVER['REQUEST_URI'] ?? 'dashboard.php';
    $parts = parse_url($uri);
    $path = $parts['path'] ?? '/dashboard.php';
    $query = [];
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
    }
    $query['clang'] = $lang;
    $qs = http_build_query($query);

    return $qs !== '' ? $path . '?' . $qs : $path;
}

function km_topmenu_label($menu)
{
    $name = trim((string) ($menu->name ?? ''));

    if (km_current_language() === 'en') {
        if (!empty($menu->accessname)) {
            return trim((string) $menu->accessname);
        }

        $href = trim((string) ($menu->href ?? ''));
        $englishByHref = [
            'dashboard' => 'Home',
        ];
        if ($href !== '' && isset($englishByHref[$href])) {
            return $englishByHref[$href];
        }

        $englishByName = [
            'Baga Bilowga' => 'Home',
            'Dashboard' => 'Home',
            'Warbixin' => 'Reports',
        ];

        return $englishByName[$name] ?? $name;
    }

    if (strcasecmp($name, 'Dashboard') === 0) {
        return 'Baga Bilowga';
    }

    return $name;
}

function km_page_label($page)
{
    if (km_current_language() === 'en' && !empty($page->accesspagename)) {
        return trim((string) $page->accesspagename);
    }

    return trim((string) ($page->pagename ?? ''));
}

function km_home_label()
{
    return km_current_language() === 'en' ? 'Home' : 'Baga Bilowga';
}

function km_user_photo_url()
{
    global $USERNAMEPHOTOURL;

    $url = trim((string) ($USERNAMEPHOTOURL ?? ''));
    if ($url === '') {
        $url = 'newimages/defaultuser.png';
    }

    if (strpos($url, '../') === 0) {
        $url = substr($url, 3);
    }

    if (preg_match('#^https?://#i', $url) || strpos($url, '/') === 0) {
        return $url;
    }

    return km_asset_prefix() . ltrim($url, '/');
}

function km_user_menu_label($key)
{
    $labels = [
        'profile' => ['so' => 'Brofaylkeegi', 'en' => 'My Profile'],
        'somali' => ['so' => 'Af-Soomaali', 'en' => 'Somali'],
        'english' => ['so' => 'Ingiriisi', 'en' => 'English'],
        'settings' => ['so' => 'Dejinta', 'en' => 'Settings'],
        'password' => ['so' => 'Badal Password', 'en' => 'Change password'],
        'logout' => ['so' => 'Ka bax', 'en' => 'Log Out'],
    ];

    $lang = km_current_language();
    return $labels[$key][$lang] ?? $key;
}

function km_user_settings_url()
{
    return 'changepassword.php';
}

function km_site_url()
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'zumar.bulsho.net';
    $base = km_base_path();

    return $scheme . '://' . $host . ($base !== '' ? $base : '');
}

function km_footer_system_label()
{
    return 'BITS - ' . km_company_name() . ' Database System';
}

function km_footer_copyright_year()
{
    return (string) km_site_config_value('footer_copyright_year', date('Y'));
}

if (class_exists('Session', true)) {
    km_init_language();
}
