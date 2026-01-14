<?php
/**
 * 评论模板
 *
 * @package Lumivra
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <div class="comments-header-wrapper">
        <h2 class="comments-title">
            <span class="icon-comment">💬</span>
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('评论 (1 条评论)', 'lumivra')
                );
            } else {
                printf(
                    esc_html(_n('评论 (%1$s 条评论)', '评论 (%1$s 条评论)', $comment_count, 'lumivra')),
                    number_format_i18n($comment_count)
                );
            }
            ?>
        </h2>
    </div>

    <?php
    $comment_form_args = array(
        'title_reply'         => '',
        'title_reply_to'      => __('回复 %s', 'lumivra'),
        'cancel_reply_link'   => __('取消回复', 'lumivra'),
        'label_submit'        => __('发布评论', 'lumivra'),
        'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"> <span class="submit-icon">🚀</span> %4$s </button>',
        'class_submit'        => 'submit',
        'comment_field'       => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="5" placeholder="' . __('世界这么大发表一下你的看法~', 'lumivra') . '" required></textarea></div>',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'logged_in_as'         => '', // 隐藏默认的已登录提示，我们自己处理布局
    );

    // 如果用户未登录，才显示个人信息字段
    if (!is_user_logged_in()) {
        $comment_form_args['fields'] = array(
            'author' => '<div class="comment-input-row"><div class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . __('昵称', 'lumivra') . '" required /></div>',
            'email'  => '<div class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . __('邮箱', 'lumivra') . '" required /></div>',
            'url'    => '<div class="comment-form-url"><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" placeholder="' . __('网址', 'lumivra') . '" /></div></div>',
        );
    } else {
        // 已登录用户的隐藏字段，用于保持布局或提示
         $comment_form_args['comment_notes_before'] = '<p class="logged-in-as">' . sprintf(
            __('已登录为 <a href="%1$s">%2$s</a>。 <a href="%3$s">注销?</a>', 'lumivra'),
            admin_url('profile.php'),
            $user_identity,
            wp_logout_url(apply_filters('the_permalink', get_permalink()))
        ) . '</p>';
    }

    comment_form($comment_form_args);
    ?>

    <?php if (have_comments()) : ?>
        
        <div class="comments-list-wrapper">
            <ol class="comment-list">
                <?php
                wp_list_comments(array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 48,
                    'callback'    => 'lumivra_comment',
                ));
                ?>
            </ol>
        </div>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <div class="comments-closed">
                <p class="no-comments"><?php _e('评论已关闭。', 'lumivra'); ?></p>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div><!-- #comments -->
