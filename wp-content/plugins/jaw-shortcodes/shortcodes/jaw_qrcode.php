<?php

class jaw_qrcode {

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

    public function jaw_qrcode_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data((array) $this->model($atts));
        return jaw_get_template_part($this->_tmpl, 'simple-shortcodes');
    }

    private function model($atts) {
        
        if (isset($atts['box_size'])) {
            $atts['box_size'] = $atts['box_size'];
        } else {
            $atts['box_size'] = 'max';
        }
        
        if (!isset($atts['size'])) {
            if (method_exists('jwUtils', 'get_size')) {
                $atts['size'] = jwUtils::get_size($atts['box_size'], true);
            } else {
                $atts['size'] = 250;
            }
        }
        
        
        
        return $atts;
    }
}
