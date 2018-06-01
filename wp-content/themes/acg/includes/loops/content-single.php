<?php
/*
The Single Posts Loop
=====================
*/
?> 

<?php if(have_posts()): while(have_posts()): the_post(); ?>

    <article class="article-item" role="article" id="post_<?php the_ID()?>">

        <div class="post-title">
            <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
            <p><?php the_category(', ') ?> | <?php _e('By', 'bst'); echo " "; the_author() ?> | <?php the_time('F d, Y') ?></p>
        </div>
        
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-8777440717420094"
     data-ad-slot="5942583015"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<br/>
        
        <div class="post-thumbnail">
            <a href="<?php the_post_thumbnail_url(); ?>" data-lity>
                <?php the_post_thumbnail(); ?>
            </a>
        </div>
        

        <div class="post-content">

            <?php the_content()?>
            

            <!--<section>-->
                
                <?php //wp_link_pages(); ?>
            <!--</section>-->

        </div>

    </article>

    <!-- <article role="article" id="post_<?php the_ID()?>" <?php post_class()?>>
    
        <header>
            <h2 class="blog-title"><?php the_title()?></h2>

            <?php  if ( has_post_thumbnail() ) { ?>
            <a href="<?php the_post_thumbnail_url(); ?>" data-lity>
                <?php the_post_thumbnail(); ?>
            </a>
            <?php } ?>

            <hr/>
            <p class="text-muted" style=";">
                <?php the_category(', ') ?> | <?php the_time('F d, Y'); ?> | <?php _e('Comments', 'bst'); ?>: <?php comments_popup_link(__('None', 'bst'), '1', '%'); ?>
            </p>
            <hr/>

        </header>

        <section>
            <?php the_content()?>
            <?php wp_link_pages(); ?>
        </section>
    </article> -->
<?php comments_template('/includes/loops/comments.php'); ?>
<?php endwhile; ?>
<?php else: get_template_part('includes/loops/content', 'none'); ?>
<?php endif; ?>
