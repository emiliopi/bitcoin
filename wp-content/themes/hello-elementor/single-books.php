<?php
/**
 * Template for displaying single books.
 *
 * @package Twenty_Twenty_Four
 */

get_header(); // Incluye el encabezado del tema

?>


<div class="container-single">
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
                    <div class="book-content-single">
                        <?php if ($imagen) : ?>
                            <div class="book-thumbnail-single">
                                <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" class="book-image-single" />
                            </div>
                        <?php endif; ?>
                        <div class="book-details-single">
                            <h1 class="book-title-single"><?php echo esc_html($title); ?></h1>
                            <div class="book-description-single">
                                <p><?php echo esc_html($descripcion_breve); ?></p>
                            </div>
                            <div class="book-year-single">
                                <p><strong>Año de publicación:</strong> <?php echo esc_html($ano_de_publicacion); ?></p>
                            </div>
                        </div>
                    </div>
                </article>
        <?php
            endwhile;
        else :
            echo '<p>No se encontró el libro.</p>';
        endif;
        ?>
    </div>
</div>

<?php get_footer(); // Incluye el pie de página del tema ?>