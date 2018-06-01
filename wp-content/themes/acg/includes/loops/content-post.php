<?php
/*
The Default Loop (used by index.php and category.php)
=====================================================

If you require only post excerpts to be shown in index and category pages, then use the [---more---] line within blog posts.

If you require different templates for different post types, then simply duplicate this template, save the copy as, e.g. "content-aside.php", and modify it the way you like it. (The function-call "get_post_format()" within index.php, category.php and single.php will redirect WordPress to use your custom content template.)

Alternatively, notice that index.php, category.php and single.php have a post_class() function-call that inserts different classes for different post types into the section tag (e.g. <section id="" class="format-aside">). Therefore you can simply use e.g. .format-aside {your styles} in css/bst.css style the different formats in different ways.
*/
?>

<?php if(have_posts()): while(have_posts()): the_post();?>

    <article class="article-item" role="article" id="post_<?php the_ID()?>">

        <div class="post-title">
            <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
            <p><?php the_category(', ') ?> | <?php _e('By', 'bst'); echo " "; the_author() ?> | <?php the_time('F d, Y') ?></p>
        </div>
        
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>

        <div class="post-content">

            <?php the_field('blog_excerpt'); ?>
            
            <br/>

            <a href="<?php the_permalink(); ?>" class="btn btn-warning">Continue reading</a>

        </div>

    </article>

<?php endwhile; ?>

<?php if ( function_exists('bst_pagination') ) { bst_pagination(); } else if ( is_paged() ) { ?>
  <ul class="pagination">
    <li class="older"><?php next_posts_link('<i class="glyphicon glyphicon-arrow-left"></i> ' . __('Previous', 'bst')) ?></li>
    <li class="newer"><?php previous_posts_link(__('Next', 'bst') . ' <i class="glyphicon glyphicon-arrow-right"></i>') ?></li>
  </ul>
<?php } ?>

<?php else: get_template_part('includes/loops/content', 'none'); endif; ?>
