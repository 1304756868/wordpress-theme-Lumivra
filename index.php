<?php
/**
 * 主模板文件
 *
 * @package Lumivra
 */

get_header();
?>

<div class="site-content">
    <div class="container">
        <main id="main" class="site-main">
            <?php if (have_posts()) : ?>

                <?php if (is_home() && !is_front_page()) : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <div class="posts-list">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <?php if (has_post_thumbnail()) : 
                                $thumbnail_id = get_post_thumbnail_id();
                                $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'lumivra-thumbnail');
                                if ($thumbnail_url) : 
                            ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo wp_get_attachment_image( $thumbnail_id, 'lumivra-thumbnail', false, array('sizes' => '(max-width: 768px) 800px, 400px', 'alt' => get_the_title() ) ); ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( lumivra_get_random_default_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>" />
                                    </a>
                                </div>
                            <?php endif; else : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( lumivra_get_random_default_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>" />
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="post-meta">
                                    <span class="post-date">
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                    <span class="post-author">
                                        <?php printf(__('作者: %s', 'lumivra'), get_the_author()); ?>
                                    </span>
                                    <?php if (has_category()) : ?>
                                        <span class="post-categories">
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php 
                if (is_home() || (is_front_page() && is_home())) {
                    // 首页显示加载更多
                    global $wp_query;
                    if ($wp_query->max_num_pages > 1) {
                        $next_page_link = get_next_posts_page_link();
                        if ($next_page_link) {
                            echo '<div class="load-more-container">';
                            echo '<button id="load-more-posts" data-next-page="' . esc_url($next_page_link) . '">' . __('点击加载更多', 'lumivra') . '</button>';
                            echo '<div class="load-more-loading"><span></span><span></span><span></span></div>';
                            echo '</div>';
                        }
                    }
                } else {
                    // 其他页面使用常规分页
                    lumivra_pagination(); 
                }
                ?>

            <?php else : ?>

                <div class="no-results">
                    <h1 class="page-title"><?php _e('未找到内容', 'lumivra'); ?></h1>
                    <div class="page-content">
                        <p><?php _e('抱歉，没有找到相关内容。请尝试使用搜索功能。', 'lumivra'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </div>

            <?php endif; ?>
        </main>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
