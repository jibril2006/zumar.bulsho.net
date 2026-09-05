<?php
if (defined('KM_SIDEBAR_RENDERED')) {
    return;
}
define('KM_SIDEBAR_RENDERED', true);

require_once __DIR__ . '/_core/theme_helpers.php';

if (!function_exists('km_render_page_badges')) {
    function km_render_page_badges($page, $myuserinfo, $thisyear)
    {
        $html = '';
        if ($page->id == 44) {
            $mytotalcases = 0;
            try {
                $sqlquery = "SELECT distinct(agent_id) FROM agenttransactions WHERE agenttransaction_status = 1 and approved = 2";
                $gbvcases = @DB::getInstance()->query($sqlquery);
                if ($gbvcases && !$gbvcases->error()) {
                    $mytotalcases = $gbvcases->count();
                }
            } catch (Exception $e) {
                $mytotalcases = 0;
            }
            if ($mytotalcases > 0) {
                $html .= '<span class="badge badge-danger">' . $mytotalcases . '</span>';
            }
        }
        return $html;
    }
}

$myuserinfo = Session::get('USERINFO');
$ROLEID = $myuserinfo["roleid"];
$thisyear = date("Y");
?>
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <?php
                        $isactivesite = 0;
                        if ($myuserinfo["roleid"] == 1) {
                            $topmenusql = "SELECT * FROM topmenu WHERE deleted = 0 order by sort asc";
                        } else {
                            $topmenusql = "SELECT * FROM topmenu WHERE deleted = 0 and id in (SELECT topmenuid FROM pages WHERE deleted = 0 and sidebar = 1 and id in (select pageid from pagepermissions where deleted = 0 and roleid = $ROLEID)) or id = 1 order by sort asc";
                        }

                        $topmenu = DB::getInstance()->query($topmenusql);
                        if ($topmenu->count()) {
                            foreach ($topmenu->results() as $menu) {
                                $isactivesite = 0;
                                if ($menu->submenu) {
                                    $topmenuid = $menu->id;
                                    $activesitename = activesitename();
                                    $pagesql = "SELECT * FROM pages WHERE deleted = 0 and topmenuid = $topmenuid and href = '$activesitename' order by sort asc";
                                    $pages = DB::getInstance()->query($pagesql);
                                    $isactivesite = $pages->count() ? 1 : 0;
                                }

                                if (isactivesite($menu->href) || $isactivesite) {
                                    $isactivesite_text = 'start active open';
                                } else {
                                    $isactivesite_text = '';
                                }

                                $menuIcon = km_menu_icon_class($menu->icon);
                        ?>
                        <li class="nav-item <?php echo $isactivesite_text; ?>">
                            <a href="<?php echo $menu->submenu ? 'javascript:;' : htmlspecialchars($menu->href . '.php', ENT_QUOTES, 'UTF-8'); ?>" class="nav-link nav-toggle">
                                <i class="<?php echo htmlspecialchars($menuIcon, ENT_QUOTES, 'UTF-8'); ?>"></i>
                                <span class="menu-title title"><?php echo htmlspecialchars(km_topmenu_label($menu), ENT_QUOTES, 'UTF-8'); ?></span>
                                <?php if ($menu->submenu) { ?>
                                <span class="arrow"></span>
                                <?php } ?>
                                <span class="selected"></span>
                            </a>
                            <?php if ($menu->submenu) {
                                echo '<ul class="sub-menu">';
                                $topmenuid = $menu->id;
                                if ($myuserinfo["roleid"] == 1) {
                                    $pagesql = "SELECT * FROM pages WHERE deleted = 0 and topmenuid = $topmenuid and sidebar = 1 order by sort asc";
                                } else {
                                    $pagesql = "SELECT * FROM pages WHERE deleted = 0 and topmenuid = $topmenuid and sidebar = 1 and id in (select pageid from pagepermissions where deleted = 0 and roleid = $ROLEID) order by sort asc";
                                }
                                $pages = DB::getInstance()->query($pagesql);
                                if ($pages->count()) {
                                    foreach ($pages->results() as $page) {
                            ?>
                                    <li class="nav-item <?php if (isactivesite($page->href)) echo 'active'; ?>">
                                        <a href="<?php echo htmlspecialchars($page->href . '.php', ENT_QUOTES, 'UTF-8'); ?>" class="nav-link">
                                            <i class="<?php echo htmlspecialchars(km_page_sidebar_icon($page), ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
                                            <span class="menu-title title"><?php
                                                echo htmlspecialchars(km_page_label($page), ENT_QUOTES, 'UTF-8');
                                                echo km_render_page_badges($page, $myuserinfo, $thisyear);
                                            ?></span>
                                        </a>
                                    </li>
                            <?php
                                    }
                                }
                                echo '</ul>';
                            } ?>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- END SIDEBAR -->
