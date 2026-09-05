<?php

function zumar_field_label($field)
{
    return km_current_language() === 'en' ? $field['label_en'] : $field['label_so'];
}

function zumar_module_title($module)
{
    return km_current_language() === 'en' ? $module['title_en'] : $module['title_so'];
}

function zumar_row_value($row, $name)
{
    return isset($row->$name) ? $row->$name : '';
}

function zumar_collect_fields($module, $existing = null)
{
    $data = array();
    foreach ($module['fields'] as $field) {
        $name = $field['name'];
        $type = $field['type'];
        if ($type === 'file') {
            $uploaded = zumar_upload($name, preg_replace('/[^a-z0-9\-]/', '', $module['table']), $existing->id ?? 'new');
            if ($uploaded !== null) {
                $data[$name] = $uploaded;
            } elseif ($existing && isset($existing->$name)) {
                $data[$name] = $existing->$name;
            }
            continue;
        }
        $value = Input::get($name);
        if ($value === null) {
            $value = '';
        }
        if (in_array($type, array('fk', 'number', 'money'), true) && $value === '') {
            $data[$name] = null;
            continue;
        }
        $data[$name] = $value;
    }
    return $data;
}

function zumar_apply_codes($key, $module, &$data, $existing = null)
{
    if (!empty($module['code_field']) && !empty($module['code_type'])) {
        $field = $module['code_field'];
        if ($existing && !empty($existing->$field)) {
            $data[$field] = $existing->$field;
        } else {
            $codeData = $data;
            if (!empty($data['project_id'])) {
                $codeData = array_merge(zumar_project_country((int) $data['project_id']), $codeData);
            }
            if (empty($codeData['year'])) {
                $codeData['year'] = date('Y');
            }
            if ($module['code_type'] === 'asset' && !empty($data['asset_type'])) {
                $codeData['asset_type'] = $data['asset_type'];
            }
            $data[$field] = zumar_generate_code($module['code_type'], $codeData);
        }
    }

    if ($key === 'projects') {
        $data['sequence_no'] = $existing ? (int) $existing->sequence_no : (int) preg_replace('/\D+/', '', substr((string) ($data['project_code'] ?? '001'), -8, 3) ?: 1);
        if (empty($data['year'])) {
            $data['year'] = date('Y');
        }
    }

    if ($key === 'orphans') {
        if (!empty($data['date_of_birth'])) {
            $data['age'] = zumar_age_from_dob($data['date_of_birth']);
        }
        if (empty($data['serial_no'])) {
            $code = (string) ($data['orphan_code'] ?? '');
            $data['serial_no'] = (int) preg_replace('/\D+/', '', substr($code, -5)) ?: 1;
        }
    }
}

function zumar_save_module($key, $module)
{
    $id = (int) Input::get('id');
    $existing = null;
    if ($id > 0) {
        $q = zumar_query("SELECT * FROM {$module['table']} WHERE id = ? AND deleted = 0", array($id));
        if (!$q->error() && $q->count()) {
            $existing = $q->first();
        }
    }

    $data = zumar_collect_fields($module, $existing);
    zumar_apply_codes($key, $module, $data, $existing);

    $data['updateduserid'] = zumar_user_id();
    $data['updatedtime'] = date('Y-m-d H:i:s');
    $data['formhash'] = Input::get('formhash');

    foreach ($data as $k => $v) {
        if ($v === null) {
            unset($data[$k]);
        }
    }

    $db = DB::getInstance();
    if ($existing) {
        $db->update($module['table'], $id, $data);
        zumar_audit($module['table'], $id, 'update', json_encode(array_keys($data)));
        return $id;
    }

    $data['createduserid'] = zumar_user_id();
    $data['createdtime'] = date('Y-m-d H:i:s');
    $data['deleted'] = 0;
    $db->insert($module['table'], $data);
    $newId = (int) $db->lastinsertid();
    zumar_audit($module['table'], $newId, 'insert', $module['code_field'] ?? $key);
    return $newId;
}

function zumar_delete_module($module)
{
    $id = (int) Input::get('id');
    if ($id < 1) {
        return;
    }
    DB::getInstance()->update($module['table'], $id, array(
        'deleted' => 1,
        'updateduserid' => zumar_user_id(),
        'updatedtime' => date('Y-m-d H:i:s'),
    ));
    zumar_audit($module['table'], $id, 'delete');
}

