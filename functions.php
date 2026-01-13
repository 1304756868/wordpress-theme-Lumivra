<?php
/**
 * Lumivra 主题功能文件
 *
 * @package Lumivra
 * @since v1.1.0
 */

if (!defined('ABSPATH')) {
    exit; // 直接访问时退出
}

/**
 * 设置主题
 */
function lumivra_setup() {
    // 启用文章和评论的 RSS feed 链接
    add_theme_support('automatic-feed-links');

    // 让 WordPress 管理文档标题
    add_theme_support('title-tag');

    // 启用文章缩略图支持
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 600, true);

    // 添加额外的图片尺寸（硬裁剪模式确保尺寸一致）
    add_image_size('lumivra-featured', 1200, 600, true);  // 特色图片（横幅）
    // 调整列表缩略图为更高分辨率以提升移动端清晰度
    add_image_size('lumivra-thumbnail', 400, 280, true);  // 列表缩略图（改为 400x280，10:7 比例）
    // 额外更大尺寸供需要更高分辨率设备使用
    add_image_size('lumivra-thumbnail-lg', 800, 560, true);

    // 注册导航菜单
    register_nav_menus(array(
        'primary' => __('主导航菜单', 'lumivra'),
        'footer' => __('页脚菜单', 'lumivra'),
    ));

    // 启用 HTML5 支持
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));

    // 启用自定义 Logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // 启用自定义背景
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // 启用选择性刷新小工具
    add_theme_support('customize-selective-refresh-widgets');

    // 启用编辑器样式
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');

    // 启用宽对齐和全宽对齐
    add_theme_support('align-wide');

    // 启用响应式嵌入
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'lumivra_setup');

/**
 * 隐藏前台管理员工具栏
 */
add_filter('show_admin_bar', '__return_false');

/**
 * 设置内容宽度
 */
function lumivra_content_width() {
    $GLOBALS['content_width'] = apply_filters('lumivra_content_width', 1200);
}
add_action('after_setup_theme', 'lumivra_content_width', 0);

/**
 * 注册小工具区域
 */
