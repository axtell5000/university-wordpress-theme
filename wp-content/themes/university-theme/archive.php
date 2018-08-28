<?php 
  // This templae page is used for archive when you want to look for example by auther or by category
  get_header();
  pageBanner(array(
    'title' => get_the_archive_title(),
    'subtitle' => get_the_archive_description()
  )); ?>

  <div class="container container--narrow page-section">
    <?php 
      while (have_posts()) {
        // to get database ready etc. Have to have this
        the_post(); ?>
        <div class="post-item">
          <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <div class="metabox">
            <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('j F Y'); ?> in <?php echo get_the_category_list(', ') ?></p>
          </div>
          <div class="generic-content">
            <?php the_excerpt(); ?> <!-- A preview of the post -->
            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
          </div>
        </div> 
    <?php }
    echo paginate_links();
    ?>
  </div>

<?php get_footer(); ?>