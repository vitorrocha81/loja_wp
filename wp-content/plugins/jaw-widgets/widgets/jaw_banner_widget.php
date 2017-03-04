<?php

class jaw_banner_widget extends jaw_default_widget {

    /**
     *  Defining the widget options
     */
    protected $options = array(
        0 => array('id' => 'custom_banner',
            'description' => 'Banner',
            'type' => 'select',
            'values' => array(
                array('name' => 'Custom Banner 1', 'value' => '1'),
                array('name' => 'Custom Banner 2', 'value' => '2'),
                array('name' => 'Custom Banner 3', 'value' => '3'),
                array('name' => 'Custom Banner 4', 'value' => '4'),
                array('name' => 'Custom Banner 5', 'value' => '5'),
                array('name' => 'Custom Banner 6', 'value' => '6'),
                array('name' => 'Custom Banner 7', 'value' => '7'),
                array('name' => 'Custom Banner 8', 'value' => '8'),
                array('name' => 'Custom Banner 9', 'value' => '9'),
                array('name' => 'Custom Banner 10', 'value' => '10')
            ),
            'default' => 'custom_banner_1',
        ),
    );

    /**
     * Registering the widget to the wordpress
     */
    function __construct() {
        $options = array('classname' => 'jwBannerWidget', 'description' => "The widget for displaying your custom Banner");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jwBannerWidget', 'J&W - Custom Banner Widget', $options, $controls);
    }

    function widget($args, $instance) {
        $ret['args'] = $args;
        $ret['instance'] = $instance;

        jaw_template_set_data($ret, $this);
        echo jaw_get_template_part('jaw_banner_widget', 'widgets');
    }

}

?>