function zumar_display_cell($module, $fieldName, $row)
{
    $value = zumar_row_value($row, $fieldName);
    $field = null;
    foreach ($module['fields'] as $candidate) {
        if ($candidate['name'] === $fieldName) {
            $field = $candidate;
            break;
        }
    }
    if ($field && $field['type'] === 'fk' && $value !== '' && $value !== null) {
        $opts = zumar_fk_options($field['fk']);
        return htmlspecialchars($opts[(string) $value] ?? (string) $value, ENT_QUOTES, 'UTF-8');
    }
    if ($fieldName === 'status' || $fieldName === 'employment_status' || $fieldName === 'approval_status' || $fieldName === 'delivery_status' || $fieldName === 'case_status' || $fieldName === 'vetting_status' || $fieldName === 'support_status') {
        return zumar_status_label($value);
    }
    if ($field && $field['type'] === 'money') {
        return htmlspecialchars(km_format_money($value), ENT_QUOTES, 'UTF-8');
    }
    if ($field && $field['type'] === 'file' && $value) {
        return '<a href="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars(km_t('file'), ENT_QUOTES, 'UTF-8') . '</a>';
    }
    if ($field && $field['type'] === 'select') {
        return htmlspecialchars(km_option_label($value), ENT_QUOTES, 'UTF-8');
    }
    return htmlspecialchars(km_option_label((string) $value), ENT_QUOTES, 'UTF-8');
}

function zumar_render_input($field, $value)
{
    $name = $field['name'];
    $req = !empty($field['required']) ? ' required' : '';
    $label = htmlspecialchars(zumar_field_label($field), ENT_QUOTES, 'UTF-8');
    echo '<div class="form-group"><label>' . $label . (!empty($field['required']) ? ' <span class="text-danger">*</span>' : '') . '</label>';

    if ($field['type'] === 'textarea') {
        echo '<textarea class="form-control" name="' . $name . '" rows="3"' . $req . '>' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '</textarea>';
    } elseif ($field['type'] === 'select') {
        echo '<select class="form-control" name="' . $name . '"' . $req . '><option value="">—</option>';
        foreach ($field['options'] as $optVal => $optLabel) {
            $sel = ((string) $value === (string) $optVal) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars((string) $optVal, ENT_QUOTES, 'UTF-8') . '"' . $sel . '>' . htmlspecialchars(km_option_label($optLabel), ENT_QUOTES, 'UTF-8') . '</option>';
        }
        echo '</select>';
    } elseif ($field['type'] === 'fk') {
        echo '<select class="form-control" name="' . $name . '"' . $req . '><option value="">—</option>';
        foreach (zumar_fk_options($field['fk']) as $optVal => $optLabel) {
            $sel = ((string) $value === (string) $optVal) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars((string) $optVal, ENT_QUOTES, 'UTF-8') . '"' . $sel . '>' . htmlspecialchars($optLabel, ENT_QUOTES, 'UTF-8') . '</option>';
        }
        echo '</select>';
    } elseif ($field['type'] === 'file') {
        if ($value) {
            echo '<div class="help-block"><a href="' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '</a></div>';
        }
        echo '<input class="form-control" type="file" name="' . $name . '">';
    } else {
        $inputType = $field['type'] === 'date' ? 'date' : ($field['type'] === 'number' || $field['type'] === 'money' ? 'number' : 'text');
        $step = $field['type'] === 'money' ? ' step="0.01"' : '';
        echo '<input class="form-control" type="' . $inputType . '" name="' . $name . '" value="' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '"' . $step . $req . '>';
    }
    echo '</div>';
}

