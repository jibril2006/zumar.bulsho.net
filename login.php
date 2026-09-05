<?php
require_once '_core/init.php';
require_once '_core/theme_helpers.php';

$showError = true;
$showError = 0;
$loginuserid = 0;
$user = null;
$msg = "";
$formhashcheck = Token::verify('formhash',Input::get('formhash'));
$formhash = Token::new('formhash');
$basePath = km_base_path();
$loginUrl = ($basePath !== '' ? $basePath : '') . '/login.php';

$dbConnected = km_check_db_connection();

if ($dbConnected) {
    $user = new User();
    if($user->isLoggedIn()){
        Redirect::to('index.php');
    }
}

$errorMessage = '';

if(Input::exists() && $dbConnected) {
    $showError = 0;

    if(isset($formhashcheck)) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if($validation->passed()){
            $user = new User();
            $remember = (Input::get('remember') == 'on') ? true : false;
            $login = $user->login(Input::get('username'),Input::get('password'),$remember);
            if($login){
                $userinfo = array();
                if($user->finduser(Input::get('username'))){
                    $loginuserid = $user->id;
                }

                $upduser = new User();
                $userinfo = array(
                    'id' => $upduser->data()->id,
                    'username' => $upduser->data()->username,
                    'employeeid' => $upduser->data()->employeeid,
                    'statusid' => $upduser->data()->statusid,
                    'roleid' => $upduser->data()->roleid
                );
                Session::put('USERINFO',$userinfo);

                try{
                    $upduser->update(array(
                        'lastlogin' => date('Y-m-d H:i:s')
                    ),$loginuserid);
                }catch(Exception $e){
                    die($e->getMessage());
                }

                Redirect::to('index.php');
            } else {
                $showError = true;
                $errorMessage = 'Login failed, username / password is incorrect!';
            }
        } else {
            $showError = true;
            $errorMessage = 'Type username and password!';
            foreach($validation->errors() as $error) {
                $errorMessage .= $error . '<br>';
            }
        }
    }
}

$generatedToken = Token::generate();

ob_start();
?>
<form id="login_form" action="<?php echo htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8'); ?>" class="kt-card-content flex flex-col gap-5 p-10" method="post" novalidate>
    <div class="flex justify-center mb-2">
        <a href="<?php echo htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8'); ?>">
            <img class="h-[44px] max-w-none" src="<?php echo htmlspecialchars(km_logo_url(false), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(km_company_name(), ENT_QUOTES, 'UTF-8'); ?>"/>
        </a>
    </div>
    <div class="text-center mb-1.5">
        <h1 class="text-xl font-semibold text-mono leading-tight mb-1"><?php echo htmlspecialchars(km_company_name(), ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="text-sm text-secondary-foreground m-0">Sign In</p>
    </div>
    <?php if ($showError && $errorMessage !== ''): ?>
        <div class="kt-alert kt-alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <div class="flex flex-col gap-1">
        <label class="kt-form-label font-normal text-mono">Username or Email</label>
        <input class="kt-input" name="username" placeholder="Enter your username" type="text" required autofocus value="<?php echo htmlspecialchars(Input::get('username'), ENT_QUOTES, 'UTF-8'); ?>"/>
    </div>
    <div class="flex flex-col gap-1">
        <div class="flex items-center justify-between gap-1">
            <label class="kt-form-label font-normal text-mono mb-0">Password</label>
            <a class="text-sm kt-link shrink-0" href="javascript:;" id="forget-password">Forgot Password?</a>
        </div>
        <input class="kt-input" name="password" placeholder="Enter your password" type="password" required autocomplete="off"/>
    </div>
    <label class="kt-label">
        <input type="hidden" name="formhash" value="<?php echo htmlspecialchars($formhash, ENT_QUOTES, 'UTF-8'); ?>">
        <input class="kt-checkbox kt-checkbox-sm" name="remember" type="checkbox" value="1"/>
        <span class="kt-checkbox-label">Remember me</span>
    </label>
    <button class="kt-btn kt-btn-primary flex justify-center grow inline-flex items-center gap-1" type="submit">
        <i class="ki-filled ki-profile-circle text-sm"></i> Sign In
    </button>
    <?php echo km_login_attribution_footer_html($dbConnected); ?>
</form>

<form class="forget-form kt-card-content flex flex-col gap-5 p-10" action="validateforgetlogin.php" method="post" style="display:none;">
    <div class="text-center mb-1.5">
        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">Forgot Password?</h3>
        <p class="text-sm text-secondary-foreground">Enter your e-mail address below to reset your password.</p>
    </div>
    <div class="flex flex-col gap-1">
        <label class="kt-form-label font-normal text-mono">Email</label>
        <input class="kt-input" type="text" autocomplete="off" placeholder="Email" name="email"/>
    </div>
    <div class="flex items-center justify-between gap-2">
        <button type="button" id="back-btn" class="kt-btn kt-btn-outline">Back</button>
        <button type="submit" class="kt-btn kt-btn-primary">Submit</button>
    </div>
</form>

<script>
(function () {
    function wireEnterSubmit(form) {
        if (!form) return;
        form.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter') return;
            var el = e.target;
            if (!el || el.tagName !== 'INPUT') return;
            var ty = (el.type || '').toLowerCase();
            if (ty !== 'text' && ty !== 'password') return;
            var pwd = form.querySelector('input[type="password"]');
            if (pwd && el !== pwd) {
                e.preventDefault();
                pwd.focus();
                return;
            }
            e.preventDefault();
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.click();
        });
    }
    function initLoginUi() {
        wireEnterSubmit(document.getElementById('login_form'));
        var forgetLink = document.getElementById('forget-password');
        var backBtn = document.getElementById('back-btn');
        var loginForm = document.getElementById('login_form');
        var forgetForm = document.querySelector('.forget-form');
        if (forgetLink && loginForm && forgetForm) {
            forgetLink.addEventListener('click', function () {
                loginForm.style.display = 'none';
                forgetForm.style.display = 'flex';
            });
        }
        if (backBtn && loginForm && forgetForm) {
            backBtn.addEventListener('click', function () {
                forgetForm.style.display = 'none';
                loginForm.style.display = 'flex';
            });
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLoginUi);
    } else {
        initLoginUi();
    }
})();
</script>
<?php
$mainContent = ob_get_clean();
require_once __DIR__ . '/metronic_auth_template.php';
render_metronic_auth_page(
    $mainContent,
    __DIR__ . '/html/demo1/authentication/classic/sign-in.html',
    km_company_name() . ' | Sign In'
);
