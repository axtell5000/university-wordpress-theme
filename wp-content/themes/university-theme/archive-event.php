<?php 
  // This templae page is used for archive when you want to look for example by auther or by category
  // If you want unique archive pages, you can create separate files for each, but the file MUST start with 'archive' and have the name
  // you used when registering the new post type - we used 'archive-event.php' for the archive page for events
  get_header(); 
  pageBanner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.'
  )); ?>

  <div class="container container--narrow page-section">
    <?php 
      while (have_posts()) {
        // to get database ready etc. Have to have this
        the_post();
        get_template_part('template-parts/content-event'); // to efficiently reuse code - another way to get same partial file
      }
    echo paginate_links();
    ?>
    <hr class="section-break" />
    <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events'); ?>">Check out our past event archive</a>.</p>
  </div>

<?php get_footer(); ?>