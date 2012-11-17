<?php get_header(); ?>
<div id="container">
    <?php if (have_posts()) : ?>
        <?php
        #echo posts START
        while (have_posts()) : the_post();
            ?>
            <div class="post">
                <div class="postviews"><p class="postviews-count"><?php comments_number('0','1','%'); ?> </p><p class="text-replies">reply</p></div>
                <div class="postheader"><p class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
                    <p class="posttags"><?php the_tags(''); ?></p>
                </div>

                <div class="entry"><?php the_content(); ?>
                    <?php /* <p class="postmetadata">
                      <?php _e('Filed under&#58;'); ?> <?php the_category(', ') ?> <?php _e('by'); ?> <?php the_author(); ?><br />
                      <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', ' &#124; ', ''); ?>
                      </p> */ ?>
        <?php link_pages('<p><strong>Pages:</strong>', '</p>', 'number'); ?>
                </div>
            </div>
        <?php endwhile;
        #echo posts END  
        ?>
        <div class="navigation">
        <?php posts_nav_link(); ?>
        </div>
    <?php else : ?>
        <div class="post"><h2><?php _e('Not Found'); ?></h2></div>
<?php endif; ?>

</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>