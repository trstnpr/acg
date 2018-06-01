<?php get_template_part('includes/header'); ?>

<div class="page-wrap uncategorized-list">
  <div class="container">
    <div class="row">
      
      <div class="col-md-8">
        <div id="content" role="main">

          <!-- <h1 class="page-title"><?php echo single_cat_title(); ?></h1>

          <span class="title-line"></span> -->
          
          <?php get_template_part('includes/loops/content-post', get_post_format()); ?>
        </div><!-- /#content -->
      </div>
      
      <div class="col-md-4" id="sidebar" role="navigation">
         <?php get_template_part('includes/sidebar'); ?>
      </div>
      
    </div><!-- /.row -->
  </div><!-- /.container -->
</div>

<?php get_template_part('includes/footer'); ?>
