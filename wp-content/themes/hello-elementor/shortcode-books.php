<?php

function display_books_shortcode() {
    $args = array(
        'post_type' => 'books',
        'posts_per_page' => -1
    );

    $books_query = new WP_Query($args);

    ob_start();

    if ($books_query->have_posts()) {
        echo '<div class="books-list">';

        while ($books_query->have_posts()) {
            $books_query->the_post();

            $title = get_the_title();
            $descripcion_breve = get_field('descripcion_breve');
            $imagen = get_field('imagen');
            $ano_de_publicacion = get_field('ano_de_publicacion');

            echo '<div class="book">';
            echo '<h2>' . esc_html($title) . '</h2>';
            if ($imagen) {
                echo '<div class="book-thumbnail"><img src="' . esc_url($imagen['url']) . '" alt="' . esc_attr($imagen['alt']) . '" /></div>';
            }
            if ($descripcion_breve) {
                echo '<div class="book-description">' . esc_html($descripcion_breve) . '</div>';
            }
            if ($ano_de_publicacion) {
                echo '<div class="book-year">Año de publicación: ' . esc_html($ano_de_publicacion) . '</div>';
            }
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo 'No books found.';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('display_books', 'display_books_shortcode');


