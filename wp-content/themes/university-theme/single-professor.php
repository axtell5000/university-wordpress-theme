<?php 
// If you want unique single pages, you can create separate files for each, but the file MUST start with 'single' and have the name
// you used when registering the new post type - we used 'single-event.php' for the single page for events
  get_header();
  // have_posts - wordpress function to see if we have any posts in db
  while (have_posts()) {
    the_post();
    pageBanner();
     ?>

    <div class="container container--narrow page-section">

      <div class="generic-content">
        <div class="row group">
          <div class="one-third">
            <!-- get from function.php, name of image size nickname -->
            <?php the_post_thumbnail('professorPortrait'); ?> 
          </div>
          <div class="two-third">
          <?php the_content(); ?>
          </div>  
        </div>
      </div>
      <?php 
        $relatedPrograms = get_field('related_program'); // returns an array
        // print_r($relatedPrograms);

        if ($relatedPrograms) { // Check to see if single event has related program
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--small">Subject(s) Taught</h2>';
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
