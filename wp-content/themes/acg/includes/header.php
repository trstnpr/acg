<!DOCTYPE html>
<html class="no-js">
<head>
	<title><?php wp_title('•', true, 'right'); bloginfo('name'); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	
	<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-105848207-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-105848207-1');
</script>
	
</head>

<body <?php body_class(); ?>>

  <header>

    <section class="header-banner parallax" data-parallax="scroll" data-image-src="<?php echo site_url('/wp-content/uploads/2017/10/pexels-photo-169677-1-1.png'); ?>">
      
      <div class="container">
        
        <div class="logo-brand">
          
          <a href="<?php echo site_url(); ?>">
            <img src="<?php echo site_url('wp-content/uploads/2017/06/logo.png'); ?>" class="img-responsive" alt="<?php bloginfo(); ?>" title="<?php bloginfo(); ?>" />
          </a>

        </div>

      </div>

    </section>

    <nav class="navbar">
      <div class="container">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url(); ?>">Home</a></li>
            <li><a href="<?php echo site_url('section/blog'); ?>">Blog</a></li>
            <li><a href="<?php echo site_url('branches'); ?>">Branches</a></li>
            <li><a href="<?php echo site_url('about-angeles-city'); ?>">About Angeles City</a></li>
            <li><a href="<?php echo site_url('contact-us'); ?>">Contact Us</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo site_url('about-us'); ?>">About Us</a></li>
            <li><a href="<?php echo site_url('advertise'); ?>">Advertise</a></li>
            <li><a href="<?php echo site_url('partners'); ?>">Partners</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <?php
      if(is_front_page() or is_archive() and !is_category(array('uncategorized','blog','news')) and !is_bbpress()) {
    ?>

      <section class="header-search">
        
        <div class="container">

          <h3 class="section-label">City Guide Search</h3>
          
          <form class="dir-form" role="search" method="get" id="searchform" action="<?php echo site_url('/'); ?>">
            <input type="hidden" name="cat" id="cat" value="3">
            <!-- <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control input-lg" placeholder="Search Keyword" name="s" />
                </div>
              </div>

              <div class="col-md-4 col-sm-8">
                <div class="form-group">
                  <select class="form-control input-lg" name="barangay">
                    <option disabled selected>Select Barangay</option>
                    <option value="Balibago">Balibago</option><option value="Balibago">Balibago</option>
                    <option value="Cutud">Cutud</option>
                  </select>
                </div>
              </div>

              <div class="col-md-2 col-sm-4">
                <div class="form-group">
                  <button class="btn btn-danger btn-lg btn-block" type="submit">SEARCH <i class="fa fa-search"></i></button>
                </div>
              </div>

            </div> -->

            <div class="row">
              <div class="col-md-8 col-md-offset-2">
                
              <div class="row">

                <div class="col-md-8">
                  <div class="form-group">
                    <input class="form-control input-lg" placeholder="Search Keyword" name="s" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <button class="btn btn-danger btn-lg btn-block" type="submit">SEARCH <i class="fa fa-search"></i></button>
                  </div>
                </div>

              </div>

              </div>
            </div>
          </form>
        </div>

      </section>

    <?php } ?>

  </header>

