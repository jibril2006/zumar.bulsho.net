<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';
require_once '_core/zumar_helpers.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$pagename = km_t('reports');
include_once 'head.php';

$q = function ($sql) {
    $res = DB::getInstance()->query($sql);
    if ($res->error() || !$res->count()) {
        return array();
    }
    return $res->results();
};

$beneficiaries = $q("
    SELECT p.country_code, p.sector_code, p.year,
           COALESCE(SUM(w.no_of_beneficiaries),0) + COALESCE(SUM(r.no_of_individuals_reached),0) AS reached
    FROM zf_projects p
    LEFT JOIN zf_water_points w ON w.project_id = p.id AND w.deleted = 0
    LEFT JOIN zf_relief_distributions r ON r.project_id = p.id AND r.deleted = 0
    WHERE p.deleted = 0
    GROUP BY p.country_code, p.sector_code, p.year
    ORDER BY p.year DESC, p.country_code
");

$costPer = $q("
    SELECT p.project_code, p.project_name, p.sector_code,
           COALESCE(SUM(e.amount),0) AS total_cost
    FROM zf_projects p
    LEFT JOIN zf_expenses e ON e.project_id = p.id AND e.deleted = 0
    WHERE p.deleted = 0
    GROUP BY p.id
    ORDER BY total_cost DESC
");

$orphanStatus = $q("
    SELECT status, COUNT(*) AS c FROM zf_orphans WHERE deleted = 0 GROUP BY status
");

$waterStatus = $q("
    SELECT country_code, status, COUNT(*) AS c FROM zf_water_points WHERE deleted = 0 GROUP BY country_code, status
");

$healthReach = $q("
    SELECT 'Facility visits' AS kind, COALESCE(SUM(no_of_patients_seen),0) AS c FROM zf_health_visits WHERE deleted = 0
    UNION ALL SELECT 'Disease control', COALESCE(SUM(no_of_beneficiaries),0) FROM zf_disease_control WHERE deleted = 0
    UNION ALL SELECT 'Eye care', COALESCE(SUM(no_of_beneficiaries),0) FROM zf_eye_care WHERE deleted = 0
    UNION ALL SELECT 'Maternal/child', COUNT(*) FROM zf_maternal_health WHERE deleted = 0
");

$peace = $q("
    SELECT case_status, COUNT(*) AS c FROM zf_mediation_cases WHERE deleted = 0 GROUP BY case_status
");

$staffDays = $q("
    SELECT p.project_code, s.full_name, a.role_on_project, a.allocation_percentage
    FROM zf_staff_assignments a
    JOIN zf_projects p ON p.id = a.project_id
    JOIN zf_staff s ON s.id = a.staff_id
    WHERE a.deleted = 0 AND p.deleted = 0 AND s.deleted = 0
    ORDER BY p.project_code
");

$procurement = $q("
    SELECT 'PR pending' AS kind, COUNT(*) AS c FROM zf_purchase_requests WHERE deleted = 0 AND approval_status = 'Pending'
    UNION ALL SELECT 'PO awaiting delivery', COUNT(*) FROM zf_purchase_orders WHERE deleted = 0 AND delivery_status <> 'Delivered'
");

$funding = $q("
    SELECT pt.partner_name, SUM(f.amount_committed) AS committed, SUM(COALESCE(f.amount_received,0)) AS received
    FROM zf_donor_funding f
    JOIN zf_partners pt ON pt.id = f.partner_id
    WHERE f.deleted = 0 AND pt.deleted = 0
    GROUP BY f.partner_id
");

$policyRate = $q("
    SELECT s.country_code, s.full_name, COUNT(a.id) AS acks
    FROM zf_staff s
    LEFT JOIN zf_policy_acks a ON a.staff_id = s.id AND a.deleted = 0
    WHERE s.deleted = 0
    GROUP BY s.id
    ORDER BY s.country_code, s.full_name
");
?>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
<?php include_once 'header.php'; include_once 'sidebar.php'; ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-pie-chart font-green"></i>
                    <span class="caption-subject font-green sbold uppercase"><?php echo htmlspecialchars($pagename, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                $sections = array(
                    array(km_t('rep_beneficiaries'), array(km_t('col_country'), km_t('col_sector'), km_t('col_year'), km_t('col_reached')), $beneficiaries, array('country_code', 'sector_code', 'year', 'reached')),
                    array(km_t('rep_cost'), array(km_t('col_project'), km_t('name'), km_t('col_sector'), km_t('col_cost')), $costPer, array('project_code', 'project_name', 'sector_code', 'total_cost')),
                    array(km_t('rep_orphan'), array(km_t('status'), km_t('col_count')), $orphanStatus, array('status', 'c')),
                    array(km_t('rep_water'), array(km_t('col_country'), km_t('status'), km_t('col_count')), $waterStatus, array('country_code', 'status', 'c')),
                    array(km_t('rep_health'), array(km_t('col_type'), km_t('col_count')), $healthReach, array('kind', 'c')),
                    array(km_t('rep_peace'), array(km_t('status'), km_t('col_count')), $peace, array('case_status', 'c')),
                    array(km_t('rep_staff'), array(km_t('col_project'), km_t('col_staff'), km_t('col_role'), '%'), $staffDays, array('project_code', 'full_name', 'role_on_project', 'allocation_percentage')),
                    array(km_t('rep_proc'), array(km_t('col_kind'), km_t('col_count')), $procurement, array('kind', 'c')),
                    array(km_t('rep_funding'), array(km_t('col_partner'), km_t('col_committed'), km_t('col_received')), $funding, array('partner_name', 'committed', 'received')),
                    array(km_t('rep_policy'), array(km_t('col_country'), km_t('col_staff'), km_t('col_acks')), $policyRate, array('country_code', 'full_name', 'acks')),
                );
                foreach ($sections as $section) {
                    echo '<h4>' . htmlspecialchars($section[0], ENT_QUOTES, 'UTF-8') . '</h4>';
                    echo '<div class="table-responsive"><table class="table table-striped table-bordered"><thead><tr>';
                    foreach ($section[1] as $h) {
                        echo '<th>' . htmlspecialchars($h, ENT_QUOTES, 'UTF-8') . '</th>';
                    }
                    echo '</tr></thead><tbody>';
                    if (!$section[2]) {
                        echo '<tr><td colspan="' . count($section[1]) . '">—</td></tr>';
                    }
                    foreach ($section[2] as $row) {
                        echo '<tr>';
                        foreach ($section[3] as $col) {
                            echo '<td>' . htmlspecialchars(km_option_label((string) ($row->$col ?? '')), ENT_QUOTES, 'UTF-8') . '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</tbody></table></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
