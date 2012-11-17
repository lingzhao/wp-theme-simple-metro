<?php
/**
 * WordPress-jQuery-Ajax-Comments v1.3 by Willin Kan.
 * 说明：这个文件是由WP3.0根目录的wp-comment-post.php修改而来
 */
if ('POST' != $_SERVER['REQUEST_METHOD']) {
    header('Allow: POST');
    header('HTTP/1.0 405 Method Not Allowed');
    header('Content-Type: text/plain');
    exit;
}

/** Sets up the WordPress Environment. */
require( dirname(__FILE__) . '/../../../wp-load.php' );

nocache_headers();

$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

$post = get_post($comment_post_ID);

if (empty($post->comment_status)) {
    do_action('comment_id_not_found', $comment_post_ID);
    err(__('Invalid comment status.')); // 将exit改为错误提示err
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status($post);

$status_obj = get_post_status_object($status);

if (!comments_open($comment_post_ID)) {
    do_action('comment_closed', $comment_post_ID);
    err(__('Sorry, comments are closed for this item.')); // 将wp_die改为错误提示err
} elseif ('trash' == $status) {
    do_action('comment_on_trash', $comment_post_ID);
    err(__('Invalid comment status.')); // 将exit改为错误提示err
} elseif (!$status_obj->public && !$status_obj->private) {
    do_action('comment_on_draft', $comment_post_ID);
    err(__('Invalid comment status.')); // 将exit改为错误提示err
} elseif (post_password_required($comment_post_ID)) {
    do_action('comment_on_password_protected', $comment_post_ID);
    err(__('Password Protected')); // 将exit改为错误提示err
} else {
    do_action('pre_comment_on_post', $comment_post_ID);
}

$comment_author = ( isset($_POST['author']) ) ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) ) ? trim($_POST['email']) : null;
$comment_author_url = ( isset($_POST['url']) ) ? trim($_POST['url']) : null;
$comment_content = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
$edit_id = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取edit_id
// If the user is logged in
$user = wp_get_current_user();
if ($user->ID) {
    if (empty($user->display_name))
        $user->display_name = $user->user_login;
    $comment_author = $wpdb->escape($user->display_name);
    $comment_author_email = $wpdb->escape($user->user_email);
    $comment_author_url = $wpdb->escape($user->user_url);
    if (current_user_can('unfiltered_html')) {
        if (wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment']) {
            kses_remove_filters(); // start with a clean slate
            kses_init_filters(); // set up the filters
        }
    }
} else {
    if (get_option('comment_registration') || 'private' == $status)
        err(__('Sorry, you must be logged in to post a comment.')); // 将wp_die改为错误提示err
}

$comment_type = '';

if (get_option('require_name_email') && !$user->ID) {
    if (6 > strlen($comment_author_email) || '' == $comment_author)
        err(__('Error: please fill the required fields (name, email).')); // 将wp_die改为错误提示err
    elseif (!is_email($comment_author_email))
        err(__('Error: please enter a valid email address.')); // 将wp_die改为错误提示err
}

//防止冒充留言_Start
if (!$user->ID) {
    $result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
    if ($result_set) {
        if ($result_set[0]->display_name == $comment_author) {
            err(__('错误：抱歉，你不可以使用这个昵称.'));
        } else {
            err(__('错误：抱歉，你不可以使用这个邮件地址.'));
        }
    }
}
//防止冒充留言_End

if ('' == $comment_content)
    err(__('Error: please type a comment.')); // 将wp_die改为错误提示err

    
// 增加: 错误提示功能

function err($ErrMsg) {
    header('HTTP/1.0 405 Method Not Allowed');
    echo $ErrMsg;
    exit;
}

// 增加: 检查重复评论功能
$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
if ($comment_author_email)
    $dupe .= "OR comment_author_email = '$comment_author_email' ";
$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
if ($wpdb->get_var($dupe)) {
    err(__('Duplicate comment detected; it looks as though you&#8217;ve already said that!'));
}

// 增加:检查评论太快功能
if ($lasttime = $wpdb->get_var($wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author))) {
    $time_lastcomment = mysql2date('U', $lasttime, false);
    $time_newcomment = mysql2date('U', current_time('mysql', 1), false);
    $flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
    if ($flood_die) {
        err(__('您评论的速度太快了，请慢一些。'));
    }
}

$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;

$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

// 增加: 检查评论是否正被编辑, 更新或新建评论
if ($edit_id) {
    $comment_id = $commentdata['comment_ID'] = $edit_id;
    wp_update_comment($commentdata);
} else {
    $comment_id = wp_new_comment($commentdata);
}

$comment = get_comment($comment_id);
if (!$user->ID) {
    $comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
    setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
    setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
    setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
}

//$location = empty($_POST['redirect_to']) ? get_comment_link($comment_id) : $_POST['redirect_to'] . '#comment-' . $comment_id; //取消原有的刷新重定向
//$location = apply_filters('comment_post_redirect', $location, $comment);
//wp_redirect($location);

$comment_depth = 1;   //为评论的class属性准备的
$tmp_c = $comment;
while ($tmp_c->comment_parent != 0) {
    $comment_depth++;
    $tmp_c = get_comment($tmp_c->comment_parent);
}

//要把主题中评论列表部分的代码复制到下面，但是去掉回复按钮
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <span class="comments_posted_top"></span>
    <div id="comment-<?php comment_ID(); ?>">
        <div class="comment-author vcard">
            <div class="avatarbg">
                <?php echo get_avatar(get_comment_author_email(), '45'); ?>
            </div>
            <div class="message_head">
                <span class="author-link"><?php comment_author_link(); ?> said:</span>
                <span class="timestamp"><?php comment_date('y/m/d H:i'); ?></span>
            </div>
            <div class="message_body">
                <?php echo comment_text(); ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    (您的评论正在等待审核.)
                <?php endif; ?>
            </div>
        </div></div>