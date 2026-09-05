<?php
require_once __DIR__ . '/_core/theme_helpers.php';
?>
        <link href="../assets/layouts/layout4/css/km-datatables-overrides.css" rel="stylesheet" type="text/css" />
        <!-- BEGIN FOOTER -->
        <div class="page-footer km-page-footer">
            <div class="page-footer-inner km-footer-inner">
                <div class="km-footer-main">
                    <span class="km-footer-badge" aria-hidden="true"><?php echo htmlspecialchars(km_brand_short(), ENT_QUOTES, 'UTF-8'); ?></span>
                    <div class="km-footer-text">
                        <span class="km-footer-copy">
                            <?php echo htmlspecialchars(km_footer_copyright_year(), ENT_QUOTES, 'UTF-8'); ?> &copy; BITS System by
                            <a target="_blank" rel="noopener noreferrer" href="http://bulsho.net">Bulsho IT Systems</a>
                        </span>
                        <span class="km-footer-divider" aria-hidden="true"></span>
                        <a class="km-footer-system-link" href="<?php echo htmlspecialchars(km_site_url(), ENT_QUOTES, 'UTF-8'); ?>" title="<?php echo htmlspecialchars(km_footer_system_label(), ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo htmlspecialchars(km_footer_system_label(), ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        </div>
        <!-- END CONTAINER -->

        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

    </body>
</html>
