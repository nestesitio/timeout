<?php

function wp_timeout_admin_bar() {
    global $wp_admin_bar;
 
   // To remove WordPress logo and related submenu items
   $wp_admin_bar->remove_menu('wp-logo');
   $wp_admin_bar->remove_menu('about');
   $wp_admin_bar->remove_menu('wporg');
   $wp_admin_bar->remove_menu('documentation');
   $wp_admin_bar->remove_menu('support-forums');
   $wp_admin_bar->remove_menu('feedback');
 
   // To remove Site name/View Site submenu and Edit menu from front end
   //$wp_admin_bar->remove_menu('site-name');
   //$wp_admin_bar->remove_menu('view-site');
   //$wp_admin_bar->remove_menu('edit');
 
   // To remove Update Icon/Menu
   //$wp_admin_bar->remove_menu('updates');
 
   // To remove Comments Icon/Menu
   $wp_admin_bar->remove_menu('comments');
 
   // To remove 'New' Menu
   //$wp_admin_bar->remove_menu('new-content');
 
   // To remove 'Howdy, user' Menu completely and Search field from front end
   //$wp_admin_bar->remove_menu('top-secondary');
   //$wp_admin_bar->remove_menu('search'); 
 
   // To remove 'Howdy, user' subMenus 
   //$wp_admin_bar->remove_menu('user-actions');
   //$wp_admin_bar->remove_menu('user-info');
   //$wp_admin_bar->remove_menu('edit-profile');   
   //$wp_admin_bar->remove_menu('logout');
 
}

add_action( 'wp_before_admin_bar_render', 'wp_timeout_admin_bar' );

?>