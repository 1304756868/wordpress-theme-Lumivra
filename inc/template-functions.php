<?php
/**
 * 主题模板函数
 *
 * @package Lumivra
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 为 body 添加类
 */
function lumivra_body_classes($classes) {
    // 添加侧边栏位置类（优先从后台设置读取，其次从自定义器）
    $sidebar_position = lumivra_get_option('sidebar_position');
    if (!$sidebar_position) {
        $sidebar_position = get_theme_mod('lumivra_sidebar_position', 'right');
    }
    $classes[] = 'sidebar-' . $sidebar_position;

    // 如果没有侧边栏
    if (!is_active_sidebar('sidebar-1') || is_page_template('page-templates/full-width.php')) {
        $classes[] = 'no-sidebar';
    }

    // 如果是单篇文章且没有特色图片
    if (is_single() && !has_post_thumbnail()) {
        $classes[] = 'no-featured-image';
    }

    return $classes;
}
add_filter('body_class', 'lumivra_body_classes');

/**
 * 自定义摘要长度（使用主题选项）
 */
function lumivra_custom_excerpt_length($length) {
    // 优先从后台设置读取
    $excerpt_length = lumivra_get_option('excerpt_length');
    if ($excerpt_length) {
        return absint($excerpt_length);
    }
    // 其次从自定义器读取
    return get_theme_mod('lumivra_excerpt_length', 40);
}
add_filter('excerpt_length', 'lumivra_custom_excerpt_length', 999);

/**
 * 获取社交媒体链接
 */
function lumivra_get_social_links() {
    $social_networks = array(
        'weibo'     => '微博',
        'wechat'    => '微信',
        'douban'    => '豆瓣',
        'zhihu'     => '知乎',
        'github'    => 'GitHub',
        'twitter'   => 'Twitter',
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
    );

    $links = array();
    foreach ($social_networks as $network => $label) {
        // 优先从后台设置读取
        $url = lumivra_get_option('social_' . $network);
        if (!$url) {
            // 其次从自定义器读取
            $url = get_theme_mod('lumivra_social_' . $network);
        }
        if ($url) {
            $links[$network] = array(
                'url'   => $url,
                'label' => $label,
            );
        }
    }

    return $links;
}

/**
 * 输出社交媒体链接
 */
function lumivra_social_links() {
    $links = lumivra_get_social_links();
    
    if (empty($links)) {
        return;
    }

    echo '<div class="social-links">';
    foreach ($links as $network => $data) {
        printf(
            '<a href="%s" class="social-link social-%s" target="_blank" rel="noopener noreferrer" title="%s">%s</a>',
            esc_url($data['url']),
            esc_attr($network),
            esc_attr($data['label']),
            esc_html($data['label'])
        );
    }
    echo '</div>';
}

/**
 * 面包屑导航
 */
function lumivra_breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumbs">';
    echo '<a href="' . home_url('/') . '">' . __('首页', 'lumivra') . '</a>';
    echo ' <span class="separator">/</span> ';

    if (is_category() || is_single()) {
        the_category(' <span class="separator">/</span> ');
        if (is_single()) {
            echo ' <span class="separator">/</span> ';
            the_title();
        }
    } elseif (is_page()) {
        echo the_title();
    } elseif (is_search()) {
        echo __('搜索结果: ', 'lumivra') . get_search_query();
    } elseif (is_404()) {
        echo __('404 错误', 'lumivra');
    }

    echo '</nav>';
}

/**
 * 获取阅读时间
 */
function lumivra_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 假设每分钟阅读 200 字

    return $reading_time;
}

/**
 * 输出阅读时间
 */
function lumivra_display_reading_time() {
    $reading_time = lumivra_reading_time();
    printf(
        '<span class="reading-time">%s %s</span>',
        $reading_time,
        __('分钟阅读', 'lumivra')
    );
}

/**
 * 自定义搜索表单
 */
function lumivra_search_form($form) {
    $form = '
    <form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <label>
            <span class="screen-reader-text">' . __('搜索:', 'lumivra') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr__('搜索...', 'lumivra') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit">' . __('搜索', 'lumivra') . '</button>
    </form>';
    return $form;
}
add_filter('get_search_form', 'lumivra_search_form');
