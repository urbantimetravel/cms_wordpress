<?php
/*
Plugin Name: Export to JSON
Author: Achilleas X.
Author URI: http://wordpress.stackexchange.com/users/90258/
Description: Every time you save,update or delete a post, all the published post are getting saved in a JSON file in the uploads directory. Have in mind that by default it only exports "title - excerpt - author" , but you can add whatever else you want.
*/

function export_posts_in_json (){

    $args = array(
        'post_type' => 'ar_hotspot',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $query = new WP_Query( $args );
    $posts = array();

    while( $query->have_posts() ) : $query->the_post();

    $posts[] = array(
        'title' => get_the_title(),
        //'excerpt' => get_the_excerpt(),
        //'author' => get_the_author(),
        //'gps' => get_post_meta(get_the_id(), 'gps_punkt', false)
        'gps' => get_post_custom_values('gps_punkt'),
        'copyright_text' => get_post_custom_values('copyright_text'),
        'image' => get_post_custom_values('image')
    );

    endwhile;

    wp_reset_query();

    $data = json_encode($posts);
    $upload_dir = wp_get_upload_dir();
    $file_name = date('d-m-Y') . '.json';
    $save_path = $upload_dir['basedir'] . '/' . $file_name;

    $f = fopen( $save_path , "w" ); //if json file doesn't gets saved, comment this and uncomment the one below
    //$f = @fopen( $save_path , "w" ) or die(print_r(error_get_last(),true)); //if json file doesn't gets saved, uncomment this to check for errors
    fwrite($f , $data);
    fclose($f);

}

add_action( 'save_post', 'export_posts_in_json' );
