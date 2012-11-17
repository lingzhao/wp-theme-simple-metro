<h1>
    <?php
    _e('Simple Metro 主题设置', 'simplemetro');
    ?>
</h1>
<link rel='stylesheet'  href='<?php echo bloginfo('template_url') . '/options.css' ?>' type='text/css' />
<?php if (!empty($_POST['submit'])): ?>
    <div id="message" class="updated"><p>设置已保存。</p>
    </div>
    <?php
    update_option('simplemetro_header_button3', $_POST['header_button3']);
    update_option('simplemetro_header_button4', $_POST['header_button4']);
    update_option('simplemetro_header_button3_link', $_POST['header_button3_link']);
    update_option('simplemetro_header_button4_link', $_POST['header_button4_link']);
    update_option('simplemetro_index_keywords', $_POST['index_keywords']);
    update_option('simplemetro_index_description', $_POST['index_description']);

    if ($_POST['header_button3'] == 'custom') {
        update_option('simplemetro_header_button3', $_POST['custom_button3_src']);
    }
    if ($_POST['header_button3'] == 'custom') {
        update_option('simplemetro_header_button4', $_POST['custom_button4_src']);
    }
    ?>
<?php endif; ?>
<?php if (!empty($_POST['restet-submit'])): ?>
    <div id="message" class="updated"><p>所有设置已经还原为默认。</p>
    </div>
    <?php
    update_option('simplemetro_header_button3', get_template_directory_uri() . '/images/header-menu-sinaweibo.png');
    update_option('simplemetro_header_button4', get_template_directory_uri() . ('template_directory') . '/images/header-menu-rss.png');
    update_option('simplemetro_header_button3_link', 'http://weibo.com');
    update_option('simplemetro_header_button4_link', get_option('siteurl') . '/feed');
    update_option('simplemetro_index_keywords', '');
    update_option('simplemetro_index_description', '');
    ?>
<?php endif; ?>

<form id="simplemetro-options" action="" method="post">
    <ul>
        <li><h2>SEO - 首页</h2>
            <div>
                <span style="color:gray">这里设置首页head域中的keywords和description标签。</span>
                <table>
                    <tr><td><span class="option-name">keywords:</span></td>
                        <td><textarea style="width: 450px;" type="text" name="index_keywords"><?php echo get_option('simplemetro_index_keywords'); ?></textarea>   </td>
                    </tr>
                    <tr><td><span class="option-name">description:</span></td>
                        <td><textarea style="width: 450px;" type="text" name="index_description"><?php echo get_option('simplemetro_index_description'); ?></textarea>  </td>
                    </tr>

                </table>
            </div>
        </li>
        <li><h2>顶栏</h2>
            <div class="the-tops">
                <table>
                    <tr style="font-size: 14px;font-weight: bold;"><td></td><td>按钮3</td><td>按钮4</td></tr>
                    <tr><td width="80">图标</td><td><select name="header_button3">
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-twitter.png">twitter</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-sinaweibo.png">新浪微博</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-qqweibo.png">腾讯微博</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-renren.png">人人</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-rss.png">RSS</option>
                                <option value="custom">自定义</option>
                            </select>
                        </td>
                        <td>
                            <select name="header_button4">
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-twitter.png">twitter</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-sinaweibo.png">新浪微博</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-qqweibo.png">腾讯微博</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-renren.png">人人</option>
                                <option value="<?php bloginfo('template_directory'); ?>/images/header-menu-rss.png">RSS</option>
                                <option value="custom">自定义</option>
                            </select> 
                        </td>
                    </tr>
                    <tr id="custom_button_src" style="opacity: 0;filter:alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";"><td>自定义图片</td>
                        <td><input type="text" style="display:none" length="40" name="custom_button3_src" value="<?php echo get_option('simplemetro_header_button3'); ?>" /></td>
                        <td><input type="text" style="display:none" length="40" name="custom_button4_src" value="<?php echo get_option('simplemetro_header_button4'); ?>" /></td>
                    </tr>
                    <tr style="height: 40px;"><td>预览</td><td><img alt="您还没有设置button3按钮图片" id="button3_show" src="<?php echo get_option('simplemetro_header_button3'); ?>" /></td><td><img alt="您还没有设置button4按钮图片" id="button4_show" src="<?php echo get_option('simplemetro_header_button4'); ?>" /></td></tr>
                    <tr><td>链接</td><td><input type="text" length="40"  name="header_button3_link" value="<?php echo get_option('simplemetro_header_button3_link'); ?>" /></td><td><input type="text" length="40" name="header_button4_link" value="<?php echo get_option('simplemetro_header_button4_link'); ?>" /></td></tr>
                </table>
                <p id="custom_button_tips" style="color:gray;display: none;">注意:您提供的自定义顶栏按钮图片的大小应为110*40。</p>
            </div>
        </li>
        <li><h2>建议&反馈</h2>
            <ol>
                <li><a href="http://wildcat.name/simplemetro.html">主题发布页</a></li>
                <li>Email:<a href="mailto:wildcat.name@gmail.com">wildcat.name@gmail.com</a></li>
            </ol>
        </li>
    </ul>

    <div>
        <input class="button-primary" type="submit" name="submit" value="更新设置" />
        <input class="button-primary" type="submit" name="restet-submit" value="还原默认" />
    </div>
