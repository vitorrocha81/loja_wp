<?php

class jaw_post_rating {

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

    public function jaw_post_rating_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($atts);
        return jaw_get_template_part('rating', 'blog');
    }

}
