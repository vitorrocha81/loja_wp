<?php

class jaw_list{

    private $_data = array();
    private $_tmpl;

    public function __construct($tmpl = null) {
        $this->class_name = get_class();
        if (isset($tmpl)) {
            $this->_tmpl = $tmpl;
        }else{
            $this->_tmpl = substr($this->class_name, 4);                
        }
        add_shortcode($this->class_name, array($this, $this->class_name . '_shortcode'));
        add_shortcode($this->class_name.'-0', array($this, $this->class_name . '_shortcode'));
        add_shortcode($this->class_name.'-1', array($this, $this->class_name . '_shortcode'));
        add_shortcode($this->class_name.'-2', array($this, $this->class_name . '_shortcode'));
    }

    public function jaw_list_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($this->model($atts,$content));
        return jaw_get_template_part($this->_tmpl,'simple-shortcodes');
    }
    
    
    private function model($atts = array(),$content = ''){
        $atts['content'] = $content;  
        
        if (isset($atts['box_size'])) {
            $atts['box_size'] = $atts['box_size'];
        } else {
            $atts['box_size'] = 'max';
        }
        
        return $atts;
    } 
}
