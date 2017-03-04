<?php

class jaw_recent_comments {

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

    public function jaw_recent_comments_shortcode($atts, $content = null, $code = null) {
        $cache_id = 'recom_'.jaw_cache_get_id().'_'.jaw_template_inc_counter('cache_tmpl');
        if(!jaw_has_template_cache($this->_tmpl, 'simple-shortcodes','',$cache_id,'fast')){
            jaw_template_set_data($this->model($atts));
        }
        return jaw_get_template_cache($this->_tmpl, 'simple-shortcodes','',$cache_id,'fast');
    }

    private function model($atts) {
        
        shortcode_atts(array(
            'number' => '6',
            'excerpt_length' => '100',
            'show_author' => '1 ',
            'show_date' => '1'
                ), $atts);
                
                
        $args_comments = array('number' => $atts['number'], 'status' => 'approve');
        $comments = get_comments($args_comments);
        
        $atts['comments'] = $comments;
        
        return $atts;
    }
}
