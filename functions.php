<!-- this file is used to interact with the WordPress system -->
<?php 
  function universityFiles() {

    wp_enqueue_script('mainUniversityJs', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    // loading a stylesheet
    wp_enqueue_style('fontAwesome', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('universityMainStyles', get_stylesheet_uri());
    wp_enqueue_style('fontAwesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  }
  // to add scripts, the second parameter is naming a function that must be called
  add_action('wp_enqueue_scripts', 'universityFiles');