function zumar_render_page($key)
{
    $module = zumar_module($key);
    if (!$module) {
        Redirect::to('dashboard.php');
    }

    if (!empty($module['restricted']) && !zumar_can_see_restricted()) {
        Redirect::to('dashboard.php');
    }

    $action = (string) Input::get('action');
    $id = (int) Input::get('id');

    $pagename = zumar_module_title($module);
    include_once dirname(__DIR__) . '/head.php';

    $row = null;
    if (in_array($action, array('add', 'edit'), true)) {
        if ($action === 'edit' && $id > 0) {
            $q = zumar_query("SELECT * FROM {$module['table']} WHERE id = ? AND deleted = 0", array($id));
            if (!$q->error() && $q->count()) {
                $row = $q->first();
            }
        }
    }

    $rows = array();
    if (!in_array($action, array('add', 'edit'), true)) {
        $q = zumar_query("SELECT * FROM {$module['table']} WHERE deleted = 0 ORDER BY id DESC LIMIT 500");
        if (!$q->error() && $q->count()) {
            $rows = $q->results();
        }
    }
    ?>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
<?php include_once dirname(__DIR__) . '/header.php'; include_once dirname(__DIR__) . '/sidebar.php'; ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered km-list-page">
                    <div class="portlet-title km-list-title">
                        <div class="caption">
                            <i class="<?php echo htmlspecialchars($module['icon'], ENT_QUOTES, 'UTF-8'); ?> font-green"></i>
                            <span class="caption-subject font-green sbold uppercase"><?php echo htmlspecialchars($pagename, ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php if (!empty($module['form_code'])) { ?>
                                <span class="label label-info"><?php echo htmlspecialchars($module['form_code'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php } ?>
                        </div>
                        <div class="actions">
                            <?php if (in_array($action, array('add', 'edit'), true)) { ?>
                                <a class="btn default btn-sm" href="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>.php"><i class="fa fa-list"></i> <?php echo htmlspecialchars(km_t('list'), ENT_QUOTES, 'UTF-8'); ?></a>
                            <?php } else { ?>
                                <a class="btn green btn-sm" href="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>.php?action=add"><i class="fa fa-plus"></i> <?php echo htmlspecialchars(km_t('add'), ENT_QUOTES, 'UTF-8'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php if (Input::get('saved')) { ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars(km_t('saved'), ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php } ?>
                        <?php if (Input::get('deleted')) { ?>
                            <div class="alert alert-warning"><?php echo htmlspecialchars(km_t('deleted'), ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php } ?>
                        <?php if (!empty($module['restricted'])) { ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars(km_t('restricted'), ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php } ?>

                        <?php if (in_array($action, array('add', 'edit'), true)) { ?>
                            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>.php">
                                <input type="hidden" name="action" value="save">
                                <input type="hidden" name="id" value="<?php echo (int) ($row->id ?? 0); ?>">
                                <input type="hidden" name="formhash" value="<?php echo htmlspecialchars($GLOBALS['formhash'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="row">
                                    <?php foreach ($module['fields'] as $field) {
                                        echo '<div class="col-md-6">';
                                        zumar_render_input($field, $row ? zumar_row_value($row, $field['name']) : (Input::get($field['name']) ?: ($field['name'] === 'year' || $field['name'] === 'year_enrolled' ? date('Y') : '')));
                                        echo '</div>';
                                    } ?>
                                </div>
                                <button type="submit" class="btn green"><?php echo htmlspecialchars(km_t('save'), ENT_QUOTES, 'UTF-8'); ?></button>
                            </form>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <?php foreach ($module['list'] as $col) {
                                                $label = $col;
                                                foreach ($module['fields'] as $field) {
                                                    if ($field['name'] === $col) {
                                                        $label = zumar_field_label($field);
                                                        break;
                                                    }
                                                }
                                                if ($col === 'id') {
                                                    $label = 'ID';
                                                }
                                                echo '<th>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</th>';
                                            } ?>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!$rows) { ?>
                                            <tr><td colspan="<?php echo count($module['list']) + 2; ?>"><?php echo htmlspecialchars(km_t('no_records'), ENT_QUOTES, 'UTF-8'); ?></td></tr>
                                        <?php } ?>
                                        <?php foreach ($rows as $item) { ?>
                                            <tr>
                                                <td><?php echo (int) $item->id; ?></td>
                                                <?php foreach ($module['list'] as $col) {
                                                    echo '<td>' . zumar_display_cell($module, $col, $item) . '</td>';
                                                } ?>
                                                <td class="text-right">
                                                    <a class="btn btn-xs blue" href="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>.php?action=edit&id=<?php echo (int) $item->id; ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn btn-xs red" href="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>.php?action=delete&id=<?php echo (int) $item->id; ?>" onclick="return confirm('<?php echo htmlspecialchars(km_t('delete_confirm'), ENT_QUOTES, 'UTF-8'); ?>');"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once dirname(__DIR__) . '/footer.php';
}

function zumar_boot($key)
{
    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/theme_helpers.php';
    require_once __DIR__ . '/zumar_helpers.php';
    require_once __DIR__ . '/zumar_modules.php';

    $user = new User();
    if (!$user->isLoggedIn()) {
        Redirect::to('login.php');
    }

    $module = zumar_module($key);
    if (!$module) {
        Redirect::to('dashboard.php');
    }
    if (!empty($module['restricted']) && !zumar_can_see_restricted()) {
        Redirect::to('dashboard.php');
    }

    $action = (string) Input::get('action');
    $id = (int) Input::get('id');
    if (Input::exists() && $action === 'save' && Input::get('formhash') && Input::get('formhash') === Session::get('formhash')) {
        Session::delete('formhash');
        $savedId = zumar_save_module($key, $module);
        Redirect::to($key . '.php?saved=' . $savedId);
    }
    if ($action === 'delete' && $id > 0) {
        zumar_delete_module($module);
        Redirect::to($key . '.php?deleted=1');
    }

    zumar_render_page($key);
}
