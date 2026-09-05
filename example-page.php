<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$pagename = km_current_language() === 'en' ? 'Example list' : 'Tusaale liis';
include_once 'head.php';
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
                <div class="portlet light portlet-fit portlet-datatable bordered km-list-page">
                    <div class="portlet-title km-list-title">
                        <div class="caption">
                            <i class="icon-list font-green"></i>
                            <span class="caption-subject font-green sbold uppercase"><?php echo htmlspecialchars($pagename, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div class="actions">
                            <a class="btn green btn-sm" href="dashboard.php">
                                <i class="fa fa-arrow-left"></i>
                                <?php echo km_current_language() === 'en' ? 'Back' : 'Dib ugu noqo'; ?>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <p class="km-list-filter-note">
                            <?php echo km_current_language() === 'en'
                                ? 'This page shows the standard list layout. Copy this file and wire up _data/ + datatables/ for Ajax tables.'
                                : 'Boggan wuxuu muujinayaa qaabka liiska caadiga ah. Nuqul ka samee oo ku xir _data/ iyo datatables/.'; ?>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo km_current_language() === 'en' ? 'Name' : 'Magac'; ?></th>
                                        <th><?php echo km_current_language() === 'en' ? 'Status' : 'Xaalad'; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sample row</td>
                                        <td><span class="label label-sm label-success">OK</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Another row</td>
                                        <td><span class="label label-sm label-info">Demo</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
