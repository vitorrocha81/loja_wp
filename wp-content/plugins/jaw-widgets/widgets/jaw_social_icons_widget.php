<?php
/* * **
* For GDN
 */
 
class jaw_social_icons_widget extends jaw_default_widget {

    /**
     *  Defining the widget options
     */
    protected $options = array(
        0 => array('id' => 'box_title',
            'description' => 'Title',
            'type' => 'text',
            'default' => 'Social'),
        1 => array('id' => 'facebook',
            'description' => 'Facebook URL',
            'type' => 'text',
            'default' => ''),
        2 => array('id' => 'twitter',
            'description' => 'Twitter URL',
            'type' => 'text',
            'default' => ''),
        3 => array('id' => 'google',
            'description' => 'Google plus URL',
            'type' => 'text',
            'default' => ''),
        4 => array('id' => 'youtube',
            'description' => 'YouTube URL',
            'type' => 'text',
            'default' => ''),
        5 => array('id' => 'vimeo',
            'description' => 'Vimeo URL',
            'type' => 'text',
            'default' => ''),
        6 => array('id' => 'linkedin',
            'description' => 'Linkedin URL',
            'type' => 'text',
            'default' => ''),
        7 => array('id' => 'pinterest',
            'description' => 'Pinterest URL',
            'type' => 'text',
            'default' => ''),
        8 => array('id' => 'flickr',
            'description' => 'Flickr URL',
            'type' => 'text',
            'default' => ''),
        9 => array('id' => 'instagram',
            'description' => 'Instagram URL',
            'type' => 'text',
            'default' => ''),
        10 => array('id' => 'size',
            'description' => 'Size in px',
            'type' => 'text',
            'default' => '32'),
        11 => array('id' => 'color',
            'description' => 'Color',
            'type' => 'text',
            'default' => '#666666'),
        12 => array('id' => 'target',
            'description' => 'Link Target',
            'type' => 'select',
            'values' => array(
                array('name' => '_self', 'value' => '_self'),
                array('name' => '_blank', 'value' => '_blank')
            ),
            'default' => '_blank'),
    );

    function __construct() {
        $options = array('classname' => 'jaw_social_icons_widget', 'description' => "Theme-based icon links to your profiles on the most common social networks");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jaw_social_icons_widget', 'J&W - Social Icons Widget', $options, $controls);
    }

    function widget($args, $instance) {
        $social = $instance;
        $instance['social'] = $social;
        $instance['box_title'] = apply_filters( 'widget_title', empty($instance['box_title']) ? '' : $instance['box_title'], $instance );
        $data = array(
            'args' => $args,
            'instance' => $instance
        );
        jaw_template_set_data($data);
        echo jaw_get_template_part('jaw_social_icons_widget', 'widgets');
    }



}
