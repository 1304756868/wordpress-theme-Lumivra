<?php
/**
 * 搜索表单模板
 *
 * @package Lumivra
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('搜索:', 'lumivra'); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('搜索...', 'placeholder', 'lumivra'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x('搜索:', 'label', 'lumivra'); ?>" />
    </label>
    <button type="submit" class="search-submit"><?php _e('搜索', 'lumivra'); ?></button>
</form>
