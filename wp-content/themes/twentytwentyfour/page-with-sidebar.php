<?php
/**
 * Template Name: Página con Sidebar
 *
 * @package Twenty_Twenty_Four
 */

get_header();
?>

<div class="wp-block-group alignwide has-base-background-color has-background has-global-padding is-layout-constrained wp-block-group-is-layout-constrained" style="padding-top:20px;padding-bottom:20px">
    <div class="wp-block-group alignwide is-content-justification-space-between is-layout-flex wp-container-core-group-is-layout-4 wp-block-group-is-layout-flex">
        <div class="content-area" style="width: 70%; float: left;">
            <?php
            while (have_posts()) : the_post();
                get_template_part('template-parts/content', 'page');
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile;
            ?>
        </div>
        <aside class="sidebar" style="width: 30%; float: right;">
            <?php if (is_active_sidebar('main-sidebar')) : ?>
                <?php dynamic_sidebar('main-sidebar'); ?>
            <?php endif; ?>
        </aside>
    </div>
</div>

<?php
get_footer();
