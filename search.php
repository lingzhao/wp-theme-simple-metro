<?php get_header(); ?>
<div id="container">
   
	
    <?php if (have_posts()) : ?>
     <p class="archiveh">
        <?php _e('Search results for '); ?><?php printf( __('keyword(s): &#8216;%1$s&#8217;'), wp_specialchars($s, 1) ); ?>
	</p>
    <?php
        #echo posts START
        while (have_posts()) : the_post();
            ?>
            <div class="post">
                <div class="postviews"><p class="postviews-count"><?php post_views(); ?> </p><p class="text-views">views</p></div>
                <div class="postheader"><div class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                    <div class="posttags"><?php the_tags(''); ?></div>
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
       <p class="archiveh"><?php _e('Not Found'); ?></p>
<?php endif; ?>

</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>