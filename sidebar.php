        <div id="sidebar">
            <ul>
                <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar()):else: ?>
                    <li id="search"><?php include(TEMPLATEPATH . '/searchform.php'); ?></li>
                    <li id="calendar"><?php _e('Calendar'); ?>
                        <?php get_calendar(); ?>
                    </li>
                    <?php wp_list_pages(); ?>
                    <li><?php _e('Categories'); ?>
                        <ul><?php wp_list_cats('sort_column=name&optionscount=1&hierarchical=0'); ?></ul>
                    </li>
                    <li><?php _e('Archives'); ?>
                        <ul>
                            <?php wp_get_archives('type=monthly'); ?>
                        </ul>
                    </li>
                    <?php get_links_list(); ?>

                    <li>
                        <?php _e('Meta'); ?>
                        <ul>
                            <?php wp_register(); ?>
                            <li><?php wp_loginout(); ?></li>
                            <?php wp_meta(); ?>
                        </ul>
                    </li>

                <?php endif; ?>
            </ul>
        </div>