<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$pagename = km_t('my_profile');
include_once 'head.php';

$profile = $user->data();
$roleName = '';
if (!empty($profile->roleid)) {
    $roleRow = DB::getInstance()->get('roles', array('id', '=', (int) $profile->roleid));
    if ($roleRow && !$roleRow->error() && $roleRow->count()) {
        $roleName = (string) $roleRow->first()->rolename;
    }
}

$displayName = trim((string) ($profile->name ?? $profile->username ?? ''));
$lastLogin = trim((string) ($profile->lastlogin ?? ''));
?>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
<?php
include_once 'header.php';
include_once 'sidebar.php';
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-user font-green"></i>
                            <span class="caption-subject font-green sbold uppercase"><?php echo htmlspecialchars($pagename, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="actions">
                            <a class="btn green btn-sm" href="changepassword.php">
                                <i class="icon-settings"></i> <?php echo htmlspecialchars(km_user_menu_label('settings'), ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-bordered table-user-information">
                            <tbody>
                                <tr>
                                    <td class="tdlabel"><?php echo htmlspecialchars(km_t('name'), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <td class="tdlabel"><?php echo htmlspecialchars(km_t('username_or_email'), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($profile->username ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <td class="tdlabel"><?php echo htmlspecialchars(km_t('role'), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($roleName !== '' ? $roleName : (string) ($profile->roleid ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <td class="tdlabel"><?php echo htmlspecialchars(km_t('last_login'), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($lastLogin !== '' ? $lastLogin : '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
