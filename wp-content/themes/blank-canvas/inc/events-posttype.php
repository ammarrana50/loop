<?php 

/**
 * Title: Events 
 * Description: Creates post type and taxonomy for "Events"
 * Version: 1.0
 * Author: Ammar Mustafa
 */

/**
 * Creates the post type: "Events"
 * * @return none
 */
function create_post_type_events() {
  register_post_type( 'events',
    array(
      'labels' => array(
        'name' => __( 'Events' ),
        'singular_name' => __( 'Event' )
        ),
      'public' => true,
      'has_archive' => true,
      'publicly_queryable' => true,
      'menu_icon' => 'dashicons-calendar',
      'supports' => array('title', 'editor'),
      'map_meta_cap' => true,
      'taxonomies' => array('post_tag'),
      'capability_type'     => 'page',
      'rest_base'           => 'events',
      'show_in_rest'        => true,
      )
    );

}
add_action( 'init', 'create_post_type_events' );