function lumivra_widgets_init() {
    register_sidebar(array(
        'name'          => __('侧边栏', 'lumivra'),
        'id'            => 'sidebar-1',
        'description'   => __('添加小工具到主侧边栏', 'lumivra'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('页脚区域 1', 'lumivra'),
        'id'            => 'footer-1',
        'description'   => __('添加小工具到页脚第一栏', 'lumivra'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('页脚区域 2', 'lumivra'),
        'id'            => 'footer-2',
        'description'   => __('添加小工具到页脚第二栏', 'lumivra'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('页脚区域 3', 'lumivra'),
        'id'            => 'footer-3',
        'description'   => __('添加小工具到页脚第三栏', 'lumivra'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'lumivra_widgets_init');

/**
 * 设置默认侧边栏小工具
 */
function lumivra_setup_default_widgets() {
    // 检查是否已经设置过默认小工具
    $widgets_set = get_option('lumivra_default_widgets_set');
    
    if (!$widgets_set) {
        // 获取当前侧边栏小工具
        $sidebars_widgets = get_option('sidebars_widgets', array());
        
        // 如果侧边栏为空，则添加默认小工具
        if (empty($sidebars_widgets['sidebar-1']) || !is_array($sidebars_widgets['sidebar-1'])) {
            
            // 设置搜索小工具
            $search_widget = get_option('widget_search', array());
            $search_id = count($search_widget) + 1;
            $search_widget[$search_id] = array('title' => '搜索');
            update_option('widget_search', $search_widget);
            
            // 设置近期文章小工具
            $recent_posts = get_option('widget_recent-posts', array());
            $recent_posts_id = count($recent_posts) + 1;
            $recent_posts[$recent_posts_id] = array(
                'title' => '近期文章',
                'number' => 5,
                'show_date' => true
            );
            update_option('widget_recent-posts', $recent_posts);
            
            // 设置近期评论小工具
            $recent_comments = get_option('widget_recent-comments', array());
            $recent_comments_id = count($recent_comments) + 1;
            $recent_comments[$recent_comments_id] = array(
                'title' => '近期评论',
                'number' => 5
            );
            update_option('widget_recent-comments', $recent_comments);
            
            // 设置分类小工具
            $categories = get_option('widget_categories', array());
            $categories_id = count($categories) + 1;
            $categories[$categories_id] = array(
                'title' => '分类',
                'count' => 1,
                'hierarchical' => 0,
                'dropdown' => 0
            );
            update_option('widget_categories', $categories);
            
            // 设置标签云小工具
            $tag_cloud = get_option('widget_tag_cloud', array());
            $tag_cloud_id = count($tag_cloud) + 1;
            $tag_cloud[$tag_cloud_id] = array(
                'title' => '标签',
                'taxonomy' => 'post_tag'
            );
            update_option('widget_tag_cloud', $tag_cloud);
            
            // 将小工具添加到侧边栏
            $sidebars_widgets['sidebar-1'] = array(
                'search-' . $search_id,
                'recent-posts-' . $recent_posts_id,
                'recent-comments-' . $recent_comments_id,
                'categories-' . $categories_id,
                'tag_cloud-' . $tag_cloud_id
            );
            
            // 更新侧边栏小工具配置
            update_option('sidebars_widgets', $sidebars_widgets);
        }
        
        // 标记为已设置
        update_option('lumivra_default_widgets_set', true);
    }
}
add_action('after_switch_theme', 'lumivra_setup_default_widgets');

/**
 * 加载脚本和样式
 */
function lumivra_scripts() {
    // 主样式表
    wp_enqueue_style('lumivra-style', get_stylesheet_uri(), array(), 'v1.1.0');
    
    // 响应式样式
    wp_enqueue_style('lumivra-responsive', get_template_directory_uri() . '/responsive.css', array('lumivra-style'), 'v1.1.0');

    // 主 JavaScript 文件
    wp_enqueue_script('lumivra-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), 'v1.1.0', true);

    // 将主题目录 URL 传给 JS，便于引用主题内资源（如加载占位图）
    wp_localize_script('lumivra-script', 'lumivra', array(
        'themeUrl' => get_template_directory_uri(),
    ));

    // 评论回复脚本
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'lumivra_scripts');

/**
 * 获取随机默认缩略图 URL（当文章没有特色图时使用）
 *
 * @return string 绝对 URL
 */
function lumivra_get_random_default_thumbnail_url() {
    $uri_base = get_template_directory_uri() . '/assets/png/random/';
    $dir = get_template_directory() . '/assets/png/random/';

    $files = glob($dir . '*.{png,jpg,jpeg,svg}', GLOB_BRACE);
    if (empty($files)) {
        return $uri_base . 'default.svg';
    }

    $file = $files[array_rand($files)];
    return $uri_base . basename($file);
}

/**
 * 自定义摘要长度
 */
function lumivra_excerpt_length($length) {
    return 40;
}
add_filter('excerpt_length', 'lumivra_excerpt_length', 999);

/**
 * 自定义摘要省略号
 */
function lumivra_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'lumivra_excerpt_more');

/**
 * 自定义分页
 */
function lumivra_pagination() {
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max   = intval($wp_query->max_num_pages);
    $is_mobile = wp_is_mobile();

    // 在移动端减少显示的页码数量
    $range = $is_mobile ? 1 : 2;

    if ($paged >= 1) {
        $links[] = $paged;
    }

    if ($paged >= ($range + 1)) {
        for ($i = $range; $i >= 1; $i--) {
            $links[] = $paged - $i;
        }
    }

    if (($paged + $range) <= $max) {
        for ($i = 1; $i <= $range; $i++) {
            $links[] = $paged + $i;
        }
    }

    echo '<div class="pagination' . ($is_mobile ? ' pagination-mobile' : '') . '"><div class="container">';

    if (get_previous_posts_link()) {
        printf('<a href="%s" class="prev">%s</a>', get_previous_posts_page_link(), __('&laquo; 上一页', 'lumivra'));
    }

    if ($is_mobile) {
        // 移动端只显示当前页码
        printf('<span class="current-page">%s / %s</span>', $paged, $max);
    } else {
        // 桌面端显示完整分页
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' current' : '';
            printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link(1)), $class, '1');

            if (!in_array(2, $links)) {
                echo '<span>…</span>';
            }
        }

        sort($links);
        foreach ((array) $links as $link) {
            $class = $paged == $link ? ' current' : '';
            printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link($link)), $class, $link);
        }

        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links)) {
                echo '<span>…</span>';
            }

            $class = $paged == $max ? ' current' : '';
            printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link($max)), $class, $max);
        }
    }

    if (get_next_posts_link()) {
        printf('<a href="%s" class="next">%s</a>', get_next_posts_page_link(), __('下一页 &raquo;', 'lumivra'));
    }

    echo '</div></div>';
}

