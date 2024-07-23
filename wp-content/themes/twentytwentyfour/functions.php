<?php

/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if (!function_exists('twentytwentyfour_block_styles')) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_styles()
	{

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __('Arrow icon', 'twentytwentyfour'),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __('Pill', 'twentytwentyfour'),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __('Checkmark', 'twentytwentyfour'),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __('With arrow', 'twentytwentyfour'),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __('With asterisk', 'twentytwentyfour'),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action('init', 'twentytwentyfour_block_styles');

/**
 * Enqueue block stylesheets.
 */

if (!function_exists('twentytwentyfour_block_stylesheets')) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets()
	{
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri('assets/css/button-outline.css'),
				'ver'    => wp_get_theme(get_template())->get('Version'),
				'path'   => get_parent_theme_file_path('assets/css/button-outline.css'),
			)
		);
	}
endif;

add_action('init', 'twentytwentyfour_block_stylesheets');

/**
 * Register pattern categories.
 */

if (!function_exists('twentytwentyfour_pattern_categories')) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories()
	{

		register_block_pattern_category(
			'twentytwentyfour_page',
			array(
				'label'       => _x('Pages', 'Block pattern category', 'twentytwentyfour'),
				'description' => __('A collection of full page layouts.', 'twentytwentyfour'),
			)
		);
	}
endif;

add_action('init', 'twentytwentyfour_pattern_categories');

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

// Registrar el Shortcode
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
            $link = get_permalink(); // Obtener el enlace al post individual
            $descripcion_breve = get_field('descripcion_breve');
            $imagen = get_field('imagen');
            $ano_de_publicacion = get_field('ano_de_publicacion');

            echo '<div class="book">';
            echo '<h2><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h2>'; // Envolver el título en un enlace
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

        echo '</div>';
    } else {
        echo 'No books found.';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('display_books', 'display_books_shortcode');

function my_theme_setup() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'your-theme')
    ));
}
add_action('after_setup_theme', 'my_theme_setup');



// Registrar la Sidebar
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
add_action('widgets_init', 'register_custom_sidebar');

// Crear el Widget de Precio de Bitcoin
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

        // Obtener el precio de Bitcoin usando la API
        $response = wp_remote_get('https://mempool.space/api/v1/prices');
        if (is_wp_error($response)) {
            echo 'Unable to retrieve Bitcoin price.';
        } else {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);
            if (isset($data['USD'])) {
                echo '<div class="bitcoin-price">$' . esc_html($data['USD']) . ' USD</div>';
            } else {
                echo 'Unable to retrieve Bitcoin price.';
            }
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        // Aquí puedes agregar campos de formulario para configurar el widget en el administrador
        echo '<p>No hay opciones para este widget.</p>';
    }

    public function update($new_instance, $old_instance) {
        return $instance;
    }
}

// Registrar el Widget
add_action('widgets_init', function() {
    register_widget('Bitcoin_Price_Widget');
});

function theme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');