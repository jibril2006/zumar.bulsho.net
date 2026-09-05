<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';
$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
}

$pagename = km_current_language() === 'en' ? 'Change password' : 'Badal password';
include_once 'head.php';
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

<!-- END PAGE LEVEL PLUGINS -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">

<?php
include_once 'header.php';
include_once 'sidebar.php';
include_once '_action/myuseraction.php';


$edituser = new User();
$edituser->find($USERID);
$edituser = $edituser->data();


$editname = trim((string) ($edituser->name ?? $edituser->username));




?>
        
        

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="col-md-12 ">
                        <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-user font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase"> Change your password.</span>
                                        <span class="caption-subject bold uppercase" style="color: #0000FF;"> </span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                                
                                                <form action="" method="POST" class="form-horizontal">
                                                    <input id="POST" name="POST" type="hidden" value="1">
                                                    <input id="POSTACTION" name="POSTACTION" type="hidden" value="editpassword">
                                                    <input id="formhash" name="formhash" type="hidden" value="<?php echo $formhash; ?>">
                                                    <input id="userid" name="userid" type="hidden" value="<?php echo $edituser->id; ?>">

                                                    <div class="form-body">
                                                       
                                                         <div class="form-group col-md-12">
                                                            <label class="col-md-2 control-label">Previus Password:<span class="required">&#42;</span></label>
                                                            <div class="col-md-4">
                                                                <input type="password" class="form-control red" placeholder="Previus Password" name="prepassword" value="<?php if(Input::get("prepassword")) echo Input::get("prepassword"); ?>" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-md-2 control-label">New password:<span class="required">&#42;</span></label>
                                                            <div class="col-md-4">
                                                                <input type="password" class="form-control red" placeholder="New Password" name="password" value="<?php if(Input::get("password")) echo Input::get("password"); ?>" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="col-md-2 control-label">New password again:<span class="required">&#42;</span></label>
                                                            <div class="col-md-4">
                                                                <input type="password" class="form-control red" placeholder="New Password again" name="passwordagain" value="<?php if(Input::get("passwordagain")) echo Input::get("passwordagain"); ?>" required="true">
                                                            </div>
                                                        </div>
                                                      
                                                        
                                                        
                                                        <div class="form-group last">
                                                            <div class="col-md-4" style="text-align: right;">
                                                                <span class="required"> &#42; Required fields and must be filled out.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-8 col-md-4">
                                                                <a class="btn red btn-outline sbold" data-toggle="modal" href="#basic"> Cancel </a>
                                                                <input name="submit" type="submit" class="btn green" value=" Save ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                                <!-- END FORM-->
                                            </div>
                            </div>
                        
                    </div>


                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            
        
<?php
include_once 'footer.php';
?>

                                <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Cancel</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to cancel! </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                                                    <a href="dashboard.php" type="button" class="btn red">Yes</a>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="../datatables/test.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>
<script src="../datatables/option-locations.js" type="text/javascript"></script>
<script src="../assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS SELECT2-->
<script src="../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS SELECT2-->
