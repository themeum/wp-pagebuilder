<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_General')){
	class WPPB_General{
		/**
		 * WPPB_General constructor.
		 */
		public function __construct(){
			if ( wppb_helper()->can_edit_editor() ) {
				add_filter('post_row_actions', array($this, 'posts_table_row_actions'), 10, 2 );
				add_filter('page_row_actions', array($this, 'posts_table_row_actions'), 10, 2 );
				add_filter('display_post_states' , array($this, 'wppb_display_post_states'), 10, 2);
			}

			// Check if editor iframe load by get_permalink
			if (wppb_helper()->is_load_editor_iframe()){
				add_filter('show_admin_bar', '__return_false' ); // Remove Admin Bar
			}
			
			add_action( 'init', array( $this, 'addon_include') ); // Include addon directory
			add_action( 'edit_form_after_title', array( $this, 'after_title_button_add' )); // Add Button After Title
			add_filter( 'the_content', array( $this, 'content_modify_filter' ) ); // Return Content After Modify

			add_action( 'admin_init', array( $this, 'wppb_go_premium_page' ) );
			add_action( 'admin_menu', array( $this, 'wppb_add_admin_menu' ), 502 );
		}
		
		/**
		 * @param $actions
		 * @param $post
		 *
		 * @return mixed
		 */
		public function posts_table_row_actions( $actions, $post ) {
			$wppb_supports_post_types = wppb_helper()->wppb_supports_post_types();
			if ( in_array( $post->post_type, $wppb_supports_post_types ) ) {
				$editor_url = wppb_helper()->get_editor_url($post->ID);
				$actions['wppb_editor'] = '<a href="'.$editor_url.'">'.__('Edit with WP Page Builder', 'wp-pagebuilder' ).'</a>';
			}
			return $actions;
		}

		/**
		 * @param $post_states
		 * @param $post
		 *
		 * @return array
		 *
		 * display post states in the wp post list
		 */
		public function wppb_display_post_states($post_states, $post){
			require_once(ABSPATH . 'wp-admin/includes/screen.php');
			$screen = get_current_screen();
			if (isset($screen->base)) {
				if ( $screen->base === 'edit'){
					$wppb_supports_post_types = wppb_helper()->wppb_supports_post_types();
					if ( in_array($post->post_type, $wppb_supports_post_types)) {
						$is_wppb_editor_page = get_post_meta( $post->ID, '_is_wppb_editor', true );
						if ( $is_wppb_editor_page ) {
							$post_states[] = ' WP Page Builder ';
						}
					}
				}
			}
			return $post_states;
		}

		// Return Content After Modify
		function content_modify_filter( $content ) {
			$editor = get_post_meta( get_the_ID(), '_wppb_current_post_editor', true );
			if( $editor  ){
				if( $editor == 'wppb_builder_activated' ){
					return '<div id="wppb-builder-container" class="wppb-builder-container">'.$content.'</div>';
				}else{
					return $content;	
				}
			}else{
				return $content;
			}
		}

		// Include addon directory
		public function addon_include(){
			$addon_dir = array_filter(glob( WPPB_DIR_PATH.'addons/*'), 'is_dir');
			if (count($addon_dir) > 0) {
				foreach ($addon_dir as $key => $value) {
					$addon_dir_name = str_replace(dirname($value).'/', '', $value);
					$file_name = WPPB_DIR_PATH . 'addons/'.$addon_dir_name.'/'.$addon_dir_name.'.php';
					if ( file_exists($file_name) ){
						include_once $file_name;
					}
				}
			}
		}

		// Add Button After Title
		public function after_title_button_add($pram){
			global $post;
			$editor = get_post_meta( $post->ID,'_wppb_current_post_editor', true );

			$supported_post_types    = wppb_helper()->wppb_supports_post_types();
			if( !in_array($pram->post_type, $supported_post_types) ){
				return;
			}
			if (! wppb_helper()->can_edit_editor()){
				return;
			}
			?>
			<?php if( $editor == 'wppb_builder_activated' ) { ?>
				<div class="wppagebuilder-edit-button wppagebuilder-edit-hide-editor" data-postid="<?php echo $post->ID; ?>">
			<?php } else { ?>
				<div class="wppagebuilder-edit-button wppagebuilder-edit-show-editor" data-postid="<?php echo $post->ID; ?>">
			<?php } ?>
			<?php if( $editor == 'wppb_builder_activated' ) { ?>
				<div class="wppb-edit-button-wrap">
					<div class="wppb-back-editor wppb-class-editor-show">
						<a href="#" class="wppb-backend-btn wppb-info-btn use-default-editor"><?php _e('Use Default Editor','wp-pagebuilder' );?></a>
					</div><!--/.wppb-back-editor-->
					<div class="wppb-editor-warper">
						<a href="<?php echo wppb_helper()->get_editor_url($post->ID); ?>" class="wppb-backend-btn wppb-primary-btn edit-with-wppb-builder"><?php _e('Edit With WP Page Builder','wp-pagebuilder');?></a>
					</div>
				</div><!--/.wppb-edit-button-wrap-->
			<?php } else { ?>
				<div class="wppb-edit-button-default-wrap">
					<div class="wppb-editor-warper">
						<a href="<?php echo wppb_helper()->get_editor_url($post->ID); ?>" class="wppb-backend-btn wppb-primary-btn edit-with-wppb-builder"><?php _e('Edit With WP Page Builder','wp-pagebuilder');?></a>
					</div>
				</div><!--/.wppb-edit-button-default-wrap-->
			<?php } ?>
			</div><!--/.wppagebuilder-edit-button-->
			<?php
		}

		/*
		 * Add go pro plugin if pro plugin as not activated
		 */
		public function wppb_add_admin_menu(){
            $is_pro_activated = is_plugin_active('wp-pagebuilder-pro/wp-pagebuilder-pro.php');
            if ( ! $is_pro_activated ){
	            add_submenu_page( 'wppb-settings', __( 'Go Premium', 'wp-pagebuilder' ), __( '<span class="dashicons dashicons-awards wppb-go-premium-star"></span> Go Premium', 'wp-pagebuilder' ), 'manage_options', 'wppb-go-premium', array($this, 'wppb_go_premium_page') );
            }
		}

		/**
		 * Admin Go Premium Redirect to Themeum
		 */
		public function wppb_go_premium_page(){
			if ( empty( $_GET['page'] ) ) {
				return;
			}
			
			if ( 'wppb-go-premium' === $_GET['page'] ) {
				wp_redirect( 'https://www.themeum.com/product/wp-pagebuilder/?utm_source=wp_pagebuilder&utm_medium=wordpress_sidebar&utm_campaign=go_premium' );
				die();
			}
        }
	}
}