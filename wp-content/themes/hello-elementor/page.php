<?php get_header(); ?>

<div class="content-wrapper">
    <div class="content-container">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?php
                while ( have_posts() ) :
					the_content();
                    the_post();
                    get_template_part( 'template-parts/content', 'page' );
                endwhile;
                ?>
            </main>
        </div>

        <?php get_template_part('aside'); ?>
    </div>
</div>

<?php get_footer(); ?>
