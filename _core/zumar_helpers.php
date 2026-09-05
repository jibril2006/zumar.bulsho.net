<?php

function zumar_lang_text($so, $en)
{
    return km_current_language() === 'en' ? $en : $so;
}

function zumar_user_id()
{
    global $USERID;
    return (int) ($USERID ?? 0);
}

function zumar_username()
{
    global $USERNAME;
    return (string) ($USERNAME ?? '');
}

function zumar_role_id()
{
    $info = Session::exists('USERINFO') ? Session::get('USERINFO') : array();
    return (int) ($info['roleid'] ?? 0);
}

function zumar_can_see_restricted()
{
    return in_array(zumar_role_id(), array(1, 3, 10, 12), true);
}

function zumar_audit($table, $recordId, $action, $details = '')
{
    DB::getInstance()->insert('zf_audit_log', array(
        'table_name' => $table,
        'record_id' => (int) $recordId,
        'action' => $action,
        'user_id' => zumar_user_id(),
        'username' => zumar_username(),
        'changed_at' => date('Y-m-d H:i:s'),
        'details' => $details,
    ));
}

function zumar_query($sql, $params = array())
{
    return DB::getInstance()->query($sql, $params);
}

function zumar_count($table)
{
    $q = zumar_query("SELECT COUNT(*) AS c FROM {$table} WHERE deleted = 0");
    if ($q->error() || !$q->count()) {
        return 0;
    }
    return (int) $q->first()->c;
}

function zumar_options($sql, $params = array())
{
    $q = zumar_query($sql, $params);
    $out = array();
    if ($q->error() || !$q->count()) {
        return $out;
    }
    foreach ($q->results() as $row) {
        $out[(string) $row->id] = $row->label;
    }
    return $out;
}

function zumar_fk_options($kind)
{
    switch ($kind) {
        case 'country':
            return zumar_options("SELECT country_code AS id, CONCAT(country_code, ' — ', country_name) AS label FROM zf_countries WHERE deleted = 0 ORDER BY country_name");
        case 'location':
            return zumar_options("SELECT id, CONCAT(location_code, ' — ', district) AS label FROM zf_locations WHERE deleted = 0 ORDER BY country_code, district");
        case 'sector':
            return zumar_options("SELECT sector_code AS id, CONCAT(sector_code, ' — ', sector_name) AS label FROM zf_sectors WHERE deleted = 0 ORDER BY sector_name");
        case 'project':
            return zumar_options("SELECT id, CONCAT(project_code, ' — ', project_name) AS label FROM zf_projects WHERE deleted = 0 ORDER BY id DESC");
        case 'staff':
            return zumar_options("SELECT id, CONCAT(staff_code, ' — ', full_name) AS label FROM zf_staff WHERE deleted = 0 ORDER BY full_name");
        case 'partner':
            return zumar_options("SELECT id, CONCAT(partner_code, ' — ', partner_name) AS label FROM zf_partners WHERE deleted = 0 ORDER BY partner_name");
        case 'orphan':
            return zumar_options("SELECT id, CONCAT(orphan_code, ' — ', full_name) AS label FROM zf_orphans WHERE deleted = 0 ORDER BY id DESC");
        case 'water_point':
            return zumar_options("SELECT id, water_point_code AS label FROM zf_water_points WHERE deleted = 0 ORDER BY id DESC");
        case 'distribution':
            return zumar_options("SELECT id, CONCAT(distribution_code, ' — ', school_name) AS label FROM zf_school_distributions WHERE deleted = 0 ORDER BY id DESC");
        case 'training':
            return zumar_options("SELECT id, CONCAT('#', id, ' — ', training_type, ' / ', IFNULL(specific_skill,'')) AS label FROM zf_livelihood_trainings WHERE deleted = 0 ORDER BY id DESC");
        case 'budget':
            return zumar_options("SELECT id, CONCAT('#', id, ' — ', budget_line) AS label FROM zf_budgets WHERE deleted = 0 ORDER BY id DESC");
        case 'pr':
            return zumar_options("SELECT id, CONCAT('PR-', id) AS label FROM zf_purchase_requests WHERE deleted = 0 ORDER BY id DESC");
        case 'vendor':
            return zumar_options("SELECT id, vendor_name AS label FROM zf_vendors WHERE deleted = 0 ORDER BY vendor_name");
        case 'po':
            return zumar_options("SELECT id, CONCAT('PO-', id) AS label FROM zf_purchase_orders WHERE deleted = 0 ORDER BY id DESC");
        case 'policy':
            return zumar_options("SELECT policy_name AS id, policy_name AS label FROM zf_hr_policies WHERE deleted = 0 ORDER BY id");
        default:
            return array();
    }
}

function zumar_next_sequence($sql, $params = array())
{
    $q = zumar_query($sql, $params);
    if ($q->error() || !$q->count()) {
        return 1;
    }
    return ((int) $q->first()->c) + 1;
}

