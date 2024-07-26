<?php

/**
 * Template for displaying single books.
 *
 * @package
 */

get_header();
?>

<div class="content-container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container-single">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        $title = get_the_title();
                        $descripcion_breve = get_post_meta(get_the_ID(), '_books_short_description', true);
                        $imagen = get_post_meta(get_the_ID(), '_books_image', true);
                        $ano_de_publicacion = get_post_meta(get_the_ID(), '_books_year', true);
                ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="book-content-single">
                                <?php if ($imagen) : ?>
                                    <div class="book-thumbnail-single">
                                        <?php
                                        // Verificar si $imagen es una URL o un array
                                        if (is_array($imagen)) {
                                            $imagen_url = esc_url($imagen['url']);
                                            $imagen_alt = esc_attr($imagen['alt']);
                                        } else {
                                            $imagen_url = esc_url($imagen);
                                            $imagen_alt = esc_attr($title);
                                        }
                                        ?>
                                        <img src="<?php echo $imagen_url; ?>" alt="<?php echo $imagen_alt; ?>" class="book-image-single" />
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
        </main>
    </div>
    <?php get_template_part('aside'); ?>
</div>

<?php get_footer(); ?>
