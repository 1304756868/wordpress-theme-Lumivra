<?php
/**
 * 404 错误页面模板
 *
 * @package Lumivra
 */

get_header();
?>

<main id="main" class="site-main error-404-page">
    <div class="container">
        <section class="error-404 not-found">
            <div class="error-404-content">
                <div class="error-404-visual">
                    <div class="error-404-number">404</div>
                    <svg class="error-404-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                
                <header class="error-404-header">
                    <h1 class="error-404-title"><?php _e('页面未找到', 'lumivra'); ?></h1>
                    <p class="error-404-message"><?php _e('抱歉，您访问的页面不存在。它可能已被移动或删除。', 'lumivra'); ?></p>
                </header>

                <div class="error-404-search">
                    <?php get_search_form(); ?>
                </div>

                <div class="error-404-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <?php _e('返回首页', 'lumivra'); ?>
                    </a>
                    <a href="javascript:history.back()" class="btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        <?php _e('返回上一页', 'lumivra'); ?>
                    </a>
                </div>

                <div class="error-404-suggestions">
                    <h3><?php _e('推荐分类', 'lumivra'); ?></h3>
                    <div class="error-404-categories">
                        <?php
                        $categories = get_categories(array(
                            'orderby'    => 'count',
                            'order'      => 'DESC',
                            'number'     => 8,
                        ));
                        
                        if ($categories) :
                            foreach ($categories as $category) :
                        ?>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-badge">
                                <?php echo esc_html($category->name); ?>
                                <span class="count"><?php echo esc_html($category->count); ?></span>
                            </a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
