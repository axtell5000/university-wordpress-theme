<?php 
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

      <?php 
        // Calculating the id umber of parent, first we get current page ID, then use ID to determine parent. 
        // if 0 means false and there is no parent
        $theParent = wp_get_post_parent_id(get_the_ID());
        // If current page has a parent show breadcrumb
        if ($theParent) { ?> 
          <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
          </div>
        <?php }
      ?>
   
      <?php
        // checking if current page has children, will return an array of them if they have 
        $testArray = get_pages(array(
          'child_of' => get_the_ID()
        ));
        
        // Checking if page has a parent or is a parent - $testArray will have id's if current page has children
        // We are doing this check to determine if we should display the sidenav on the right. These stand alone adhoc pages should not have the sidenav on the right
        if ($theParent or $testArray) { ?>
        <div class="page-links">
          <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
          <ul class="min-list">
            <?php 
            // example of an associative array in php
            // $animalSounds = array(
            //   'cat' => 'meow',
            //   'dog' => 'bark',
            //   'pig' => 'onk'
            // );

            // echo $animalSounds['cat'];
            
            // if current page has a parent
            if ($theParent) {
              $findChildrenOf = $theParent;
            } else {
              $findChildrenOf = get_the_ID(); // if current page hasnt got a parent
            }
            // making a list of nav items, based on the current page
            wp_list_pages(array(
              'title_li' => NULL,
              'child_of' => $findChildrenOf
            )); 
            ?>
          </ul>
        </div>
      <?php } ?>

      <div class="generic-content">
        <?php the_content(); ?>
      </div>

    </div>
    
  <?php }
  get_footer();
?>
