<?php get_template_part('includes/header'); ?>

<div class="page-wrap page-content">
  <div class="container">
    <div class="row">

      <div class="col-md-8">
        <div id="content" role="main">
          <?php get_template_part('includes/loops/content', 'page'); ?>
        </div><!-- /#content -->
      </div>
      
      <div class="col-md-4" id="sidebar" role="navigation">
          <?php get_template_part('includes/sidebar'); ?>
      </div>
      
    </div><!-- /.row -->
  </div><!-- /.container -->
</div>

<?php get_template_part('includes/footer'); ?>
