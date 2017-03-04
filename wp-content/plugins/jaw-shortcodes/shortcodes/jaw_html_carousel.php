<?php

class jaw_html_carousel {

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

    public function jaw_html_carousel_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($this->model($atts,$content));
        return jaw_get_template_part($this->_tmpl, 'simple-shortcodes');
    }
    
    private function model($atts, $content) {
        if (isset($content)) {
            $atts['content'] = $content;
        }
        if (isset($atts['slider_interval'])) {
            $atts['slider_interval'] = $atts['slider_interval'];
        } else {
            $atts['slider_interval'] = '5000';
        }
        return $atts;
    }
}
