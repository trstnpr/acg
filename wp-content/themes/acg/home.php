<?php /* Template Name: Homepage */ ?>



<?php get_template_part('includes/header'); ?>

<section class="section-adspace bg-white">

 

    <center><strong>

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

</strong></center></div>

          </div>

        </div>

      </div>

    </section>



    <section class="section-bizcat">



      <div class="container">



        <h2 class="section-title">Browse <span class="txt-red">Businesses</span> by Category</h2>



        <?php get_template_part('includes/home-guide-cat'); ?>



      </div>



    </section>

    

    <section class="section-featured-business">



      <div class="container">

        

        <h2 class="section-title txt-center">Featured <span class="txt-red">Businesses</span></h2>



        <br/>

        

        <div class="featured-wrap">
	        <?php
	            $featposts = get_posts(array(
	         	//$featposts = new WP_Query(array(
	              'posts_per_page' => 4,
	              'numberposts' => -1,
	              'post_type'   => 'post',
	              // 'category__in' => 3,
	              // 'category' => 5,
	              'cat' => 5,
	              'meta_key'    => 'featured_business',
	              'meta_compare' => '=',
	              'meta_value'  => 1
              ));
	            if( $featposts ):
	        ?>

	        <div class="feat-carousel">
	            <?php foreach( $featposts as $post ): 
	            	setup_postdata( $post );      
              ?>
              
                  <div class="feat-carousel-item">
                    <div class="featured-item">
                      <div class="biz-thumb">
		                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
		                  </div>
		                  <div class="bizcard-info">
		                    <ul class="biz-details">
		                      <li>
		                        <i class="fa fa-building"></i>
		                        <a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a>
		                      </li>
		                      <li>
		                        <i class="fa fa-map-marker"></i>
		                          <?php the_field('address_1') ?>
		                          <?php the_field('address_2'); ?>
		                      </li>
		                      <li>
		                        <i class="fa fa-location-arrow"></i>
		                        <?php the_field('address_3'); ?>
		                      </li>
		                      <li>
		                        <i class="fa fa-phone"></i>
		                        <?php the_field('contact_number'); ?>
		                      </li>
		                    </ul>
		                  </div>
	                	</div>
	                </div>
	            <?php endforeach; ?>
	        </div>
	        <?php 
	        	wp_reset_postdata();
          endif; ?>
        </div>



      </div>



    </section>

    

    <section class="section-blog-news">

    

        <div class="container">

            

            <div class="row">

            

                <div class="col-md-6">

                

                    <div class="content-blog">

                        

                        <div class="clearfix">

                            <h2 class="section-title pull-left">Helpful Information</h2>

                            <a href="<?php echo get_site_url('section/blog'); ?>/section/blog" class="btn btn-danger btn-sm pull-right">More <i class="fa fa-caret-right"></i></a>

                        </div>



                        <hr/>

                        

                        <div class="blogs-wrap">

                        

                            <?php

                                // $catquery = new WP_Query('cat=2&posts_per_page=3&orderby=publish_date&order=DESC' );
                                $catquery = new WP_Query(array(
                                  'cat' => 4,
                                  'post_per_page' => 3 ,
                                  'orderby' => 'publish_date',
                                  'order' => 'DESC'
                                ));

                                while($catquery->have_posts()) : $catquery->the_post();

                            ?>

                            

                            <div class="blog-item">



                                <div class="row">

                                  

                                  <div class="col-md-3">

                                    <div class="blog-image">

                                      <a href="<?php the_permalink(); ?>">

                                        <?php  if ( has_post_thumbnail() ) { ?>

                                          <img class="img-responsive" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />

                                        <?php } else { ?>

                                          <img class="img-responsive" src="<?php echo get_site_url('wp-content/uploads/2017/07/placer.jpg'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />

                                        <?php } ?>

                                      </a>

                                    </div>

                                  </div>

                

                                  <div class="col-md-9">

                                    <div class="blog-info">

                                      <a href="<?php the_permalink(); ?>" class="blog-title"><?php the_title(); ?></a>

                                      <p class="blog-meta"><?php the_category(', '); ?> | <?php the_time('F d, Y'); ?></p>

                                      <p class="blog-excerpt"><?php the_field('blog_excerpt'); ?></p>

                                      <a href="<?php the_permalink(); ?>" class="btn btn-warning btn-xs">READ MORE</a>

                                    </div>

                                  </div>

                

                                </div>

                

                              </div>

                            

                            <?php

                                endwhile;

                                wp_reset_postdata();

                            ?>

                        

                        </div>

                    

                    </div>

                

                </div>

            

                <div class="col-md-6">

                    

                    <div class="content-news">

                        

                        <div class="clearfix">

                            <h2 class="section-title pull-left">Blog</h2>

                            <a href="<?php echo get_site_url(); ?>/section/news" class="btn btn-danger btn-sm pull-right">More <i class="fa fa-caret-right"></i></a>

                        </div>



                        <hr/>

                        

                        <div class="news-wrap">

                        

                            <?php

                                $catquery = new WP_Query( 'cat=92&posts_per_page=3&orderby=date&order=DESC' );

                                while($catquery->have_posts()) : $catquery->the_post();

                            ?>

                            

                            <div class="news-item">



                                <div class="row">

                                  

                                  <div class="col-md-3">

                                    <div class="news-image">

                                      <a href="<?php the_permalink(); ?>">

                                        <?php  if ( has_post_thumbnail() ) { ?>

                                          <img class="img-responsive" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />

                                        <?php } else { ?>

                                          <img class="img-responsive" src="<?php echo get_site_url('wp-content/uploads/2017/07/placer.jpg'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />

                                        <?php } ?>

                                      </a>

                                    </div>

                                  </div>

                

                                  <div class="col-md-9">

                                    <div class="news-info">

                                      <a href="<?php the_permalink(); ?>" class="news-title"><?php the_title(); ?></a>

                                      <p class="news-meta"><?php the_category(', '); ?> | <?php the_time('F d, Y'); ?></p>

                                      <p class="news-excerpt"><?php the_field('blog_excerpt'); ?></p>

                                      <a href="<?php the_permalink(); ?>" class="btn btn-warning btn-xs">READ MORE</a>

                                    </div>

                                  </div>

                

                                </div>

                

                              </div>

                            

                            <?php

                                endwhile;

                                wp_reset_postdata();

                            ?>

                        

                        </div>

                    

                    </div>

                

                </div>

            

            </div>

            

        </div>

    

    </section>



  <center> <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- Angelescityguide.com home -->

