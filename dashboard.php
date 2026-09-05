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
$welcomeLabel = km_t('welcome');
$startLabel = km_t('getting_started');
$startText = km_t('dash_intro');

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
        --dash-border: #d5e0dc;
        --dash-muted: #57534e;
        --dash-text: #1c1917;
        --dash-teal: #0f766e;
        --dash-link: #115e59;
        max-width: 1480px;
        width: calc(100% - 28px);
        margin: 0 28px 0 0;
        padding: 0.25rem 0 1.5rem;
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
    .dashboard-pos-theme .dash-kpi-card--1 { background: #3d5f8a; }
    .dashboard-pos-theme .dash-kpi-card--2 { background: #536878; }
    .dashboard-pos-theme .dash-kpi-card--3 { background: #8a7048; }
    .dashboard-pos-theme .dash-kpi-card--4 { background: #9a534e; }
    .dashboard-pos-theme .dash-kpi-card--5 { background: #5a5878; }
    .dashboard-pos-theme .dash-kpi-card--6 { background: #364454; }
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
        border: 1px solid #d5e0dc;
        border-radius: 0.75rem;
        box-shadow: 0 1px 8px rgba(11, 61, 56, 0.06);
        margin-bottom: 1.25rem;
    }
    .dashboard-pos-theme .dash-panel-body { padding: 1.25rem 1.35rem; }
    .dashboard-pos-theme .dash-panel-body h2 {
        margin: 0 0 0.75rem;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0b3d38;
    }
    .dashboard-pos-theme .dash-panel-body p {
        margin: 0 0 0.65rem;
        color: #57534e;
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
                    km_t('kpi_projects'),
                    km_t('kpi_projects_hint'),
                    'fas fa-folder-open'
                );
                $dashStatCard(
                    'orphans.php',
                    'dash-kpi-card--2',
                    (string) zumar_count('zf_orphans'),
                    km_t('kpi_orphans'),
                    'ORPH-01',
                    'fas fa-child'
                );
                $dashStatCard(
                    'water-points.php',
                    'dash-kpi-card--3',
                    (string) zumar_count('zf_water_points'),
                    km_t('kpi_water'),
                    'WASH-01',
                    'fas fa-tint'
                );
                $dashStatCard(
                    'staff.php',
                    'dash-kpi-card--4',
                    (string) zumar_count('zf_staff'),
                    km_t('kpi_staff'),
                    km_t('kpi_staff_hint'),
                    'fas fa-users'
                );
                $dashStatCard(
                    'purchase-requests.php',
                    'dash-kpi-card--5',
                    (string) zumar_count('zf_purchase_requests'),
                    km_t('kpi_pr'),
                    km_t('kpi_pr_hint'),
                    'fas fa-file-alt'
                );
                $dashStatCard(
                    'reports.php',
                    'dash-kpi-card--6',
                    '→',
                    km_t('kpi_reports'),
                    km_t('kpi_reports_hint'),
                    'fas fa-chart-pie'
                );
                ?>
            </div>

            <div class="dash-panel-card">
                <div class="dash-panel-body">
                    <h2><?php echo htmlspecialchars($startLabel, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars(km_t('dash_start_1'), ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><?php echo htmlspecialchars(km_t('dash_start_2'), ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
