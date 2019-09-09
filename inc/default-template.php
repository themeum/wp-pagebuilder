<?php
/**
 * WP PageBuilder
 *
 * @package wp-pagebuilder
 * @since v.1.0.0
 * @copyright: https://themeum.com
 *
 */

get_header();
while ( have_posts() ) : the_post();
	the_content();
endwhile; // End of the loop.

get_footer();