<?php

$of_options = array();

/* ==== CONTENT ==== */
$of_options[] = array(
    "name" => "Content",
    "type" => "sectionstart"
);

if (class_exists('DZSVideoGallery')) {
    $opts = get_option("zsvg_items");
    $options = array();
    foreach($opts as $opt => $key) {
        $options[$key["settings"]["id"]] = $key["settings"]["id"];
    }
    $of_options[] = array(
        'id' => 'playlist',
        'type' => 'select',
        'name' => 'ID of Video Playlist',
        'desc' => 'Please type ID of your already created Video Playlist.',
        'std' => '',
        'mod' => 'big',
        "builder" => 'true',
        "options" => $options
    );
}

$of_options[] = array(
    "type" => "sectionend"
);

global $jaw_sc_builder_options;
$jaw_sc_builder_options['video_playlist'] = $of_options;
