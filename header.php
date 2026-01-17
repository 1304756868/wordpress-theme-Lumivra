<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( is_single() ) : ?>
    <div id="scroll-progress" class="scroll-progress"></div>
<?php endif; ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="site-title-wrapper">
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
                
                <div class="user-menu">
                    <?php if (is_user_logged_in()) : 
                        $current_user = wp_get_current_user();
                        ?>
                        <div class="user-avatar-wrapper">
                            <a href="<?php echo esc_url(get_dashboard_url()); ?>" class="user-avatar-link">
                                <?php echo get_avatar($current_user->ID, 40, '', $current_user->display_name, array('class' => 'user-avatar')); ?>
                            </a>
                            <div class="user-dropdown">
                                <a href="<?php echo esc_url(get_dashboard_url()); ?>"><?php _e('仪表盘', 'lumivra'); ?></a>
                                <a href="<?php echo esc_url(get_edit_profile_url()); ?>"><?php _e('编辑资料', 'lumivra'); ?></a>
                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php _e('退出登录', 'lumivra'); ?></a>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="auth-btn" title="<?php _e('登录', 'lumivra'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">
