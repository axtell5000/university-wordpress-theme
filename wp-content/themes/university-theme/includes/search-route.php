<?php

// Here we are creating a custom route (url) for REST API
add_action('rest_api_init', universityRegisterSearch);

function universityRegisterSearch() {
  // parameters - namespace (the wp in default url, can include the /v2/ as part of namespace), route (posts in default url)
  // third parameter describes what must happen when using the new url
  register_rest_route('university/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'universitySearchResults'
  ));
}

function universitySearchResults($data) {
  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
    's' => sanitize_text_field($data['term']) // search term to use
  ));

  $results = array(
    'generalInfo' => array(),
    'professors' => array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array()
  );

  // We are doing this to have more control of the data we pull. We are avoiding having to pull more data than needed
  while($mainQuery->have_posts()) {
    $mainQuery->the_post();

    $currentPostType = get_post_type();

    switch ($currentPostType) {
      case 'post':
      case 'page':
        array_push($results['generalInfo'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'postType' => get_post_type(),
          'authorName' => get_the_author()
        ));
        break;
      case 'professor':
        array_push($results['professors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'image' => get_the_post_thumbnail_url(0, 'professorLandscape') // params - which post you want to use (0 means current), the image size type
        ));
        break;
      case 'program':
        array_push($results['programs'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
        break;
      case 'event':
        array_push($results['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
        break;
      case 'campus':
        array_push($results['campuses'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink()
        ));
        break;

    }
    
  }

  return $results; // once returned wordPress will automatically convert it to JSON

}