</form>
<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $("select[name='header_button3']").val('<?php echo get_option('simplemetro_header_button3'); ?>');  
        $("select[name='header_button4']").val('<?php echo get_option('simplemetro_header_button4'); ?>'); 
     
        
        $("select[name='header_button3']").change(function(){
            $("#button3_show").attr('src',$(this).val());
            if($(this).val()=="custom"){
                $("input[name='custom_button3_src']").fadeTo(1000,1);
            }else{
                $("input[name='custom_button3_src']").fadeTo(1000,0);
            }
            custom_button_setting();
        });
        $("select[name='header_button4']").change(function(){
            $("#button4_show").attr('src',$(this).val());
            if($(this).val()=="custom"){
                $("input[name='custom_button4_src']").fadeTo(1000,1);
            }else{
                $("input[name='custom_button4_src']").fadeTo(1000,0);
            }
            custom_button_setting();
        });
        $("input[name='custom_button3_src']").change(function(){
            if($("select[name='header_button3']").val() == "custom"){
                $("#button3_show").attr('src',$(this).val());
            } 
        });
        $("input[name='custom_button4_src']").change(function(){
            if($("select[name='header_button4']").val() == "custom"){
                $("#button4_show").attr('src',$(this).val());
            } 
        });
        
        function custom_button_setting(){
            if($("select[name='header_button3']").val() == "custom" || $("select[name='header_button4']").val() == "custom"){
                $("#custom_button_tips").fadeTo(1500,1);
                $("#custom_button_src").fadeTo(1000,1);
            }else{
                $("#custom_button_tips").fadeTo(1500,0);
                $("#custom_button_src").fadeTo(1000,0);
            }
        }
<?php
if (get_option('simplemetro_header_button3') != get_template_directory_uri() . '/images/header-menu-twitter.png'
        && get_option('simplemetro_header_button3') != get_template_directory_uri() . '/images/header-menu-sinaweibo.png'
        && get_option('simplemetro_header_button3') != get_template_directory_uri() . '/images/header-menu-qqweibo.png'
        && get_option('simplemetro_header_button3') != get_template_directory_uri() . '/images/header-menu-renren.png'
        && get_option('simplemetro_header_button3') != get_template_directory_uri() . '/images/header-menu-rss.png') {
    ?>
                $("select[name='header_button3']").val('custom');
                $("#custom_button_tips").fadeTo(1500,1);
                $("#custom_button_src").fadeTo(1000,1);
                $("input[name='custom_button3_src']").fadeTo(1000,1);
    <?php
}
if (get_option('simplemetro_header_button4') != get_template_directory_uri() . '/images/header-menu-twitter.png'
        && get_option('simplemetro_header_button4') != get_template_directory_uri() . '/images/header-menu-sinaweibo.png'
        && get_option('simplemetro_header_button4') != get_template_directory_uri() . '/images/header-menu-qqweibo.png'
        && get_option('simplemetro_header_button4') != get_template_directory_uri() . '/images/header-menu-renren.png'
        && get_option('simplemetro_header_button4') != get_template_directory_uri() . '/images/header-menu-rss.png') {
    ?>
                $("select[name='header_button4']").val('custom');
                $("#custom_button_tips").fadeTo(1500,1);
                $("#custom_button_src").fadeTo(1000,1);
                $("input[name='custom_button4_src']").fadeTo(1000,1);
    <?php
}
?>
        
        
    });
</script>

