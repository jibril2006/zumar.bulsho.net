<?php
require_once __DIR__ . '/_core/theme_helpers.php';
?>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top km-topbar km-topbar--electric">
            <div class="page-header-inner">
                <div class="page-logo">
                    <a href="dashboard.php" title="<?php echo htmlspecialchars(km_company_name(), ENT_QUOTES, 'UTF-8'); ?>">
                        <img src="<?php echo htmlspecialchars(km_logo_url(true), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(km_brand_short(), ENT_QUOTES, 'UTF-8'); ?>" class="logo-default km-header-logo" />
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"><span></span></a>
                <div class="page-top">
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="separator hide"></li>
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile"><?php echo htmlspecialchars($USERNAME, ENT_QUOTES, 'UTF-8'); ?></span>
                                    <img alt="" class="img-circle" src="<?php echo htmlspecialchars(km_user_photo_url(), ENT_QUOTES, 'UTF-8'); ?>" />
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default km-user-dropdown-menu">
                                    <li>
                                        <a href="dashboard.php">
                                            <i class="icon-user"></i> <?php echo htmlspecialchars(km_user_menu_label('profile'), ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="<?php echo km_current_language() === 'so' ? 'active-lang' : ''; ?>">
                                        <a href="<?php echo htmlspecialchars(km_language_url('so'), ENT_QUOTES, 'UTF-8'); ?>">
                                            <i class="fa fa-flag"></i> <?php echo htmlspecialchars(km_user_menu_label('somali'), ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                    <li class="<?php echo km_current_language() === 'en' ? 'active-lang' : ''; ?>">
                                        <a href="<?php echo htmlspecialchars(km_language_url('en'), ENT_QUOTES, 'UTF-8'); ?>">
                                            <i class="fa fa-flag"></i> <?php echo htmlspecialchars(km_user_menu_label('english'), ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <?php if ((int) $ROLEID === 1) { ?>
                                    <li>
                                        <a href="<?php echo htmlspecialchars(km_user_settings_url(), ENT_QUOTES, 'UTF-8'); ?>">
                                            <i class="icon-settings"></i> <?php echo htmlspecialchars(km_user_menu_label('settings'), ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <a href="changepassword.php">
                                            <i class="icon-lock"></i> <?php echo htmlspecialchars(km_user_menu_label('password'), ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php">
                                            <i class="icon-key"></i> <?php echo htmlspecialchars(km_user_menu_label('logout'), ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
