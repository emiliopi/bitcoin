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

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0');

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles()
{

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20);

function create_books_post_type()
{
	register_post_type(
		'books',
		array(
			'labels' => array(
				'name' => __('Books'),
				'singular_name' => __('Book')
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'menu_position' => 5,
			'menu_icon' => 'dashicons-book',
			'rewrite' => array('slug' => 'books'),
		)
	);
}
add_action('init', 'create_books_post_type');

// Añadir campos personalizados
function books_add_meta_boxes()
{
	add_meta_box('books_details', 'Book Details', 'books_meta_box_callback', 'books', 'normal', 'high');
}
add_action('add_meta_boxes', 'books_add_meta_boxes');

function books_meta_box_callback($post)
{
	// Agregar el nonce para la verificación de seguridad
	wp_nonce_field('books_save_meta_box_data', 'books_meta_box_nonce');

	// Obtener los valores actuales de los campos personalizados
	$short_description = get_post_meta($post->ID, '_books_short_description', true);
	$image = get_post_meta($post->ID, '_books_image', true);
	$year = get_post_meta($post->ID, '_books_year', true);

?>
	<div class="books-meta-box">
		<!-- Campo de descripción breve -->
		<p>
			<label for="books_short_description">Short Description</label>
			<input type="text" id="books_short_description" name="books_short_description" value="<?php echo esc_attr($short_description); ?>" size="30" required/>
		</p>

		<!-- Campo de imagen -->
		<p>
			<label for="books_image">Image</label>
			<input type="text" id="books_image" name="books_image" value="<?php echo esc_url($image); ?>" size="30" required/>
			<button type="button" class="button button-secondary" id="books_image_button">Select Image</button>
		<div id="books_image_preview">
			<?php if ($image) : ?>
				<img src="<?php echo esc_url($image); ?>" style="max-width: 100%; height: auto;" />
			<?php endif; ?>
		</div>
		</p>

		<!-- Campo de año de publicación -->
		<p>
			<label for="books_year">Publication Year</label>
			<input type="text" id="books_year" name="books_year" value="<?php echo esc_attr($year); ?>" size="30" required/>
		</p>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var mediaUploader;

				$('#books_image_button').click(function(e) {
					e.preventDefault();

					// Si el medidor ya está creado, abrirlo
					if (mediaUploader) {
						mediaUploader.open();
						return;
					}

					// Crear el medidor
					mediaUploader = wp.media({
						title: 'Select Image',
						button: {
							text: 'Use this image'
						},
						multiple: false
					});

					// Cuando se selecciona una imagen
					mediaUploader.on('select', function() {
						var attachment = mediaUploader.state().get('selection').first().toJSON();
						$('#books_image').val(attachment.url);
						$('#books_image_preview').html('<img src="' + attachment.url + '" style="max-width: 100%; height: auto;" />');
					});

					// Abrir el medidor
					mediaUploader.open();
				});
			});
		</script>
	</div>
<?php
}


function books_save_meta_box_data($post_id)
{
	if (!isset($_POST['books_meta_box_nonce']) || !wp_verify_nonce($_POST['books_meta_box_nonce'], 'books_save_meta_box_data')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$short_description = sanitize_text_field($_POST['books_short_description']);
	$image = esc_url_raw($_POST['books_image']);
	$year = sanitize_text_field($_POST['books_year']);

	update_post_meta($post_id, '_books_short_description', $short_description);
	update_post_meta($post_id, '_books_image', $image);
	update_post_meta($post_id, '_books_year', $year);
}
add_action('save_post', 'books_save_meta_box_data');

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
			$link = get_permalink();
			$short_description = get_post_meta(get_the_ID(), '_books_short_description', true);
			$image = get_post_meta(get_the_ID(), '_books_image', true);
			$year = get_post_meta(get_the_ID(), '_books_year', true);

			echo '<div class="book">';
			echo '<h4 class="book-title"><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h4>';
			if ($image) {
				echo '<div class="book-thumbnail"><a href="' . esc_url($link) . '"><img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '" class="book-image" /></a></div>';
			}
			if ($short_description) {
				echo '<div class="book-description">' . esc_html($short_description) . '</div>';
			}
			if ($year) {
				echo '<div class="book-year">Año de publicación: ' . esc_html($year) . '</div>';
			}
			echo '</div>';
		}

		echo '</div>';

		// Añadir paginación
		echo '<div class="pagination">';
		echo paginate_links(array(
			'total' => $books_query->max_num_pages
		));
		echo '</div>';
	} else {
		echo '<p>No books found.</p>';
	}

	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode('display_books', 'display_books_shortcode');


class Bitcoin_Price_Widget extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'bitcoin_price_widget',
			'Bitcoin Price Widget',
			array('description' => 'Displays current Bitcoin price.')
		);
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];
		echo $args['before_title'] . 'Bitcoin Price' . $args['after_title'];

		$response = wp_remote_get('https://mempool.space/api/v1/prices');
		if (is_wp_error($response)) {
			echo 'Unable to retrieve Bitcoin price.';
		} else {
			$body = wp_remote_retrieve_body($response);
			$data = json_decode($body, true);

			if (!empty($data)) {
				echo '<div class="bitcoin-prices">';

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

function register_custom_sidebar()
{
	register_sidebar(array(
		'name' => 'Bitcoin Price Widget',
		'id' => 'bitcoin_price_widget',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}

add_action('widgets_init', function () {
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
