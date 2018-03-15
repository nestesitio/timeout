<?php


function my_custom_post_highlights() {
  $labels = array(
    'name'               => _x( 'Highlights', 'post type general name' ),
    'singular_name'      => _x( 'Highlights', 'post type singular name' ),
    'menu_name'          => _x( 'Highlights', 'admin menu' ),
    'name_admin_bar'     => _x( 'Highlights', 'add new on admin bar' ),
    'add_new'            => _x( 'Add New', 'highlight' ),
    'add_new_item'       => __( 'Add new highlight' ),
    'new_item'           => __( 'New highlight' ),
    'edit_item'          => __( 'Edit highlight' ),
    'view_item'          => __( 'View highlight' ),
    'all_items'          => __( 'All highlights' ),
    'search_items'       => __( 'Search highlights' ),
    'parent_item_colon'  => __( 'Parent highlight:' ),
    'not_found'          => __( 'No highlights found.' ),
    'not_found_in_trash' => __( 'No highlights found in Trash.' ) 
  );
  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Highlights.' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'highlights' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
  );

  register_post_type( 'highlights', $args ); 

}
add_action( 'init', 'my_custom_post_highlights' );



 ?>