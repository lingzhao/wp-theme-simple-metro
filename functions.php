<?php
#-主题初始化 
function sm_options_install() {
    add_option('simplemetro_header_button3', get_template_directory_uri().'/images/header-menu-sinaweibo.png');
    add_option('simplemetro_header_button4', get_template_directory_uri().'/images/header-menu-rss.png');
    add_option('simplemetro_header_button3_link', 'http://weibo.com');
    add_option('simplemetro_header_button4_link', get_option('siteurl') . '/feed');
    add_option('simplemetro_index_keywords', '');
    add_option('simplemetro_index_description', '');
}

add_action('after_setup_theme', 'sm_options_install');
?>
<?php
#-主题设置 theme option

function sm_theme_options_add_page() {
    $theme_page = add_theme_page(
            'Simple Metro 主题设置', //页面Titlee
            '主题设置', // 在后台菜单中显示的名字
            'edit_theme_options', // 选项放置的位置
            'theme_options', // 别名,也就是get传送的参数
            'sm_theme_op_page' //调用显示内容调用的函数
    );
}

function sm_theme_op_page() {//内容显示函数
    include_once TEMPLATEPATH . '/options.php';
}

add_action('admin_menu', 'sm_theme_options_add_page');
?>
<?php

//---------- seo---------
$new_meta_boxes =
array(
    "keywords" => array(
        "name" => "keywords",
        "std" => "",
        "title" => "关键字：",
        "desc" => "填写head域keywords的内容，留空则自动以标签作为keyword"),

    "description" => array(
        "name" => "description",
        "std" => "",
        "title" => "网页描述：",
        "desc" => "填写head域description的内容，留空则使用文章内容前200字")
);
function new_meta_boxes() {
    global $post, $new_meta_boxes;

	echo '<table class="form-table">';
    foreach($new_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);

        if($meta_box_value == "")
            $meta_box_value = $meta_box['std'];

		echo '<tr valign="top">';
        echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		echo '<th scope="row"><label for="'.$meta_box['name'].'">'.$meta_box['title'].'</label></th>';
		echo '<td><input name="'.$meta_box['name'].'" type="text" id="'.$meta_box['name'].'" value="'.$meta_box_value.'" class="regular-text" />
		<span class="description" style="color:gray">'.$meta_box['desc'].'</span></td>';

		echo '</tr>';
    }
	echo '</table>';
}
function create_meta_box() {
    global $theme_name;

    if ( function_exists('add_meta_box') ) {
        add_meta_box( 'new-meta-boxes', 'SEO设置', 'new_meta_boxes', 'post', 'normal', 'high' );
		add_meta_box( 'new-meta-boxes', 'SEO设置', 'new_meta_boxes', 'page', 'normal', 'high' );
    }
}
function save_postdata( $post_id ) {
    global $post, $new_meta_boxes;

    foreach($new_meta_boxes as $meta_box) {
        if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))  {
            return $post_id;
        }

        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ))
                return $post_id;
        } 

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
        else {
            if ( !current_user_can( 'edit_post', $post_id ))
                return $post_id;
        }

        $data = $_POST[$meta_box['name']];

        if(get_post_meta($post_id, $meta_box['name']) == "")
            add_post_meta($post_id, $meta_box['name'], $data, true);
        elseif($data != get_post_meta($post_id, $meta_box['name'], true))
            update_post_meta($post_id, $meta_box['name'], $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
    }
}
add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
//---------- seo----------


if (function_exists('register_sidebar'))
    register_sidebar();

function post_views($before = '', $after = '', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int) get_post_meta($post_ID, 'views', true);
    if ($echo)
        echo $before, number_format($views), $after;
    else
        return $views;
}

function simplemetro_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $countComments = 1;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <span class="comments_posted_top"></span>
        <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
                <div class="avatarbg">
    <?php echo get_avatar(get_comment_author_email(), '45'); ?>
                </div>
                <div class="message_head">
                    <span class="author-link"><?php comment_author_link(); ?> 说:</span>
                    <span class="timestamp"><?php comment_date('y/m/d H:i'); ?></span>
                </div>
                <div class="reply">
    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => 9))); ?>
                </div>

                <div class="message_body">
                    <?php echo comment_text(); ?>
                    <?php if ($comment->comment_approved == '0') : ?>
                        (您的评论正在等待审核.)
    <?php endif; ?>
                </div>


            </div></div>
        <?php
    }
    ?>
