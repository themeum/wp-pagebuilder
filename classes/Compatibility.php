<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Compatibility {

    protected $is_current_editor_gutenberg = false;

	public function __construct() {
		$this->wp_importer_esacpe(); // WordPress Default Importer JSON slash issue
		add_action( 'admin_print_scripts-edit.php', array( $this, 'wppb_add_btn_to_gutenburg_dropdown'), 20 ); // Gutenburg
		add_action( 'init', array( $this, 'add_image_size'), 30 );  // Image Size Add for Post Addons

		add_action( 'updated_post_meta', array( $this, 'thirdparty_pagebuilder_comparability_check' ) , 12, 4 );

		if( defined('GIVE_VERSION') ){
			add_action( 'wppb_enqueue_scripts_in_editor', array( $this, 'wppb_give_compatibility' ) ); // Give Plugins Compatibility
		}


		/**
         * Gutenberg
         */

        if (is_admin()){
	        add_action('admin_body_class', array($this, 'add_extra_body_class'));
	        add_action( 'enqueue_block_editor_assets', array($this, 'add_required_assets') );
	        add_action( 'admin_footer', array($this, 'add_required_template_to_guttenberg_editor') );
        }
	}

	/**
	 * @since 1.0.2
	 * Give Plugins Compatibility Callback
	 */
	public function wppb_give_compatibility(){
		wp_deregister_script( 'give' );
	}

	/**
	 * Thirdparty Page builder Comparability Check
	 * @since v 1.0.0
	 */
	function thirdparty_pagebuilder_comparability_check( $meta_id, $post_id, $meta_key, $meta_value ){
		if( $meta_key == '_wppb_content' ){
			update_post_meta( $post_id , '_wppb_current_post_editor', 'wppb_builder_activated' );
		}else{
			if( ($meta_key == '_elementor_data') || // Elementor
			    ($meta_key == '_themify_builder_settings_json') || // Themify
			    ($meta_key == '_et_pb_use_builder' &&  $meta_value == 'on' ) || // Divi
			    ($meta_key == '_wpb_vc_js_status' &&  $meta_value == 'true' ) || // Visual Composer
			    ($meta_key == 'panels_data') // SiteOrigin
			){
				delete_post_meta( $post_id, '_wppb_current_post_editor' );
			}
		}
	}



	/**
	 * @since 1.0.1
	 * gutenburg Dropdown Menu Add
	 */
	public function wp_importer_esacpe(){
		if( /* defined('WP_LOAD_IMPORTERS') && */ is_admin() ){
			add_filter( 'wp_import_post_meta', array( $this, 'import_post_meta_esacpe' ) );
		}
	}
	public function import_post_meta_esacpe( $post_meta ){
		foreach ( $post_meta as &$meta ) {
			if ( '_wppb_content' === $meta['key'] ) {
				$meta['value'] = wp_slash( $meta['value'] );
				break;
			}
		}
		return $post_meta;
	}

	/**
	 * @since 1.0.0
	 * gutenburg Dropdown Menu Add
	 */
	public function wppb_add_btn_to_gutenburg_dropdown(){
		global $typenow;
		$wppb_page_url = wppb_helper()->get_editor_url();
		$wppb_page_url = add_query_arg( array('post_type' => $typenow), $wppb_page_url);
		$supported_post_types    = wppb_helper()->wppb_supports_post_types();
		if (! in_array($typenow, $supported_post_types)){
			return;
		}
		?>
        <script type="text/javascript">
            document.addEventListener( 'DOMContentLoaded', function() {
                var dropdown = document.querySelector( '#split-page-title-action .dropdown' );
                if ( ! dropdown ) {
                    return;
                }
                var url = '<?php echo $wppb_page_url; ?>';
                dropdown.insertAdjacentHTML( 'afterbegin', '<a href="' + url + '">WP Pagebuilder</a>' );
            } );
        </script>
		<?php
	}

	/**
	 * @since 1.0.0
	 * Add Image Size for Posts Addons
	 */
	public function add_image_size() {
		add_image_size( 'wppb-medium', 600, 450, true );
	}

	public function add_extra_body_class($classes){
		global $pagenow;

		if ($pagenow == 'post.php') {
			$current_editor = get_post_meta(get_the_ID(), '_wppb_current_post_editor', true);

		    if ($current_editor){
			    $classes .= " currently-activated-editor-{$current_editor} ";
		    }
		}
		return $classes;
	}

	public function add_required_assets(){
	    $this->is_current_editor_gutenberg = true;
    }

	public function add_required_template_to_guttenberg_editor() {
		if ( ! $this->is_current_editor_gutenberg )
		    return;
		?>
        <script id="wp-pagebuilder-to-gutenberg-switch-mode" type="text/html">
            <div id="wp-pagebuilder-switch-to-gutenberg">
                <a href="<?php echo admin_url('post.php?post='.get_the_ID().'&action=wppb_editor') ?>" id="wp-pagebuilder-switch-to-gutenberg-btn" class="wppb-backend-btn wppb-primary-btn edit-with-wppb-builder">
	                <?php echo __( 'Edit with WP Page Builder', 'wp-pagebuilder' ); ?>
                </a>
            </div>
        </script>
		<?php
	}


}