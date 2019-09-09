<?php

class WPPB{
	public static $instance = null;

	public $wppb_general;
	public $wppb_widget;
	public $wppb_editor;
	public $wppb_assets;
	public $wppb_options;
	public $wppb_ajax;
	public $wppb_frontend;
	public $wppb_theme_manager;
	public $compatibility;

	/**
	 * WPPB constructor
	 */
	public function __construct() {
		$this->register_autoloader();
		add_action( 'init', array($this, 'init'), 0 );
		add_action('init', array($this, 'load_addons_and_initialize'), 11);
	}

	public function init(){
		$this->init_components();
	}

	/**
	 * @return null|WPPB
	 *
	 * instance of WPPB Class
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			do_action( 'wppb_loaded' );
		}

		return self::$instance;
	}

	/**
	 * Auto load class
	 */
	private function register_autoloader() {
		require WPPB_DIR_PATH . '/inc/class-wppb-autoloader.php';
		\WPPB\Wppb_autoloader::run();
	}

	/**
	 * Init all components
	 *
	 * @since v.1.0.0
	 */
	private function init_components(){
		$this->wppb_frontend		= new WPPB_Frontend();
		$this->wppb_widget			= new WPPB_Widget();
		$this->wppb_editor			= new WPPB_Editor_Management();
		$this->wppb_assets			= new WPPB_Assets();
		$this->wppb_general			= new WPPB_General();
		$this->wppb_options			= new WPPB_Options();
		$this->wppb_ajax			= new WPPB_Ajax();
		$this->wppb_theme_manager 	= new WPPB_Theme_Manager();
		$this->compatibility 		= new Compatibility();
	}

	/**
	 * Get all addons and Initialize them
	 */
	function load_addons_and_initialize(){
		$addons = wppb_helper()->get_addon_classes();
		$initializeAddonClasses = array();
		do_action('before_wppb_addon_initialize');
		foreach ($addons as $addon){
			if (class_exists($addon)){
				do_action('before_wppb_addon_initializing_'.$addon);
				$initializeAddonClasses[$addon] = new $addon;
				do_action('after_wppb_addon_initializing_'.$addon);
			}
		}
		do_action('after_wppb_addon_initialize');
		apply_filters('wppb_initialize_addons', $initializeAddonClasses);
	}
}



if (! function_exists('wppb_init')){
	function wppb_init(){
		WPPB::instance();
	}
}
wppb_init();


if ( ! function_exists('wppb_helper')){
	function wppb_helper(){
		return new WPPB_Helper();
	}
}

/**
 * @param null $addon_name
 *
 * @return null
 */
if ( ! function_exists('addon_instance')){
	function addon_instance($addon_name = null){
		list($instance, $addon_instance) = null;

		$available_addons = wppb_helper()->get_addon_classes();
		if( !empty($available_addons) ) {
			foreach ( $available_addons as $class ) {
				if ( ! class_exists($class)){
					continue;
				}
				$instance = new $class;
				if ($instance->get_name() === $addon_name){
					$addon_instance = $instance;
				}
			}
		}
		return $addon_instance;
	}
}
