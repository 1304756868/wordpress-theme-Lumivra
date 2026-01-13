<?php
/**
 * 页面模板
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
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('lumivra-featured'); ?>
                        </div>
                    <?php else : ?>
                        <div class="post-thumbnail">
                            <img src="<?php echo esc_url( lumivra_get_random_default_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>" />
                        </div>
                    <?php endif; ?>

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
                        // 可选的页面导航（保持空以备后用）
                        ?>
                    </footer>
                </article>

                <?php
                // 将评论模板放在文章后（与单篇文章布局一致）
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
