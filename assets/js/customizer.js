/**
 * Lumivra 自定义器预览 JavaScript
 *
 * @package Lumivra
 */

(function($) {
    'use strict';

    // 主色调
    wp.customize('lumivra_primary_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--primary-color', newval);
        });
    });

    // 次要色调
    wp.customize('lumivra_secondary_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--secondary-color', newval);
        });
    });

    // 文字颜色
    wp.customize('lumivra_text_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--text-color', newval);
        });
    });

    // 容器宽度
    wp.customize('lumivra_container_width', function(value) {
        value.bind(function(newval) {
            $(':root').css('--max-width', newval + 'px');
        });
    });

    // 字体大小
    wp.customize('lumivra_font_size', function(value) {
        value.bind(function(newval) {
            $('html').css('font-size', newval + 'px');
        });
    });

    // 网站标题
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.site-title a').text(newval);
        });
    });

    // 网站描述
    wp.customize('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

    // 版权信息
    wp.customize('lumivra_copyright_text', function(value) {
        value.bind(function(newval) {
            $('.site-info p').text(newval);
        });
    });

})(jQuery);
