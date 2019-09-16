<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Options')){

	class WPPB_Options{
		// Constructor
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}

		/**
		 * Add Menu Page Callback
		 *
		 * @since 1.0.0
		 */
		public function add_admin_menu() {
			add_menu_page(
				esc_html__( 'WP Page Builder', 'wp-pagebuilder' ),
				esc_html__( 'WP Page Builder', 'wp-pagebuilder' ),
				'manage_options',
				'wppb-settings',
				array( $this, 'create_admin_page' ),
				plugins_url( 'wp-pagebuilder/assets/img/tinny-logo.png' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * @since 1.0.0
		 */
		public function register_settings() {
			register_setting( 'wppb_options', 'wppb_options', array( $this, 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {
			if ( $options ) {
				if ( ! empty( $options['css_save_as'] ) ) {
					$options['css_save_as'] = sanitize_text_field( $options['css_save_as'] );
				}
				if ( ! empty( $options['supported_post_type'] ) ) {
					$options['supported_post_type'] = $options['supported_post_type'];
				}
			}
			return $options;
		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>
            <div class="wrap">
                <h1><?php esc_html_e( 'WP Page Builder Options', 'wp-pagebuilder' ); ?></h1>

                <form method="post" action="options.php">
					<?php
					settings_fields( 'wppb_options' );
					$option_data    = get_option( 'wppb_options' );
					$post_types     = get_post_types( [ 'public' => true ], 'objects' );
					if( isset($post_types['attachment']) ){ unset( $post_types['attachment'] ); }

					$user_roles = get_editable_roles();
					?>

                    <table class="form-table wpex-custom-admin-login-table">

                        <tr>
                            <th scope="row"><?php esc_html_e( 'Post Type', 'wp-pagebuilder' ); ?></th>
                            <td>
								<?php
								$value = wppb_get_option('supported_post_type');
								if( $post_types ){
									foreach( $post_types as $post_type ){ ?>
                                        <label>
                                            <input type="checkbox" name="wppb_options[supported_post_type][]" value="<?php echo $post_type->name; ?>" <?php if( $value ){ if(in_array( $post_type->name, $value )){ echo 'checked'; } } ?> >
                                            <?php echo $post_type->label; ?><br>
                                        </label>
									<?php }
								}
								?>

                                <p class="description"> <?php _e('Select post types that can be edited with WP Page Builder.', 'wp-pagebuilder'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php esc_html_e( 'Exclude User Role', 'wp-pagebuilder' ); ?></th>
                            <td>
								<?php
								$value = wppb_get_option('exclude_role');
								if( $user_roles ){
									foreach( $user_roles as $user_slug => $single_role ){ ?>
                                        <label><input type="checkbox" name="wppb_options[exclude_role][]" value="<?php echo $user_slug; ?>" <?php if( $value ){ if(in_array( $user_slug, $value )){ echo 'checked'; } } ?> > <?php echo $single_role['name']; ?><br></label>
									<?php }
								}
								?>

                                <p class="description"> <?php _e('Exclude the user roles that you want to prevent from editing this site with WP Page Builder.', 'wp-pagebuilder'); ?></p>

                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php _e('Content Width', 'wp-pagebuilder'); ?></th>
                            <td>
                                <input type="text" class="regular-text" id="wppb_container_width" name="wppb_options[wppb_container_width]" value="<?php echo wppb_get_option('wppb_container_width'); ?>" placeholder="1140"> px
                                <p class="description"> <?php _e('Default Content Width is 1140 px. You can set any width.','wp-pagebuilder'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php _e('Gutter', 'wp-pagebuilder'); ?></th>
                            <td>
                                <input type="text" class="regular-text" id="wppb_col_spacing" name="wppb_options[wppb_col_spacing]" value="<?php echo wppb_get_option('wppb_col_spacing'); ?>" placeholder="30"> px
                                <p class="description"> <?php _e('Default Spacing is 30 px. You can set any spacing.','wp-pagebuilder'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php esc_html_e( 'CSS Save Method', 'wp-pagebuilder' ); ?></th>
                            <td>
								<?php $value = $option_data['css_save_as']; ?>
                                <select name="wppb_options[css_save_as]">
									<?php
									$options = array(
										'filesystem' => __( 'File System','wp-pagebuilder' ),
										'wp_head'   => __( 'Header','wp-pagebuilder' ),
									);
									foreach ( $options as $id => $label ) { ?>
                                        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
											<?php echo strip_tags( $label ); ?>
                                        </option>
									<?php } ?>
                                </select>
                                <p class="description"> <?php _e('Select where you want to save the CSS.', 'wp-pagebuilder'); ?></p>
                            </td>
						</tr>

                        <tr>
                            <th scope="row"><?php esc_html_e( 'Cache', 'wp-pagebuilder' ); ?></th>
                            <td>
                                <label>
                                    <button type="button" id="wppb_clear_cache_btn" class="button"><?php _e('Clean Cache and Sync','wp-pagebuilder'); ?></button>
                                    <p class="response-text"></p>
									<p class="description"> <?php _e('Clean WP Page Builder cache & synchronize built-in layouts & blocks with server.', 'wp-pagebuilder'); ?></p>
                                </label>
                            </td>
                        </tr>


                    </table>
					<?php submit_button(); ?>
                </form>
            </div>
		<?php }
	}


}