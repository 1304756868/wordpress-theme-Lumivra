    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="site-info">
            <div class="container">
                <p>
                    &copy; <?php echo date('Y'); ?>&nbsp; 
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
                        echo '｜' . esc_html($lumivra_copyright);
                    }
                    ?>
                </p>
                <?php
                // 显示备案信息
                $miit_beian = lumivra_get_option('miit_beian');
                $police_beian = lumivra_get_option('police_beian');
                $police_beian_url = lumivra_get_option('police_beian_url', 'https://beian.mps.gov.cn/#/query/webSearch');
                
                if ($miit_beian || $police_beian) {
                    echo '<p class="beian-info">';
                    
                    $beian_parts = array();
                    
                    if ($miit_beian) {
                        $beian_parts[] = '<a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener noreferrer">' . esc_html($miit_beian) . '</a>';
                    }
                    
                    if ($police_beian) {
                        $police_link = '<a href="' . esc_url($police_beian_url) . '" target="_blank" rel="noopener noreferrer">';
                        $police_link .= '<img src="' . get_template_directory_uri() . '/assets/png/gongan.png" alt="公安备案" style="vertical-align: middle; margin-right: 5px; height: 1em;">';
                        $police_link .= esc_html($police_beian);
                        $police_link .= '</a>';
                        $beian_parts[] = $police_link;
                    }
                    
                    echo implode('｜', $beian_parts);
                    echo '</p>';
                }
                ?>
                <p class="powered-by">
                    <?php printf(__('Theme by %s', 'lumivra'), '<a href="https://lumivra.yanqs.me" rel="noopener noreferrer" target="_blank">Lumivra</a>'); ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
