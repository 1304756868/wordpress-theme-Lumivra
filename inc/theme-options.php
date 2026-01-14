<?php
/**
 * 主题选项设置页面
 *
 * @package Lumivra
 */

/**
 * 添加主题自定义选项
 */
function lumivra_customize_register($wp_customize) {
    
    // ============================================
    // 颜色设置
    // ============================================
    $wp_customize->add_section('lumivra_colors', array(
        'title'    => __('主题颜色', 'lumivra'),
        'priority' => 30,
    ));

    // 主色调
    $wp_customize->add_setting('lumivra_primary_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lumivra_primary_color', array(
        'label'    => __('主色调', 'lumivra'),
        'section'  => 'lumivra_colors',
        'settings' => 'lumivra_primary_color',
    )));

    // 次要色调
    $wp_customize->add_setting('lumivra_secondary_color', array(
        'default'           => '#1e40af',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lumivra_secondary_color', array(
        'label'    => __('次要色调', 'lumivra'),
        'section'  => 'lumivra_colors',
        'settings' => 'lumivra_secondary_color',
    )));

    // 文字颜色
    $wp_customize->add_setting('lumivra_text_color', array(
        'default'           => '#1f2937',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lumivra_text_color', array(
        'label'    => __('文字颜色', 'lumivra'),
        'section'  => 'lumivra_colors',
        'settings' => 'lumivra_text_color',
    )));

    // ============================================
    // 布局设置
    // ============================================
    $wp_customize->add_section('lumivra_layout', array(
        'title'    => __('布局设置', 'lumivra'),
        'priority' => 40,
    ));

    // 侧边栏位置
    $wp_customize->add_setting('lumivra_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'lumivra_sanitize_sidebar_position',
    ));

    $wp_customize->add_control('lumivra_sidebar_position', array(
        'label'    => __('侧边栏位置', 'lumivra'),
        'section'  => 'lumivra_layout',
        'type'     => 'radio',
        'choices'  => array(
            'left'  => __('左侧', 'lumivra'),
            'right' => __('右侧', 'lumivra'),
            'none'  => __('无侧边栏', 'lumivra'),
        ),
    ));

    // 容器宽度
    $wp_customize->add_setting('lumivra_container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('lumivra_container_width', array(
        'label'       => __('容器最大宽度 (px)', 'lumivra'),
        'section'     => 'lumivra_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1920,
            'step' => 10,
        ),
    ));

    // ============================================
    // 字体设置
    // ============================================
    $wp_customize->add_section('lumivra_typography', array(
        'title'    => __('字体设置', 'lumivra'),
        'priority' => 50,
    ));

    // 字体大小
    $wp_customize->add_setting('lumivra_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('lumivra_font_size', array(
        'label'       => __('基础字体大小 (px)', 'lumivra'),
        'section'     => 'lumivra_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // 字体系列
    $wp_customize->add_setting('lumivra_font_family', array(
        'default'           => 'system',
        'sanitize_callback' => 'lumivra_sanitize_font_family',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('lumivra_font_family', array(
        'label'   => __('字体系列', 'lumivra'),
        'section' => 'lumivra_typography',
        'type'    => 'select',
        'choices' => array(
            'system'    => __('系统默认', 'lumivra'),
            'serif'     => __('衬线字体', 'lumivra'),
            'noto-sans' => __('思源黑体 Noto Sans SC', 'lumivra'),
            'noto-serif'=> __('思源宋体 Noto Serif SC', 'lumivra'),
            'lxgw'      => __('霞鹜文楷 LXGW WenKai', 'lumivra'),
            'pingfang'  => __('苹方 PingFang SC', 'lumivra'),
            'source-han'=> __('Source Han Sans CN', 'lumivra'),
        ),
    ));

    // ============================================
    // 页脚设置
    // ============================================
    $wp_customize->add_section('lumivra_footer', array(
        'title'    => __('页脚设置', 'lumivra'),
        'priority' => 60,
    ));

    // 版权信息
    $wp_customize->add_setting('lumivra_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('lumivra_copyright_text', array(
        'label'    => __('版权信息', 'lumivra'),
        'section'  => 'lumivra_footer',
        'type'     => 'text',
    ));

    // 显示返回顶部按钮
    $wp_customize->add_setting('lumivra_show_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'lumivra_sanitize_checkbox',
    ));

    $wp_customize->add_control('lumivra_show_back_to_top', array(
        'label'    => __('显示"返回顶部"按钮', 'lumivra'),
        'section'  => 'lumivra_footer',
        'type'     => 'checkbox',
    ));

    // ============================================
    // 博客设置
    // ============================================
    $wp_customize->add_section('lumivra_blog', array(
        'title'    => __('博客设置', 'lumivra'),
        'priority' => 70,
    ));

    // 摘要长度
    $wp_customize->add_setting('lumivra_excerpt_length', array(
        'default'           => 40,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('lumivra_excerpt_length', array(
        'label'       => __('摘要字数', 'lumivra'),
        'section'     => 'lumivra_blog',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // ============================================
    // 社交媒体链接
    // ============================================
    $wp_customize->add_section('lumivra_social', array(
        'title'    => __('社交媒体', 'lumivra'),
        'priority' => 80,
    ));

    $social_networks = array(
        'weibo'    => __('微博', 'lumivra'),
        'wechat'   => __('微信', 'lumivra'),
        'douban'   => __('豆瓣', 'lumivra'),
        'zhihu'    => __('知乎', 'lumivra'),
        'github'   => __('GitHub', 'lumivra'),
        'twitter'  => __('Twitter', 'lumivra'),
        'facebook' => __('Facebook', 'lumivra'),
        'instagram'=> __('Instagram', 'lumivra'),
    );

    foreach ($social_networks as $social => $label) {
        $wp_customize->add_setting('lumivra_social_' . $social, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('lumivra_social_' . $social, array(
            'label'    => $label . ' ' . __('链接', 'lumivra'),
            'section'  => 'lumivra_social',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'lumivra_customize_register');

/**
 * 消毒回调函数
 */
function lumivra_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

function lumivra_sanitize_sidebar_position($input) {
    $valid = array('left', 'right', 'none');
    return (in_array($input, $valid) ? $input : 'right');
}

function lumivra_sanitize_font_family($input) {
    $valid = array('system', 'serif', 'noto-sans', 'noto-serif', 'lxgw', 'pingfang', 'source-han');
    return (in_array($input, $valid) ? $input : 'system');
}

/**
 * 输出自定义 CSS
 */
function lumivra_customize_css() {
    $primary_color = get_theme_mod('lumivra_primary_color', '#2563eb');
    $secondary_color = get_theme_mod('lumivra_secondary_color', '#1e40af');
    $text_color = get_theme_mod('lumivra_text_color', '#1f2937');
    $container_width = get_theme_mod('lumivra_container_width', 1200);
    $font_size = get_theme_mod('lumivra_font_size', 16);
    $font_family = get_theme_mod('lumivra_font_family', 'system');

    // 字体栈映射
    $font_stacks = array(
        'system'     => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
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
            --font-sans: <?php echo $font_stack; ?>;
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
add_action('wp_head', 'lumivra_customize_css');

/**
 * 自定义预览 JS
 */
function lumivra_customize_preview_js() {
    wp_enqueue_script('lumivra-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '1.2.0', true);
}
add_action('customize_preview_init', 'lumivra_customize_preview_js');
