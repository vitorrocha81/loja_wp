<?php

class jwSimpleShort {

    //DEFAULT========================================================
    public static function shortcode_default($name, $attr) {
        $shortcode = '';
        $shortcode .= '[' . $name . ' ';
        $content = '';
        foreach ((array) $attr as $index => $val) {
            if ($index == 'sc_content') {
                $content = $val;
                continue;
            }
            $shortcode .= ' ' . $index . '="' . $val . '"';
        }
        $shortcode .= ']';
        if ($content != '') {
            $shortcode .= $content;
            $shortcode .= '[/' . $name . ']';
        }
        return $shortcode;
    }

    //LIST========================================================
    public static function shortcode_list($attr) {
        $shortcode = '';
        $shortcode .= '[jaw_list ';
        // var_dump($attr); //parsovat list-X

        $list = array();

        foreach ((array) $attr as $index => $val) {
            if (strpos($index, 'ist-')) {
                $list[] = $val;
            } else {
                $shortcode .= ' ' . $index . '="' . $val . '"';
            }
        }
        $shortcode .= '] ';

        foreach ((array) $list as $li) {
            $shortcode .= '[jaw_list_item ';
            $shortcode .= 'list ="' . $li . '"';
            $shortcode .= ' ]';
        }

        $shortcode .= '[/jaw_list]';
        return $shortcode;
    }

    //Tabs========================================================
    public static function shortcode_tabs($attr) {
        $shortcode = '';
        $shortcode .= '[jaw_tabs ';
        $title = '';
        $content = '';
        $class = 'active';
        $attr = (array) $attr;
        if (isset($attr)) {

            foreach ((array) $attr as $index => $tab) {
                $i = substr($index, 5);
                if (strpos($index, 'abs')) {
                    $tab = (array) $tab;
                    if (isset($tab['title']) && isset($tab['description'])) {
                        $title .= '[jaw_tabs_title class="' . $class . '" id="' . $i . '"]' . $tab['title'] . '[/jaw_tabs_title]';
                        $content .= '[jaw_tabs_content class="' . $class . '" id="' . $i . '"]' . $tab['description'] . '[/jaw_tabs_content]';
                        $class = '';
                    }
                } else {
                    $shortcode .= ' ' . $index . '="' . $tab . '"';
                }
            }
        }
        $shortcode .= ']';
        $shortcode .= '[jaw_tabs_titles]' . $title . '[/jaw_tabs_titles]';
        $shortcode .= '[jaw_tabs_contents]' . $content . '[/jaw_tabs_contents]';
        $shortcode .= '[/jaw_tabs]';

        return $shortcode;
    }

    public static function shortcode_accordion($attr) {
        $shortcode = '';
        $shortcode .= '[jaw_accordion]';
        $item = '';
        $first = true;
        $attr = (array) $attr;
        if (isset($attr)) {



            foreach ((array) $attr as $index => $tab) {
                $i = substr($index, 5);
                if (strpos($index, 'ccordion')) {
                    $tab = (array) $tab;
                    if (isset($tab['title']) && isset($tab['description'])) {
                        $class = 'collapse';
                        if ($first && isset($attr['open_first']) && $attr['open_first'] == '1') {
                            $class = 'collapse in';
                            $first = false;
                        }
                        $shortcode .= '[jaw_accordion_item class="' . $class . '" title="' . $tab['title'] . '"]' . $tab['description'] . '[/jaw_accordion_item]';
                        $class = '';
                    }
                }
            }
        }
        $shortcode .= '[/jaw_accordion]';
        return $shortcode;
    }

    public static function shortcode_google_map($attr) {

        $shortcode = '';
        $shortcode .= '[jaw_google_map';
        $marker = '';
        $attr = (array) $attr;

        if (isset($attr)) {
            foreach ((array) $attr as $index => $markers) {
                // markers
                if (strpos($index, 'arkers')) {
                    $markers = (array) $markers;
                    if (!empty($markers['longitude']) && !empty($markers['latitude'])) {
                        $marker .= '[jaw_google_map_marker longitude="' . $markers['longitude'] . '" latitude="' . $markers['latitude'] . '" descriptionopened="' . $markers['descriptionopened'] . '" ]' . $markers['description_marker'] . '[/jaw_google_map_marker]';
                    }
                }
                // street highlight
                if(strpos($index,'ocations')) {
                    $markers = (array) $markers;
                    if (!empty($markers['location'])) {
                        $marker .= '[jaw_google_map_street_highlight longitude="' . $markers['longitude'] . '" latitude="' . $markers['latitude'] . '"]';
                    }
                }
            }
        }
        $shortcode .= ' ' . 'latitude' . '="' . $attr['latitude'] . '" description_open' . '="' . $attr['description_open'] . '" description' . '="' . $attr['description'] . '" longitude' . '="' . $attr['longitude'] . '" zoom' . '="' . $attr['zoom'] . '" controls' . '="' . $attr['controls'] . '" disabledoubleclickzoom' . '="' . $attr['disabledoubleclickzoom'] . '" scrollwheel' . '="' . $attr['scrollwheel'] . '" dragable' . '="' . $attr['dragable'] . '" maptype' . '="' . $attr['maptype'] . '" height' . '="' . $attr['height'] . '"';
        $shortcode .= ']';
        $shortcode .= $marker;
        $shortcode .= '[/jaw_google_map]';

        return $shortcode;
    }

    public static function shortcode_gallery($attr) {
        $shortcode = '';
        $shortcode .= '[jaw_gallery ';
        if (isset($attr['gallery'])) {
            $shortcode .= ' gallery="';
            foreach ((array) $attr['gallery'] as $img) {

                $img = json_decode(stripcslashes($img));
                foreach ($img as $i) {
                    $shortcode .= $i->id . ',';
                }
            }
            $shortcode .= '"';
            unset($attr['gallery']);
        }

        foreach ((array) $attr as $index => $val) {
            $shortcode .= ' ' . $index . '="' . $val . '" ';
        }

        $shortcode .= '] ';
        return $shortcode;
    }

}

?>
