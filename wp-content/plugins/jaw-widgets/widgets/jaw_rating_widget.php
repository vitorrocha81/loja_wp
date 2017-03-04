<?php
class feedData{
    public $ratings; 
}

/* zobrazi oratovanae posty */
class jaw_rating_widget extends jaw_default_widget {

    /**
     *  Defining the widget options
     */
    protected $options = array(
        0 => array('id' => 'ratings_title',
            'description' => 'Ratings title:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => 'Ratings'),
        1 => array('id' => 'ratings_categories',
            'description' => 'Exclude / include categories by id. E.g. 1,5,-8:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => ''),
        2 => array('id' => 'rats_num_of_posts',
            'description' => 'Number of rating`s posts to show:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '3'),
    );

    function __construct() {
        $options = array('classname' => 'jwRatingWidget', 'description' => "widget - overview of ratings");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jwRatingWidget', 'J&W - Rating Widget', $options, $controls);
    }

    function widget($args, $instance) {
        global $post;

        $ratings = $this->_get_ratings_posts($instance);

        if (!empty($ratings)) {
            $feedData = new feedData();
            $feedData->ratings = $ratings;
            $ret['feedData'] = $feedData;
        }
        $instance['ratings_title'] = apply_filters( 'widget_title', empty($instance['ratings_title']) ? '' : $instance['ratings_title'], $instance );
        $ret['args'] = $args;
        $ret['instance'] = $instance;
        $ret['ratings'] = $ratings;

        jaw_template_set_data($ret, $this);
        echo jaw_get_template_part('jaw_rating_widget', 'widgets');
    }

    private function _get_ratings_posts($instance) {
        $args = array(
            'orderby' => 'post_date',
            'order' => 'desc',
            'numberposts' => $instance['rats_num_of_posts'],
            'meta_key' => 'fw_rating_overal',
            'meta_value' => '1',
            'suppress_filters' => false
        );
        if (!empty($instance['ratings_categories'])) {
            $args['category'] = $instance['ratings_categories'];
        }        
        $posts = get_posts($args);        
        return $posts;
    }

}