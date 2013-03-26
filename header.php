<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if (is_single() || is_page() || is_archive()) : ?><?php wp_title('', true); ?> | <?php bloginfo('name'); ?><?php else : ?><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?><?php endif; ?></title>

        <meta  charset="<?php bloginfo('charset'); ?>" />
        <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
        <?php
        if (is_home()) {
            $description = get_option('simplemetro_index_description');

            $keywords = get_option('simplemetro_index_keywords');
        } elseif (is_single() || is_page()) {
            $description1 = get_post_meta($post->ID, "description", true);
            $description2 = mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200, "…");

            // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
            $description = $description1 ? $description1 : $description2;

            // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
            $keywords = get_post_meta($post->ID, "keywords", true);
            if ($keywords == '') {
                $tags = wp_get_post_tags($post->ID);
                foreach ($tags as $tag) {
                    $keywords = $keywords . $tag->name . ", ";
                }
                $keywords = rtrim($keywords, ', ');
            }
        } elseif (is_category()) {
            $description = get_option('simplemetro_index_description');
            $keywords = single_cat_title('', false);
        } elseif (is_tag()) {
            $description = get_option('simplemetro_index_description');
            $keywords = single_tag_title('', false);
        }
        $description = trim(strip_tags($description));
        $keywords = trim(strip_tags($keywords));
        ?>
        <meta name="description" content="<?php echo $description; ?>" />
        <meta name="keywords" content="<?php echo $keywords; ?>" />

        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="alternate" type="text/xml" title="RSS.92" href="<?php bloginfo('rss_url'); ?>" />
        <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /> 

        <!--[if lt IE 7]>
        <script defer type="text/javascript" src="<?php bloginfo('template_directory'); ?>/pngfix.js"></script>
        <![endif]-->
        <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/base.js"></script>
        <?php if (is_singular()) { ?>
            <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/comments-ajax.js"></script>
        <?php } ?>
        <?php //wp_get_archives('type=monthly&format=link'); ?>
        <?php //comments_popup_script(); //off by default  ?>
        <?php if (is_singular()) wp_enqueue_script('comment-reply'); ?>
        <?php wp_head(); ?>
    </head>
    
    <body>

        <div id="wrapper">
            <div id="header">
                <ul id="menu">
                    <li id="logo"><a href="<?php bloginfo('url'); ?>"></a></li>

                    <li class="about"><a href="<?php bloginfo('url'); ?>/about"><?php _e('About'); ?></a></li>
                    <li class="header-cats"><a>分类目录</a>
                        <ul class="header-cats-content">

                            <?php wp_list_cats(); ?></ul>
                    </li>
 
                    
                    <li class="button"><a href="<?php echo get_option('simplemetro_header_button3_link'); ?>"><img alt="button3" src="<?php echo get_option('simplemetro_header_button3'); ?>"/></a></li>
                    <li class="button"><a href="<?php echo get_option('simplemetro_header_button4_link'); ?>"><img alt="button3" src="<?php echo get_option('simplemetro_header_button4'); ?>"/></a></li>
                    <li class="search-form"><form method="get" action="<?php bloginfo('url'); ?>"><input type="text" id="search-form-keyword" name="s" maxlength="100" />
                            <input type="submit" id="seach-form-submit" value="" /></form></li>
                </ul>


            </div>