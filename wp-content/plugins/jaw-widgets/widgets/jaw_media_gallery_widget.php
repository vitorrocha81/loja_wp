<?php

/**
 * widget for GdayNews
 * 
 * informace jsou ve funkci widget, doporucuju kazdou promenou vardumpnout
 */
class jaw_media_gallery_widget extends jaw_default_widget {

    private $opt_values = array();

    /**
     *  Defining the widget options
     */ 
    protected $options = array(
        /*         * *************************************************************************** */
        /* POSTS AREA
          /***************************************************************************** */
        0 => array('id' => 'media_gallery_title',
            'description' => 'Widget title:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => 'Gallery'),
        1 => array('id' => 'media_gallery_id',
            'description' => 'Gallery ID, e.g. 1:',
            'type' => 'text', // [[ text, check, select ]]
            'default' => ''),
        2 => array('id' => 'media_gallery_type',
            'description' => 'Gallery Type',
            'type' => 'select',
            'default' => 'horizontal',
            'values' => array(
                array('name' => 'Horizontal', 'value' => 'horizontal'),
                array('name' => 'Vertical', 'value' => 'vertical'),
                array('name' => 'Single', 'value' => 'single'),
            ),
        ),
        3 => array(
            'id' => 'media_gallery_thumb',
            'type' => 'select',
            'description' => 'Gallery Images',
            'default' => '4',
            'ng-show' => 'edit[\'media_gallery_type\']==\'vertical\' || edit[\'media_gallery_type\']==\'horizontal\'',
            "values" => array(
                array('name' => '4 thumbnails', 'value' => '4'),
                array('name' => '6 thumbnails', 'value' => '6')
            )
        )
    );

    /**
     * Registering the widget to the wordpress
     */
    function jaw_media_gallery_widget() {

        $options = array('classname' => 'media_gallery_widget', 'description' => "JaW Gallery");
        $controls = array('width' => 250, 'height' => 200);
        parent::__construct('media_gallery', 'J&W Gallery for GDay News Theme', $options, $controls);
    }

    public function widget($args, $instance) {
        $ret['args'] = $args;
        $ret['instance'] = $instance;
        jaw_template_set_data($ret, $this);
        
        echo jaw_get_template_part('jaw_media_gallery_widget', 'widgets');
    }
}
