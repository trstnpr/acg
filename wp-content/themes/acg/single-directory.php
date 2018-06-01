<?php /* Template Name: Single Directory */ ?>



<?php get_template_part('includes/header'); ?>



  <div class="page-wrap single-biz">



    <section class="biz-header biz-cover data-img" data-img="<?php echo site_url('wp-content/uploads/2017/07/grid-60.png'); ?>">

      <div class="container">

        <div class="biz-title">

          <h1><?php the_title(); ?> <small title="Barangay" class="txt-yellow"><?php the_field('address_2'); ?></small></h1>

        </div>

      </div>

    </section>



    <section class="biz-main">



      <div class="container">

        

        <div class="row">

          

          <div class="col-md-3">



            <div class="biz-left">

              <div class="biz-card">

                <div class="biz-thumb">

                  <?php the_post_thumbnail('full'); ?>

                </div>

                <div class="bizcard-info">

                  <ul class="biz-details">

                    <li>

                      <i class="fa fa-map-marker"></i>

                      <strong>

                        <?php the_field('address_1') ?>

                        <?php the_field('address_2'); ?>

                      </strong>

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



              <div class="card-panel adspace">

                <center><strong>AD SPACE</strong></center>

              </div>

            </div>

          </div>



          <div class="col-md-9">

            <div class="biz-right">



            <?php

              // $photos = get_field('photos');

              $photos = get_post_gallery_ids($post->ID);

              if($photos) { ?>



              <div class="panel-info panel-gallery">

                <div class="gallery-wrap rollin">

                  <div class="masonry-grid">



                  <?php foreach($photos as $photo) { ?>



                    <div class="masonry-block">

                      <a href="<?php echo wp_get_attachment_url( $photo ); ?>" data-lity>

                        <img src="<?php echo wp_get_attachment_url( $photo ); ?>" class="img-responsive"  alt="<?php echo the_title(); ?>" title="<?php echo the_title(); ?>" />

                      </a>

                    </div>



                  <?php } ?>



                  </div>

                </div>



                <div class="overflow-fade"></div>



                <button type="button" class="btn btn-default btn-block cta-roll"><i class="fa fa-chevron-down fa-lg"></i></a>





              </div>



            <?php } else { ?>



              <div class="alert alert-danger">

                No Photos Available.

              </div>



            <?php } ?>



              <div class="panel-info panel-details">



                <ul class="nav nav-tabs">

                  <li class="active"><a data-toggle="tab" href="#details"><i class="fa fa-info"></i> Details</a></li>

                  <li><a data-toggle="tab" href="#services"><i class="fa fa-list"></i> Services</a></li>

                  <li><a data-toggle="tab" href="#direction" class="tab-map"><i class="fa fa-location-arrow"></i> Direction</a></li>

                  <li><a data-toggle="tab" href="#inquiry"><i class="fa fa-paper-plane"></i> Send an Inquiry</a></li>

                </ul>



                <div class="tab-content">



                  <div id="details" class="table-responsive tab-pane fade in active">

                    <table class="table table-striped table-bordered">

                      <tbody>

                        <tr>

                          <th><i class="fa fa-home"></i> Address</th>

                          <td>

                            <?php the_field('address_1'); ?>

                            <?php the_field('address_2'); ?>

                            <?php the_field('address_3'); ?>

                          </td>

                        </tr>

                        <tr>

                          <th><i class="fa fa-map-marker"></i> Barangay</th>

                          <td><?php the_field('address_2'); ?></td>

                        </tr>

                        <tr>

                          <th><i class="fa fa-phone"></i> Contact Number</th>

                          <td><a href="tel:<?php the_field('contact_number'); ?>"><?php the_field('contact_number'); ?></a></td>

                        </tr>

                        <tr>

                          <th><i class="fa fa-envelope"></i> Email</th>

                          <td><a href="mailto:<?php the_field('email'); ?>"><?php the_field('email'); ?></a></td>

                        </tr>

                        <tr>

                          <th><i class="fa fa-link"></i> Website</th>

                          <td><a href="<?php the_field('website'); ?>" target="_blank"><?php the_field('website'); ?></a></td>

                        </tr>

                        <tr>

                          <th><i class="fa fa-facebook"></i> Facebook</th>

                          <td><a href="<?php the_field('facebook'); ?>" target="_blank"><?php the_field('facebook'); ?></a></td>

                        </tr>

                      </tbody> 

                    </table>

                  </div>



                  <div id="services" class="card-panel tab-pane fade">

                    <?php the_field('services'); ?>

                  </div>



                  <div id="direction" class="tab-pane fade ">

                    <?php 

                      $location = get_field('business_map');

                      if( !empty($location) ): ?>

                      <div class="acf-map">

                        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>

                      </div>

                    <?php endif; ?>

                  </div>



                  <div id="inquiry" class="card-panel tab-pane fade">



                    <?php echo do_shortcode('[contact-form-7 id="1077" title="Business Inquiry Form"]'); ?>



                  </div>



                </div>



              </div>



          </div>



        </div>



      </div>



    </section>





    <section class="related-biz">



      <div class="container">



        <h2 class="section-title">Related Post</h2>



        <div class="related-wrap">



          <div class="row"> 



          <?php



          $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 5, 'post__not_in' => array($post->ID) ) );

          if( $related ) foreach( $related as $post ) {

          setup_postdata($post); ?>



            <div class="col-md-4 col-sm-6">

              

              <a href="<?php the_permalink() ?>">



                <div class="related-item">

                  

                  <div class="biz-thumb">

                    <?php the_post_thumbnail('full'); ?>

                  </div>

                  <div class="bizcard-info">

                    <ul class="biz-details">

                        <li>

                            <i class="fa fa-building"></i>

                            <strong><?php the_title(); ?></strong>

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



              </a>



            </div>





          <?php }

          wp_reset_postdata(); ?>



          </div>



        </div>



      </div>



    </section>



  </div>



<?php get_template_part('includes/footer'); ?>