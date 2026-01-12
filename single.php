<?php
/**
 * 单篇文章模板
 *
 * @package Lumivra
 */

get_header();
?>

<div class="site-content">
    <div class="container">
        <main id="main" class="site-main single-post">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        
                        <div class="entry-meta">
                            <span class="posted-on">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </span>
                            <span class="byline">
                                <?php printf(__('作者: %s', 'lumivra'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author() . '</a>'); ?>
                            </span>
                            <?php if (has_category()) : ?>
                                <span class="cat-links">
                                    <?php _e('分类: ', 'lumivra'); ?><?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                            <?php if (has_tag()) : ?>
                                <span class="tags-links">
                                    <?php _e('标签: ', 'lumivra'); ?><?php the_tags('', ', ', ''); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('页面:', 'lumivra'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        // 文章导航
                        the_post_navigation(array(
                            'prev_text' => '<span class="nav-subtitle">' . __('上一篇', 'lumivra') . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . __('下一篇', 'lumivra') . '</span> <span class="nav-title">%title</span>',
                        ));
                        ?>
                    </footer>
                </article>

                <?php
                // 如果评论开启或有评论，则加载评论模板
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile;
            ?>
        </main>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