function zumar_generate_code($type, $data)
{
    $country = strtoupper(trim((string) ($data['country_code'] ?? 'SO')));
    $sector = strtoupper(trim((string) ($data['sector_code'] ?? 'ORPH')));
    $year = (int) ($data['year'] ?? date('Y'));
    $assetType = strtoupper(preg_replace('/[^A-Za-z0-9]+/', '', (string) ($data['asset_type'] ?? 'ASSET')));

    if ($type === 'project') {
        $seq = zumar_next_sequence(
            "SELECT COUNT(*) AS c FROM zf_projects WHERE deleted = 0 AND country_code = ? AND sector_code = ? AND year = ?",
            array($country, $sector, $year)
        );
        return sprintf('%s-%s-%03d-%d', $country, $sector, $seq, $year);
    }
    if ($type === 'orphan') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_orphans WHERE deleted = 0 AND country_code = ?", array($country));
        return sprintf('%s-ORPH-%05d', $country, $seq);
    }
    if ($type === 'staff') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_staff WHERE deleted = 0 AND country_code = ?", array($country));
        return sprintf('ZF-%s-%03d', $country, $seq);
    }
    if ($type === 'asset') {
        $seq = zumar_next_sequence(
            "SELECT COUNT(*) AS c FROM zf_infrastructure WHERE deleted = 0 AND country_code = ? AND YEAR(createdtime) = ?",
            array($country, $year)
        );
        return sprintf('%s-%s-%03d-%d', $country, $assetType !== '' ? $assetType : 'ASSET', $seq, $year);
    }
    if ($type === 'water') {
        $seq = zumar_next_sequence(
            "SELECT COUNT(*) AS c FROM zf_water_points WHERE deleted = 0 AND country_code = ? AND YEAR(createdtime) = ?",
            array($country, $year)
        );
        return sprintf('%s-BOREHOLE-%03d-%d', $country, $seq, $year);
    }
    if ($type === 'edu_dist') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_school_distributions WHERE deleted = 0 AND project_id = ?", array((int) ($data['project_id'] ?? 0)));
        return sprintf('%s-EDU-DIST-%04d', $country, $seq);
    }
    if ($type === 'scholarship') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_scholarships WHERE deleted = 0");
        return sprintf('%s-SCH-%04d', $country, $seq);
    }
    if ($type === 'health_visit') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_health_visits WHERE deleted = 0");
        return sprintf('%s-HLTH-VISIT-%04d', $country, $seq);
    }
    if ($type === 'relief') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_relief_distributions WHERE deleted = 0");
        return sprintf('%s-RELF-DIST-%04d', $country, $seq);
    }
    if ($type === 'mediation') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_mediation_cases WHERE deleted = 0");
        return sprintf('%s-PEACE-CASE-%04d', $country, $seq);
    }
    if ($type === 'sponsor') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_sponsors WHERE deleted = 0");
        return sprintf('SPN-%03d', $seq);
    }
    if ($type === 'partner') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_partners WHERE deleted = 0");
        return sprintf('PTR-%03d', $seq);
    }
    if ($type === 'location') {
        $seq = zumar_next_sequence("SELECT COUNT(*) AS c FROM zf_locations WHERE deleted = 0 AND country_code = ?", array($country));
        return sprintf('%s-LOC-%03d', $country, $seq);
    }

    return '';
}

function zumar_project_country($projectId)
{
    $q = zumar_query("SELECT country_code, sector_code, year FROM zf_projects WHERE id = ? AND deleted = 0", array((int) $projectId));
    if ($q->error() || !$q->count()) {
        return array('country_code' => 'SO', 'sector_code' => 'ORPH', 'year' => (int) date('Y'));
    }
    $row = $q->first();
    return array(
        'country_code' => $row->country_code,
        'sector_code' => $row->sector_code,
        'year' => (int) $row->year,
    );
}

function zumar_age_from_dob($dob)
{
    if ($dob === '' || $dob === null) {
        return 0;
    }
    try {
        $born = new DateTime($dob);
        return (int) $born->diff(new DateTime('today'))->y;
    } catch (Exception $e) {
        return 0;
    }
}

function zumar_upload($field, $module, $recordHint)
{
    if (empty($_FILES[$field]['name']) || (int) ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ((int) $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'mp4', 'mov');
    if (!in_array($ext, $allowed, true)) {
        return null;
    }

    $dir = dirname(__DIR__) . '/uploads/zumar/' . preg_replace('/[^a-z0-9\-]/', '', $module);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $name = strtoupper($module) . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', (string) $recordHint) . '_1.' . $ext;
    $path = $dir . '/' . $name;
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $path)) {
        return null;
    }
    return 'uploads/zumar/' . preg_replace('/[^a-z0-9\-]/', '', $module) . '/' . $name;
}

function zumar_status_label($value)
{
    $value = trim((string) $value);
    $ok = array('Active', 'Functional', 'Completed', 'Delivered', 'Resolved', 'Approved by Operations Manager', 'Provided');
    $warn = array('Pending', 'Open', 'Planned', 'Under construction', 'Under repair', 'Partially provided', 'Partially delivered');
    $bad = array('Inactive', 'Non-functional', 'Rejected', 'Blacklisted', 'Deceased', 'Withdrawn', 'Closed unresolved');
    $class = 'info';
    if (in_array($value, $ok, true)) {
        $class = 'success';
    } elseif (in_array($value, $warn, true)) {
        $class = 'warning';
    } elseif (in_array($value, $bad, true)) {
        $class = 'danger';
    }
    return '<span class="label label-sm label-' . $class . '">' . htmlspecialchars(km_option_label($value), ENT_QUOTES, 'UTF-8') . '</span>';
}
