<?php 
  // This mu-plugins folder forces user to have certain plugins for the theme. So anything in this folder
  // Is a must. This code was taken from the function.php
  function universityPostTypes() {
    register_post_type('event', array(
      'public' => true,
      'labels' => array(
        'name' => 'Events',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'all_items' => 'All Events',
        'singular_name' => 'Event'
      ),
      'menu_icon' => 'dashicons-calendar'
    ));
  }

  add_action('init', 'universityPostTypes');

?>