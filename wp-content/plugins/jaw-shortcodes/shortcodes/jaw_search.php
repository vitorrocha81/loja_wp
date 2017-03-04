<?php

class jaw_search {

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

    public function jaw_search_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($atts);
        return jaw_get_template_part($this->_tmpl, 'simple-shortcodes');
    }

}
