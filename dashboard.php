<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';
require_once '_core/zumar_helpers.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$pagename = km_home_label();
include_once 'head.php';

$companyName = km_company_name();
$welcomeLabel = km_current_language() === 'en' ? 'Welcome' : 'Ku soo dhawoow';
$startLabel = km_current_language() === 'en' ? 'Getting started' : 'Bilowga';
$startText = km_current_language() === 'en'
    ? 'Every record is tagged to a Project, and therefore to a country and sector. Use the modules in the sidebar to record field activity across Somalia, Uganda and Kenya.'
    : 'Diiwaan kasta wuxuu ku xiran yahay Mashruuc, sidaas darteed waddan iyo qayb. Adeegso menu-ga si aad u diiwaangeliso howlaha Somalia, Uganda iyo Kenya.';

$dashStatCard = static function (
    ?string $href,
    string $toneClass,
    string $valueHtml,
    string $labelHtml,
    ?string $hintHtml = null,
    string $iconClass = 'icon-home'
): void {
    $tag = $href !== null && $href !== '' ? 'a' : 'div';
    $extra = $href !== null && $href !== '' ? ' dash-kpi-card-link' : '';
    $attr = $href !== null && $href !== ''
        ? ' href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '"'
        : '';
    echo '<' . $tag . ' class="dash-kpi-card ' . htmlspecialchars($toneClass, ENT_QUOTES, 'UTF-8') . $extra . '"' . $attr . '>';
    echo '<div class="dash-kpi-icon" aria-hidden="true"><i class="' . htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8') . '"></i></div>';
    echo '<div class="dash-kpi-value">' . $valueHtml . '</div>';
    echo '<div class="dash-kpi-label">' . $labelHtml . '</div>';
    if ($hintHtml !== null && $hintHtml !== '') {
        echo '<div class="dash-kpi-hint">' . $hintHtml . '</div>';
    }
    echo '</' . $tag . '>';
};
?>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
<?php
include_once 'header.php';
include_once 'sidebar.php';
?>
<style>
    .dashboard-pos-theme {
        --dash-page: transparent;
        --dash-card: #ffffff;
        --dash-border: #e4e6ef;
        --dash-muted: #7e8299;
        --dash-text: #181c32;
        --dash-teal: #319795;
        --dash-link: #3699ff;
        max-width: 1320px;
        margin: 0 auto;
        padding: 0.25rem 0 1.5rem 10px;
        font-size: 1rem;
    }
    .dashboard-pos-theme .dash-kpi-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.35rem;
    }
    @media (min-width: 640px) {
        .dashboard-pos-theme .dash-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (min-width: 1200px) {
        .dashboard-pos-theme .dash-kpi-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    .dashboard-pos-theme .dash-kpi-card {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        padding: 1rem 1.15rem;
        min-height: 6.75rem;
        color: #fff;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.12);
        text-decoration: none;
    }
    .dashboard-pos-theme .dash-kpi-card--1 { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .dashboard-pos-theme .dash-kpi-card--2 { background: linear-gradient(135deg, #14b8a6, #0f766e); }
    .dashboard-pos-theme .dash-kpi-card--3 { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
    .dashboard-pos-theme .dash-kpi-value { font-size: 1.65rem; font-weight: 700; line-height: 1.1; }
    .dashboard-pos-theme .dash-kpi-label { font-size: 0.9rem; opacity: 0.95; margin-top: 0.35rem; }
    .dashboard-pos-theme .dash-kpi-hint { font-size: 0.78rem; opacity: 0.85; margin-top: 0.35rem; }
    .dashboard-pos-theme .dash-kpi-icon {
        position: absolute;
        right: 0.85rem;
        top: 0.85rem;
        font-size: 1.35rem;
        opacity: 0.35;
    }
    .dashboard-pos-theme .dash-panel-card {
        background: #fff;
        border: 1px solid #e4e6ef;
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(76, 87, 125, 0.08);
        margin-bottom: 1.25rem;
    }
    .dashboard-pos-theme .dash-panel-body { padding: 1.25rem 1.35rem; }
    .dashboard-pos-theme .dash-panel-body h2 {
        margin: 0 0 0.75rem;
        font-size: 1.15rem;
        font-weight: 700;
        color: #181c32;
    }
    .dashboard-pos-theme .dash-panel-body p {
        margin: 0 0 0.65rem;
        color: #5e6278;
        line-height: 1.55;
    }
    .dashboard-pos-theme .dash-panel-body code {
        background: #f5f8fa;
        padding: 0.1rem 0.35rem;
        border-radius: 0.25rem;
        font-size: 0.9em;
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="dashboard-pos-theme">
            <div class="dash-panel-card">
                <div class="dash-panel-body">
                    <h2><?php echo htmlspecialchars($welcomeLabel, ENT_QUOTES, 'UTF-8'); ?> — <?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($startText, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>

            <div class="dash-kpi-grid">
                <?php
                $dashStatCard(
                    'projects.php',
                    'dash-kpi-card--1',
                    (string) zumar_count('zf_projects'),
                    km_current_language() === 'en' ? 'Projects' : 'Mashruucyada',
                    km_current_language() === 'en' ? 'Hub for all modules' : 'Xudunta dhammaan qaybaha',
                    'fa fa-folder-open'
                );
                $dashStatCard(
                    'orphans.php',
                    'dash-kpi-card--2',
                    (string) zumar_count('zf_orphans'),
                    km_current_language() === 'en' ? 'Registered orphans' : 'Agoonta diiwaangashan',
                    'ORPH-01',
                    'fa fa-child'
                );
                $dashStatCard(
                    'water-points.php',
                    'dash-kpi-card--3',
                    (string) zumar_count('zf_water_points'),
                    km_current_language() === 'en' ? 'Water points' : 'Goobaha biyaha',
                    'WASH-01',
                    'fa fa-tint'
                );
                $dashStatCard(
                    'staff.php',
                    'dash-kpi-card--1',
                    (string) zumar_count('zf_staff'),
                    km_current_language() === 'en' ? 'Staff' : 'Shaqaalaha',
                    km_current_language() === 'en' ? 'HR registry' : 'Diiwaanka shaqaalaha',
                    'fa fa-users'
                );
                $dashStatCard(
                    'purchase-requests.php',
                    'dash-kpi-card--2',
                    (string) zumar_count('zf_purchase_requests'),
                    km_current_language() === 'en' ? 'Purchase requests' : 'Codsiyada iibsiga',
                    km_current_language() === 'en' ? 'Operations approval' : 'Ansixinta hawlgallada',
                    'fa fa-file-o'
                );
                $dashStatCard(
                    'reports.php',
                    'dash-kpi-card--3',
                    '→',
                    km_current_language() === 'en' ? 'Standard reports' : 'Warbixinno',
                    km_current_language() === 'en' ? 'Cross-cutting queries' : 'Warbixinno isku-dhafan',
                    'fa fa-pie-chart'
                );
                ?>
            </div>

            <div class="dash-panel-card">
                <div class="dash-panel-body">
                    <h2><?php echo htmlspecialchars($startLabel, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo km_current_language() === 'en'
                        ? 'Start with Master data (countries, locations, sectors, partners), then create a Project. Finance, HR, procurement and program forms all require a Project ID.'
                        : 'Bilow Xogta aasaasiga (waddamada, goobaha, qaybaha, lammaanayaasha), kadibna samee Mashruuc. Maaliyadda, HR, iibsiga iyo foomamka barnaamijku waxay u baahan yihiin Project ID.'; ?></p>
                    <p><?php echo km_current_language() === 'en'
                        ? 'Codes are generated automatically: SO-WASH-014-2025 for projects, SO-ORPH-00231 for beneficiaries, ZF-UG-014 for staff.'
                        : 'Koodhadhka waa toos: SO-WASH-014-2025 mashruucyada, SO-ORPH-00231 ka-faa\'iidaystayaasha, ZF-UG-014 shaqaalaha.'; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
