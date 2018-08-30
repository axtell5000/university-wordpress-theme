<?php 
  // If you want unique archive pages, you can create separate files for each, but the file MUST start with 'archive' and have the name
  // you used when registering the new post type - we used 'archive-campus.php' for the archive page for campuses
  get_header();
  pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conveniently located campuses.'
  )); ?>

  <div class="container container--narrow page-section">
    <div class="acf-map">
      <?php 
        while (have_posts()) {
          // to get database ready etc. Have to have this
          the_post();
          $mapLocation = get_field('map_location') ?>
          <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php echo $mapLocation['address']; ?>
          </div>
      <?php } ?>
    </div>

  </div>

<?php get_footer(); ?>