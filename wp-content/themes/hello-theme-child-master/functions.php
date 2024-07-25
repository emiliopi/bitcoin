<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

// Registrar el Custom Post Type "Books"
function create_books_cpt()
{
	$labels = array(
		'name' => _x('Books', 'Post Type General Name', 'textdomain'),
		'singular_name' => _x('Book', 'Post Type Singular Name', 'textdomain'),
		'menu_name' => _x('Books', 'Admin Menu text', 'textdomain'),
		'name_admin_bar' => _x('Book', 'Add New on Toolbar', 'textdomain'),
		'archives' => __('Book Archives', 'textdomain'),
		'attributes' => __('Book Attributes', 'textdomain'),
		'parent_item_colon' => __('Parent Book:', 'textdomain'),
		'all_items' => __('All Books', 'textdomain'),
		'add_new_item' => __('Add New Book', 'textdomain'),
		'add_new' => __('Add New', 'textdomain'),
		'new_item' => __('New Book', 'textdomain'),
		'edit_item' => __('Edit Book', 'textdomain'),
		'update_item' => __('Update Book', 'textdomain'),
		'view_item' => __('View Book', 'textdomain'),
		'view_items' => __('View Books', 'textdomain'),
		'search_items' => __('Search Book', 'textdomain'),
		'not_found' => __('Not found', 'textdomain'),
		'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
		'featured_image' => __('Featured Image', 'textdomain'),
		'set_featured_image' => __('Set featured image', 'textdomain'),
		'remove_featured_image' => __('Remove featured image', 'textdomain'),
		'use_featured_image' => __('Use as featured image', 'textdomain'),
		'insert_into_item' => __('Insert into book', 'textdomain'),
		'uploaded_to_this_item' => __('Uploaded to this book', 'textdomain'),
		'items_list' => __('Books list', 'textdomain'),
		'items_list_navigation' => __('Books list navigation', 'textdomain'),
		'filter_items_list' => __('Filter books list', 'textdomain'),
	);
	$args = array(
		'label' => __('Book', 'textdomain'),
		'description' => __('Custom Post Type for Books', 'textdomain'),
		'labels' => $labels,
		'menu_icon' => 'dashicons-book',
		'supports' => array('title', 'editor', 'thumbnail'),
		'taxonomies' => array('category', 'post_tag'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type('books', $args);
}
add_action('init', 'create_books_cpt', 0);

function display_books_shortcode($atts)
{
	// Extraer los atributos del shortcode
	$atts = shortcode_atts(array(
		'paged' => 1,
	), $atts);

	$paged = (int) $atts['paged'];

	// Definir el número de libros por página
	$books_per_page = 10; // Puedes ajustar esto si lo deseas

	$args = array(
		'post_type' => 'books',
		'posts_per_page' => $books_per_page,
		'paged' => $paged
	);

	$books_query = new WP_Query($args);

	ob_start();

	if ($books_query->have_posts()) {
		echo '<div class="books-list">';

		while ($books_query->have_posts()) {
			$books_query->the_post();

			$title = get_the_title();
			$link = get_permalink(); // Obtener el enlace al post individual
			$descripcion_breve = get_field('descripcion_breve');
			$imagen = get_field('imagen');
			$ano_de_publicacion = get_field('ano_de_publicacion');

			echo '<div class="book">';
			echo '<h4 class="book-title"><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h4>'; // Envolver el título en un enlace
			if ($imagen) {
				echo '<div class="book-thumbnail"><a href="' . esc_url($link) . '"><img src="' . esc_url($imagen['url']) . '" alt="' . esc_attr($imagen['alt']) . '" class="book-image" /></a></div>'; // Envolver la imagen en un enlace
			}
			if ($descripcion_breve) {
				echo '<div class="book-description">' . esc_html($descripcion_breve) . '</div>';
			}
			if ($ano_de_publicacion) {
				echo '<div class="book-year">Año de publicación: ' . esc_html($ano_de_publicacion) . '</div>';
			}
			echo '</div>';
		}

		echo '</div>'; // Cierre del contenedor books-list
	} else {
		echo '<p>No books found.</p>';
	}

	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode('display_books', 'display_books_shortcode');

class Bitcoin_Price_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'bitcoin_price_widget',
            'Bitcoin Price Widget',
            array('description' => 'Displays current Bitcoin price.')
        );
    }

    public function widget($args, $instance) {
		echo $args['before_widget'];
		echo $args['before_title'] . 'Bitcoin Price' . $args['after_title'];
	
		// Obtén el precio de Bitcoin usando la API
		$response = wp_remote_get('https://mempool.space/api/v1/prices');
		if (is_wp_error($response)) {
			echo 'Unable to retrieve Bitcoin price.';
		} else {
			$body = wp_remote_retrieve_body($response);
			$data = json_decode($body, true);
	
			if (!empty($data)) {
				echo '<div class="bitcoin-prices">';
				
				// Itera sobre el array de datos
				foreach ($data as $currency => $value) {
					echo '<div class="bitcoin-price">' . esc_html($currency) . ' $' . number_format($value) . '</div>';
				}
				
				echo '</div>';
			} else {
				echo 'Unable to retrieve Bitcoin price.';
			}
		}
	
		echo $args['after_widget'];
	}
	
	
}

function register_custom_sidebar() {
    register_sidebar(array(
        'name' => 'Bitcoin Price Widget',
        'id' => 'bitcoin_price_widget',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', function() {
    register_widget('Bitcoin_Price_Widget');
    register_custom_sidebar();
});

function theme_enqueue_styles()
{
	wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function enqueue_slick_slider()
{
	// Enqueue Slick Slider CSS
	wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
	wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');

	// Enqueue Slick Slider JS
	wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true);

	// Enqueue Custom JS
	wp_enqueue_script('custom-slider-js', get_template_directory_uri() . '/js/custom-slider.js', array('jquery', 'slick-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_slick_slider');

