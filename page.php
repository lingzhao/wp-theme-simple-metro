<?php get_header(); ?>
        <div id="container">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="post">
                       
                        <div class="entry"> <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2><?php the_content(); ?><?php link_pages('<p><strong>Pages:</strong>', '</p>', 'number'); ?>
                           
                        </div>
                    </div>
                         <div class="comments-template">
        <?php comments_template(); ?>
                </div>
                <?php endwhile; ?>
                
            <?php else : ?>
                <div class="post"><h2><?php _e('Not Found'); ?></h2></div>
            <?php endif; ?>

        </div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>