<?php

class jaw_grid_item {

    private $_data = array();
    private $_tmpl;

    public function __construct($tmpl = null) {
        $this->class_name = get_class();
        if (isset($tmpl)) {
            $this->_tmpl = $tmpl;
        } else {
            $this->_tmpl = substr($this->class_name, 4);
        }
        add_shortcode($this->class_name, array($this, $this->class_name . '_shortcode'));
    }

    public function jaw_grid_item_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($this->model((array) $atts, $content));
        return jaw_get_template_part($this->_tmpl, 'sliders');
    }

    private function model($atts, $content) {
        $atts=array_merge((array)jaw_template_get_data(),$atts);
        shortcode_atts(array(
            "img" => '',
            "url" => '',
            "title" => '',
            "description" => '',
                ), $atts);
                
        $atts['description'] = $content;
        
        return $atts;
    }

}
