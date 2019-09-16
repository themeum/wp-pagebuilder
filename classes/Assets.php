<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Assets')) {
	class WPPB_Assets {

		private $_post_id;

		public function __construct() {
			if( wppb_helper()->is_editor_screen() ) {
				$this->_post_id = absint( $_REQUEST['post'] );
			}

			if (wppb_helper()->is_editor_screen() || wppb_helper()->is_load_editor_iframe()){
				//Load only for WP Page Builder
				add_action('wppb_enqueue_scripts', array($this, 'wppb_enqueue_scripts'));
				add_action('wppb_enqueue_scripts', array($this, 'wppb_enqueue_gblobal_scripts'));
				add_action('wppb_enqueue_styles', array($this, 'wppb_enqueue_styles'));

				add_action('wp_enqueue_scripts', array($this, 'wppb_enqueue_gblobal_scripts'));
				add_action('wp_enqueue_scripts', array($this, 'wppb_enqueue_styles'));

				do_action('wppb_after_enqueue_in_editor');
			}

			// Load backend script
			add_action('admin_enqueue_scripts', array($this, 'wppb_backend_script_loader'));
			add_action('wp_ajax_wppb_switch_editor', array($this, 'wppb_switch_editor_callback'));
			add_action('wp_ajax_wppb_switch_default', array($this, 'wppb_switch_default_callback'));
		}

		/**
		 * enqueue scripts to the pagebuilder section
		 */
		public function wppb_enqueue_scripts(){
			global $wp_styles, $wp_scripts;

			if( wppb_helper()->is_editor_screen() ){

				// Reset global variable
				$wp_scripts = new \WP_Scripts();


				$is_script_debug = wppb_helper()->is_script_debug();
				$suffix = $is_script_debug ? '' : '.min';
				/**
				 * Giving widgets support from wp version 4.8
				 */
				$wp_scripts->add( 'media-widgets', "/wp-admin/js/widgets/media-widgets{$suffix}.js", array( 'jquery', 'media-models', 'media-views' ) );
				$wp_scripts->add_inline_script( 'media-widgets', 'wp.mediaWidgets.init();', 'after' );

				$wp_scripts->add( 'media-audio-widget', "/wp-admin/js/widgets/media-audio-widget{$suffix}.js", array( 'media-widgets', 'media-audiovideo' ) );
				$wp_scripts->add( 'media-image-widget', "/wp-admin/js/widgets/media-image-widget{$suffix}.js", array( 'media-widgets' ) );
				$wp_scripts->add( 'media-video-widget', "/wp-admin/js/widgets/media-video-widget{$suffix}.js", array( 'media-widgets', 'media-audiovideo' ) );
				$wp_scripts->add( 'text-widgets', "/wp-admin/js/widgets/text-widgets{$suffix}.js", array( 'jquery', 'editor', 'wp-util' ) );
				$wp_scripts->add_inline_script( 'text-widgets', 'wp.textWidgets.init();', 'after' );

				wp_enqueue_style( 'widgets' );
				wp_enqueue_style( 'media-views' );

				do_action( 'admin_print_scripts-widgets.php' );
				do_action( 'sidebar_admin_setup' );
				do_action( 'admin_enqueue_scripts', 'widgets.php' );
				do_action( 'admin_print_styles-widgets.php' );
				/**
				 * End specialized widgets support
				 */

				wp_enqueue_editor();

				wp_enqueue_script( 'wppb-lodash',WPPB_DIR_URL.'assets/js/lodash.min.js',array(),false,true );
				wp_add_inline_script( 'wppb-lodash', 'window.__ = _.noConflict();' );

				wp_enqueue_script( 'engine',WPPB_DIR_URL.'assets/js/engine.js',
					array(
						'jquery',
						'jquery-ui-resizable',
						'wp-auth-check',
						'heartbeat',
					), false,true );


				$initial_state = json_decode( get_post_meta( $this->_post_id,'_wppb_content', true ) );
				if( empty($initial_state) ){
					$initial_state = array();
				}
				$addons_data = new WPPB_Base_Data();


				$dashboard_page = '#';
				$view_page = '#';
				if (wppb_helper()->is_editor_screen()){
					$editor_id = wppb_helper()->get_the_editor_post_id();
					$dashboard_page = admin_url("post.php?post={$editor_id}&action=edit");
					$view_page = get_permalink($editor_id);
				}

				$js_translate = array(
					'add_row' => __('Add Row','wp-pagebuilder'), 'layouts' => __('Layouts','wp-pagebuilder'), 'default_addons' => __('Default Addons','wp-pagebuilder'), 
					'wordpress_widgets' => __('WordPress Widgets','wp-pagebuilder'), 'add_column' => __('Add Column','wp-pagebuilder'), 'duplicate_column' => __('Duplicate Column','wp-pagebuilder'), 
					'disable_column' => __('Disable Column','wp-pagebuilder'), 'delete_column' => __('Delete Column','wp-pagebuilder'), 'add_inner_row' => __('Add Inner Row','wp-pagebuilder'), 
					'drag_column' => __('Drag Column','wp-pagebuilder'), 'drag_inner_row' => __('Drag Inner Row','wp-pagebuilder'), 'addons' => __('Addons','wp-pagebuilder'), 
					'blocks' => __('Blocks','wp-pagebuilder'), 'library' => __('Library','wp-pagebuilder'), 'tools' => __('Tools','wp-pagebuilder'), 'import' => __('Import','wp-pagebuilder'), 
					'export' => __('Export','wp-pagebuilder'), 'clear_page_content' => __('Clear Page Content','wp-pagebuilder'), 'view' => __('View','wp-pagebuilder'), 
					'save' => __('Save','wp-pagebuilder'), 'dashboard' => __('Dashboard','wp-pagebuilder'), 'edit_page' => __('Edit Page','wp-pagebuilder'), 
					'view_page' => __('View Page','wp-pagebuilder'), 'undo' => __('Undo','wp-pagebuilder'), 'redo' => __('Redo','wp-pagebuilder'), 
					'duplicate_row' => __('Duplicate Row','wp-pagebuilder'), 'save_row' => __('Save Row','wp-pagebuilder'), 'disable_row' => __('Disable Row','wp-pagebuilder'), 
					'move_up' => __('Move Up','wp-pagebuilder'), 'move_down' => __('Move Down','wp-pagebuilder'), 'delete_row' => __('Delete Row','wp-pagebuilder'), 
					'preview' => __('Preview','wp-pagebuilder'), 'pro' => __('PRO','wp-pagebuilder'), 'save_to_library' => __('Save to Library','wp-pagebuilder'), 
					'discard' => __('Discard','wp-pagebuilder'), 'title_of_the_custom_section' => __('Title of the custom section','wp-pagebuilder'), 'pages' => __('Pages','wp-pagebuilder'), 
					'categories' => __('Categories','wp-pagebuilder'), 'search' => __('Search','wp-pagebuilder'), 'apply' => __('Apply','wp-pagebuilder'), 'add_item' => __('Add Item','wp-pagebuilder'), 
					'cancel' => __('Cancel','wp-pagebuilder'), 'name' => __('Name','wp-pagebuilder'), 'delay' => __('Delay','wp-pagebuilder'), 'duration' => __('duration','wp-pagebuilder'), 
					'background' => __('Background','wp-pagebuilder'), 'hover' => __('Hover','wp-pagebuilder'), 'color' => __('Color','wp-pagebuilder'), 'image' => __('Image','wp-pagebuilder'), 
					'gradient' => __('Gradient','wp-pagebuilder'), 'video' => __('Video','wp-pagebuilder'), 'position' => __('Position','wp-pagebuilder'), 
					'attachment' => __('Attachment','wp-pagebuilder'), 'repeat' => __('Repeat','wp-pagebuilder'), 'size' => __('Size','wp-pagebuilder'), 'url' => __('URL','wp-pagebuilder'), 
					'fallback_image' => __('Fallback Image','wp-pagebuilder'), 'upload_video' => __('Upload Video','wp-pagebuilder'), 'type' => __('Type','wp-pagebuilder'), 
					'background_color' => __('Background Color','wp-pagebuilder'), 'style' => __('Style','wp-pagebuilder'), 'horizontal' => __('Horizontal','wp-pagebuilder'), 
					'vertical' => __('Vertical','wp-pagebuilder'), 'blur' => __('Blur','wp-pagebuilder'), 'spread' => __('Spread','wp-pagebuilder'), 'top' => __('Top','wp-pagebuilder'), 'right' => __('Right','wp-pagebuilder'), 
					'bottom' => __('Bottom','wp-pagebuilder'), 'left' => __('Left','wp-pagebuilder'), 'gradient_type' => __('Gradient Type','wp-pagebuilder'), 
					'gradient_direction' => __('Gradient Direction','wp-pagebuilder'), 'start_position' => __('Start Position','wp-pagebuilder'), 'end_position' => __('End Position','wp-pagebuilder'), 
					'all' => __('All','wp-pagebuilder'), 'wppb_icon' => __('Default Icon','wp-pagebuilder'), 'fontawesome' => __('Font Awesome 5','wp-pagebuilder'), 
					'open_in_new_window' => __('Open in new window','wp-pagebuilder'), 'nofollow' => __('nofollow','wp-pagebuilder'), 'delete' => __('Delete','wp-pagebuilder'), 
					'width' => __('Width','wp-pagebuilder'), 'height' => __('Height','wp-pagebuilder'), 'flip' => __('Flip','wp-pagebuilder'), 'invert' => __('Invert','wp-pagebuilder'), 
					'bring_to_front' => __('Bring to Front','wp-pagebuilder'), 'font_family' => __('Font Family','wp-pagebuilder'), 'font_size' => __('Font Size','wp-pagebuilder'), 
					'line_height' => __('Line Height','wp-pagebuilder'), 'letter_spacing' => __('Letter Spacing','wp-pagebuilder'), 'font_style' => __('Font Style','wp-pagebuilder'), 
					'font_weight' => __('Font Weight','wp-pagebuilder'),'text_decoration' => __('Text Decoration','wp-pagebuilder'), 'text_transform' => __('Text Transform','wp-pagebuilder'),'disable' => __('Disable','wp-pagebuilder'),'enable' => __('Enable','wp-pagebuilder'), 
					'brightness' => __('Brightness','wp-pagebuilder'), 'contrast' => __('Contrast','wp-pagebuilder'), 'grayscale' => __('Grayscale','wp-pagebuilder'), 'invert' => __('Invert','wp-pagebuilder'), 'hue_rotate' => __('Hue Rotate','wp-pagebuilder'), 'saturate' => __('Saturate','wp-pagebuilder'), 'sepia' => __('Sepia','wp-pagebuilder'),       
				);

				$page_data = apply_filters('wppb_page_data',
					array(
						'ajaxurl'           => admin_url( 'admin-ajax.php' ),
						'wppb_version'      => WPPB_VERSION,
						'initialState'      => $initial_state,
						'pagebuilder_base'  => WPPB_DIR_URL,
						'script_debug'      => $is_script_debug ? 1 : 0,
						'content_url'       => content_url(),
						'admin_url'         => admin_url('/'),
						'addonsJSON'        => $addons_data->addons_data()['addons'],
						'rowSettings'       => $addons_data->row_settings(),
						'colSettings'       => $addons_data->column_settings(),
						'globalAttr'        => $addons_data->global_attr(),
						'widgetJSON'        => $addons_data->widgetLists(),
						'dashboard_page'    => $dashboard_page,
						'view_page'         => $view_page,
						'wppb_wp_editor'    => $this->wp_editor_default_template(),
						'SvgShape'			=> $addons_data->getSvgShapes(),
						'wppbimagesize'		=> wppb_getLall_image_sizes_option(),
						'i18n'				=> $js_translate,
					)
				);
				
				wp_localize_script( 'engine', 'page_data', $page_data );
			}
		}

		public function wppb_enqueue_gblobal_scripts(){
			// Register JS for Addons
			wp_enqueue_script( 'jquery.magnific-popup',WPPB_DIR_URL.'assets/js/jquery.magnific-popup.min.js',array(),false,true );
			wp_enqueue_script( 'jquery.easypiechart',WPPB_DIR_URL.'assets/js/jquery.easypiechart.min.js',array(),false,true );
			wp_enqueue_script( 'jquery.inview',WPPB_DIR_URL.'assets/js/jquery.inview.min.js',array(),false,true );
			wp_enqueue_script( 'wppb-slick-slider', WPPB_DIR_URL.'assets/js/slick/slick.min.js', array(),'1.8.0', true);

			wp_enqueue_script( 'wppagebuilder-main',WPPB_DIR_URL.'assets/js/main.js',array(),false,true );
			wp_localize_script( 'wppagebuilder-main', 'ajax_objects', array(
				'ajaxurl'           => admin_url( 'admin-ajax.php' ),
				'redirecturl'       => home_url('/'),
			));

			do_action('wppb_enqueue_scripts_in_editor');
		}

		/**
		 * Adding stylesheet in the pagebuilder section
		 */

		public function wppb_enqueue_styles(){
			$suffix = wppb_helper()->is_script_debug() ? '' : '.min';
			wp_enqueue_style( 'jquery-ui', WPPB_DIR_URL . 'assets/css/jquery-ui.css',false,'1.12.1');
			wp_enqueue_style( 'animate', WPPB_DIR_URL . 'assets/css/animate.min.css',false,'all');
			wp_enqueue_style( 'font-awesome-5', WPPB_DIR_URL . 'assets/css/font-awesome-5.min.css',false,'all');
			wp_enqueue_style( 'wppb-fonts', WPPB_DIR_URL . 'assets/css/wppb-fonts.css',false,'all');
			wp_enqueue_style( 'magnific-popup', WPPB_DIR_URL . 'assets/css/magnific-popup.css',false,'all');

			//SLick Slider
			wp_enqueue_style('wppb-slick', WPPB_DIR_URL.'assets/js/slick/slick.css', array(),'1.8.0' );
			wp_enqueue_style('wppb-slick-theme', WPPB_DIR_URL.'assets/js/slick/slick-theme.css', array(),'1.8.0' );

			// New Grid
			wp_enqueue_style( 'wppb-addons', WPPB_DIR_URL . 'assets/css/wppb-addons.css',false,'all');

			//Load only in the page builder editor
			wp_enqueue_style( 'dashicons-wppb', "/wp-includes/css/dashicons{$suffix}.css", false, 'all' );
			wp_enqueue_style( 'edit-frontend', WPPB_DIR_URL . 'assets/css/edit.css', false, 'all' );
			wp_enqueue_style( 'react-select', WPPB_DIR_URL . 'assets/css/react-select.css', false, 'all' );
			wp_enqueue_style( 'wppb-main', WPPB_DIR_URL . 'assets/css/wppb-main.css', array('wp-auth-check'),'all');

			do_action('wppb_enqueue_style_in_editor');
		}


		public function wp_editor_default_template(){
			ob_start();

			wp_editor( '{{WP_EDITOR_CONTENT}}', 'wppb_wp_editor',
				array(
					'editor_class' => 'wppb-wp-editor',
					'editor_height' => 250,
					'drag_drop_upload' => true
				)
			);
			return ob_get_clean();
		}

		/**
		 * @param $page
		 *
		 *
		 */
		function wppb_backend_script_loader($page) {
			wp_enqueue_style( 'wppb-edit-backend',  WPPB_DIR_URL . 'assets/css/wppb-backend.css',false,'all');
			wp_enqueue_script( 'wppb-edit-backend-js',WPPB_DIR_URL.'assets/js/wppb-backend.js',array(),false,true );
			$is_switched_editor = '';
			if ($page === 'post.php' && ! empty($_GET['post'])){
				$page_id = (int) sanitize_text_field($_GET['post']);
				$get_editor_switched = get_post_meta($page_id, '_wppb_current_post_editor', true);
				if ($get_editor_switched){
					$is_switched_editor = $get_editor_switched;
				}
			}
			$ajax_nonce = wp_create_nonce( "wppb-nonce-string" );


			$supported_post_types    = wppb_helper()->wppb_supports_post_types();

			wp_localize_script( 'wppb-edit-backend-js', 'wppb_admin_ajax',
				array(
					'ajax_url' => admin_url('admin-ajax.php'),
					'wppb_nonce'     => $ajax_nonce,
					'current_editor' => $is_switched_editor,
					'supported_post_type'   => $supported_post_types
				)
			);
		}

		function wppb_switch_editor_callback(){
			check_ajax_referer( 'wppb-nonce-string', 'wppb_nonce' );

			$post_id = (int) sanitize_text_field($_POST['post_id']);
			if ($post_id){
				update_post_meta($post_id, '_wppb_current_post_editor', 'wppb_builder_activated');
				wp_send_json_success(array('success' => true));
			}
		}

		function wppb_switch_default_callback(){
			check_ajax_referer( 'wppb-nonce-string', 'wppb_nonce' );

			$post_id = (int) sanitize_text_field($_POST['post_id']);
			if ($post_id){
				//Mark last edit to view pages
				$lastEditor = isset($_POST['last_editor']) ? sanitize_text_field($_POST['last_editor']) : 'wppb_default_editor';
				update_post_meta($post_id, '_wppb_current_post_editor', $lastEditor);
				wp_send_json_success(array('success' => true));
			}
		}


	}
}