<?php get_template_part('includes/header'); ?>

<?php

  $srch_cat = (isset($_GET['cat']) AND !empty($_GET['cat']) AND $_GET['cat'] == 1 OR $_GET['cat'] == 2 OR $_GET['cat'] == 92) ? 1 : 0 ;

  if($srch_cat == 1) {

?>
  <div class="page-wrap blog-list">
    <div class="container">
      <div class="row">
        
        <div class="col-md-8">
          <div id="content" role="main">
            <!-- <h2><?php _e('Search Results for', 'bst'); ?> &ldquo;<?php the_search_query(); ?>&rdquo;</h2> -->
            
            <span class="title-line"></span>

    				<?php get_template_part('includes/loops/content-post', 'search'); ?>

          </div>
        </div>
        
        <div class="col-md-4" id="sidebar" role="navigation">
            <?php get_template_part('includes/sidebar'); ?>
        </div>
        
      </div>
    </div>
  </div>

<?php } else { ?>
  <div class="page-wrap guide-list">
    <div class="container">
      <div class="row">
        
        <div class="col-md-3" id="sidebar" role="navigation">
          <aside class="category-sidebar">
            
            <?php get_template_part('includes/sidebar-guide'); ?>

          </aside>
        </div>
        
        <div class="col-md-9">
          <div id="content" role="main"> 
            <!-- <h2><?php _e('Search Results for', 'bst'); ?> &ldquo;<?php the_search_query(); ?>&rdquo;</h2> -->        
            <?php get_template_part('includes/loops/content', get_post_format()); ?>
          </div>
        </div>
        
      </div>
    </div>
  </div>
<?php } ?>

<?php get_template_part('includes/footer'); ?>
