<?php
/**
 * Lumivra 主题功能文件
 *
 * @package Lumivra
 * @since 1.2.0
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

    // 加载主题文本域
    load_theme_textdomain('lumivra', get_template_directory() . '/languages');
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
    wp_enqueue_style('lumivra-style', get_stylesheet_uri(), array(), '1.2.0');
    
    // 响应式样式
    wp_enqueue_style('lumivra-responsive', get_template_directory_uri() . '/responsive.css', array('lumivra-style'), '1.2.0');

    // 主 JavaScript 文件
    wp_enqueue_script('lumivra-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.2.0', true);
    wp_script_add_data('lumivra-script', 'defer', true);

    // 将主题目录 URL 传给 JS，便于引用主题内资源（如加载占位图）
    wp_localize_script('lumivra-script', 'lumivra', array(
        'themeUrl' => get_template_directory_uri(),
    ));

    // 评论回复脚本
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
        wp_script_add_data('comment-reply', 'defer', true);
    }
}
add_action('wp_enqueue_scripts', 'lumivra_scripts');

/**
 * 移除 jQuery Migrate 以优化加载速度
 */
function lumivra_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $jquery_dependencies = $scripts->registered['jquery']->deps;
        $scripts->registered['jquery']->deps = array_diff($jquery_dependencies, array('jquery-migrate'));
    }
}
add_action('wp_default_scripts', 'lumivra_remove_jquery_migrate');

/**
 * 在页面首屏渲染前应用主题模式（深色/浅色/系统），避免闪烁。
 */
function lumivra_theme_mode_bootstrap() {
    ?>
    <script>
        (function() {
            try {
                var mode = localStorage.getItem('lumivra-theme-mode');
                var root = document.documentElement;

                if (mode === 'dark' || mode === 'light') {
                    root.setAttribute('data-theme', mode);
                    root.setAttribute('data-theme-mode', mode);
                } else {
                    root.removeAttribute('data-theme');
                    root.setAttribute('data-theme-mode', 'system');
                }
            } catch (e) {}
        })();
    </script>
    <?php
}
add_action('wp_head', 'lumivra_theme_mode_bootstrap', 0);

/**
 * 添加资源预连接以优化加载速度
 */
function lumivra_resource_hints($hints, $relation_type) {
    if ('preconnect' === $relation_type) {
        $hints[] = 'https://cravatar.cn';
        $hints[] = 'https://cdn.jsdelivr.net';
    }
    return $hints;
}
add_filter('wp_resource_hints', 'lumivra_resource_hints', 10, 2);

/**
 * 禁用 WordPress emoji 以优化加载速度
 */
function lumivra_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'lumivra_disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'lumivra_disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'lumivra_disable_emojis');

function lumivra_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

