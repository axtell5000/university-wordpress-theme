<?php 
  get_header();
  // have_posts - wordpress function to see if we have any posts in db
  while (have_posts()) {
    the_post(); ?>
    <h2><?php the_title(); ?></h2>
    <?php the_content() ?>
    
  <?php }
  get_footer();
?>
