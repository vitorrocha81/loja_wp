<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('jaw_template_set_data')) {

    /**
     * Set input $data to $jaw_data
     * And set instance of class to $jaw_data['model']
     * @global type $jaw_data
     * @param type $data
     * @param type $model
     */
    function jaw_template_set_data($data, $model = null) {

        global $jaw_data;
        $jaw_data['data'] = $data;
        if (isset($model)) {
            $jaw_data['model'] = $model;
        }
    }

}

if (!function_exists('jaw_template_set_var')) {

    /**
     * Set input $value to $jaw_data[$name]
     * @global type $jaw_data
     * @param type $data
     * @param type $model
     */
    function jaw_template_set_var($name, $value) {

        global $jaw_data;

        if (isset($jaw_data['data']) && is_array($jaw_data['data'])) {
            $jaw_data['data'][$name] = $value;
        } else if (isset($jaw_data['data']) && is_object($jaw_data['data'])) {
            $jaw_data['data']->$name = $value;
        } else {
            $jaw_data['data'] = array();
            $jaw_data['data'][$name] = $value;
        }
    }

}

if (!function_exists('jaw_template_get_data')) {

    /**
     * Return whole $jaw_data
     * @global type $jaw_data
     * @param type $data
     * @param type $model
     */
    function jaw_template_get_data() {

        global $jaw_data;

        if (isset($jaw_data['data'])) {
            return $jaw_data['data'];
        }
    }

}

if (!function_exists('jaw_template_get_var')) {

    /**
     * Return $jaw_data[name]
     * If it's not set it return $default
     * @global type $jaw_data
     * @param type $data
     * @param type $model
     */
    function jaw_template_get_var($name, $default = '') {

        global $jaw_data;

        if (isset($jaw_data['data']) && is_array($jaw_data['data']) && array_key_exists($name, $jaw_data['data'])) {
            return $jaw_data['data'][$name];
        } else if (isset($jaw_data['data']) && is_object($jaw_data['data']) && isset($jaw_data['data']->$name)) {
            return $jaw_data['data']->$name;
        } else {
            return $default;
        }
    }

}


if (!function_exists('jaw_template_call')) {

    /**
     * You can call method from saved instace of class in $jaw_data['model']
     * @global type $jaw_data
     * @param type $data
     * @param type $model
     */
    function jaw_template_call($function, $atts) {

        global $jaw_data;

        $atts = (array) $atts;
        if (method_exists($jaw_data['model'], $function)) {
            return call_user_func_array(array($jaw_data['model'], $function), $atts);
        } else {
            return false;
        }
    }

}

if (!function_exists('jaw_get_template_part')) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        add_action('wp_head', create_function('', 'echo "<!-- Templates is loaded from JaW Widgets plugin -->";'), 0);
    }

    /**
     * Load template 
     * First it look to TEMPLATE/templates folder - suppot also childtheme
     * Second to PLUGIN/templates folder
     * @global type $jaw_data
     * @param type $data
     * @param type $model
     */
    function jaw_get_template_part($tmpl, $dir = '', $subtmpl = '') {

        global $jaw_data;

        if ($dir == '') {
            $dir = $tmpl;
        } else if (is_array($dir)) {
            $dir = implode('/', $dir);
        } else {
            $dir = $dir;
        }

        if ($subtmpl != '') {
            $tmpl_name = $tmpl . '-' . $subtmpl;
        } else {
            $tmpl_name = $tmpl;
        }

        ob_start();

        // Pro templaty, ktery jsou zkompilovane v jednom souboru - GDN
        $funcNameBase = 'jw_tmpl_' . str_replace('/', '__', $dir) . '__';
        $functionName = $funcNameBase . $tmpl_name;
        $functionName = str_replace('-', '_', $functionName);
        $functionNameWithoutSub = $funcNameBase . $tmpl;
        $functionNameWithoutSub = str_replace('-', '_', $functionNameWithoutSub);
        if(function_exists($functionName)){
            $functionName();
        } else if(function_exists($functionNameWithoutSub)){
            $functionNameWithoutSub(); 
        }
        // Stary typ templateru - fallback pro GoodStore/JaWesome
        else if (locate_template(array('templates/' . $dir . '/' . $tmpl_name . '.php'), true, false)) {
            //it's loaded
        }else if(locate_template(array('templates/' . $dir . '/' . $tmpl . '.php'), true, false)) { //if sub-template not exist
            //it's loaded
        } else {
            echo '<div class="jaw_msg jaw_msg_type_warning">';
            echo 'Template: ' . $tmpl_name . ' not exist!';
            echo '</div>';
        }
        $return = ob_get_clean();
        $return = apply_filters( 'jaw_get_template_part' , $return, $tmpl_name, $dir );
        return $return;
    }

}

if (!function_exists('jaw_ajax_get_template_part')) {

    add_action('wp_ajax_get_template_part', 'jaw_ajax_get_template_part');
    add_action('wp_ajax_nopriv_get_template_part', 'jaw_ajax_get_template_part');

    function jaw_ajax_get_template_part() {

        if (isset($_POST['data']['tmpl'])) {
            $tmpl = $_POST['data']['tmpl'];
        } else {
            $tmpl = '';
        }

        if (isset($_POST['data']['dir'])) {
            $dir = $_POST['data']['dir'];
        } else {
            $dir = '';
        }

        echo jaw_get_template_part($tmpl, $dir);
        die();
    }

}

if (!function_exists('jaw_template_get_counter')) {

    function jaw_template_get_counter($name) {
        global $jaw_data;
        if (!isset($jaw_data['counters'][$name])) {
            return 0;
        } else {
            return $jaw_data['counters'][$name];
        }
    }

}

if (!function_exists('jaw_template_inc_counter')) {

    function jaw_template_inc_counter($name) {
        global $jaw_data;
        if (!isset($jaw_data['counters'][$name])) {
            $jaw_data['counters'][$name] = 0;
        } else {
            $jaw_data['counters'][$name] ++;
        }
        return $jaw_data['counters'][$name];
    }

}

if (!function_exists('jaw_template_dec_counter')) {

    function jaw_template_dec_counter($name) {
        global $jaw_data;
        if (!isset($jaw_data['counters'][$name])) {
            $jaw_data['counters'][$name] = 0;
        } else {
            $jaw_data['counters'][$name] --;
        }
        return $jaw_data['counters'][$name];
    }

}

if (!function_exists('jaw_enqueue_phplib')) {

    function jaw_enqueue_phplib($name, $path, $ver) {
        global $enqueue_phplib;

        if (count($enqueue_phplib[$name]) <= 0) {
            $file = new stdClass();

            $file->version = $ver;
            $file->path = $path;

            $enqueue_phplib[$name] = $file;
        } else {
            if (version_compare($enqueue_phplib[$name]->version, $ver, '<')) {
                $file = new stdClass();

                $file->version = $ver;
                $file->path = $path;

                $enqueue_phplib[$name] = $file;
            }
        }
    }

}

add_action('init', 'jaw_inlude_phplib', 1);

if (!function_exists('jaw_inlude_phplib')) {

    function jaw_inlude_phplib() {
        global $enqueue_phplib;

        foreach ((array) $enqueue_phplib as $file) {
            require_once ($file->path);
        }
    }

}

if (!function_exists('jaw_encode')) {
    
    function jaw_encode($content) {
        return base64_encode($content);
    }
}
if (!function_exists('jaw_decode')) {
    
    function jaw_decode($content) {
        return base64_decode($content);
    }
}