<?php

class jaw_sidebar{

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
    }

    public function jaw_sidebar_shortcode($atts, $content = null, $code = null) {
        $cache_id = 'isb_'.jaw_cache_get_id().'_'.jaw_template_inc_counter('cache_tmpl');
        if(!jaw_has_template_cache($this->_tmpl, 'simple-shortcodes','',$cache_id,'fast')){
            jaw_template_set_data($this->model($atts));
        }
        return jaw_get_template_cache($this->_tmpl, 'simple-shortcodes','',$cache_id,'fast',true);
    }   
    
    private function model($atts){
        $atts['box_size'] = jaw_template_get_var('size');
        return $atts;
    }
}
