<?php

class jaw_jaw_gallery_widget extends jaw_default_widget {
    
    protected $options = array(
        0 => array('id' => 'widget_title',
            'description' => 'Title',
            'type' => 'text',
            'default' => 'JaW Gallery'
        ),        
        1 => array(
            'id' => 'jaw_gallery_id',
            'description' => 'JaW Gallery ID:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => ''
        ),
        2 => array(
            'id' => 'jaw_gallery_type',
            'description' => 'JaW Gallery Type:',
            'type' => 'select', // [[ text, check, select ]]
            'default' => '4',
            'values' => array(
                array('name' => 'Single', 'value' => 'single'),
                array('name' => 'Vertical', 'value' => 'vertical'),
                array('name' => 'Horizontal', 'value' => 'horizontal'),
            )
        ),
         3 => array(
            'id' => 'jaw_gallery_thumbs',
            'description' => 'JaW Gallery Thumbnails (not for the Single type)',
            'type' => 'select', // [[ text, check, select ]]
            'default' => '4',
            'values' => array(
                array('name' => '4 Thumbnails', 'value' => '4'),
                array('name' => '6 Thumbnails', 'value' => '6')
            )
        )
    );
    function __construct() {
        $options = array('classname' => 'jaw_jaw_gallery_widget', 'description' => "J&W Gallery Widget.");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jaw_jaw_gallery_widget', 'J&W Gallery Widget', $options, $controls);
    }
    function widget($args, $instance) {
        $ret['args'] = $args;
        $ret['instance'] = $instance;

        jaw_template_set_data($ret, $this);
        echo jaw_get_template_part('jaw_jaw_gallery_widget', 'widgets');
    }
}
