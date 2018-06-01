<?php
/*
The Page Loop
=============
*/
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

    <article class="page-item clearfix" role="article" id="post_<?php the_ID()?>" <?php post_class()?>>

        <h1 class="page-title"><?php the_title()?></h1>
        <span class="title-line"></span>

        <?php the_content()?>

        <?php wp_link_pages(); ?>
        
    </article>

<?php endwhile; ?>
<?php else: get_template_part('includes/loops/content', 'none'); ?>
<?php endif; ?>