<ins class="adsbygoogle"

     style="display:inline-block;width:728px;height:90px"

     data-ad-client="ca-pub-8777440717420094"

     data-ad-slot="1114418851"></ins>

<script>

(adsbygoogle = window.adsbygoogle || []).push({});

</script>  </center>



    



    <section class="section-barangay parallax" data-parallax="scroll" data-image-src="<?php echo site_url('wp-content/uploads/2017/08/ph-blur1.jpg'); ?>">

      

      <div class="overlay">



        <div class="container">



          <h2 class="section-title txt-center">Barangays</h2>



          <br/>

          <?php

            $barangay = array('Agapito Del Rosario', 'Amsic', 'Anunas', 'Balibago', 'Capaya', 'Claro M. Recto', 'Cuayan', 'Cutcut', 'Cutud', 'Lourdes North West','Lourdes Sur','Lourdes Sur East', 'Margot', 'Marisol', 'Mining','Malabanas', 'Pampang', 'Pandan', 'Pulungbulu', 'Pulung Cacutud', 'Pulung Maragul', 'Salapungan', 'San Jose', 'San Nicolas', 'Santa Teresita', 'Santa Trinidad', 'Santo Cristo', 'Santo Domingo', 'Santo Rosario', 'Sapalibutad', 'Sapangbato', 'Tabun', 'Virgen Delos Remedios', );

          ?>



          <ul class="row list-unstyled barangay-list">

            <?php foreach($barangay as $bar) { ?>

            <li class="col-md-2 col-sm-4 col-xs-6">

              <a href="<?php echo site_url(strtolower(preg_replace('![^a-z0-9]+!i', '-', $bar))); ?>"><?php echo $bar; ?></a>

            </li>

            <?php } ?>

          </ul>



        </div>



      </div>



    </section>



  </div>



<?php get_template_part('includes/footer'); ?>