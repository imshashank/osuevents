<?php

/**
 * Goecraft Recent Post Widget
 * This widget shows latest place post
 */
class GeoCraft_Recent_Post extends WP_Widget {

    /** constructor */
    function __construct() {
        $widget_ops = array(
            'classname' => 'geocraft_recent_posts_widget',
            'description' => R_S_R_C_PTYPE
        );
        parent::__construct('advanced-recent-posts', R_GEO_P, $widget_ops);
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? 'Recent Listing' : $instance['title'], $instance, $this->id_base);
        if (!$number = absint($instance['number']))
            $number = 5;
        if (!$excerpt_length = absint($instance['excerpt_length']))
            $excerpt_length = 5;
        if (!$show_type = $instance["show_type"])
            $show_type = 'post';
        $default_sort_orders = array('date', 'title', 'comment_count', 'rand');
        // by default, display latest first
        $sort_by = 'date';
        $sort_order = 'DESC';
        //Excerpt more filter
        $new_excerpt_more = create_function('$more', 'return " ";');
        add_filter('excerpt_more', $new_excerpt_more);
        // Excerpt length filter
        $new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
        if ($instance["excerpt_length"] > 0)
            add_filter('excerpt_length', $new_excerpt_length);
        // post info array.
        $my_args = array(
            'showposts' => $number,
            'orderby' => $sort_by,
            'order' => $sort_order,
            'post_type' => $show_type
        );
        $adv_recent_posts = '';
        $excerpt_readmore = '[...]';
        $linkmore .= ' <a href="' . get_permalink() . '" class="more-link">' . $excerpt_readmore . '</a>';
        $adv_recent_posts = new WP_Query($my_args);
        echo $before_widget;
        // Widget title
        ?>
        <!--Start Review Thumb-->
        <div class="review_thumb">
            <h4 class="recent_title"><?php echo $instance["title"]; ?></h4>
            <?php
            global $post;
            while ($adv_recent_posts->have_posts()) {
                $adv_recent_posts->the_post();
                 $img_meta =  get_post_meta($post->ID, 'geocraft_meta_image1', true);
                ?>      
                <!--Start Review Element-->
                <div class="r_element">
                 
                        <?php inkthemes_get_image(38, 38, 'r_thumb', $img_meta); ?> 
              
                    <div class="r_content">
                        <h6 class="r_title"><a  href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>" class="post-title"><?php the_title(); ?></a></h6>
                            <?php if ($instance['date']) : ?>
                            <p class="post-date"><?php the_time("j M Y"); ?></p>
                            <?php endif; ?>
                        <ul class="r_rating">
                        <?php
                        global $post;
                        echo geocraft_get_post_rating_star($post->ID);
                        ?>
                        </ul>
                            <?php if ($instance['excerpt']) : ?>
                            <div class="post-entry">                   
                            <?php if ($instance['excerpt']) : ?>                            
                                    <p><?php echo get_the_excerpt() . $linkmore; ?> </p>
                            <?php endif; ?>
                            </div>
                        <?php endif; ?>               
                        <?php if ($instance['comment_num']) : ?>
                            <p class="r_excerpt">                     
                                (<?php comments_number(); ?>)                
                            </p>
                <?php endif; ?>
                    </div>
                </div>
                <!--End Review Element-->  

            <?php
        }
        wp_reset_query();
        ?>
        </div>
        <!--End Review Thumb-->
        <?php
        echo $after_widget;
        remove_filter('excerpt_length', $new_excerpt_length);
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['sort_by'] = esc_attr($new_instance['sort_by']);
        $instance['show_type'] = esc_attr($new_instance['show_type']);
        $instance['number'] = absint($new_instance['number']);
        $instance['date'] = esc_attr($new_instance['date']);
        $instance['comment_num'] = esc_attr($new_instance['comment_num']);
        $instance["excerpt_length"] = absint($new_instance["excerpt_length"]);
        $instance["excerpt"] = esc_attr($new_instance["excerpt"]);
        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : R_RECENT_POST;
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_type = isset($instance['show_type']) ? esc_attr($instance['show_type']) : 'post';
        $excerpt_length = isset($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 5;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo R_TITLE; ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p>
            <label for="<?php echo $this->get_field_id("sort_by"); ?>">
        <?php echo R_SORT_BY; ?>:
                <select id="<?php echo $this->get_field_id("sort_by"); ?>" name="<?php echo $this->get_field_name("sort_by"); ?>">
                    <option value="date"<?php selected($instance["sort_by"], "date"); ?>><?php echo R_DATE; ?></option>
                    <option value="title"<?php selected($instance["sort_by"], "title"); ?>><?php echo R_TITLE; ?></option>
                    <option value="comment_count"<?php selected($instance["sort_by"], "comment_count"); ?>><?php echo R_N_CMT; ?></option>
                    <option value="rand"<?php selected($instance["sort_by"], "rand"); ?>><?php echo R_RANDOM; ?></option>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("excerpt"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked((bool) $instance["excerpt"], true); ?> />
        <?php echo R_I_POST; ?>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("excerpt_length"); ?>">
                <?php echo R_EXCERPT_L; ?>
            </label>
            <input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>" name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php echo $excerpt_length; ?>" size="3" />
        </p>      
        <p>
            <label for="<?php echo $this->get_field_id("date"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked((bool) $instance["date"], true); ?> />
                <?php echo R_IN_POST_D; ?>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("comment_num"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php checked((bool) $instance["comment_num"], true); ?> />
        <?php echo R_NO_CMT; ?>
            </label>
        </p>
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php echo R_NO_P_SHOW; ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p>
            
                <input type="hidden" id="<?php echo $this->get_field_id('show_type'); ?>" name="<?php echo $this->get_field_name('show_type'); ?>" value="listing"/>
             
        </p>
        <?php
    }

}

function Geocraft_recent_post() {
    register_widget('GeoCraft_Recent_Post');
}

// register RecentPostsPlus widget
add_action('widgets_init', 'Geocraft_recent_post');
?>
