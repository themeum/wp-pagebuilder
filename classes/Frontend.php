<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Frontend')){

	class WPPB_Frontend{

		/**
		 * WPPB_Frontend constructor.
		 */
		public function __construct() {
			add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));

			//enqueue scripts
			add_action('wp_enqueue_scripts', array($this, 'enqueue_common_scripts'));
			//enqueue style
			add_action('wp_enqueue_scripts', array($this, 'enqueue_common_style'), 1);

			//Load Addon Specific scripts
			add_action('wp_enqueue_scripts', array($this, 'enqueue_addon_handler_scripts'), 30);
			//Load Addon Specific style
			add_action('wp_enqueue_scripts', array($this, 'enqueue_addon_handler_style'), 30);

			//Modify the_content with page builder data
			if ( ! wppb_helper()->is_load_editor_iframe()){
				add_filter('the_content', array($this, 'filter_content_with_pagebuilder'));

				add_filter( 'post_class', array($this, 'wppb_container_post_class') );
				add_filter( 'body_class', array($this, 'wppb_container_body_class') );
			}

			/**
			 * Add a menu link in top admin bar
			 */
			if (wppb_helper()->can_edit_editor()){
				add_action('admin_bar_menu', array($this, 'add_toolbar_items'), 100);
			}
		}

		public function enqueue_frontend_scripts(){
			do_action('wppb_pre_load_frontend_scripts');
			//Frontend Scripts load goes here

			//End Frontend
			do_action('wppb_post_load_frontend_scripts');
		}

		/**
		 * Load Scripts in frontend
		 */
		public function enqueue_common_scripts(){
			// Register Frontend
			wp_register_script( 'jquery.magnific-popup' , WPPB_DIR_URL.'assets/js/jquery.magnific-popup.min.js', array('jquery'),false, true );
			wp_register_script( 'wppb-slick-slider' , WPPB_DIR_URL.'assets/js/slick/slick.min.js', array('jquery'),'1.8.0', true);
			wp_register_script( 'jquery.easypiechart' , WPPB_DIR_URL.'assets/js/jquery.easypiechart.min.js', array('jquery'),false, true);
			wp_register_script( 'jquery.inview' , WPPB_DIR_URL.'assets/js/jquery.inview.min.js',array(),false,true );
			// Enqueue Frontend
			wp_enqueue_script( 'wppagebuilder-main',WPPB_DIR_URL.'assets/js/main.js',array('jquery'),false,true );
		}

		/**
		 * Load in frontend View
		 */
		public function enqueue_common_style(){
			wp_register_style( 'magnific-popup', WPPB_DIR_URL . 'assets/css/magnific-popup.css',false,'all');
			wp_register_style('wppb-slick-slider-css', WPPB_DIR_URL.'assets/js/slick/slick.css', array(),'1.8.0' );
			wp_register_style('wppb-slick-slider-css-theme', WPPB_DIR_URL.'assets/js/slick/slick-theme.css', array(),'1.8.0' );

			wp_enqueue_style( 'jquery-ui', WPPB_DIR_URL . 'assets/css/jquery-ui.css',false,'1.12.1');
			wp_enqueue_style( 'animate', WPPB_DIR_URL . 'assets/css/animate.min.css',false,'all');
			
			wp_enqueue_style( 'font-awesome-5', WPPB_DIR_URL . 'assets/css/font-awesome-5.min.css',false,'all');
			
			wp_enqueue_style( 'wppb-fonts', WPPB_DIR_URL . 'assets/css/wppb-fonts.css',false,'all');
			//wp_enqueue_style( 'magnific-popup', WPPB_DIR_URL . 'assets/css/magnific-popup.css',false,'all');
			wp_enqueue_style( 'wppb-addons', WPPB_DIR_URL . 'assets/css/wppb-addons.css',false,'all');
			wp_enqueue_style( 'wppb-main', WPPB_DIR_URL . 'assets/css/wppb-main.css',array(),'all');

			/**
			 * Load page specific css from file or inline style
			 */
			if ( ! wppb_helper()->is_load_editor_iframe()) {
				$post_id = wppb_helper()->is_wppb_single();
				if ( $post_id ) {
					$css_save_as = wppb_get_option( 'css_save_as' );
					if ( $css_save_as === 'filesystem' ) {
						$upload_dir     = wp_get_upload_dir();
						$upload_css_dir = trailingslashit( $upload_dir['basedir'] );
						$css_path       = $upload_css_dir . "wp-pagebuilder/wppb-page-css-{$post_id}.css";
						if ( file_exists( $css_path ) ) {
							$css_dir_url = trailingslashit( $upload_dir['baseurl'] );
							$css_url     = $css_dir_url . "wp-pagebuilder/wppb-page-css-{$post_id}.css";
							if ( ! wppb_helper()->is_editor_screen() ) {
								wp_enqueue_style( "wppb-page-{$post_id}", $css_url, array(), time(), 'all' );
							}
						}
					}else{
						$getCssFromMeta = get_post_meta($post_id, '_wppb_page_css', true);
						wp_add_inline_style('wppb-main', $getCssFromMeta);
					}
				}
			}

		}

		public function used_addons_in_page(){
			//Getting page builder content
			$is_wppb_pagebuilder_page = get_post_meta(get_the_ID(), '_wppb_content', true);
			$is_wppb_pagebuilder_page = json_decode($is_wppb_pagebuilder_page);
			$used_addons_names = array();

			//Checking all addons used by current page
			if (is_array($is_wppb_pagebuilder_page) && count($is_wppb_pagebuilder_page)){
				foreach ($is_wppb_pagebuilder_page as $row){
					if (is_array($row->columns) && count($row->columns) ){
						foreach ($row->columns as $col){
							if (is_array($col->addons) && count($col->addons) ) {
								foreach ($col->addons as $addon){
									if( isset( $addon->type ) && $addon->type == 'inner_row' ){
										if (is_array($addon->columns) && count($addon->columns) ) {
											foreach ($addon->columns as $inner_addons ){
												if (is_array($inner_addons->addons) && count($inner_addons->addons) ){
													foreach ($inner_addons->addons as $inner_addons ){
														if( isset($inner_addons->name) ){
															$used_addons_names[] = $inner_addons->name;
														}
													}
												}
											}
										}
									}else{
										if( isset($addon->name) ){
											$used_addons_names[] = $addon->name;
										}
									}	
								}
							}
						}
					}
				}
			}

			return $used_addons_names;
		}
		/**
		 * Enquee scripts which called in addon and registered to WordPress
		 * @since v.1.0.0
		 */
		public function enqueue_addon_handler_scripts(){
			if ( ! wppb_helper()->is_wppb_single())
				return;

			$used_addons_names = $this->used_addons_in_page();

			//Checking used addons if used any script or style from Enqueue
			$get_addon_classes = wppb_helper()->get_addon_classes();

			$registered_scripts = array();
			if ( ! empty($get_addon_classes) && count($get_addon_classes)){
				foreach ($get_addon_classes as $addon_class){
					if (class_exists($addon_class)){
						$class_instance = new $addon_class;
						if (in_array($class_instance->get_name(), $used_addons_names)){
							if (method_exists($class_instance, 'get_enqueue_script')){
								$enqueue_scripts = $class_instance->get_enqueue_script();
								if ( ! empty($enqueue_scripts) && count($enqueue_scripts)){
									foreach ($enqueue_scripts as $script){
										$registered_scripts[$script] = $script;
									}
								}
							}
						}
					}
				}
			}

			//Enqueue script used by addons
			if ( ! empty($registered_scripts) && count($registered_scripts)){
				foreach ($registered_scripts as $script){
					if (wp_script_is($script,'registered')){
						wp_enqueue_script($script);
					}
				}
			}
		}

		/**
		 * Enquee style from registered Style
		 * @since v.1.0.0
		 */
		public function enqueue_addon_handler_style(){
			if ( ! wppb_helper()->is_wppb_single())
				return;

			$used_addons_names = $this->used_addons_in_page();
			$get_addon_classes = wppb_helper()->get_addon_classes();

			$registered_scripts = array();
			if ( ! empty($get_addon_classes) && count($get_addon_classes)){
				foreach ($get_addon_classes as $addon_class){
					if (class_exists($addon_class)){
						$class_instance = new $addon_class;
						if (in_array($class_instance->get_name(), $used_addons_names)) {
							if ( method_exists( $class_instance, 'get_enqueue_style' ) ) {
								$enqueue_scripts = $class_instance->get_enqueue_style();
								if ( ! empty( $enqueue_scripts ) && count( $enqueue_scripts ) ) {
									foreach ( $enqueue_scripts as $script ) {
										$registered_scripts[ $script ] = $script;
									}
								}
							}
						}
					}
				}
			}

			if ( ! empty($registered_scripts) && count($registered_scripts)){
				foreach ($registered_scripts as $script){
					if (wp_style_is($script,'registered')){
						wp_enqueue_style($script);
					}
				}
			}
		}


		/**
		 * Filter the_content with WP PageBuilder Content
		 */

		function filter_content_with_pagebuilder($content){
			$page_id = get_the_ID();
			$last_editor = get_post_meta($page_id, '_wppb_current_post_editor', true);

			/**
			 * Returning original content if last edit with classic editor
			 * Returning original content if it's not a page builder content
			 */

			if($last_editor === 'wppb_builder_activated' ){
				$page_builder_content = get_post_meta($page_id, '_wppb_content', true);
				if ( ! empty($page_builder_content)){
					$settings = json_decode($page_builder_content, true);
					include WPPB_DIR_PATH.'classes/Layout_Generator.php';
					ob_start();
					$generate = new WPPB_Layout_Generator;
					echo $generate->generate($settings);
					$content = ob_get_clean();

					return $content;
				}
			}
			

			return $content;
		}

		/**
		 * @param $classes
		 *
		 * @return array
		 *
		 * Add Post Class in single page for WP Page Builder
		 */
		function wppb_container_post_class( $classes ) {
			global $post;

			if ( ! wppb_helper()->is_wppb_single()){
				return $classes;
			}

			$classes[] = "type-wppb";
			//$classes[] = "wppb-container";
			$classes[] = "wppb-{$post->post_type}";
			$classes[] = "wppb-{$post->post_type}-{$post->ID}";
			return $classes;
		}

		/**
		 * @param $classes
		 *
		 * @return array
		 *
		 * Add Body Class in single page for WP Page Builder
		 */
		public function wppb_container_body_class( $classes ){
			global $post;

			if ( ! wppb_helper()->is_wppb_single()){
				return $classes;
			}

			$classes[] = "wppb-body";
			$classes[] = "wppb-body-{$post->post_type}";
			$classes[] = "wppb-body-{$post->post_type}-{$post->ID}";
			$classes[] = "wppb-body-single-{$post->ID}";
			return $classes;
		}


		/**
		 * @param $admin_bar
		 *
		 * Add a edit with page builder link in admin menu
		 */

		function add_toolbar_items($admin_bar){
			if (is_singular()){
				global $post;

				$wppb_supports_post_types = wppb_helper()->wppb_supports_post_types();
				if ( in_array($post->post_type, $wppb_supports_post_types)) {
					$link = wppb_helper()->get_editor_url( get_the_ID() );
					$admin_bar->add_menu(
						array(
							'id'    => 'edit-with-wppb',
							'title' => __( 'Edit with WP Page Builder', 'wp-pagebuilder' ),
							'href'  => $link,
							'meta'  => array(
								'title' => __( 'Edit with WP Page Builder', 'wp-pagebuilder' ),
							),
						)
					);
				}
			}
		}




	}
}