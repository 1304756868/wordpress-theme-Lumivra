<?php
/**
 * Lumivra 主题后台设置页面
 *
 * @package Lumivra
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 添加主题设置菜单
 */
function lumivra_add_admin_menu() {
    add_theme_page(
        'Lumivra 主题设置',           // 页面标题
        'Lumivra 设置',               // 菜单标题
        'manage_options',             // 权限
        'lumivra-settings',           // 菜单别名
        'lumivra_settings_page',      // 回调函数
        30                            // 位置
    );
}
add_action('admin_menu', 'lumivra_add_admin_menu');

/**
 * 注册设置
 */
function lumivra_settings_init() {
    // 注册设置组
    register_setting('lumivra_settings', 'lumivra_options', 'lumivra_validate_options');

    // ========================================
    // 颜色设置
    // ========================================
    add_settings_section(
        'lumivra_colors_section',
        '颜色设置',
        'lumivra_colors_section_callback',
        'lumivra_settings'
    );

    add_settings_field(
        'primary_color',
        '主色调',
        'lumivra_color_field_render',
        'lumivra_settings',
        'lumivra_colors_section',
        array('field' => 'primary_color', 'default' => '#2563eb')
    );

    add_settings_field(
        'secondary_color',
        '次要色调',
        'lumivra_color_field_render',
        'lumivra_settings',
        'lumivra_colors_section',
        array('field' => 'secondary_color', 'default' => '#1e40af')
    );

    add_settings_field(
        'text_color',
        '文字颜色',
        'lumivra_color_field_render',
        'lumivra_settings',
        'lumivra_colors_section',
        array('field' => 'text_color', 'default' => '#1f2937')
    );

    // ========================================
    // 布局设置
    // ========================================
    add_settings_section(
        'lumivra_layout_section',
        '布局设置',
        'lumivra_layout_section_callback',
        'lumivra_settings'
    );

    add_settings_field(
        'sidebar_position',
        '侧边栏位置',
        'lumivra_select_field_render',
        'lumivra_settings',
        'lumivra_layout_section',
        array(
            'field' => 'sidebar_position',
            'options' => array(
                'left' => '左侧',
                'right' => '右侧',
                'none' => '无侧边栏'
            ),
            'default' => 'right'
        )
    );

    add_settings_field(
        'container_width',
        '容器最大宽度 (px)',
        'lumivra_number_field_render',
        'lumivra_settings',
        'lumivra_layout_section',
        array('field' => 'container_width', 'default' => '1200', 'min' => '960', 'max' => '1920')
    );

    // ========================================
    // 字体设置
    // ========================================
    add_settings_section(
        'lumivra_typography_section',
        '字体设置',
        'lumivra_typography_section_callback',
        'lumivra_settings'
    );

    add_settings_field(
        'font_size',
        '基础字体大小 (px)',
        'lumivra_number_field_render',
        'lumivra_settings',
        'lumivra_typography_section',
        array('field' => 'font_size', 'default' => '16', 'min' => '12', 'max' => '24')
    );

    add_settings_field(
        'font_family',
        '字体系列',
        'lumivra_select_field_render',
        'lumivra_settings',
        'lumivra_typography_section',
        array(
            'field' => 'font_family',
            'options' => array(
                'system'     => '系统默认',
                'serif'      => '衬线字体',
                'noto-sans'  => '思源黑体 Noto Sans SC',
                'noto-serif' => '思源宋体 Noto Serif SC',
                'lxgw'       => '霞鹜文楷 LXGW WenKai',
                'pingfang'   => '苹方 PingFang SC',
                'source-han' => 'Source Han Sans CN'
            ),
            'default' => 'system'
        )
    );

    // ========================================
    // 博客设置
    // ========================================
    add_settings_section(
        'lumivra_blog_section',
        '博客设置',
        'lumivra_blog_section_callback',
        'lumivra_settings'
    );

    add_settings_field(
        'excerpt_length',
        '摘要字数',
        'lumivra_number_field_render',
        'lumivra_settings',
        'lumivra_blog_section',
        array('field' => 'excerpt_length', 'default' => '40', 'min' => '10', 'max' => '100')
    );

    // ========================================
    // 页脚设置
    // ========================================
    add_settings_section(
        'lumivra_footer_section',
        '页脚设置',
        'lumivra_footer_section_callback',
        'lumivra_settings'
    );

    add_settings_field(
        'copyright_text',
        '版权信息',
        'lumivra_text_field_render',
        'lumivra_settings',
        'lumivra_footer_section',
        array('field' => 'copyright_text', 'placeholder' => '例如：保留所有权利')
    );

    add_settings_field(
        'show_back_to_top',
        '返回顶部按钮',
        'lumivra_checkbox_field_render',
        'lumivra_settings',
        'lumivra_footer_section',
        array('field' => 'show_back_to_top', 'label' => '显示"返回顶部"按钮')
    );

    add_settings_field(
        'miit_beian',
        '工信部备案号',
        'lumivra_text_field_render',
        'lumivra_settings',
        'lumivra_footer_section',
        array('field' => 'miit_beian', 'placeholder' => '例如：浙ICP备12345678号')
    );

    add_settings_field(
        'police_beian',
        '公安备案号',
        'lumivra_text_field_render',
        'lumivra_settings',
        'lumivra_footer_section',
        array('field' => 'police_beian', 'placeholder' => '例如：浙公网安备33010002000123号')
    );

    add_settings_field(
        'police_beian_url',
        '公安备案跳转链接',
        'lumivra_url_field_render',
        'lumivra_settings',
        'lumivra_footer_section',
        array('field' => 'police_beian_url', 'placeholder' => 'https://beian.mps.gov.cn/#/query/webSearch?code=123456789')
    );

    // ========================================
    // 社交媒体设置
    // ========================================
    add_settings_section(
        'lumivra_social_section',
        '社交媒体链接',
        'lumivra_social_section_callback',
        'lumivra_settings'
    );

    $social_networks = array(
        'weibo' => '微博',
        'wechat' => '微信',
        'douban' => '豆瓣',
        'zhihu' => '知乎',
        'github' => 'GitHub',
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram'
    );

    foreach ($social_networks as $network => $label) {
        add_settings_field(
            'social_' . $network,
            $label . ' 链接',
            'lumivra_url_field_render',
            'lumivra_settings',
            'lumivra_social_section',
            array('field' => 'social_' . $network, 'placeholder' => 'https://')
        );
    }
}
add_action('admin_init', 'lumivra_settings_init');

