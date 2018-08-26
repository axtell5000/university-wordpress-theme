<?php 
// If you want unique single pages, you can create separate files for each, but the file MUST start with 'single' and have the name
// you used when registering the new post type - we used 'single-event.php' for the single page for events
  get_header();
  // have_posts - wordpress function to see if we have any posts in db
  while (have_posts()) {
    the_post(); ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>DONT FORGET TO REPLACE ME LATER!!</p>
        </div>
      </div>  
    </div>

    <div class="container container--narrow page-section">
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
      </div>
      <div class="generic-content"><?php the_content(); ?></div>
      <?php 
        $relatedPrograms = get_field('related_program'); // returns an array
        // print_r($relatedPrograms);

        if ($relatedPrograms) { // Check to see if single event has related program
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--small">Related Program(s)</h2>';
          echo '<ul class="link-list min-list">';
          // remember like javascript methods on Arrays
          foreach($relatedPrograms as $program) { ?>
            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
          <?php }
          echo '</ul>';
        }
      ?>
    </div>
      
  <?php }
  get_footer();

?>
