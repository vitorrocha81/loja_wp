<?php

class jaw_cta {

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

    public function jaw_cta_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($this->model((array) $atts,$content));
        return jaw_get_template_part($this->_tmpl, 'simple-shortcodes');
    }
    
    private function model($atts, $content=null){
        if(isset($content)){
            $atts['text'] = $content;
        }
        return $atts;
    }
}