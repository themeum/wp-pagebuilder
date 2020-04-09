<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Helper')) {
	class WPPB_Helper {
		public function __construct() {
			add_filter( 'plugin_action_links_' . WPPB_BASENAME, array($this, 'plugin_action_links_callback') );
			add_filter( 'plugin_row_meta' , array($this, 'plugin_row_meta_callback'), 10, 2 );
		}

		/**
		 * @param int $post_id
		 *
		 * @return mixed
		 *
		 * @return WPPB editor URL
		 *
		 * @since v.1.0.0
		 */
		public function get_editor_url($post_id = 0){
			$edit_link = add_query_arg( array( 'post' => $post_id, 'action' => 'wppb_editor' ), admin_url( 'post.php' ) );
			return apply_filters( 'wppb_get_editor_url', $edit_link, $post_id );
		}

		public function is_script_debug(){
			return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
		}


		/**
		 * @param $post_id
		 *
		 * Setup post data based on post id
		 *
		 * @since v.1.0.0
		 */
		public function setup_post_data( $post_id ) {
			if ( $post_id === get_the_ID()) {
				return;
			}
			$GLOBALS['post'] = get_post( $post_id );
			setup_postdata( $GLOBALS['post'] );
		}


		/**
		 *
		 * determine if wppb editor is open
		 *
		 * @since V.1.0.0
		 * @return bool
		 *
		 * @since v.1.0.0
		 */
		public function is_editor_screen(){
			if ( ! empty($_GET['action']) &&  $_GET['action'] === 'wppb_editor'){
				return true;
			}
			return false;
		}

		/**
		 * @return bool
		 *
		 * @since v.1.0.0
		 */
		public function is_load_editor_iframe(){
			if ( ! empty($_GET['load_for']) && $_GET['load_for'] === 'wppb_editor_iframe' ){
				return true;
			}
			return false;
		}

		/**
		 * @return bool|false|int
		 *
		 * determine if current single page is WP Page Builder Page
		 */
		public function is_wppb_single(){
			$post_id = get_the_ID();
			if ( ! $post_id){
				return false;
			}
			$post = get_post($post_id);
			if ( ! is_singular($post->post_type)){
				return false;
			}

			if ( ! $this->is_wppb_content($post_id)){
				return false;
			}
			return $post_id;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 *
		 * Determine if this post contain wppb editor content
		 *
		 * @since v.1.0.0
		 */
		public function is_wppb_content($post_id = 0){
			$is_wppb_pagebuilder_page = get_post_meta($post_id, '_is_wppb_editor', true);
			if ($is_wppb_pagebuilder_page){
				return true;
			}

			return false;
		}

		/**
		 * @return mixed
		 *
		 * return options
		 *
		 * @since v.1.0.0
		 */
		public function wppb_options(){
			return apply_filters('wppb_options', get_option( 'wppb_options' ));
		}

		/**
		 * @return mixed
		 *
		 * get WP Page Builder Support Post Type
		 * @since v.1.0.0
		 */
		public function wppb_supports_post_types(){
			$wppb_option = $this->wppb_options();
			$support_post_type = array();
			if ( is_array( $wppb_option['supported_post_type'] ) ){
				if( ! empty($wppb_option['supported_post_type'] ) ){
					$support_post_type = $wppb_option['supported_post_type'];
				}
			}
			return apply_filters('wppb_supports_post_type', $support_post_type);
		}

		/**
		 * @return array
		 *
		 * get exclude roles
		 * @since v.1.0.0
		 */
		public function wppb_exclude_roles(){
			$exclude = array();
			$wppb_options = $this->wppb_options();

			if ( ! empty($wppb_options['exclude_role'])){
				$exclude = $wppb_options['exclude_role'];
			}

			return $exclude;
		}

		/**
		 * @return bool
		 *
		 * @since v.1.0.0
		 */
		public function can_edit_editor(){
			if ( ! is_user_logged_in()){
				return false;
			}
			$exclude_roles = $this->wppb_exclude_roles();
			$user_meta = get_userdata( get_current_user_id() );

			$bool = true;
			if (count($exclude_roles)){
				if( count( array_intersect( $user_meta->roles , $exclude_roles ) ) > 0 ){
					$bool = false;
				}
			}
			return $bool;
		}

		/**
		 * @return array
		 *
		 * Get All Addon Class Name
		 *
		 * @since v.1.0.0
		 */
		public function get_addon_classes(){
			$addons = array(
				'WPPB_Addon_Accordion',
				'WPPB_Addon_Alert',
				'WPPB_Addon_Animated_Number',
				'WPPB_Addon_Blocknumber',
				'WPPB_Addon_Button',
				'WPPB_Addon_Button_Group',
				'WPPB_Addon_Carousel',
				'WPPB_Addon_Form',
				'WPPB_Addon_Feature_Box',
				'WPPB_Addon_Flip_Box',
				'WPPB_Addon_Heading',
				'WPPB_Addon_Icon',
				'WPPB_Addon_Image',
				'WPPB_Addon_Image_Hover',
				'WPPB_Addon_Person',
				'WPPB_Addon_Person_Carousel',
				'WPPB_Addon_Pie_Progress',
				'WPPB_Addon_Posts_Grid',
				'WPPB_Addon_Pricing_Table',
				'WPPB_Addon_Progress_Bar',
				'WPPB_Addon_Raw_Html',
				'WPPB_Addon_Social_Button',
				'WPPB_Addon_Soundcloud',
				'WPPB_Addon_Tab',
				'WPPB_Addon_Testimonial',
				'WPPB_Addon_Testimonial_Carousel',
				'WPPB_Addon_Text_Block',
				'WPPB_Addon_Video',
				'WPPB_Addon_Video_Popup',
			);
			return apply_filters('wppb_available_addons', $addons);
		}

		/**
		 * @return int
		 *
		 * Get the editor ID
		 */
		public function get_the_editor_post_id(){
			$id = 0;
			if ($this->is_editor_screen()){
				$id = get_the_ID();
			}

			return $id;
		}

		public function get_class_by_addon_name($addon_name = null){
			if ( ! $addon_name){
				return false;
			}

			$get_addon_classes = wppb_helper()->get_addon_classes();
			if ( ! empty($get_addon_classes) && count($get_addon_classes)){
				foreach ($get_addon_classes as $addon_class){
					if (class_exists($addon_class)){
						$class_instance = new $addon_class;
						if (method_exists($class_instance, 'get_name')){

							if ($addon_name === $class_instance->get_name()){
								return $class_instance;
							}

						}
					}
				}
			}
			return false;
		}

		public function plugin_action_links_callback( $links ){
			$actionsLinks =  array();
			if (!defined('WPPB_PRO_VERSION')) {
				$actionsLinks['wppb_go_premium'] = '<a href="https://www.themeum.com/product/wp-pagebuilder/?utm_source=wp_pagebuilder&amp;utm_medium=plugin_action_link&amp;utm_campaign=go_premium" target="_blank"><span style="color: #39a700eb; font-weight: bold;">'.__('Get Premium', 'wp-pagebuilder').'</span></a>';
			}
			$actionsLinks['wppb_settings'] = '<a href="' . admin_url( 'admin.php?page=wppb-settings' ) . '">'.__('Settings', 'wp-pagebuilder').'</a>';
			return array_merge( $actionsLinks, $links );
		}

		public function plugin_row_meta_callback( $links , $plugin ){
			if( WPPB_BASENAME === $plugin ){
			$actionsLinks =  array(
				'wppb_docs' =>  '<a href="https://docs.themeum.com/wp-pagebuilder/" target="_blank">'.__('Docs', 'wp-pagebuilder').'</a>',
				'wppb_dev_docs' =>  '<a href="https://github.com/themeum/WP-Page-Builder" target="_blank">'.__('Dev Docs', 'wp-pagebuilder').'</a>',
				'wppb_support' =>  '<a href="https://www.themeum.com/support/" target="_blank">'.__('Free Support', 'wp-pagebuilder').'</a>',
			);
				$links = array_merge( $links, $actionsLinks );
			}
			return $links;
		}

	}
}


