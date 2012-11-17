<?php
// Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('Please do not load this page directly. Thanks!');
}
if (!empty($post->post_password)) {
    if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {
        ?>
        <p class="alert">This post is password protected. Enter the password to view comments.</p>
        <?php
        return;
    }
}

$countComments = 0;
$countPings = 0;
if ($post->comment_count > 0) {
    $comments_list = array();
    $pings_list = array();
    foreach ($comments as $comment) {
        if ('comment' == get_comment_type())
            $comments_list[++$countComments] = $comment;
        else
            $pings_list[++$countPings] = $comment;
    }
}
?>

<!-- You can start editing here. -->

    <?php if ($comments) : ?>
    <h3 id="comments"><?php //comments_number('No Responses', 'One Response', '% Responses'); to &#8220;    ?> <?php //the_title();&#8221;   ?></h3>

    <ol class="commentlist">
        <?php //wp_list_comments('max_depth=2'); ?>
        <?php wp_list_comments('type=comment&avatar_size=38
&callback=simplemetro_comment&max_depth=2'); ?>
    <?php
    ?>
    </ol>

<?php else : // this is displayed if there are no comments so far     ?>

    <?php if ('open' == $post->comment_status) : ?>
        <p><?php _e('No comments yet.'); ?></p>
    <?php else : // comments are closed   ?>

        <!-- If comments are closed. -->
        <p class="nocomments">Comments are closed.</p>

    <?php endif; ?>
<?php endif; ?>
<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through  ?>
    <nav id="comment-nav-below">
        <span class="nav-header">评论:</span>
        <span class="nav-previous"><?php previous_comments_link(__('上页')); ?></span>
        <span class="nav-next"><?php next_comments_link(__('下页')); ?></span>
    </nav>
<?php endif; // check for comment navigation  ?>

    <?php if ('open' == $post->comment_status) : ?>
    <div  id="respond">
        <h3>发表评论</h3> <?php cancel_comment_reply_link(' '); ?>

        <?php if (get_option('comment_registration') && !$user_ID) : ?>
            <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>

            <?php else : ?>

            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                <?php if ($user_ID) : ?>

                    <p>您以 <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> 的身份发表评论. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

                            <?php else : ?>

                    <p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
                        <label for="author"><small> <?php
                    _e('Name');
                    if ($req)
                        echo _e('(required)');
                    ?></small></label></p>

                    <p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
                        <label for="email"><small><?php
                    _e('Mail');
                    _e('(不会被公开)');
                    if ($req)
                        echo _e('(required)');
                    ?></small></label></p>

                    <p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
                        <label for="url"><small><?php _e('Website'); ?></small></label></p>

        <?php endif; ?>

                                                <!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags&#58;'); ?> <?php echo allowed_tags(); ?></small></p>-->

                <p><textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>

                <p><input name="submit" type="submit" id="submit" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};" tabindex="5" value=" " />
                    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
                </p>

        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>

            </form>
        </div>

    <?php endif; // If registration required and not logged in   ?>

    <?php endif; /// if you delete this the sky will fall on your head 
?>



    <?php /* Check for pings */ if ($countPings > 0) { ?>
    <p class="pinglisth">The trackbacks and pingpacks:</p>
    <ul id="pinglist">
        <?php
        foreach ($pings_list as $comment) {
            if ('pingback' == get_comment_type())
                $pingtype = 'Pingback';
            else
                $pingtype = 'Trackback';
            ?>
            <li id="comment-<?php echo $comment->comment_ID ?>">
        <?php comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php echo mysql2date('y/m/d H:i', $comment->comment_date); ?>
            </li>
    <?php } ?>
    </ul>
<?php } ?>