<?php get_header(); ?>
<div id="container">
   
	
    <?php if (have_posts()) : ?>
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
     <p class="archiveh">
       	<?php
		// If this is a category archive
		if (is_category()) {
			printf( __('Archive for the &#8216;%1$s&#8217; Category'), single_cat_title('', false) );
		// If this is a tag archive
		} elseif (is_tag()) {
			printf( __('标签: &#8216;%1$s&#8217;'), single_tag_title('', false) );
		// If this is a daily archive
		} elseif (is_day()) {
			printf( __('Archive for %1$s'), get_the_time(__('F jS, Y')) );
		// If this is a monthly archive
		} elseif (is_month()) {
			printf( __('Archive for %1$s'), get_the_time(__('F, Y')) );
		// If this is a yearly archive
		} elseif (is_year()) {
			printf( __('Archive for %1$s'), get_the_time(__('Y')) );
		// If this is an author archive
		} elseif (is_author()) {
			_e('Author Archive' );
		// If this is a paged archive
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			_e('Blog Archives' );
		}
		?>
	</p>
      <?php
        #echo posts START
        while (have_posts()) : the_post();
            ?>
            <div class="post">
                <div class="postviews"><p class="postviews-count"><?php comments_number('0','1','%'); ?></p><p class="text-replies">reply</p></div>
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