/**
 * 设置区块说明回调
 */
function lumivra_colors_section_callback() {
    echo '<p>自定义主题的颜色方案，使其与您的品牌风格保持一致。</p>';
}

function lumivra_layout_section_callback() {
    echo '<p>调整网站的布局和结构设置。</p>';
}

function lumivra_typography_section_callback() {
    echo '<p>控制网站的字体大小和字体系列。</p>';
}

function lumivra_blog_section_callback() {
    echo '<p>自定义博客文章的显示选项。</p>';
}

function lumivra_footer_section_callback() {
    echo '<p>配置网站页脚的显示内容。</p>';
}

function lumivra_social_section_callback() {
    echo '<p>添加您的社交媒体账号链接。留空则不显示该社交媒体图标。</p>';
}

/**
 * 字段渲染函数
 */
function lumivra_color_field_render($args) {
    $options = get_option('lumivra_options');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : $args['default'];
    ?>
    <input type="color" name="lumivra_options[<?php echo esc_attr($args['field']); ?>]" 
           value="<?php echo esc_attr($value); ?>" class="lumivra-color-picker">
    <span class="description">默认：<?php echo esc_html($args['default']); ?></span>
    <?php
}

function lumivra_text_field_render($args) {
    $options = get_option('lumivra_options');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    ?>
    <input type="text" name="lumivra_options[<?php echo esc_attr($args['field']); ?>]" 
           value="<?php echo esc_attr($value); ?>" 
           placeholder="<?php echo esc_attr($placeholder); ?>"
           class="regular-text">
    <?php
}

