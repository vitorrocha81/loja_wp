<?php

/**
 * Prints 4 types of feed:
 * Popular ( posts )
 * Recent ( posts )
 * Comments ( comment )
 * Tags ( in post table )
 * 
 * 
 * informace jsou ve funkci widget, doporucuju kazdou promenou vardumpnout
 */
class jaw_recent_comments_widget_gdn extends jaw_default_widget {

    /**
     *  Defining the widget options
     */
    protected $options = array(
        /*         * *************************************************************************** */
        /* COMMENTS AREA 
          /***************************************************************************** */
        0 => array('id' => 'comments_title',
            'description' => 'recent comments title:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => 'Comments'),
        1 => array('id' => 'comments_num_of_posts',
            'description' => 'Number of recent comments to show:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '5'),
        2 => array('id' => 'comments_excerpt_num',
            'description' => 'Comments excerpt:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => '100'),
        3 => array('id' => 'comments_author_show',
            'description' => 'Show author\'s name ',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 1),
        4 => array('id' => 'comments_meta_show',
            'description' => 'Show date ',
            'type' => 'checkbox', // [[ text, check, select ]]
            'default' => 1),
    );

    /**
     * Registering the widget to the wordpress
     */
    function __construct() {
        
        $options = array('classname' => 'recent_comments_widget_gdn', 'description' => "Theme styled recent comments to be displayed in a preview tabs");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('recent_comments', 'J&W - Recent Comments Widget', $options, $controls);
    }


    /**
     * Printing widget, called by wordpress
     */
    function widget($args, $instance) {
        
        extract($args); 
        
        echo $before_widget;
        
        if(!empty($instance["comments_title"])){
            $instance['comments_title'] = apply_filters( 'widget_title', empty($instance['comments_title']) ? '' : $instance['comments_title'], $instance );
            echo $before_title . $instance["comments_title"] . $after_title;
        }
        if(!isset($instance['comments_num_of_posts'])){
            $instance['comments_num_of_posts'] = '6';
        }
        if(!isset($instance['comments_excerpt_num'])){
            $instance['comments_excerpt_num'] = '100';
        }
        if(!isset($instance['comments_author_show'])){
            $instance['comments_author_show'] = '1';
        }
        if(!isset($instance['comments_meta_show'])){
            $instance['comments_meta_show'] = '1';
        }
        echo do_shortcode('[jaw_recent_comments number="'.$instance['comments_num_of_posts'].'" excerpt_length="'.$instance['comments_excerpt_num'].'" show_author="'.$instance['comments_author_show'].'" show_date="'.$instance['comments_meta_show'].'"]');
        
        echo $after_widget;
    }
    
}
