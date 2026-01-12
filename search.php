<?php
/**
 * 搜索结果模板
 *
 * @package Lumivra
 */

get_header();
?>

<div class="site-content">
    <div class="container">
        <main id="main" class="site-main">
            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        printf(
                            __('搜索结果: %s', 'lumivra'),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                </header>

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
                                    <?php the_post_thumbnail('lumivra-thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; endif; ?>

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
                                <span class="post-type">
                                    <?php echo get_post_type(); ?>
                                </span>
                            </div>

                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php lumivra_pagination(); ?>

        <?php else : ?>

            <div class="no-results">
                <h1 class="page-title"><?php _e('未找到相关内容', 'lumivra'); ?></h1>
                <div class="page-content">
                    <p><?php _e('抱歉，没有找到与您的搜索相关的内容。请尝试其他关键词。', 'lumivra'); ?></p>
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
