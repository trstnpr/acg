<?php
/*
The Default Loop (used by index.php and category.php)
=====================================================

If you require only post excerpts to be shown in index and category pages, then use the [---more---] line within blog posts.

If you require different templates for different post types, then simply duplicate this template, save the copy as, e.g. "content-aside.php", and modify it the way you like it. (The function-call "get_post_format()" within index.php, category.php and single.php will redirect WordPress to use your custom content template.)

Alternatively, notice that index.php, category.php and single.php have a post_class() function-call that inserts different classes for different post types into the section tag (e.g. <section id="" class="format-aside">). Therefore you can simply use e.g. .format-aside {your styles} in css/bst.css style the different formats in different ways.
*/
?>

<div class="bizlist-wrap">
    <?php if(have_posts()): while(have_posts()): the_post();?>
        
        <div class="bizlist-item">
            
            <div class="row">

                <div class="col-md-3">
                    <div class="biz-thumb">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="biz-info">

                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?> <small><?php the_field('address_2') ?></small></a></h2>
                        <span class="line"></span>

                        <ul class="biz-details">
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
                        <br/>
                        <div class="bizcat-badge"><?php the_category(); ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="biz-operation">
                        <p class="label label-default">Opens <?php the_field('operating_schedule'); ?></p>
                        <p><?php the_field('operating_hours'); ?></p>
                    </div>
                </div>

            </div>

        </div>
        
    <?php endwhile; ?>
</div>

<?php if ( function_exists('bst_pagination') ) { bst_pagination(); } else if ( is_paged() ) { ?>
  <ul class="pagination">
    <li class="older"><?php next_posts_link('<i class="glyphicon glyphicon-arrow-left"></i> ' . __('Previous', 'bst')) ?></li>
    <li class="newer"><?php previous_posts_link(__('Next', 'bst') . ' <i class="glyphicon glyphicon-arrow-right"></i>') ?></li>
  </ul>
<?php } ?>

<?php// else: get_template_part('includes/loops/content', 'none'); endif; ?>
<?php else: ?>

<div class="alert alert-danger">
    <strong>No Post Available.</strong>
</div>

<?php endif; ?>
