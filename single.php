<?php get_header(); ?>
<div id="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <div class="post">
                <div class="postviews"><p class="postviews-count">
                    <?php comments_number('0','1','%');  ?> </p>
                    <p class="text-replies">reply</p></div>
                <div class="postheader"><div class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                    
                </div>

                <div class="entry"><?php the_content(); ?>
                    <?php link_pages('<p><strong>Pages:</strong>', '</p>', 'number'); ?>
                    <p class="postmetadata">
                        
                         <?php _e('标签'); ?>:<?php the_tags('');   ?><br />
                     <?php _e('发布在'); ?> <?php the_category(', ') ?> 于 <?php the_date(); ?> <?php //the_author(); ?><br />
        <?php //comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php //edit_post_link('Edit', ' &#124; ', ''); ?>
                      
                    </p>
                    
                </div>

                <div class="comments-template">
        <?php comments_template(); ?>
                </div>
                
            </div>
            <?php endwhile; ?>
        <div class="navigation">
        <?php previous_post_link('<< %link') ?> || <?php next_post_link(' %link >>') ?>
        </div>
    <?php else : ?>
        <div class="post"><h2><?php _e('Not Found'); ?></h2></div>
<?php endif; ?>

</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>