/**
 * Lumivra 主题 JavaScript
 *
 * @package Lumivra
 */

(function($) {
    'use strict';

    // 当文档加载完成
    $(document).ready(function() {
        
        // ============================================
        // 移动端菜单切换
        // ============================================
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('toggled');
            $('body').toggleClass('menu-open');
            // 同步 aria-expanded 属性，便于辅助设备识别状态
            var expanded = $(this).hasClass('active') ? 'true' : 'false';
            $(this).attr('aria-expanded', expanded);
        });

        // 点击外部关闭菜单
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation').removeClass('toggled');
                $('body').removeClass('menu-open');
                $('.menu-toggle').attr('aria-expanded', 'false');
            }
        });

        // ============================================
        // 返回顶部按钮
        // ============================================
        var backToTop = $('#back-to-top');
        
        if (backToTop.length) {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    backToTop.fadeIn();
                } else {
                    backToTop.fadeOut();
                }
            });

            backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 600, 'swing');
                return false;
            });
        }

        // ============================================
        // 平滑滚动锚点链接
        // ============================================
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && 
                location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 800);
                    return false;
                }
            }
        });

        // ============================================
        // 导航栏滚动效果
        // ============================================
        var header = $('.site-header');
        var scrollThreshold = 100;

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            
            if (scroll >= scrollThreshold) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        });

        // ============================================
        // 图片延迟加载
        // ============================================
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                // 只在有 data-src 时才设置 src
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
            });
        } else {
            // 为不支持的浏览器加载 polyfill
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            document.body.appendChild(script);
        }

        // ============================================
        // 搜索框聚焦效果
        // ============================================
        $('.search-field').on('focus', function() {
            $(this).parent().parent().addClass('focused');
        }).on('blur', function() {
            $(this).parent().parent().removeClass('focused');
        });

        // ============================================
        // 文章卡片悬停效果
        // ============================================
        $('.post-card').hover(
            function() {
                $(this).find('.post-thumbnail img').addClass('zoomed');
            },
            function() {
                $(this).find('.post-thumbnail img').removeClass('zoomed');
            }
        );

        // ============================================
        // 评论表单验证
        // ============================================
        $('#commentform').on('submit', function(e) {
            var name = $('#author').val();
            var email = $('#email').val();
            var comment = $('#comment').val();
            var error = false;

            if (name === '' || email === '' || comment === '') {
                alert('请填写所有必填字段');
                error = true;
            }

            if (!error) {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert('请输入有效的邮箱地址');
                    error = true;
                }
            }

            if (error) {
                e.preventDefault();
                return false;
            }
        });

        // ============================================
        // 图片灯箱效果（简单版）
        // ============================================
        $('.entry-content img').on('click', function() {
            var src = $(this).attr('src');
            var lightbox = $('<div class="lightbox"></div>');
            var img = $('<img>').attr('src', src);
            var close = $('<span class="close">&times;</span>');

            lightbox.append(close).append(img);
            $('body').append(lightbox);

            lightbox.fadeIn();

            close.on('click', function() {
                lightbox.fadeOut(function() {
                    $(this).remove();
                });
            });

            lightbox.on('click', function(e) {
                if ($(e.target).hasClass('lightbox')) {
                    $(this).fadeOut(function() {
                        $(this).remove();
                    });
                }
            });
        });

        // ============================================
        // 外部链接在新窗口打开
        // ============================================
        $('.entry-content a[href^="http"]').not('[href*="' + window.location.hostname + '"]').attr({
            target: '_blank',
            rel: 'noopener noreferrer'
        });

        // ============================================
        // 表格响应式包装
        // ============================================
        $('.entry-content table').wrap('<div class="table-responsive"></div>');

        // ============================================
        // 侧边栏固定（仅桌面端）
        // ============================================
        if ($(window).width() > 992) {
            var sidebar = $('.sidebar');
            var sidebarOffset = sidebar.offset();
            
            if (sidebar.length && sidebarOffset) {
                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();
                    
                    if (scroll >= sidebarOffset.top - 100) {
                        sidebar.addClass('sticky');
                    } else {
                        sidebar.removeClass('sticky');
                    }
                });
            }
        }

    }); // document ready 结束

    // ============================================
    // 窗口加载完成后
    // ============================================
    $(window).on('load', function() {
        // 移除预加载类（如果有）
        $('body').removeClass('preload');
    });

    // ============================================
    // 窗口尺寸改变
    // ============================================
    var resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // 在这里添加需要在窗口尺寸改变后执行的代码
            if ($(window).width() < 768) {
                $('.main-navigation').removeClass('toggled');
                    $('.menu-toggle').removeClass('active');
                    $('.menu-toggle').attr('aria-expanded', 'false');
            }
        }, 250);
    });

})(jQuery);
