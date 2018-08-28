<?php 
  // If you want unique archive pages, you can create separate files for each, but the file MUST start with 'archive' and have the name
  // you used when registering the new post type - we used 'archive-event.php' for the archive page for events
  get_header();
  pageBanner(array(
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone. Have a look around.'
  )); ?>

  <div class="container container--narrow page-section">
    <ul class="link-list min-list">
      <?php 
        while (have_posts()) {
          // to get database ready etc. Have to have this
          the_post(); ?>
          <li><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></li>
      <?php } 
        echo paginate_links();
      ?>
    </ul>

  </div>

<?php get_footer(); ?>