function lumivra_url_field_render($args) {
    $options = get_option('lumivra_options');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '';
    $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
    ?>
    <input type="url" name="lumivra_options[<?php echo esc_attr($args['field']); ?>]" 
           value="<?php echo esc_attr($value); ?>" 
           placeholder="<?php echo esc_attr($placeholder); ?>"
           class="regular-text">
    <?php
}

function lumivra_number_field_render($args) {
    $options = get_option('lumivra_options');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : $args['default'];
    $min = isset($args['min']) ? $args['min'] : '';
    $max = isset($args['max']) ? $args['max'] : '';
    ?>
    <input type="number" name="lumivra_options[<?php echo esc_attr($args['field']); ?>]" 
           value="<?php echo esc_attr($value); ?>" 
           min="<?php echo esc_attr($min); ?>"
           max="<?php echo esc_attr($max); ?>"
           class="small-text">
    <?php if (isset($args['default'])) : ?>
        <span class="description">默认：<?php echo esc_html($args['default']); ?></span>
    <?php endif; ?>
    <?php
}

function lumivra_select_field_render($args) {
    $options = get_option('lumivra_options');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : $args['default'];
    ?>
    <select name="lumivra_options[<?php echo esc_attr($args['field']); ?>]">
        <?php foreach ($args['options'] as $key => $label) : ?>
            <option value="<?php echo esc_attr($key); ?>" <?php selected($value, $key); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

function lumivra_checkbox_field_render($args) {
    $options = get_option('lumivra_options');
    $value = isset($options[$args['field']]) ? $options[$args['field']] : '1';
    ?>
    <label>
        <input type="checkbox" name="lumivra_options[<?php echo esc_attr($args['field']); ?>]" 
               value="1" <?php checked($value, '1'); ?>>
        <?php echo esc_html($args['label']); ?>
    </label>
    <?php
}

/**
 * 验证和清理输入
 */
function lumivra_validate_options($input) {
    $output = array();

    // 验证颜色
    if (isset($input['primary_color'])) {
        $output['primary_color'] = sanitize_hex_color($input['primary_color']);
    }
    if (isset($input['secondary_color'])) {
        $output['secondary_color'] = sanitize_hex_color($input['secondary_color']);
    }
    if (isset($input['text_color'])) {
        $output['text_color'] = sanitize_hex_color($input['text_color']);
    }

    // 验证布局
    if (isset($input['sidebar_position'])) {
        $valid = array('left', 'right', 'none');
        $output['sidebar_position'] = in_array($input['sidebar_position'], $valid) ? $input['sidebar_position'] : 'right';
    }
    if (isset($input['container_width'])) {
        $output['container_width'] = absint($input['container_width']);
    }

    // 验证字体
    if (isset($input['font_size'])) {
        $output['font_size'] = absint($input['font_size']);
    }
    if (isset($input['font_family'])) {
        $valid = array('system', 'serif', 'noto-sans', 'noto-serif', 'lxgw', 'pingfang', 'source-han');
        $output['font_family'] = in_array($input['font_family'], $valid) ? $input['font_family'] : 'system';
    }

    // 验证博客设置
    if (isset($input['excerpt_length'])) {
        $output['excerpt_length'] = absint($input['excerpt_length']);
    }

    // 验证页脚
    if (isset($input['copyright_text'])) {
        $output['copyright_text'] = sanitize_text_field($input['copyright_text']);
    }
    $output['show_back_to_top'] = isset($input['show_back_to_top']) ? '1' : '0';

    // 验证备案信息
    if (isset($input['miit_beian'])) {
        $output['miit_beian'] = sanitize_text_field($input['miit_beian']);
    }
    if (isset($input['police_beian'])) {
        $output['police_beian'] = sanitize_text_field($input['police_beian']);
    }
    if (isset($input['police_beian_url'])) {
        $output['police_beian_url'] = esc_url_raw($input['police_beian_url']);
    }

    // 验证社交媒体链接
    $social_networks = array('weibo', 'wechat', 'douban', 'zhihu', 'github', 'twitter', 'facebook', 'instagram');
    foreach ($social_networks as $network) {
        $field = 'social_' . $network;
        if (isset($input[$field])) {
            $output[$field] = esc_url_raw($input[$field]);
        }
    }

    return $output;
}

/**
 * 渲染设置页面
 */
function lumivra_settings_page() {
    ?>
    <div class="wrap lumivra-settings-wrap">
        <h1>
            <span class="dashicons dashicons-admin-appearance" style="font-size: 32px; vertical-align: middle;"></span>
            Lumivra 主题设置
        </h1>
        
        <p class="description">自定义您的 Lumivra 主题外观和功能。更改设置后，请点击"保存更改"按钮。</p>

        <div class="lumivra-settings-container">
            <div class="lumivra-settings-main">
                <form action="options.php" method="post">
                    <?php
                    settings_fields('lumivra_settings');
                    do_settings_sections('lumivra_settings');
                    submit_button('保存更改', 'primary large');
                    ?>
                </form>
            </div>

            <div class="lumivra-settings-sidebar">
                <div class="lumivra-settings-box">
                    <h3>
                        <span class="dashicons dashicons-info"></span>
                        关于 Lumivra
                    </h3>
                    <p><strong>版本：</strong> 1.1.0</p>
                    <p><strong>作者：</strong> <a href="https://yanqs.me/" target="_blank">YanQS</a></p>
                    <p class="description">Lumivra 是一个简洁、现代、富有设计感的 WordPress 主题。</p>
                </div>

                <div class="lumivra-settings-box">
                    <h3>
                        <span class="dashicons dashicons-book"></span>
                        快速链接
                    </h3>
                    <ul>
                        <li><a href="<?php echo admin_url('customize.php'); ?>">主题自定义器</a></li>
                        <li><a href="<?php echo admin_url('nav-menus.php'); ?>">管理菜单</a></li>
                        <li><a href="<?php echo admin_url('widgets.php'); ?>">管理小工具</a></li>
                        <li><a href="<?php echo admin_url('themes.php'); ?>">主题管理</a></li>
                    </ul>
                </div>

                <div class="lumivra-settings-box">
                    <h3>
                        <span class="dashicons dashicons-sos"></span>
                        需要帮助？
                    </h3>
                    <p>查看我们的文档以获取详细的使用说明。</p>
                    <p>
                        <a href="https://lumivra.yanqs.me/doc" class="button button-secondary" target="_blank">查看文档</a>
                    </p>
                </div>

                <div class="lumivra-settings-box lumivra-tips">
                    <h3>
                        <span class="dashicons dashicons-lightbulb"></span>
                        使用技巧
                    </h3>
                    <ul>
                        <li>💡 为每篇文章设置特色图片可获得更好的视觉效果</li>
                        <li>💡 使用小工具来丰富侧边栏内容</li>
                        <li>💡 调整颜色方案以匹配您的品牌</li>
                        <li>💡 定期更新主题以获得最新功能</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        .lumivra-settings-wrap {
            margin: 20px 20px 0 0;
        }
        .lumivra-settings-wrap h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .lumivra-settings-container {
            display: flex;
            gap: 30px;
            margin-top: 30px;
        }
        .lumivra-settings-main {
            flex: 1;
            background: #fff;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .lumivra-settings-main h2 {
            margin-top: 0;
            padding-top: 20px;
            border-top: 2px solid #2563eb;
            color: #1f2937;
            font-size: 20px;
        }
        .lumivra-settings-main h2:first-child {
            margin-top: 0;
            padding-top: 0;
            border-top: none;
        }
        .lumivra-settings-main .form-table {
            margin-top: 20px;
        }
        .lumivra-settings-main .form-table th {
            font-weight: 600;
            color: #1f2937;
        }
        .lumivra-settings-sidebar {
            width: 300px;
            flex-shrink: 0;
        }
        .lumivra-settings-box {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .lumivra-settings-box h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .lumivra-settings-box h3 .dashicons {
            color: #2563eb;
        }
        .lumivra-settings-box p {
            margin: 10px 0;
            font-size: 14px;
            line-height: 1.6;
        }
        .lumivra-settings-box ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .lumivra-settings-box ul li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .lumivra-settings-box ul li:last-child {
            border-bottom: none;
        }
        .lumivra-settings-box ul li a {
            text-decoration: none;
            color: #2563eb;
        }
        .lumivra-settings-box ul li a:hover {
            color: #1e40af;
        }
        .lumivra-tips ul li {
            border: none;
            padding: 5px 0;
        }
        .lumivra-color-picker {
            width: 80px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-table .description {
            display: block;
            margin-top: 8px;
            color: #666;
            font-style: italic;
        }
        @media screen and (max-width: 1200px) {
            .lumivra-settings-container {
                flex-direction: column;
            }
            .lumivra-settings-sidebar {
                width: 100%;
            }
        }
    </style>
    <?php
}

/**
 * 获取主题选项（辅助函数）
 */
function lumivra_get_option($key, $default = '') {
    $options = get_option('lumivra_options');
    return isset($options[$key]) ? $options[$key] : $default;
}

/**
 * 输出自定义 CSS（基于后台设置）
 */
function lumivra_admin_custom_css() {
    $primary_color = lumivra_get_option('primary_color', '#2563eb');
    $secondary_color = lumivra_get_option('secondary_color', '#1e40af');
    $text_color = lumivra_get_option('text_color', '#1f2937');
    $container_width = lumivra_get_option('container_width', '1200');
    $font_size = lumivra_get_option('font_size', '16');
    $font_family = lumivra_get_option('font_family', 'system');

    // 字体栈映射
    $font_stacks = array(
        'system'     => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif',
        'serif'      => 'Georgia, Cambria, "Times New Roman", Times, serif',
        'noto-sans'  => '"Noto Sans SC", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'noto-serif' => '"Noto Serif SC", Georgia, Cambria, "Times New Roman", Times, serif',
        'lxgw'       => '"LXGW WenKai", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'pingfang'   => '"PingFang SC", -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif',
        'source-han' => '"Source Han Sans CN", "Noto Sans SC", -apple-system, sans-serif',
    );

    $font_stack = isset($font_stacks[$font_family]) ? $font_stacks[$font_family] : $font_stacks['system'];

    // Google Fonts / 在线字体 CDN
    $font_imports = '';
    if ($font_family === 'noto-sans') {
        $font_imports = '@import url("https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap");';
    } elseif ($font_family === 'noto-serif') {
        $font_imports = '@import url("https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;500;700&display=swap");';
    } elseif ($font_family === 'lxgw') {
        $font_imports = '@import url("https://cdn.jsdelivr.net/npm/lxgw-wenkai-webfont@1.1.0/style.css");';
    } elseif ($font_family === 'source-han') {
        $font_imports = '@import url("https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap");';
    }

    ?>
    <style type="text/css">
        <?php echo $font_imports; ?>
        
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --text-color: <?php echo esc_attr($text_color); ?>;
            --max-width: <?php echo esc_attr($container_width); ?>px;
            --font-sans: <?php echo esc_attr($font_stack); ?>;
        }
        html {
            font-size: <?php echo esc_attr($font_size); ?>px;
        }
        body {
            font-family: var(--font-sans);
        }
    </style>
    <?php
}
add_action('wp_head', 'lumivra_admin_custom_css');

/**
 * 添加设置链接到主题列表
 */
function lumivra_add_theme_page_link($actions, $theme) {
    if ($theme->get_stylesheet() === get_stylesheet()) {
        $actions['lumivra-settings'] = '<a href="' . admin_url('themes.php?page=lumivra-settings') . '">主题设置</a>';
    }
    return $actions;
}
add_filter('theme_action_links', 'lumivra_add_theme_page_link', 10, 2);