/**
 * @param null $option
 *
 * @return null
 *
 * get wppb option from this helper
 */
if ( ! function_exists('wppb_get_option')){
	function wppb_get_option($option = null){
		$wppb_options = get_option('wppb_options');
		$value = null;
		if ( $wppb_options ){
			if ( ! empty($wppb_options[$option])){
				$value = $wppb_options[$option];
			}
		}

		return $value;
	}
}

if ( ! function_exists('get_wppb_array_value_by_key')){
	function get_wppb_array_value_by_key($array = array(), $key = null){
		$value = null;

		if ( key_exists($key, $array)){
			$value = $array[$key];
		}
		return $value;
	}
}

/**
 * @return array
 *
 * Return all image sizes
 */
if ( ! function_exists('wppb_get_all_image_sizes')){
	function wppb_get_all_image_sizes() {
		global $_wp_additional_image_sizes;

		$image_sizes = array();
		$default_image_sizes = get_intermediate_image_sizes();

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
			$image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
			$image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
		}

		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		return $image_sizes;
	}
}

/**
 * @return array
 *
 * Return ready made options for image sizes
 */
if ( ! function_exists('wppb_getLall_image_sizes_option')){
	function wppb_getLall_image_sizes_option(){
		$sizes = wppb_get_all_image_sizes();

		$sizes_option = array();
		foreach ($sizes as $key => $size){
			$sizes_option[$key] = ucwords(str_replace(array('_', '-'), ' ', $key))." - ({$size['width']} x {$size['height']}) ";
		}
		return $sizes_option;
	}
}

