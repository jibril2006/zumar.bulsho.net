<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';
require_once '_core/zumar_helpers.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$pagename = km_current_language() === 'en' ? 'Standard reports' : 'Warbixinno';
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
                    array(zumar_lang_text('Ka-faa\'iidaystayaasha qayb / waddan / sanad', 'Beneficiaries by sector, country and year'), array('Country', 'Sector', 'Year', 'Reached'), $beneficiaries, array('country_code', 'sector_code', 'year', 'reached')),
                    array(zumar_lang_text('Kharashka mashruuc kasta', 'Cost by project'), array('Project', 'Name', 'Sector', 'Cost'), $costPer, array('project_code', 'project_name', 'sector_code', 'total_cost')),
                    array(zumar_lang_text('Xaaladda agoonta', 'Orphan status'), array('Status', 'Count'), $orphanStatus, array('status', 'c')),
                    array(zumar_lang_text('Xaaladda goobaha biyaha', 'Water point status'), array('Country', 'Status', 'Count'), $waterStatus, array('country_code', 'status', 'c')),
                    array(zumar_lang_text('Gaaritaanka caafimaadka', 'Health service reach'), array('Type', 'Count'), $healthReach, array('kind', 'c')),
                    array(zumar_lang_text('Kiisaska dhexdhexaadinta', 'Mediation caseload'), array('Status', 'Count'), $peace, array('case_status', 'c')),
                    array(zumar_lang_text('Qoondeynta shaqaalaha', 'Staff allocation by project'), array('Project', 'Staff', 'Role', '%'), $staffDays, array('project_code', 'full_name', 'role_on_project', 'allocation_percentage')),
                    array(zumar_lang_text('Iibsiga ee sugaya', 'Procurement pipeline'), array('Kind', 'Count'), $procurement, array('kind', 'c')),
                    array(zumar_lang_text('Maalgelinta deeq-bixiyayaasha', 'Donor funding committed vs received'), array('Partner', 'Committed', 'Received'), $funding, array('partner_name', 'committed', 'received')),
                    array(zumar_lang_text('Oggolaanshaha siyaasadaha', 'Policy acknowledgement by staff'), array('Country', 'Staff', 'Acks'), $policyRate, array('country_code', 'full_name', 'acks')),
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
                            echo '<td>' . htmlspecialchars((string) ($row->$col ?? ''), ENT_QUOTES, 'UTF-8') . '</td>';
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
