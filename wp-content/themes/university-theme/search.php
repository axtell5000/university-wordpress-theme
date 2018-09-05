<?php 
  // This is for the search results of tthe non javascript search
  get_header();
  pageBanner(array(
    'title' => 'Search Results',
    // advisable to use esc_html() like this when getting a search term or something from a url and you are going to use it as text
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;' 
  )); ?>

  <div class="container container--narrow page-section">
    <?php 

      if (have_posts()) {
        
        while (have_posts()) {
          // to get database ready etc. Have to have this
          the_post();

          //the line below allows us to use different part files that start with 'content' and ends with the post type
          get_template_part('template-parts/content', get_post_type()); 

        }
        echo paginate_links();
      } else {
        echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
      }
      //get_search_form() - built in WP method, iserts form from a separate file. File has to be called 'searchform.php' and them root
      get_search_form();

    ?>
  </div>

<?php get_footer(); ?>