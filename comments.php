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

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('1 条评论', 'lumivra')
                );
            } else {
                printf(
                    esc_html(_n('%1$s 条评论', '%1$s 条评论', $comment_count, 'lumivra')),
                    number_format_i18n($comment_count)
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback'    => 'lumivra_comment',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php _e('评论已关闭。', 'lumivra'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'         => __('发表评论', 'lumivra'),
        'title_reply_to'      => __('回复 %s', 'lumivra'),
        'cancel_reply_link'   => __('取消回复', 'lumivra'),
        'label_submit'        => __('提交评论', 'lumivra'),
        'comment_field'       => '<p class="comment-form-comment"><label for="comment">' . __('评论', 'lumivra') . '</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>',
        'fields'              => array(
            'author' => '<p class="comment-form-author"><label for="author">' . __('名称', 'lumivra') . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . __('邮箱', 'lumivra') . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . __('网站', 'lumivra') . '</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
        ),
    ));
    ?>

</div><!-- #comments -->
