<?php

/**
 * Post Slides
 * @author JaW Templates <http://www.jawtemplates.com>
 * @copyright (c) 2014, CCB, spol. s r.o.
 * @version 1.0
 */
add_action('init', 'register_jaw_timeline');


add_action('add_meta_boxes', 'add_custom_meta_box_jaw_timeline');
add_action('save_post', 'save_custom_meta_jaw_timeline');


function register_jaw_timeline() {
    $labels = array(
        'name' => __('Timeline', 'jaw_cp'),
        'singular_name' => __('Timeline Item', 'jaw_cp'),
        'add_new' => __('Add New', 'jaw_cp'),
        'add_new_item' => __('Add New Timeline Item', 'jaw_cp'),
        'edit_item' => __('Edit Timeline Item', 'jaw_cp'),
        'new_item' => __('New Timeline Item', 'jaw_cp'),
        'view_item' => __('View Timeline Item', 'jaw_cp'),
        'search_items' => __('Search Timeline Items', 'jaw_cp'),
        'not_found' => __('No Timeline items found', 'jaw_cp'),
        'not_found_in_trash' => __('No Timeline items found in Trash', 'jaw_cp'),
        'parent_item_colon' => __('Parent Timeline:', 'jaw_cp'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => __('Custom Post Type - Timeline Pages', 'jaw_cp'),
        'supports' => array('title', 'editor'),
        'taxonomies' => array('jaw-timeline-category'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => plugins_url('images/faq.png', __FILE__),
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type('jaw-timeline', $args);

    // "timeline Categories" Custom Taxonomy
    $labels = array(
        'name' => __('Timeline Categories', 'jaw_cp'),
        'singular_name' => __('timeline Category', 'jaw_cp'),
        'search_items' => __('Search timeline Categories', 'jaw_cp'),
        'all_items' => __('All timeline Categories', 'jaw_cp'),
        'parent_item' => __('Parent timeline Category', 'jaw_cp'),
        'parent_item_colon' => __('Parent timeline Category:', 'jaw_cp'),
        'edit_item' => __('Edit timeline Category', 'jaw_cp'),
        'update_item' => __('Update timeline Category', 'jaw_cp'),
        'add_new_item' => __('Add New timeline Category', 'jaw_cp'),
        'new_item_name' => __('New timeline Category Name', 'jaw_cp'),
        'menu_name' => __('Timeline Categories', 'jaw_cp')
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'jaw-timeline-category')
    );

    register_taxonomy('jaw-timeline-category', array('jaw-timeline'), $args);
}

function add_custom_meta_box_jaw_timeline() {
    add_meta_box(
            'jaw_timeline_meta_box', // $id
            __('Timeline Settings', 'jaw_cp'), // $title
            'show_custom_meta_box_jaw_timeline', // $callback
            'jaw-timeline', // $page
            'normal', // $context
            'high'); // $priority
}


// The Callback Meta Boxes
function show_custom_meta_box_jaw_timeline() {
    global $custom_meta_timeline, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="custom_meta_timeline" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

    // Begin the field table and loop
    echo '<table class="form-table" ng-controller="customPostAdminCtrl">';
    foreach ((array)$custom_meta_timeline as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], false);
        if(isset($meta[0])){
            $meta = $meta[0];    
        }else if(isset($field['std'])){
            $meta = $field['std'];
        }else{
            $meta = '';
        }
        
        // begin a table row with
        echo '<tr>
				<th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
				<td>';
        switch ($field['type']) {
            // text
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="50" />
								<br /><span class="description">' . $field['desc'] . '</span>';
                break;
            // textarea
            case 'textarea':
                echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="60" rows="4">' . $meta . '</textarea>
								<br /><span class="description">' . $field['desc'] . '</span>';
                break;


            case 'media_picker':
                $a_default = 'init_edit(\'' . $field['id'] . '\',json_decode(\'' . addslashes(str_replace('"', '\'', $meta)) . '\'));';
                echo '<span ng-init="' . $a_default . '" ></span>';
                echo '<div gallerypicker ng-model="edit[\'' . $field['id'] . '\']" name="' . $field['id'] . '"></div>';
                break;

            case 'simplemediapicker':
                $a_default = 'init_edit(\'' . $field['id'] . '\',json_decode(\'' . addslashes(str_replace('"', '\'', $meta)) . '\'));';
                echo '<span ng-init="' . $a_default . '" ></span>';
                echo '<div simplemediapicker ng-model="edit[\'' . $field['id'] . '\']" name="' . $field['id'] . '" mod="image" ></div>';
                break;

            case 'select':
                $a_default = 'init_edit(\'' . $field['id'] . '\',\'' . $meta . '\');';
                echo '<div class="timeline_select">';
                $angular = 'ng-model="edit[\'' . $field['id'] . '\']" ng-init="' . $a_default . '"';
                echo '<select class="timeline_select " name="' . $field['id'] . '" id="' . $field['id'] . '"  ' . $angular . '>';
                if (isset($field['options']) && count($field['options']) > 0)
                    foreach ((array) $field['options'] as $select_ID => $option) {
                        echo '<option id="' . $select_ID . '" value="' . $select_ID . '" ' . selected($meta, $select_ID, false) . ' >' . $option . '</option>';
                    }
                echo '</select></div>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data - Metaboxes
function save_custom_meta_jaw_timeline($post_id) {
    global $custom_meta_timeline;

    // verify nonce
    // if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))

    if (!isset($_POST['custom_meta_timeline']) || !wp_verify_nonce($_POST['custom_meta_timeline'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ((array)$custom_meta_timeline as $field) {
        if ($field['type'] == 'tax_select')
            continue;
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // enf foreach
}