<?php

require_once '_core/init.php';
require_once '_core/theme_helpers.php';
require_once 'metronic_legacy_styles.php';
km_init_language();
$user = new User();
$USERID = $user->data()->id;
$USERNAME = $user->data()->username;

date_default_timezone_set('Africa/Mogadishu');
setlocale(LC_TIME, array('LC_ALL','English_United States','en_US','english'));

if (!empty($user->data()->photourl)) {
    $USERNAMEPHOTOURL = $user->data()->photourl;
} else {
    $USERNAMEPHOTOURL = 'newimages/defaultuser.png';
}

Session::put('USERID',$USERID);
$myuserinfo = Session::get('USERINFO');
$ROLEID = $myuserinfo["roleid"];
$EMPLOYEEID = $myuserinfo["employeeid"];
$init_status = '';
$generatedToken = Token::generate('headertoken');

if(Input::get('formhash') && (Input::get('formhash') == Session::get('formhash'))){
    $test = 'ok';
    $formhashcheck = 1;
    Session::delete('formhash');
} else { $formhashcheck = 0; }

$formhash = Token::new('formhash');

$uri = $_SERVER['REQUEST_URI'];
$showedit = 0;
$showdelete = 0;

$this_site = activesitename();

$pageaccess = new Page();
$pageaccess->hasaccess($ROLEID,$this_site);
$hasaccess = $pageaccess->count();
if ($hasaccess || ($ROLEID == 1)) {
    $sitecontinue = 1;
} else  $sitecontinue = 0;

if (!$sitecontinue && in_array($this_site, array('profile', 'changepassword'), true)) {
    $sitecontinue = 1;
}

if (!$sitecontinue) Redirect::to('dashboard.php');

$pageTitle = isset($pagename) ? $pagename . ' - ' . km_company_name() : km_company_name();
?>

<!DOCTYPE html>
<html lang="<?php echo km_current_language() === 'en' ? 'en' : 'so'; ?>">
    <head>
        <meta charset="utf-8" />
        <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo htmlspecialchars(km_company_name() . ' Admin System', ENT_QUOTES, 'UTF-8'); ?>" name="description" />
        <link href="<?php echo htmlspecialchars(km_favicon_url(), ENT_QUOTES, 'UTF-8'); ?>" rel="icon" type="image/svg+xml"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout4/css/custom.css" rel="stylesheet" type="text/css" />
        <?php echo km_metronic_legacy_styles(); ?>
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            (function() {
                function initDateUkSort() {
                    if (typeof jQuery !== 'undefined' && jQuery.fn.dataTableExt) {
                        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                            "date-uk-pre": function(a) {
                                if (a == null || a == "") return 0;
                                var ukDatea = a.split('-');
                                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
                            },
                            "date-uk-asc": function(a, b) {
                                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                            },
                            "date-uk-desc": function(a, b) {
                                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                            }
                        });
                    }
                }
                if (document.readyState === 'complete') {
                    initDateUkSort();
                } else {
                    window.addEventListener('load', initDateUkSort);
                }
            })();
        </script>
    </head>