/**
 * 添加"返回顶部"功能
 */
function lumivra_back_to_top() {
    // 检查是否启用返回顶部按钮（优先从后台设置读取）
    $show_back_to_top = lumivra_get_option('show_back_to_top', '1');
    if (!$show_back_to_top || $show_back_to_top === '0') {
        // 如果后台设置未启用，再检查自定义器
        $show_back_to_top = get_theme_mod('lumivra_show_back_to_top', true);
    }
    
    if ($show_back_to_top && $show_back_to_top !== '0') {
        echo '<a href="#" id="back-to-top" class="back-to-top" style="display: none;">↑</a>';
    }
}
add_action('wp_footer', 'lumivra_back_to_top');

/**
 * 自定义评论列表
 */
function lumivra_comment($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                    <?php printf('<b class="fn">%s</b>', get_comment_author_link()); ?>
                </div>
                <div class="comment-metadata">
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php printf('%1$s %2$s', get_comment_date(), get_comment_time()); ?>
                        </time>
                    </a>
                </div>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <div class="reply">
                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                )));
                ?>
            </div>
        </article>
    <?php
}

/**
 * 加载主题选项（自定义器）
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * 加载后台设置页面
 */
require get_template_directory() . '/inc/admin-settings.php';

/**
 * 加载自定义函数
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * 自定义登录页面样式
 */
function lumivra_login_styles() {
    // 加载外部CSS文件
    wp_enqueue_style(
        'lumivra-login',
        get_template_directory_uri() . '/assets/css/login.css',
        array(),
        '1.0.0'
    );
    
    // 添加动态CSS变量
    $primary_color = get_theme_mod('lumivra_primary_color', '#2563eb');
    $blog_name = get_bloginfo('name');
    
    $custom_css = "
        :root {
            --lumivra-primary-color: {$primary_color};
        }
        #login {
            --site-name: '{$blog_name}';
        }
    ";
    
    wp_add_inline_style('lumivra-login', $custom_css);
    
    // 添加JavaScript设置站点名称（因为CSS attr()不能用于::after content）
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var loginDiv = document.getElementById('login');
            if (loginDiv) {
                loginDiv.setAttribute('data-site-name', '<?php echo esc_js($blog_name); ?>');
            }
        });
    </script>
    <?php
}
add_action('login_enqueue_scripts', 'lumivra_login_styles');

/**
 * 修改登录页面Logo链接
 */
function lumivra_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'lumivra_login_logo_url');

/**
 * 修改登录页面Logo标题
 */
function lumivra_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'lumivra_login_logo_url_title');

/**
 * 自定义首页文档标题为 “站点标题｜站点副标题”。
 */
function lumivra_custom_home_title($title) {
    if (is_front_page() || is_home()) {
        $site_name = get_bloginfo('name');
        $site_desc = trim(get_bloginfo('description'));
        if (!empty($site_desc)) {
            return $site_name . '｜' . $site_desc;
        }
        return $site_name;
    }
    return $title;
}
add_filter('pre_get_document_title', 'lumivra_custom_home_title', 10, 1);
