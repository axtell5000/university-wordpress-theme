<?php 
  // Here we are creating a special page. We first need to create a normal page in wordpress backend.
  // The filename must start with 'page', then the slug named obtained from the backend (see url when editing page)
  // Now this structure will be used on just that page
  get_header();
  pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
  ));  ?>

  <div class="container container--narrow page-section">
    <?php
      // we need to do this because it will just use default page query 
      $today = date('Ymd'); 
      $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1), // need this for pagination when using custom queries
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num', // just meta_value is good for letters and words, use meta_value_num for numbers
        'order' => 'ASC',
        // refining our query, each sub array is a query, think of each array like a good old select * from etc
        'meta_query' => array(
          array(
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
            'type' => 'numeric'
          )
        )
      ));

      while ($pastEvents->have_posts()) {
        // to get database ready etc. Have to have this
        $pastEvents->the_post();
        get_template_part('template-parts/content-event'); // to efficiently reuse code - dont put .php as file extension
      }
    echo paginate_links(array(
      'total' => $pastEvents->max_num_pages // need this for pagination when using custom queries
    ));
    ?>
  </div>

<?php get_footer(); ?>