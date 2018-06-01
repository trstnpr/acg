<?php get_template_part('includes/header'); ?>

<div class="page-wrap blog-list">

  <div class="container">
    <div class="row">
      
      <div class="col-md-8">
        <div id="content" role="main">

          <h1 class="page-title"><?php echo single_cat_title(); ?></h1>

          <span class="title-line"></span>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Must Have ACG -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8777440717420094"
     data-ad-slot="1700633752"
     data-ad-format="link"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
           <br>

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
