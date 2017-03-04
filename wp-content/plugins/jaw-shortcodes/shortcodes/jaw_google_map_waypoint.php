<?php
class jaw_google_map_waypoint {

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

    public function jaw_google_map_waypoint_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($this->model((array) $atts, $content));
        return jaw_get_template_part($this->_tmpl, 'simple-shortcodes');
    }

    private function model($atts, $content) {
        
        shortcode_atts(array(
            "longitude" => '',
            "latitude" => ''
                ), $atts);
        
        
        if (isset($atts['longitude'])) {
            
            $atts['longitude'] = $atts['longitude'];
        } else {
            
            $atts['longitude'] = '';
        }
        
        if (isset($atts['latitude'])) {
            
            $atts['latitude'] = $atts['latitude'];
        } else {
            
            $atts['latitude'] = '';
        }

        return $atts;
    }
}
