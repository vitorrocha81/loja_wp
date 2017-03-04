<?php
/* * **
* For GDN
 */

class jaw_submit_message_widget extends jaw_default_widget {

    private static $_model = null;

    /**
     *  Defining the widget options
     */
    protected $options = array(
        0 => array('id' => 'box_title',
            'description' => 'Title',
            'type' => 'text',
            'default' => ''),
        1 => array('id' => 'style',
            'description' => 'Submit Message Text',
            'type' => 'text',
            'default' => 'Leave a Tip'
        ),
        2 => array('id' => 'icon',
            'description' => 'Put class of an icon',
            'type' => 'text',
            'default' => 'jaw-icon-pen'
        ),
        3 => array('id' => 'modal_id',
            'description' => 'Popup maker ID <a href="http://support.jawtemplates.com/gdaynews/web/how-to-set-up-submit-message-video-button/" target="_blank">tutorial</a>',
            'type' => 'text',
            'default' => ''),
    );

    /**
     * Registering the widget to the wordpress
     */
    function __construct() {
        $options = array('classname' => 'jwSubmitMessage', 'description' => "Theme-based Submit message");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jwSubmitMessage', 'J&W - Submit Message Widget', $options, $controls);
    }

    /**
     * Printing widget, called by wordpress
     */
    function widget($args, $instance) {
        $instance['box_title'] = apply_filters( 'widget_title', empty($instance['box_title']) ? '' : $instance['box_title'], $instance );
        $data = array(
            'args' => $args,
            'instance' => $instance
        );
        jaw_template_set_data($data);   
        echo jaw_get_template_part('jaw_submit_message_widget', 'widgets');   
    }


}

