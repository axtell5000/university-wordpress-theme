
<?php 
  // this file is used to interact with the WordPress system
  require get_theme_file_path('/includes/search-route.php');
  
  // here adding custom fields to the rest api
  function universityCustomRest () {
    // params - post type, name of new field , call back array
    register_rest_field('post', 'authorName', array(
      'get_callback' => function() { return get_the_author();}
    ));
  }

  add_action('rest_api_init', 'universityCustomRest');

  function pageBanner($args = NULL) {

    if (!$args['title']) {
      $args['title'] = get_the_title();
    }

    if (!$args['subtitle']) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
      if (get_field('page_banner_background_image')) {
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
        $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }

    ?>
    <div class="page-banner">
      <!-- echo $pageBannerImage['sizes']['pageBanner']; the previous is used depending how you set up the custom field. this one is
      used because we used the return Image object under the custom field page -->
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>  
    </div>
  <?php }

  function universityFiles() {
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=need-key', '1.0', microtime(), true);
    // microtime() is a trick for dealing with caching issues
    wp_enqueue_script('mainUniversityJs', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    // loading a stylesheet
    wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

    wp_enqueue_style('fontAwesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    // microtime() is a trick for dealing with caching issues
    wp_enqueue_style('universityMainStyles', get_stylesheet_uri(), NULL, microtime());
    // below code allows flexibilty of where these site files are hosted
    wp_localize_script('mainUniversityJs', 'universityData', array(
      'root_url' => get_site_url()
    ));
  }
  // to add scripts, the second parameter is naming a function that must be called
  add_action('wp_enqueue_scripts', 'universityFiles');

  function universityFeatures() {
    //register_nav_menu('footerLocationOne', 'Footer Location One'); //to add menu to the backend
    //register_nav_menu('footerLocationTwo', 'Footer Location Two'); //to add menu to the backend
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true); // unique name. width, height. do you want to crop
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1920, 350, true);
  }

  // after_setup_theme is like lifecycle hook when something is done like Angulars ngOninit
  add_action('after_setup_theme', 'universityFeatures');

  // function to sort based on what url you are on, this is to run just before posts are gotten
  function universityAdjustmentQueries($query) {

    if (!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
      $query->set('posts_per_page', -1);
    }

    if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
      $query->set('orderby', 'title');
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

  function universityMapKey($key) {
    $api['key'] = 'need key';
    $api['libraries'] = 'places';
    return $api;
  }

  add_filter('acf/fields/google_map/api', 'universityMapKey');

