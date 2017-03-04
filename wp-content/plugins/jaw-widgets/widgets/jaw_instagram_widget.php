<?php

/**
 * jwinstagram_widget
 * 
 * 
 */
class jaw_instagram_widget extends jaw_default_widget {

    /**
     *  Defining the widget options
     */
    protected $options = array(
        0 => array('id' => 'widget_title',
            'description' => 'Title',
            'type' => 'text',
            'default' => 'Instagram'),
        1 => array('id' => 'i_username',
            'description' => 'Instagram user ID (<a href="http://jelled.com/instagram/lookup-user-id" target="_blank">Get it</a>)', 
            'type' => 'text',
            'default' => ''),
        2 => array('id' => 'images_per_row',
            'description' => 'Images per row',
            'type' => 'select',
            'default' => '6',
            'values' => array(
                array('name' => '1', 'value' => '12'),
                array('name' => '2', 'value' => '6'),
                array('name' => '3', 'value' => '4'),
                array('name' => '4', 'value' => '3'),
                array('name' => '6', 'value' => '2')
            ),
        ),
        3 => array('id' => 'images_count',
            'description' => 'Images Count',
            'type' => 'text',
            'default' => '10'
        ),
        4 => array('id' => 'target',
            'description' => 'Image Target',
            'type' => 'select',
            'default' => '_self',
            'values' => array(
                array('name' => '_self', 'value' => '_self'),
                array('name' => '_blank', 'value' => '_blank')
            ),
            'default' => '_blank'
        ),
        5 => array('id' => 'description',
            'description' => ' Instagram Icon After Hover',
            'type' => 'select',
            'values' => array(
                array('name' => 'Show', 'value' => true),
                array('name' => 'Hide', 'value' => false)
            ),
            'default' => 'true'
        ),
        6 => array('id' => 'description_text',
            'description' => 'Description Text',
            'type' => 'text',
            'default' => 'Check on Instagram'
        ),
    );

    function __construct() {
        $options = array('classname' => 'jaw_instagram_widget', 'description' => "J&W - instagram Widget.");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('jaw_instagram_widget', 'J&W - Instagram Widget', $options, $controls);
    }

    function widget($args, $instance) {

        $expiration = 60 * 60; //once per hour

        $hash = md5(serialize($instance)); //kdyz se zmeni nastaveni - tak se prerenderuje widget

        $data['args'] = $args;
        $instance['widget_title'] = apply_filters( 'widget_title', empty($instance['widget_title']) ? '' : $instance['widget_title'], $instance );
        $data['instance'] = $instance;
        
        $transient_name = 'jaw_instagram_widget_cache_'.$args["widget_id"];
        //pokud cache vyprsela 
        $feedData = get_transient($transient_name);
        if( false === $feedData || (isset($feedData->hash) && $hash != $feedData->hash)){
            $feedData = array();
            $feedData = $this->_collect_data($instance);
            $feedData->hash = $hash; 
            set_transient($transient_name, $feedData, $expiration);
        }else{
            echo '<!-- JaW instagram Widget is Cached -->';
        }
        $data['decode'] = $feedData;
        jaw_template_set_data($data, $this);
        echo jaw_get_template_part('jaw_instagram_widget', 'widgets');
    }

    private function _collect_data($instance){
        $feedData = false;
        if (jwOpt::get_option('instagram_token', '') != '') {
            $response_media = wp_remote_retrieve_body(wp_remote_request('https://api.instagram.com/v1/users/' . $instance["i_username"] . '/media/recent/?access_token=' . jwOpt::get_option('instagram_token', ''), array('method' => 'GET')));
            $feedData = json_decode($response_media);
            if($feedData == NULL) {
                $feedData = false;
            }
        }
        return $feedData;
    } 
}
