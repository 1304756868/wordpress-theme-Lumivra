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
        // 阅读进度条
        // ============================================
        if ($('.scroll-progress').length) {
            $(window).scroll(function() {
                var scrollTop = $(window).scrollTop();
                var docHeight = $(document).height();
                var winHeight = $(window).height();
                var scrollPercent = 0;

                if (docHeight > winHeight) {
                    scrollPercent = (scrollTop) / (docHeight - winHeight);
                }

                var scrollPercentRounded = Math.min(100, Math.max(0, Math.round(scrollPercent * 100)));
                $('.scroll-progress').css('width', scrollPercentRounded + '%');
            });
        }

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
        // 图片懒加载（IntersectionObserver）；占位图使用主题内的 assets/png/load.svg
        // 逻辑：将 img.src/srcset 储存到 data-*，替换为占位图；进入视口时再加载真实图片。
        // ============================================
        (function() {
            var placeholder = (typeof lumivra !== 'undefined' && lumivra.themeUrl) ? lumivra.themeUrl + '/assets/png/load.svg' : '/assets/png/load.svg';

            function prepareImages() {
                var imgs = document.querySelectorAll('img:not([data-lazy-processed])');
                imgs.forEach(function(img) {
                    // 可通过 data-lazy-ignore 跳过某些图片
                    if (img.hasAttribute('data-lazy-ignore')) return;
                    // 已经使用 data-src 的不重复处理
                    if (img.dataset.src) {
                        img.setAttribute('data-lazy-processed', '1');
                        return;
                    }

                    var src = img.getAttribute('src');
                    if (!src) return;

                    // 保存原始资源
                    img.dataset.src = img.dataset.src || src;
                    if (img.hasAttribute('srcset')) img.dataset.srcset = img.getAttribute('srcset');

                    // 设置占位图
                    try {
                        img.setAttribute('src', placeholder);
                    } catch (e) {}

                    // 移除 srcset，避免浏览器提前选择资源
                    if (img.hasAttribute('srcset')) img.removeAttribute('srcset');

                    img.setAttribute('data-lazy-processed', '1');
                    img.setAttribute('loading', 'lazy');
                });
            }

            function loadImage(img) {
                if (!img || !img.dataset || !img.dataset.src) return;
                var realSrc = img.dataset.src;
                var realSrcset = img.dataset.srcset;

                // 使用新的 Image 对象预加载
                var tmp = new Image();
                if (realSrcset) tmp.srcset = realSrcset;
                tmp.src = realSrc;
                tmp.onload = function() {
                    if (realSrcset) img.setAttribute('srcset', realSrcset);
                    img.setAttribute('src', realSrc);
                    img.classList.add('is-loaded');
                    // 清理 data 属性
                    delete img.dataset.src;
                    delete img.dataset.srcset;
                };
                tmp.onerror = function() {
                    // 发生错误时保留占位图，不阻塞页面
                    img.classList.add('is-error');
                };
            }

            function initObserver() {
                if ('IntersectionObserver' in window) {
                    var io = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                var img = entry.target;
                                io.unobserve(img);
                                loadImage(img);
                            }
                        });
                    }, { rootMargin: '200px 0px', threshold: 0.01 });

                    document.querySelectorAll('img[data-lazy-processed]').forEach(function(i) {
                        io.observe(i);
                    });
                } else {
                    // 回退：直接加载所有图片（较早浏览器）
                    document.querySelectorAll('img[data-lazy-processed]').forEach(function(i) {
                        loadImage(i);
                    });
                }
            }

            // 初始化
            prepareImages();
            initObserver();

            // 如果有动态插入图片（AJAX 或内容变更），可再次调用 prepareImages/ initObserver
            // 为简单起见，绑定到 window 的一次性暴露方法
            window.lumivra_lazy_reload = function() {
                prepareImages();
                initObserver();
            };
        })();

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
            var comment = $('#comment').val();
            var error = false;

            // 检查评论内容是否为空
            if (comment === '') {
                alert('请填写评论内容');
                error = true;
            }

            // 只对未登录用户验证姓名和邮箱字段
            if ($('#author').length > 0) {
                var name = $('#author').val();
                var email = $('#email').val();

                if (name === '' || email === '') {
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
            }

            if (error) {
                e.preventDefault();
                return false;
            }
        });

        // ============================================
        // 图片灯箱效果（简单版） - 使用全屏覆盖并锁定页面滚动
        // ============================================
        $('.entry-content img').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // 优先使用懒加载保存的真实资源（data-src / data-srcset），否则回退到当前的 src
            var $orig = $(this);
            var realSrc = $orig.data('src') || $orig.attr('src');
            var realSrcset = $orig.data('srcset') || $orig.attr('srcset');
            
            // 创建 lightbox 容器，添加强制定位样式
            var lightbox = $('<div class="lightbox"></div>').css({
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'z-index': '12000',
                'display': 'none'
            });
            
            var img = $('<img>').attr('src', realSrc).attr('alt', $orig.attr('alt') || '');
            if (realSrcset) img.attr('srcset', realSrcset);
            
            var close = $('<span class="close" aria-label="关闭">&times;</span>');

            lightbox.append(close).append(img);
            $('body').append(lightbox);
            
            // 锁定页面滚动
            $('body').addClass('lightbox-open');

            lightbox.fadeIn(160);

            // 关闭 lightbox 的函数
            function closeLightbox() {
                lightbox.fadeOut(160, function() {
                    $(this).remove();
                    $('body').removeClass('lightbox-open');
                    // 移除键盘事件监听
                    $(document).off('keydown.lightbox');
                });
            }

            // 点击关闭按钮
            close.on('click', function(e) {
                e.stopPropagation();
                closeLightbox();
            });

            // 点击遮罩关闭
            lightbox.on('click', function(e) {
                if ($(e.target).hasClass('lightbox')) {
                    closeLightbox();
                }
            });

            // 按 ESC 键关闭
            $(document).on('keydown.lightbox', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    closeLightbox();
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

        // ============================================
        // 首页点击加载更多
        // ============================================
        var $loadMoreBtn = $('#load-more-posts');
        var $postsContainer = $('.posts-list');
        var $loadingAnim = $('.load-more-loading');

        if ($loadMoreBtn.length) {
            $loadMoreBtn.on('click', function(e) {
                e.preventDefault();
                var nextPageUrl = $(this).attr('data-next-page');
                
                if (!nextPageUrl) return;

                $(this).hide();
                $loadingAnim.css('display', 'block');

                $.ajax({
                    url: nextPageUrl,
                    type: 'GET',
                    dataType: 'html',
                    success: function(response) {
                        var $data = $(response);
                        var newPosts = $data.find('.posts-list').html();
                        var newNextLink = $data.find('#load-more-posts').attr('data-next-page');

                        if (newPosts) {
                            // 简单的淡入效果
                            var $newContent = $(newPosts).hide();
                            $postsContainer.append($newContent);
                            $newContent.fadeIn();
                            
                            // 重新初始化某些可能需要的JS行为（如懒加载）
                            // 如果有专门的函数，可以在这里调用，例如触发scroll事件
                            $(window).trigger('scroll'); 
                            
                            // 更新下一页链接
                            if (newNextLink) {
                                $loadMoreBtn.attr('data-next-page', newNextLink);
                                $loadMoreBtn.show();
                            } else {
                                // 没有更多页面了
                                $loadMoreBtn.remove();
                                $('.load-more-container').append('<span class="no-more-posts" style="color:var(--text-secondary);">已经到底啦～</span>');
                            }
                        } else {
                            $loadMoreBtn.remove();
                        }

                        $loadingAnim.hide();
                    },
                    error: function(xhr) {
                        if (xhr.status == 404) {
                            // 404 表示没有更多内容了
                            $loadingAnim.hide();
                            $loadMoreBtn.remove();
                            // 避免重复添加
                            if ($('.load-more-container .no-more-posts').length === 0) {
                                $('.load-more-container').append('<span class="no-more-posts" style="color:var(--text-secondary);">已经到底啦～</span>');
                            }
                        } else {
                            alert('加载失败，请检查网络连接后重试。');
                            $loadMoreBtn.show();
                            $loadingAnim.hide();
                        }
                    }
                });
            });
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
