<?php
/* * **
* For GDN
 */
 
class jaw_rate_post_gdn_widget extends jaw_default_widget {

    /**
     *  Defining the widget options
     */
    protected $options = array(
        0 => array('id' => 'ratings_title',
            'description' => 'Widget title',
            'type' => 'text', // [[ text, check, select ]]
            'default' => 'Rating'),
        1 => array('id' => 'post_id',
            'description' => 'Post ID - Insert ID of post which rating you want to show.<br><strong>Use 0 for actual post.</strong>',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '0'),
    );

    function __construct() {
        $options = array('classname' => 'jwRatePostWidget', 'description' => "widget for rating posts");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jwRatePostWidget', 'J&W - Rate Post Widget for G`Day News', $options, $controls);
    }

    function widget($args, $instance) {
        $instance['ratings_title'] = apply_filters( 'widget_title', empty($instance['ratings_title']) ? '' : $instance['ratings_title'], $instance );
        $data = array(
            'args' => $args,
            'instance' => $instance
        );
        jaw_template_set_data($data);
        echo jaw_get_template_part('jaw_rate_post_gdn_widget', 'widgets');
    }

}
