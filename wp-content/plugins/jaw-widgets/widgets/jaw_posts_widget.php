<?php

/**
 * widget for GdayNews
 * 
 * informace jsou ve funkci widget, doporucuju kazdou promenou vardumpnout
 */
class jaw_posts_widget extends jaw_default_widget {

    private $opt_values = array();

    /**
     *  Defining the widget options
     */ 
    protected $options = array(
        /*         * *************************************************************************** */
        /* POSTS AREA
          /***************************************************************************** */
        array('id' => 'post_title',
            'description' => 'Widget title:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => 'Posts'),
        array('id' => 'posts_show',
            'description' => 'Order Posts by',
            'type' => 'select', // [[ text, check, select ]]
            'default' => 'Recent',
            'values' => array(
                array('name' => 'Recent Posts', 'value' => 'recent'),
                array('name' => 'Modified Date', 'value' => 'modified'),
                array('name' => 'Title', 'value' => 'title'),
                array('name' => 'Posts In', 'value' => 'post__in'),
                array('name' => 'Random Posts', 'value' => 'rand'),
                array('name' => 'Menu Order', 'value' => 'menu_order'),
                array('name' => 'The Most Commented Posts', 'value' => 'comments'),
                array('name' => 'The Most Recent Commented Posts', 'value' => 'recend_comments'),
                array('name' => 'The Most Liked Posts', 'value' => 'liked'),
                array('name' => 'The Most Read Posts', 'value' => 'read')
            ),
        ),
        array('id' => 'posts_order',
            'description' => 'Order Posts',
            'type' => 'select', // [[ text, check, select ]]
            'default' => 'Desc',
            'values' => array(
                array('name' => 'Desc', 'value' => 'desc'),
                array('name' => 'Asc', 'value' => 'asc')
            ),
        ),
        array('id' => 'post_categories',
            'description' => 'Include / exclude categories by id. E.g. 1,5,-8:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => ''),
        array('id' => 'post_in',
            'description' => 'Include / exclude posts by id. E.g. 725,545',
            'type' => 'text', // [[ text, check, select ]]
            'default' => ''),
        array('id' => 'num_of_posts',
            'description' => 'Number of posts to show:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '5'),
        array('id' => 'offset',
            'description' => 'Offset posts:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '0'),
        array('id' => 'columns',
            'description' => 'Number of columns:',
            'type' => 'select', // [[ text, check, select ]]
            'default' => '12',
            'values' => array(
                array('name' => '1', 'value' => '12'),
                array('name' => '2', 'value' => '6'),
                array('name' => '3', 'value' => '4'),
                array('name' => '4', 'value' => '3'),
                array('name' => '6', 'value' => '2'),
            )),
        array('id' => 'posts_type',
            'description' => 'Post Type:',
            'type' => 'select', // [[ text, check, select ]]
            'default' => 'Simple',
            'values' => array(
                array('name' => 'Simple', 'value' => 'simple'),
                array('name' => 'Simple with numbers', 'value' => 'simple_numbers'),
                array('name' => 'Vertical', 'value' => 'vertical'),
                array('name' => 'Vertical Small', 'value' => 'vertical-small'),
                array('name' => 'Mix', 'value' => 'mix'),
            ),
        ),
        array('id' => 'letter_excerpt_title',
            'description' => 'Number of Characters - Post Titles',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '50'),
        array('id' => 'letter_excerpt',
            'description' => 'Number of Characters - Excerpt in Main Post',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '50'),
        array('id' => 'blog_comments_inimage',
            'description' => 'Show Comments Count in Image',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 0),
        array('id' => 'blog_category_inimage',
            'description' => 'Show Category Labels in Image',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 1),
        array('id' => 'blog_meta_author',
            'description' => 'Show Author',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 0),
        array('id' => 'blog_comments_count',
            'description' => 'Show Comments Count',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 1),
        array('id' => 'blog_metadate',
            'description' => 'Show Date',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 1),
        array('id' => 'blog_meta_category',
            'description' => 'Show Categories',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 0),
        array('id' => 'blog_ratings',
            'description' => 'Show Rating',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 0),
        array('id' => 'blog_meta_like',
            'description' => 'Show Post likes.',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 0),
        array('id' => 'blog_readers',
            'description' => 'Show Number of Readers',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 0),
        array('id' => 'how_old_posts',
            'description' => 'How old posts to get',
            'type' => 'select', // [[ text, check, select ]]
            'default' => 'all',
            'values' => array(
                array('name' => 'Last Day', 'value' => '1'),
                array('name' => 'Last Week', 'value' => '7'),
                array('name' => 'Last 14 days', 'value' => '14'),
                array('name' => 'Last Month', 'value' => '30'),
                array('name' => 'Last 3 Month', 'value' => '90'),
                array('name' => 'All time', 'value' => 'all'),
            )
        ),
        array('id' => 'clickable_image',
            'description' => 'Clickable Images',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 1),
        array('id' => 'post_widget_cache',
            'description' => 'Cache time in minutes (if you`re using some cache plugin, set this to 0)',
            'type' => 'text', // [[ text, check, select ]]
            'default' => 1440),
    );

    /**
     * Registering the widget to the wordpress
     */
    function __construct() {

        $options = array('classname' => 'posts_widget', 'description' => "Theme with all type of posts to be displayed in a preview tabs");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('posts', 'J&W - Posts Widget for Gdaynews', $options, $controls);
    }

    private function _print_widget($args, $instance, $feedData) {
        global $post;
        /*
         * data naleznes ve stdClass feedData.
         * Ma nasledujici attributy:
         * - popular_posts			// klasicky post
         * - recent_posts			// klasicky post
         * - recent_comments		// class comment
         * - tags					// class tag
         * 
         * !! V pripade ze tisknes post, je moznost ze se neaplikuji vsechny 
         * filtry ( napr na post content nebo excerpt). Pokud by to blblo, tak :
         * 
         * foreach( $feedData->popular_posts as $post ) {
         * 	setup_postdata( $post );
         * 	the_title(), the_content() || get_the_title(), get_the_content;
         * }
         * 
         * jinak presny struktury jednotlivych trid neznam, resil bych to stejne
         * jak ty var_dump, tak v tom neporadim :(
         * 
         * pokud nejsou zadna data, tak je promenna nastavena na null
         */
        $instance['post_title'] = apply_filters( 'widget_title', empty($instance['post_title']) ? '' : $instance['post_title'], $instance );
        $ret['args'] = $args;
        $ret['instance'] = $instance;
        $ret['feedData'] = $feedData;
        jaw_template_set_data($ret, $this);


        // meta
        if (isset($instance['blog_meta_author'])) {
            jaw_template_set_var("blog_meta_author", $instance['blog_meta_author']);
        }
        if (isset($instance['blog_metadate'])) {
            jaw_template_set_var("blog_metadate", $instance['blog_metadate']);
        }
        if (isset($instance['blog_comments_count'])) {
            jaw_template_set_var("blog_comments_count", $instance['blog_comments_count']);
        }
        if (isset($instance['blog_meta_category'])) {
            jaw_template_set_var("blog_meta_category", $instance['blog_meta_category']);
        }
        if (isset($instance['blog_ratings'])) {
            jaw_template_set_var("blog_ratings", $instance['blog_ratings']);
        }
        if (isset($instance['blog_meta_like'])) {
            jaw_template_set_var("blog_meta_like", $instance['blog_meta_like']);
        }
        if (isset($instance['blog_readers'])) {
            jaw_template_set_var("blog_readers", $instance['blog_readers']);
        }
        if (isset($instance['letter_excerpt_title'])) {
            jaw_template_set_var("letter_excerpt_title", $instance['letter_excerpt_title']);
        }
        if (isset($instance['letter_excerpt'])) {
            jaw_template_set_var("letter_excerpt", $instance['letter_excerpt']);
        }
        if (isset($instance['clickable_image'])) {
            jaw_template_set_var("clickable_image", $instance['clickable_image']);
        }
        if (isset($instance['blog_comments_inimage'])) {
            jaw_template_set_var("blog_comments_inimage", $instance['blog_comments_inimage']);
        }
        if (isset($instance['blog_category_inimage'])) {
            jaw_template_set_var("blog_category_inimage", $instance['blog_category_inimage']);
        }
        if (isset($instance['columns'])) {
            jaw_template_set_var("columns", $instance['columns']);
        }else{
            jaw_template_set_var("columns", 12);
        }
        echo jaw_get_template_part('jaw_posts_widget', 'widgets');
    }

    /**
     * Printing widget, called by wordpress
     */
    function widget($args, $instance) {
        $expiration = 1440*60;
        if(isset($instance['post_widget_cache'])){
            $expiration = $instance['post_widget_cache']*60;
        }
        $hash = md5(serialize($instance));
        
        $transient_name = 'jaw_post_widget_cache_'.$args["widget_id"];
        //pokud je zaply debug nebo cache vyprsela nebo je vypla
        $feedData = get_transient($transient_name);
        if( current_user_can('manage_options') || $expiration == 0 || false === $feedData || (isset($feedData->hash) && $hash != $feedData->hash)){
            $feedData = array();
            $feedData = $this->_collect_data($instance);
            $feedData->hash = $hash; 
            set_transient($transient_name, $feedData, $expiration);
        }else{
            echo '<!-- JaW Posts Widget is Cached -->';
        }
        $this->_print_widget($args, $instance, $feedData);
    }

    /*     * *************************************************************************** */
    /* COLLECTING DATA
      /***************************************************************************** */

    private function _collect_data($instance) {
        $this->opt_values = $instance;
        $feedData = new stdClass();
        $feedData->popular_posts = null;
        $feedData->recent_posts = null;
        if(empty($instance['posts_order'])){
            $instance['posts_order'] = 'desc';
        }
        if (isset($instance['posts_show'])) {
            if(isset($instance['how_old_posts']) && $instance['how_old_posts'] != 'all'){
                add_filter('posts_where', array(&$this, 'filter_how_old_posts'));
            }
            switch ($instance['posts_show']) {
                case "comments" :
                    $instance['comment_count'] = "date";
                    $popular_posts = $this->_get_posts($instance);
                    if (!empty($popular_posts)) {
                        $feedData->posts = $popular_posts;
                    }
                    break;
                case "recent" :
                    $instance['posts_show'] = "date";
                    $recent_posts = $this->_get_posts($instance);
                    if (!empty($recent_posts)) {
                        $feedData->posts = $recent_posts;
                    }
                    break;
                case "liked" :
                    $liked_posts = $this->_get_liked_posts($instance);
                    if (!empty($liked_posts)) {
                        $feedData->posts = $liked_posts;
                    }
                    break;
                case "read" :
                    $read_posts = $this->_get_read_posts($instance);
                    if (!empty($read_posts)) {
                        $feedData->posts = $read_posts;
                    }
                    break;
                case "recend_comments" :
                    $recend_comments_posts = $this->_get_recend_comments_posts($instance);
                    if (!empty($recend_comments_posts)) {
                        $feedData->posts = $recend_comments_posts;
                    }
                    break;
                default;
                    $posts = $this->_get_posts($instance);
                    if (!empty($posts)) {
                        $feedData->posts = $posts;
                    }
                    break;
            }
            remove_filter('posts_where', array(&$this, 'filter_how_old_posts'));
        }

        return $feedData;
    }

    private function _get_posts($instance) {
        $args = array('orderby' => $instance['posts_show'], 'order' => $instance['posts_order'], 'posts_per_page' => $instance['num_of_posts']);
        if (!empty($instance['post_categories']))
            $args['cat'] = $instance['post_categories'];
        if (!empty($instance['post_in']))
            $args['post__in'] = explode(',',$instance['post_in']);
        if (!empty($instance['offset']))
            $args['offset'] = $instance['offset'];
        $args['suppress_filters'] = false;
        $posts = query_posts($args);
        return $posts;
    }
    
    private function _get_liked_posts($instance) {
        $args = array('meta_key' => 'jaw_rating_value', 'orderby' => 'meta_value_num', 'order' => $instance['posts_order'], 'posts_per_page' => $instance['num_of_posts']);
        if (!empty($instance['post_categories']))
            $args['cat'] = $instance['post_categories'];
        if (!empty($instance['post_in']))
            $args['post__in'] = explode(',',$instance['post_in']);
        if (!empty($instance['offset']))
            $args['offset'] = $instance['offset'];
        $args['suppress_filters'] = false;
        $posts = query_posts($args);
        return $posts;
    }
    
    private function _get_read_posts($instance) {
        $args = array('meta_key' => 'jaw_readers', 'orderby' => 'meta_value_num', 'order' => $instance['posts_order'], 'posts_per_page' => $instance['num_of_posts']);
        if (!empty($instance['post_categories']))
            $args['cat'] = $instance['post_categories'];
        if (!empty($instance['post_in']))
            $args['post__in'] = explode(',',$instance['post_in']);
        if (!empty($instance['offset']))
            $args['offset'] = $instance['offset'];
        $args['suppress_filters'] = false;
        $posts = query_posts($args);
        return $posts;
    }
    
    private function _get_recend_comments_posts($instance) {
        $args = array('order' => $instance['posts_order'], 'posts_per_page' => $instance['num_of_posts']);
        if (!empty($instance['post_categories']))
            $args['cat'] = $instance['post_categories'];
        if (!empty($instance['post_in']))
            $args['post__in'] = explode(',',$instance['post_in']);
        if (!empty($instance['offset']))
            $args['offset'] = $instance['offset'];
        $args['suppress_filters'] = false;
        add_filter( 'posts_clauses', array(&$this,'filter_recend_comments'), 20, 1 );        
        $posts = query_posts($args);
        remove_filter( 'posts_clauses',array(&$this,'filter_recend_comments'), 20);
        return $posts;
    }
    
   
    
    public function filter_how_old_posts($where = '') {
        //posts in the last XX days
        if(isset($this->opt_values['how_old_posts'])){
            $where .= " AND post_date > '" . date('Y-m-d', strtotime('-'.$this->opt_values['how_old_posts'].' days')) . "'";
        }
        return $where;
    }
    
     function filter_recend_comments( $pieces ) {
        global $wpdb;
    
        $pieces['fields'] = "wp_posts.*,
        (
            select max(comment_date)
            from " . $wpdb->comments ." wpc
            where wpc.comment_post_id = wp_posts.id AND wpc.comment_approved = 1
        ) as mcomment_date";
        $pieces['orderby'] = "mcomment_date desc";
    
        return $pieces;
    }

}
