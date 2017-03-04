<?php

class jaw_presentation_box {

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

    public function jaw_presentation_box_shortcode($atts, $content = null, $code = null) {
        jaw_template_set_data($this->model((array) $atts, $content));
        return jaw_get_template_part($this->_tmpl, 'simple-shortcodes');
    }

    private function model($atts, $content) {

        $atts['content'] = $content;
        
        if(!isset($atts['layout'])){
            $atts['layout'] = 'nextto_left';
        }
        $layout = explode('_',$atts['layout']);
        
        if(isset($layout[0])){
            $atts['style'] = $layout[0];
        }else{
            $atts['style'] = "nextto";
        }
        
        if(isset($layout[1])){
            $atts['align'] = $layout[1];
        }else{
            $atts['align'] = "left";
        }
        
        if (isset($atts['image'])) {

            if ((is_array($atts['image']) && isset($atts['image'][0])) || is_numeric($atts['image'])) {
                $atts['image'][0] = json_decode(json_encode($atts['image'][0]));
                if (isset($atts['image'][0]->id)) {
                    $id = $atts['image'][0]->id;
                } else {
                    $id = $atts['image'];
                }
                
                $url = wp_get_attachment_image_src($id, 'full');

                $atts['url'] = $url[0];
            } else {
                $atts['url'] = $atts['image'];
            }
        }
        
        
        if (isset($atts['hover_image'])) {

            if ((is_array($atts['hover_image']) && isset($atts['hover_image'][0])) || is_numeric($atts['hover_image'])) {
                $atts['hover_image'][0] = json_decode(json_encode($atts['hover_image'][0]));
                if (isset($atts['hover_image'][0]->id)) {
                    $id = $atts['hover_image'][0]->id;
                } else {
                    $id = $atts['hover_image'];
                }
                
                $url = wp_get_attachment_image_src($id, 'full');

                $atts['hover_url'] = $url[0];
            } else {
                $atts['hover_url'] = $atts['hover_image'];
            }
        }

        return $atts;
    }
}