function lumivra_disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

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
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    
    // 模拟徽章等级，实际项目中可能来自数据库
    $badges = '';
    $user_id = $comment->user_id;
    if ($user_id > 0) {
        // $badges .= '<span class="badge-level">LV.1</span>'; // 移除等级显示
        if (user_can($user_id, 'administrator')) {
            $badges .= '<span class="badge-admin">管理员</span>';
        } else {
            $badges .= '<span class="badge-member">评论达人</span>';
        }
    } else {
        $badges .= '<span class="badge-guest">游客</span>';
    }

    // 系统信息
    $user_agent = $comment->comment_agent;
    $os_icon = '💻'; 
    $os_name = 'Windows';
    $browser_icon = '🌐';
    $browser_name = 'Chrome';
    
    if (strpos($user_agent, 'Mac') !== false) { $os_icon = '🍎'; $os_name = 'macOS'; }
    elseif (strpos($user_agent, 'Linux') !== false) { $os_icon = '🐧'; $os_name = 'Linux'; }
    elseif (strpos($user_agent, 'Android') !== false) { $os_icon = '🤖'; $os_name = 'Android'; }
    
    if (strpos($user_agent, 'Firefox') !== false) { $browser_icon = '🦊'; $browser_name = 'Firefox'; }
    elseif (strpos($user_agent, 'Edge') !== false) { $browser_icon = '🌊'; $browser_name = 'Edge'; }
    elseif (strpos($user_agent, 'Safari') !== false && strpos($user_agent, 'Chrome') === false) { $browser_icon = '🧭'; $browser_name = 'Safari'; }
    
    // 获取评论位置信息
    $comment_location = get_comment_meta($comment->comment_ID, 'lumivra_comment_location', true);

    // 如果位置信息不存在，且不是本地开发环境 (如果是本地IP，API可能无法解析，或者我们选择不请求)
    if (empty($comment_location) && !empty($comment->comment_author_IP) && $comment->comment_author_IP != '127.0.0.1' && $comment->comment_author_IP != '::1') {
        // 尝试获取位置信息 (对于旧评论，懒加载)
        // 注意：这里可能会影响页面加载速度，如果是大量评论的页面，建议使用异步加载或者后台任务。
        // 为了演示效果，且假设单页评论数不多，我们这里做个简单的请求，但设置较短的超时时间。
        // 在实际生产环境中，最好是在评论发布时获取，或使用 WP Cron 定时更新。
        $comment_location = lumivra_fetch_ip_location($comment->comment_author_IP);
        if ($comment_location) {
            update_comment_meta($comment->comment_ID, 'lumivra_comment_location', $comment_location);
        }
    }
    
    if (empty($comment_location)) {
        $comment_location = '火星';
    }

    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
    
    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <div class="comment-author-avatar">
            <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>
        </div>
        
        <div class="comment-main-area">
            <div class="comment-meta-header">
                <span class="comment-author-name"><?php echo get_comment_author_link(); ?></span>
                <span class="comment-badges"><?php echo $badges; ?></span>
                <span class="comment-time-wrapper">
                    <time datetime="<?php comment_time('Y-m-d H:i:s'); ?>">
                        <?php comment_time('Y-m-d H:i:s'); ?>
                    </time>
                </span>
            </div>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <div class="comment-meta-footer">
                <div class="comment-location-info">
                   <span class="info-item" title="<?php echo esc_attr($os_name); ?>"><span class="icon"><?php echo $os_icon; ?></span> <?php echo esc_html($os_name); ?></span>
                   <span class="info-item" title="<?php echo esc_attr($browser_name); ?>"><span class="icon"><?php echo $browser_icon; ?></span> <?php echo esc_html($browser_name); ?></span>
                   <span class="info-item location"><span class="icon">📍</span> 来自：<?php echo esc_html($comment_location); ?></span>
                </div>
                
                <div class="reply-button">
                    <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * 获取 IP 归属地信息
 *
 * @param string $ip IP地址
 * @return string|false 格式化的地址信息 或 false
 */
function lumivra_fetch_ip_location($ip) {
    if (empty($ip)) {
        return false;
    }

    $api_url = "https://v2.xxapi.cn/api/ip?ip=" . $ip;
    
    // 发起请求，设置较短的超时时间防止阻塞
    $response = wp_remote_get($api_url, array('timeout' => 3));

    if (is_wp_error($response)) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['code']) && $data['code'] == 200 && isset($data['data'])) {
        $address = isset($data['data']['address']) ? $data['data']['address'] : '';
        $isp = isset($data['data']['isp']) ? $data['data']['isp'] : '';
        
        // 特殊情况处理：保留地址或无ISP信息时显示未“本地”
        if ($address === '保留地址' || $isp === '0') {
            return '本地';
        }

        // 拼接地址和ISP
        $location = trim($address . ' ' . $isp);
        return $location;
    }

    return false;
}

/**
 * 评论发布时自动保存 IP 归属地信息
 * 
 * @param int $comment_id 评论ID
 */
function lumivra_save_comment_location($comment_id) {
    $comment = get_comment($comment_id);
    if ($comment) {
        $ip = $comment->comment_author_IP;
        // 避免重复获取（如果已经有了）
        if (!get_comment_meta($comment_id, 'lumivra_comment_location', true)) {
            $location = lumivra_fetch_ip_location($ip);
            if ($location) {
                update_comment_meta($comment_id, 'lumivra_comment_location', $location);
            }
        }
    }
}
add_action('comment_post', 'lumivra_save_comment_location');

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
 * GitHub 仓库展示短代码
 * 使用方法: [github]用户名/仓库名[/github]
 *
 * @param array $atts 短代码属性
 * @param string $content 短代码内容
 * @return string HTML输出
 */
