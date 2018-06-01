<!DOCTYPE html>
<html class="no-js">
  <head>
    <title><?php wp_title('•', true, 'right'); bloginfo('name'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?> id="page-404">

    <div class="container">
      
      <div class="row">
        
        <div class="col-md-4 col-md-offset-4">

          <h1>404</h1>

          <p><a href="<?php echo site_url(); ?>"><i class="fa fa-long-arrow-left"></i> Go back to Home</a></p>

        </div>

      </div>

    </div>

  </body>

</html>

  