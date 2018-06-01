<?php get_template_part('includes/header'); ?>

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
          <h2 class="page-title"><?php echo single_cat_title(); ?></h2> 
          <?php get_template_part('includes/loops/content', get_post_format()); ?>
        </div><!-- /#content -->
      </div>
      
    </div><!-- /.row -->
  </div><!-- /.container -->
</div>
<?php get_template_part('includes/footer'); ?>
