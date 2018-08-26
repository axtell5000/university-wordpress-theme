
<?php 
  // this file is used to interact with the WordPress system 
  function universityFiles() {
    // microtime() is a trick for dealing with caching issues
    wp_enqueue_script('mainUniversityJs', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    // loading a stylesheet
    wp_enqueue_style('fontAwesome', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // microtime() is a trick for dealing with caching issues
    wp_enqueue_style('universityMainStyles', get_stylesheet_uri(), NULL, microtime());
    wp_enqueue_style('fontAwesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  }
  // to add scripts, the second parameter is naming a function that must be called
  add_action('wp_enqueue_scripts', 'universityFiles');

  function universityFeatures() {
    register_nav_menu('footerLocationOne', 'Footer Location One'); //to add menu to the backend
    register_nav_menu('footerLocationTwo', 'Footer Location Two'); //to add menu to the backend
    add_theme_support('title-tag');
  }

  // after_setup_theme is like lifecycle hook when something is done like Angulars ngOninit
  add_action('after_setup_theme', 'universityFeatures');

  // function to sort based on what url you are on, this is to run just before posts are gotten
  function universityAdjustmentQueries($query) {

    if (!is_admin() AND is_post_type_archive('preogram') AND $query->is_main_query()) {
      $query->set('orderby', 'titlr');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', -1);
    }

    // if not in admin section of wordpress and on event archive and only use main default url query - not custom secondary query
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
      $today = date('Ymd');  
      $query->set('meta_key', 'event_date');
      $query->set('orderby', 'meta_value_num');
      $query->set('order', 'ASC');
      $query->set('meta_query', array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        )
      ));
    }
    
  }

  add_action('pre_get_posts', 'universityAdjustmentQueries');

