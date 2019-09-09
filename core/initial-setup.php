<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (! class_exists('WPPB_Initial_Setup')) {
    class WPPB_Initial_Setup{
        protected static $_instance = null;
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        // Dependency For 1.0.0-beta2 to Update+ 
        public static function wppb_legacy_data(){
            global $wpdb;
            $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = %s WHERE meta_key = %s", '_wppb_content', 'wppb_content' ) );
            $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = %s WHERE meta_key = %s", '_wppb_page_css', 'wppb_page_css' ) );
            $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = %s WHERE meta_key = %s", '_wppb_current_post_editor', 'wppb_current_post_editor' ) );
        }

        // Initialize Save Data
        public static function initialize_data(){
            
            // Update Legacy
            self::wppb_legacy_data();

            // Activating default post type
            if ( !get_option('wppb_is_used') ){ 
	            $wppb_options = (array) get_option('wppb_options');
	            $wppb_options['supported_post_type'] = array('post', 'page');
	            $wppb_options['css_save_as'] = 'wp_head';
	            update_option('wppb_options', $wppb_options);
	            update_option( 'wppb_is_used', WPPB_VERSION );
            }
            update_option( 'wppb_is_used', WPPB_VERSION );
        }

        // PHP Error Notice
        public static function php_error_notice(){
            $message = sprintf( esc_html__( 'WP Page Builder requires PHP version %s or more.', 'wp-pagebuilder' ), '5.4' );
            $html_message = sprintf( '<div class="notice notice-error is-dismissible">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html_message );
        }

        // Wordpress Error Notice
        public static function worpress_error_notice(){
            $message = sprintf( esc_html__( 'WP Page Builder requires WordPress version %s or more.', 'wp-pagebuilder'
            ), '4.7' );
            $html_message = sprintf( '<div class="notice notice-error is-dismissible">%s</div>', wpautop( $message ) );
            echo wp_kses_post( $html_message );
        }

    }
}