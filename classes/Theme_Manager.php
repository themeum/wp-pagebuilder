<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Theme_Manager {

	/**
	 * WPPB_Theme_Manager constructor.
	 *
	 */
	public function __construct() {
		//Include wp page builder default template without wrapper
		add_filter( 'template_include', array($this, 'template_include') );

		//Add WP PageBuilder supported Post type in page template
		$post_types = wppb_get_option('supported_post_type');
		if( is_array($post_types) ){
			foreach ($post_types as $post_type){
				add_filter( "theme_{$post_type}_templates", array( $this, 'add_wppb_pagebuilder_template' ) );
			}
		}
	}

	/**
	 * @param $template
	 *
	 * @return string
	 */
	public function template_include($template){
		if ( is_singular() ) {
			$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			if ( $page_template === 'wppb_theme_template' ) {
				$template = WPPB_DIR_PATH . 'inc/default-template.php';
			}
		}
		return $template;
	}

	/**
	 * @param $post_templates
	 *
	 * @return mixed
	 */
	public function add_wppb_pagebuilder_template($post_templates){
		$post_templates['wppb_theme_template'] = __('WP Page Builder Template', 'wp-pagebuilder');
		return $post_templates;
	}

}