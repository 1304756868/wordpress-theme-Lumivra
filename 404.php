<?php
/**
 * 404 错误页面模板
 *
 * @package Lumivra
 */

get_header();
?>

<main id="main" class="site-main">
    <div class="container">
        <section class="error-404 not-found text-center">
            <header class="page-header">
                <h1 class="page-title"><?php _e('404', 'lumivra'); ?></h1>
                <p class="error-message"><?php _e('页面未找到', 'lumivra'); ?></p>
            </header>

            <div class="page-content">
                <p><?php _e('抱歉，您访问的页面不存在。它可能已被移动或删除。', 'lumivra'); ?></p>

                <?php get_search_form(); ?>

                <div class="widget widget_categories mt-4">
                    <h2 class="widget-title"><?php _e('浏览分类', 'lumivra'); ?></h2>
                    <ul>
                        <?php
                        wp_list_categories(array(
                            'orderby'    => 'count',
                            'order'      => 'DESC',
                            'show_count' => 1,
                            'title_li'   => '',
                            'number'     => 10,
                        ));
                        ?>
                    </ul>
                </div>

                <div class="mt-4">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="read-more">
                        <?php _e('返回首页', 'lumivra'); ?>
                    </a>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
