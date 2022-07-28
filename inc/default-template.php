<?php
/**
 * WP PageBuilder
 *
 * @package wp-pagebuilder
 * @since v.1.0.0
 * @copyright: https://themeum.com
 *
 */

global $wp_version;
if ( version_compare( $wp_version, '5.9', '>=' ) && function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) { ?>
	<!doctype html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<?php wp_head(); ?>
		</head>
		<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
			<div class="wp-site-blocks">
			<?php
				$theme      = wp_get_theme();
				$theme_slug = $theme->get( 'TextDomain' );
				echo do_blocks( '<!-- wp:template-part {"slug":"header","theme":"' . $theme_slug . '","tagName":"header","className":"site-header","layout":{"inherit":true}} /-->' );
} else {
	get_header();
}

while ( have_posts() ) : the_post();
	the_content();
endwhile; // End of the loop.

if ( version_compare( $wp_version, '5.9', '>=' ) && function_exists( 'wp_is_block_theme' ) && true === wp_is_block_theme() ) {
	$theme      = wp_get_theme();
	$theme_slug = $theme->get( 'TextDomain' );
	echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"' . $theme_slug . '","tagName":"footer","className":"site-footer","layout":{"inherit":true}} /-->');
	echo '</div>';
	wp_footer();
	echo '</body>';
	echo '</html>';
} else {
	get_footer();
}