/**
 * @return array
 */
if ( ! function_exists('wppb_get_category_lists')){
	function wppb_get_category_lists(){
		$cat = array();
		$categories = get_categories();

		foreach ($categories as $category){
			$cat[$category->cat_ID] = $category->cat_name;
		}

		return $cat;
	}
}

if ( ! function_exists('wppb_get_tags_lists')){
	function wppb_get_tags_lists(){
		$tagArr = array();
		$tags = get_tags();

		foreach ($tags as $tag){
			$tagArr[$tag->term_id] = $tag->name;
		}

		return $tagArr;
	}
}

if ( ! function_exists('wppb_get_saved_addon_settings')) {
	function wppb_get_saved_addon_settings( $addon_id = 0, $page_id = 0 ) {
		if ( ! $addon_id || ! $page_id ) {
			return false;
		}

		$addon_id = (int) $addon_id;

		$page_builder_content = get_post_meta( $page_id, '_wppb_content', true );
		$settings             = json_decode( $page_builder_content, true );

		foreach ( $settings as $setting ) {
			$columns_count = 0;
			if ( isset( $setting['columns'] ) ) {
				$columns_count = count( $setting['columns'] );
			}

			if ( $columns_count ) {
				foreach ( $setting['columns'] as $col ) {
					$addons_count = 0;
					if ( isset( $col['addons'] ) ) {
						$addons_count = count( $col['addons'] );
					}

					if ( $addons_count ) {
						foreach ( $col['addons'] as $addon ) {

							$addon_type = '';
							if ( ! empty( $addon['type'] ) ) {
								$addon_type = $addon['type'];
							}

							if ( $addon_type === 'inner_row' ) {

							} else {
								if ( $addon_type === 'addon' ) {
									$saved_addon_id = (int) isset( $addon ) ? $addon['id'] : 0;
									if ( $addon_id === $saved_addon_id ) {
										return $addon;
									}
								}
							}
						}
					}
				}
			}
		}
	}
}

if ( ! function_exists('wppb_get_saved_addons_by_name')){

	function wppb_get_saved_addons_by_name($addon_name = false, $page_id = 0){
		if ( ! $addon_name || ! $page_id){
			return false;
		}

		$page_builder_content = get_post_meta($page_id, '_wppb_content', true);
		$settings = json_decode($page_builder_content, true);

		$addons = array();
		if( is_array( $settings ) ){
			foreach ( $settings as $setting ){
				$columns_count = 0;
				if ( isset($setting['columns'])){
					$columns_count = count($setting['columns']);
				}

				if ($columns_count){
					foreach ($setting['columns'] as $col){
						$addons_count = 0;
						if ( isset($col['addons'])){
							$addons_count = count($col['addons']);
						}

						if ($addons_count) {
							foreach ( $col['addons'] as $addon ) {

								$addon_type = '';
								if ( ! empty($addon['type'])){
									$addon_type = $addon['type'];
								}

								if ($addon_type === 'inner_row'){

								}else{
									if ( $addon_type === 'addon' ) {
										$addon_name = isset($addon) ? $addon['name'] : '';
										if ($addon_name === $addon_name){
											$addons[] = $addon;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return $addons;
	}
}