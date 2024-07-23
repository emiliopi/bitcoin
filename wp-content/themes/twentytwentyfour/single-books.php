<?php

/**
 * Template for displaying single books.
 *
 * @package Twenty_Twenty_Four
 */

get_header(); // Esta función incluye el encabezado del tema

?>

<div class="book-single">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            $title = get_the_title();
            $descripcion_breve = get_field('descripcion_breve');
            $imagen = get_field('imagen');
            $ano_de_publicacion = get_field('ano_de_publicacion');
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="book-title"><?php echo esc_html($title); ?></h1>
                <?php if ($imagen) : ?>
                    <div class="book-thumbnail">
                        <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" class="book-image" />
                    </div>
                <?php endif; ?>
                <div class="book-description">
                    <p><?php echo esc_html($descripcion_breve); ?></p>
                </div>
                <div class="book-year">
                    <p>Año de publicación: <?php echo esc_html($ano_de_publicacion); ?></p>
                </div>
            </article>
    <?php
        endwhile;
    else :
        echo '<p>No se encontró el libro.</p>';
    endif;
    ?>
</div>

<?php
get_footer(); // Esta función incluye el pie de página del tema