function lumivra_github_shortcode($atts, $content = null) {
    if (empty($content)) {
        return '<p class="github-error">请提供 GitHub 仓库地址（格式：用户名/仓库名）</p>';
    }
    
    $repo = trim($content);
    
    // 验证仓库格式
    if (!preg_match('/^[a-zA-Z0-9_-]+\/[a-zA-Z0-9_-]+$/', $repo)) {
        return '<p class="github-error">仓库地址格式错误，正确格式：用户名/仓库名</p>';
    }
    
    // 设置缓存键
    $cache_key = 'lumivra_github_' . md5($repo);
    $cached_data = get_transient($cache_key);
    
    // 如果有缓存且未过期，直接使用缓存
    if ($cached_data !== false) {
        return $cached_data;
    }
    
    // 调用 GitHub API
    $api_url = "https://api.github.com/repos/{$repo}";
    $response = wp_remote_get($api_url, array(
        'timeout' => 5,
        'headers' => array(
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress-Lumivra-Theme'
        )
    ));
    
    if (is_wp_error($response)) {
        return '<p class="github-error">无法获取 GitHub 仓库信息</p>';
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!isset($data['id']) || isset($data['message'])) {
        return '<p class="github-error">仓库不存在或无法访问</p>';
    }
    
    // 提取仓库信息
    $repo_name = esc_html($data['full_name']);
    $description = !empty($data['description']) ? esc_html($data['description']) : '暂无描述';
    $stars = number_format($data['stargazers_count']);
    $forks = number_format($data['forks_count']);
    $watchers = number_format($data['subscribers_count']);
    $repo_url = esc_url($data['html_url']);
    
    // 生成 HTML 输出
    $output = '<div class="github-repo-card">';
    $output .= '<a href="' . $repo_url . '" target="_blank" rel="noopener noreferrer" class="github-repo-link">';
    $output .= '<div class="github-header">';
    $output .= '<svg class="github-icon" height="24" width="24" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path></svg>';
    $output .= '<span class="github-repo-name">' . $repo_name . '</span>';
    $output .= '</div>';
    $output .= '<p class="github-description">' . $description . '</p>';
    $output .= '<div class="github-stats">';
    $output .= '<span class="github-stat">';
    $output .= '<svg class="stat-icon" height="16" width="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 .25a.75.75 0 01.673.418l1.882 3.815 4.21.612a.75.75 0 01.416 1.279l-3.046 2.97.719 4.192a.75.75 0 01-1.088.791L8 12.347l-3.766 1.98a.75.75 0 01-1.088-.79l.72-4.194L.818 6.374a.75.75 0 01.416-1.28l4.21-.611L7.327.668A.75.75 0 018 .25z"></path></svg>';
    $output .= '<span class="stat-number">' . $stars . '</span>';
    $output .= '</span>';
    $output .= '<span class="github-stat">';
    $output .= '<svg class="stat-icon" height="16" width="16" viewBox="0 0 16 16" fill="currentColor"><path d="M5 3.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm0 2.122a2.25 2.25 0 10-1.5 0v.878A2.25 2.25 0 005.75 8.5h1.5v2.128a2.251 2.251 0 101.5 0V8.5h1.5a2.25 2.25 0 002.25-2.25v-.878a2.25 2.25 0 10-1.5 0v.878a.75.75 0 01-.75.75h-4.5A.75.75 0 015 6.25v-.878zm3.75 7.378a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm3-8.75a.75.75 0 100-1.5.75.75 0 000 1.5z"></path></svg>';
    $output .= '<span class="stat-number">' . $forks . '</span>';
    $output .= '</span>';
    $output .= '<span class="github-stat">';
    $output .= '<svg class="stat-icon" height="16" width="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 2c1.981 0 3.671.992 4.933 2.078 1.27 1.091 2.187 2.345 2.637 3.023a1.62 1.62 0 010 1.798c-.45.678-1.367 1.932-2.637 3.023C11.67 13.008 9.981 14 8 14c-1.981 0-3.671-.992-4.933-2.078C1.797 10.83.88 9.576.43 8.898a1.62 1.62 0 010-1.798c.45-.677 1.367-1.931 2.637-3.022C4.33 2.992 6.019 2 8 2zM1.679 7.932a.12.12 0 000 .136c.411.622 1.241 1.75 2.366 2.717C5.176 11.758 6.527 12.5 8 12.5c1.473 0 2.825-.742 3.955-1.715 1.124-.967 1.954-2.096 2.366-2.717a.12.12 0 000-.136c-.412-.621-1.242-1.75-2.366-2.717C10.824 4.242 9.473 3.5 8 3.5c-1.473 0-2.825.742-3.955 1.715-1.124.967-1.954 2.096-2.366 2.717zM8 10a2 2 0 100-4 2 2 0 000 4z"></path></svg>';
    $output .= '<span class="stat-number">' . $watchers . '</span>';
    $output .= '</span>';
    $output .= '</div>';
    $output .= '</a>';
    $output .= '</div>';
    
    // 缓存 1 小时
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    
    return $output;
}
add_shortcode('github', 'lumivra_github_shortcode');

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

/**
 * 将头像源从 secure.gravatar.com 更换为 cravatar.cn
 */
function lumivra_change_avatar_url($url) {
    return str_replace('secure.gravatar.com', 'cravatar.cn', $url);
}
add_filter('get_avatar_url', 'lumivra_change_avatar_url');
