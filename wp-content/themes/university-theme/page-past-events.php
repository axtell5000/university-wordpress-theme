<?php 
  // Here we are creating a special page. We first need to create a normal page in wordpress backend.
  // The filename must start with 'page', then the slug named obtained from the backend (see url when editing page)
  // Now this structure will be used on just that page
  get_header(); ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">Past Events</h1>
      <div class="page-banner__intro">
        <p>A recap of our past events.</p>
      </div>
    </div>  
  </div>

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
        $pastEvents->the_post(); ?>
        <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month"><?php  
              $eventDate = new DateTime(get_field('event_date')); // normal php method
              echo $eventDate->format('M');
            ?></span>
            <span class="event-summary__day"><?php  echo $eventDate->format('d'); ?></span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words(get_the_content(), 18) ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
          </div>
        </div>
    <?php }
    echo paginate_links(array(
      'total' => $pastEvents->max_num_pages // need this for pagination when using custom queries
    ));
    ?>
  </div>

<?php get_footer(); ?>