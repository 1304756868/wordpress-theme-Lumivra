    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
            <div class="footer-widgets">
                <div class="container">
                    <div class="footer-widgets-inner">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <div class="footer-column">
                                <?php dynamic_sidebar('footer-1'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <div class="footer-column">
                                <?php dynamic_sidebar('footer-2'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <div class="footer-column">
                                <?php dynamic_sidebar('footer-3'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="site-info">
            <div class="container">
                <p>
                    &copy; <?php echo date('Y'); ?> 
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php
                    // 优先从后台设置读取版权信息
                    $lumivra_copyright = lumivra_get_option('copyright_text');
                    if (!$lumivra_copyright) {
                        // 其次从自定义器读取
                        $lumivra_copyright = get_theme_mod('lumivra_copyright_text');
                    }
                    if ($lumivra_copyright) {
                        echo ' | ' . esc_html($lumivra_copyright);
                    }
                    ?>
                </p>
                <p class="powered-by">
                    <?php printf(__('Powered by %s', 'lumivra'), '<a href="https://wordpress.org/">WordPress</a>'); ?>
                    <?php printf(__(' | Theme: %s', 'lumivra'), '<a href="#">Lumivra</a>'); ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
