<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Editor_Management')){
	class WPPB_Editor_Management {

		private $_post_id;

		public function __construct() {
			add_action( 'admin_action_wppb_editor', array($this, 'init') );
			add_action( 'template_redirect', array($this, 'redirect_to_frontend_editor') );

			add_action('admin_footer', array($this, 'print_edit_with_wp_pagebuilder_button'));

			add_action('pre_post_update', array($this, 'save_by_wp'), 10, 2);
		}

		public function redirect_to_frontend_editor(){
			if ( ! isset( $_GET['wppb_editor'] ) ) {
				return;
			}

			$post_id = get_the_ID();
			wp_redirect( wppb_helper()->get_editor_url($post_id) );
			die;
		}

		public function init() {
			if ( ! wppb_helper()->can_edit_editor()){
				wp_die( __( 'Sorry, you are not allowed to access this page.' ), 403 );
			}

			$post_id = absint( $_REQUEST['post'] );

            if ($post_id === 0){
                $post_type = isset($_REQUEST['post_type']) ? sanitize_text_field($_REQUEST['post_type']) : 'post';

	            $newPostData = array();
	            $newPostData['post_type'] = $post_type;

	            $post_id = wp_insert_post($newPostData);

	            if ($post_id){
	                $updatePostData = array(
                        'ID' => $post_id,
                        'post_title' => '#'.$post_id
                    );
	                wp_update_post($updatePostData);
                }

	            $new_url = add_query_arg(array('post' => $post_id));
                wp_redirect($new_url);
	            die();
            }else{
                $get_post = get_post($post_id );

                if ($get_post->post_status === 'auto-draft'){
	                $updatePostData = array(
		                'ID' => $post_id,
		                'post_title' => '#'.$post_id,
		                'post_status' => 'draft',

	                );
	                wp_update_post($updatePostData);
                }
            }

			$this->_post_id = $post_id;

			// Send MIME Type header like WP admin-header.
			@header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );

			query_posts(
				array(
					'p' => $this->_post_id,
					'post_type' => get_post_type( $this->_post_id )
				)
			);

			wppb_helper()->setup_post_data($this->_post_id);

			//add_filter( 'show_admin_bar', '__return_false' );
			$this->mark_post_as_wppb_editor_content();

			// Remove all WordPress actions
			remove_all_actions( 'wp_head' );
			remove_all_actions( 'wp_print_styles' );
			remove_all_actions( 'wp_print_head_scripts' );
			remove_all_actions( 'wp_footer' );

			// Handle `wp_head`
			add_action( 'wp_head', 'wp_enqueue_scripts', 1 );
			add_action( 'wp_head', 'wp_print_styles', 8 );
			add_action( 'wp_head', 'wp_print_head_scripts', 9 );
			add_action( 'wp_head', 'wp_site_icon' );

			// Handle `wp_footer`
			add_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
			add_action( 'wp_footer', 'wp_auth_check_html', 30 );
			add_action( 'wp_footer', [ $this, 'wp_footer' ] );

			// Handle `wp_enqueue_scripts`
			remove_all_actions( 'wp_enqueue_scripts' );

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 999999 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 999999 );

			// Change mode to Builder

			// Setup default heartbeat options
			add_filter( 'heartbeat_settings', function( $settings ) {
				$settings['interval'] = 15;
				return $settings;
			} );

			// Print the panel
			$this->load_frontend_template();
			die;
		}


		private function load_frontend_template(){
			include WPPB_DIR_PATH.'inc/editor-main.php';
		}

		/**
		 * @since 1.0.0
		 * @access public
		 */
		public function enqueue_scripts() {
			remove_action( 'wp_enqueue_scripts', [ $this, __FUNCTION__ ], 999999 );

			// Set the global data like $authordata and etc
			setup_postdata( $this->_post_id );
			do_action('wppb_enqueue_scripts');
		}

		/**
		 * @since 1.0.0
		 * @access public
		 */
		public function enqueue_styles() {
			// Remove all TinyMCE plugins.
			remove_all_filters( 'mce_buttons', 10 );
			remove_all_filters( 'mce_external_plugins', 10 );

			// Tweak for WP Admin menu icons
			wp_print_styles( 'editor-buttons' );

			do_action( 'wppb_enqueue_styles' );
		}

		/**
		 * @since V.1.0.0
		 */
		public function wp_footer(){
			$this->template_data_footer_add();

			do_action( 'admin_footer-widgets.php' );
		}

		public function lodash_style_generator( $settings ){
			$arr = array();
			foreach( $settings as $key => $value ){
				if( isset( $value['selector'] ) ){
					if( is_array( $value['selector'] ) ){
						if( !empty( $value['selector'] ) ){
							foreach( $value['selector'] as $val ){
								if( $value['type'] == 'typography' 
									|| $value['type'] == 'typography2' 
									|| $value['type'] == 'gradient' 
									|| $value['type'] == 'border' 
									|| $value['type'] == 'color2' 
									|| $value['type'] == 'filter' 
									|| $value['type'] == 'boxshadow' ){
										if( array_key_exists( $key , $arr) ){
											$arr[$key] = $arr[$key] . $val . '{{data.'.$key.'}}';
										} else {
											$arr[$key] = $val . '{{data.'.$key.'}}';
										}
								} else {
									if( array_key_exists( $key , $arr) ){
										$arr[$key] = $arr[$key] . $val;
									} else {
										$arr[$key] = $val;
									}
								}
							}
						}
					} else {
						if( $value['type'] == 'typography' 
							|| $value['type'] == 'typography2' 
							|| $value['type'] == 'gradient' 
							|| $value['type'] == 'border' 
							|| $value['type'] == 'color2' 
							|| $value['type'] == 'filter' 
							|| $value['type'] == 'boxshadow' ){
								$arr[$key] = $value['selector'] . '{{data.'.$key.'}}';
						} else {
							$arr[$key] = $value['selector'];
						}
					}
				}

				// Repeated Fields
				if( $value['type'] == 'repeatable' ){
					if( is_array( $value['attr'] ) ){
						foreach( $value['attr'] as $k=>$v ){
							if( isset( $v['selector'] ) ){
								$arr = array_merge( $arr , $this->repetable_selector( $key, $v, $k ) );
							}
							if( $v['type'] == 'repeatable' ){
								if( is_array( $v['attr'] ) ){
									foreach( $v['attr'] as $inner_k=>$inner_v ){
										if( isset( $inner_v['selector'] ) ){
											$arr = array_merge( $arr , $this->repetable_selector( $key, $inner_v, $inner_k ) );
										}
									}
								}
							}
						}
					}
				}
			}
			if( !empty( $arr ) ){ echo json_encode($arr); }
		}

		public function repetable_selector( $key, $v, $k ){
			$arr = array();
				if( is_array( $v['selector'] ) ){
					if( !empty( $v['selector'] ) ){
						foreach( $v['selector'] as $val ){
							if( $v['type'] == 'typography' || $v['type'] == 'typography2' || $v['type'] == 'gradient' || $v['type'] == 'border' || $v['type'] == 'color2' || $v['type'] == 'filter' || $v['type'] == 'boxshadow' ){
								if( array_key_exists( $key , $arr) ){
									$arr[$key.'.'.$k] = $arr[$key] . $val . '{{data.'.$k.'}}';
								} else {
									$arr[$key.'.'.$k] = $val . '{{data.'.$k.'}}';
								}
							} else {
								if( array_key_exists( $key , $arr) ){
									$arr[$key.'.'.$k] = $arr[$key] . $val;
								} else {
									$arr[$key.'.'.$k] = $val;
								}
							}
						}
					}
				} else {
					if( $v['type'] == 'typography' || $v['type'] == 'typography2' || $v['type'] == 'gradient' || $v['type'] == 'border' || $v['type'] == 'color2' || $v['type'] == 'filter' || $v['type'] == 'boxshadow' ){
						$arr[$key.'.'.$k] = $v['selector'] . '{{data.'.$k.'}}';
					} else {
						$arr[$key.'.'.$k] = $v['selector'];
					}
				}
			return $arr;
		}


		/**
		 * Add addon template data in footer
		 */
		public function template_data_footer_add(){
			// Add Common CSS
			if ( class_exists('WPPB_Ajax')){
				echo '<script id="wppb-tmpl-common-css" type="x-tmpl-lodash">';
					echo WPPB_Ajax::get_content_common_css();
				echo '</script>';
			}

			$global = new WPPB_Base_Data();
			$global = $global->global_attr();

			$available_addons = wppb_helper()->get_addon_classes();
			if( !empty($available_addons) ) {
				foreach ( $available_addons as $class ) {
					if (!class_exists($class)){
						continue;
					}
					$data = new $class();

					$settings = $data->get_settings();
					if (method_exists($data, 'getTemplate')) {
						echo '<script id="wppb-tmpl-addon-' . $data->get_name() . '" type="x-tmpl-lodash">';
						echo $data->getTemplate();
						echo '</script>';
					}
					if (method_exists($data, 'get_settings')) {
						echo '<script id="wppb-tmpl-addon-style-'.$data->get_name().'" type="x-tmpl-lodash">';
						$settings = $data->get_settings();
						if( is_array( $settings ) ){
							if( !empty( $settings ) ){
								$this->lodash_style_generator( array_merge( $settings, $global['style'],$global['advanced'] ) );
							}
						}
						echo '</script>';
					}
				}
			}

			$data = new WPPB_Base_Data();

			echo '<script id="wppb-tmpl-row-style" type="x-tmpl-lodash">';
			$row = $data->row_settings();
			$this->lodash_style_generator( array_merge( $row['attr']['general'],$row['attr']['style'],$row['attr']['advanced'] ) );
			echo '</script>';

			echo '<script id="wppb-tmpl-col-style" type="x-tmpl-lodash">';
			$col = $data->column_settings();
			$this->lodash_style_generator( array_merge( $col['attr']['general'],$col['attr']['style'],$col['attr']['advanced'] ) );
			echo '</script>';

			echo '<script id="wppb-tmpl-addon-widget" type="x-tmpl-lodash">';
			$col = $data->column_settings();
			$this->lodash_style_generator( $global['advanced'] );
			echo '</script>';
		}

		/**
		 * @param int $post_id
		 */
		public function mark_post_as_wppb_editor_content($post_id = 0){
			if ( ! $post_id){
				$post_id = get_the_ID();
			}
			update_post_meta($post_id, '_is_wppb_editor', true);
			update_post_meta($post_id, '_wppb_current_post_editor', 'wppb_builder_activated');
		}


		public function print_edit_with_wp_pagebuilder_button(){
			global $post;
			if ( ! $post){
			    return;
            }
			$editor = get_post_meta( $post->ID,'_wppb_current_post_editor', true );
			$supported_post_types    = wppb_helper()->wppb_supports_post_types();

			if (! in_array($post->post_type, $supported_post_types)){
			    return;
            }

            $currentEditor = get_post_meta($post->ID, '_wppb_current_post_editor', true);

			?>
			<script id="wppb-edit-with-btn-in-gutenberg-toolbar" type="text/html">
				<div class="wppb-editor-warper">
					<a href="<?php echo wppb_helper()->get_editor_url($post->ID); ?>" class="components-button  is-button is-primary is-large edit-with-wppb-builder" style="display: <?php echo $currentEditor !== 'wppb_builder_activated'? 'block':'none'; ?>;"><?php _e('Edit With WP Page Builder','wp-pagebuilder');?></a>

					<a href="<?php echo wppb_helper()->get_editor_url($post->ID); ?>" class="components-button  is-button is-default is-large wppb-back-to-gutenberg" style="display: <?php echo $currentEditor === 'wppb_builder_activated'? 'block':'none'; ?>;"><i class="
dashicons dashicons-arrow-left-alt2"></i><?php _e('Back to Guttenberg',
					'wp-pagebuilder');?></a>
				</div>
			</script>
			<?php
		}

		/**
		 * @param $post_ID
		 * @param $data
         *
         * Save view preference with last edited editor
         * Show view as per last editor content
		 */
		public function save_by_wp( $post_ID, $data){
			global $wpdb;

            $is_guttenBlock = ( false !== strpos( (string) $data['post_content'], '<!-- wp:' ) );
            //die(var_dump($is_guttenBlock));
			if ($is_guttenBlock){
                //This is gutenberg Editor
	            $previousPost = $wpdb->get_row("SELECT * from {$wpdb->posts} WHERE ID = {$post_ID} ");
	            if ($previousPost->post_content != $data['post_content'] ){
		            update_post_meta($post_ID, '_wppb_current_post_editor', 'gutenberg');
	            }
            }

		    if ( ! empty($_POST['action']) && $_POST['action'] === 'editpost'){
                $previousPost = $wpdb->get_row("SELECT * from {$wpdb->posts} WHERE ID = {$post_ID} ");
                $shouldMakeClassicEditor = apply_filters('wppb_should_view_classic_editor_content', false);

                if (strlen(sanitize_text_field($previousPost->post_content)) != strlen(sanitize_text_field($data['post_content'])) ){
                    update_post_meta($post_ID, '_wppb_current_post_editor', 'wppb_default_editor');
                }
                if ($shouldMakeClassicEditor){
	                update_post_meta($post_ID, '_wppb_current_post_editor', 'wppb_default_editor');
                }
		    }
        }

	}
}