  <footer class="section-footer">

    <div class="widget-footer info-foot">
      <div class="container">
        
      	<div class="row">

          <?php //dynamic_sidebar('footer-widget-area'); ?>

          <div class="col-md-8">
            <div class="widget-aboutus">
              <h2 class="txt-yellow">About <?php bloginfo('name'); ?></h2>
              <p>Angeles City Guide is an online business listings and guide of 33 barangays in Angeles City, Pampanga, Philippines. 
We aim to help local businesses to grow by finding them more customers online. 
We also aim to provide helpful information to foreign and local visitors from businesses to people and places.
<br>
If you want to be featured or advertise your business, products or services, connect with us.
For more information, visit <a href="https://angelescityguide.com/advertise">https://angelescityguide.com/advertise</a> 
and  <a href="https://angelescityguide.com/contact-us">https://angelescityguide.com/contact-us</a> 



</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="widget-brand">
              <img src="<?php echo site_url('wp-content/uploads/2017/06/logo.png'); ?>" class="img-responsive" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" />
            </div>

            <br/>

            <div class="widget-socials">
              <div class="row">
                <div class="col-xs-3">
                  <div class="social-btn">
                    <a href="https://www.facebook.com/Angelescityphilippinesguide/" class=" social-fb" title="Facebook">
                      <i class="fa fa-facebook"></i>
                    </a>
                  </div>
                </div>
                <div class="col-xs-3">
                  <div class="social-btn">
                    <a href="https://twitter.com/AngelesCtyGuide" class="social-tw" title="Twitter">
                      <i class="fa fa-twitter"></i>
                    </a>
                  </div>
                </div>
                <div class="col-xs-3">
                  <div class="social-btn">
                    <a href="https://www.instagram.com/angelescityguide" class="social-ig" title="Instagram">
                      <i class="fa fa-instagram"></i>
                    </a>
                  </div>
                </div>
                <div class="col-xs-3">
                  <div class="social-btn">
                    <a href="https://www.youtube.com/channel/UComDa632oaWBItnRywObX5Q" class="social-gp" title="Youtube">
                      <i class="fa fa-youtube-play"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>

    <div class="footer-copy">
      <div class="container">
        <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a></p>
      </div>
    </div>

  </footer>

  <?php wp_footer(); ?>
  
  </body>
</html>