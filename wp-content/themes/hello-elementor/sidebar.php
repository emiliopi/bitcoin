<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
if (is_active_sidebar('bitcoin_price_widget')) : ?>
	<aside id="secondary" class="widget-area">
		<?php dynamic_sidebar('bitcoin_price_widget'); ?>
	</aside>
<?php endif; ?>