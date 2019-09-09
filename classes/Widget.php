<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Widget')){
	class WPPB_Widget {
		public static function init(){
			$return = new self();
			return $return;
		}

		/**
		 * @since 1.0.0-BETA
         * @return Widget ID
		*/
		public function get_id($settings  = array()){
		    $default_data = $this->get_default_data();
		    $widget_id = null;
		    if ( ! empty($_POST['id'])){
		        $widget_id = sanitize_text_field($_POST['id']);
            }elseif (! empty($_POST['widget']['id'])){
		        $widget_id = sanitize_text_field($_POST['widget']['id']);
            }elseif( ! empty($_POST['widget']['settings']['wppb_widget_id']) ) {
			    $widget_id = sanitize_text_field( $_POST['widget']['settings']['wppb_widget_id'] );
		    }elseif( ! empty($settings['wppb_widget_id'])){
			    $widget_id = $settings['wppb_widget_id'];
            }else{
			    $widget_id = $default_data['id'];
		    }
		    return $widget_id;
        }

		/**
		 * @since 1.0.0-BETA
         * @return Widget Base ID
		 */
        private function get_widget_id_base($settings = array()){
		    $widget_id_base = null;
		    if ( ! empty($_POST['widget_id_base'])){
                $widget_id_base = sanitize_text_field($_POST['widget_id_base']);
            }elseif( ! empty($_POST['widget']['settings']['wppb_widget_id_base'] )){
                $widget_id_base = sanitize_text_field($_POST['widget']['settings']['wppb_widget_id_base']);
            }
            if (is_null($widget_id_base)){
            	if ( ! empty($settings['wppb_widget_id_base'])){
		            $widget_id_base = $settings['wppb_widget_id_base'];
	            }
            }
            return $widget_id_base;
        }
		protected function get_default_data() {
			return array(
				'id'    => time(),
				'settings' => array(),
			);
		}

		/**
		 * @since 1.0.0-BETA
		 * @return Widget Instance
		*/
		public function get_widget_instance($settings = array()) {
			global $wp_widget_factory;
			$widget_instance = null;
			$_widget_class_name = null;
			if (is_null($widget_instance)){
			    $widget_id_base = $this->get_widget_id_base($settings);
			    $available_widgets = $wp_widget_factory->widgets;
			    foreach ($available_widgets as $class_name => $widget_options){
			        if ($widget_id_base=== $widget_options->id_base){
			            $_widget_class_name = $class_name;
			            break;
                    }
                }
				// Creating Instance
				if ( isset( $wp_widget_factory->widgets[ $_widget_class_name ] ) ) {
					$widget_instance = $wp_widget_factory->widgets[ $_widget_class_name ];
					$widget_instance->_set( esc_attr( $this->get_id($settings) ) );
				} elseif ( class_exists( $_widget_class_name ) ) {
					$widget_instance = new $_widget_class_name();
					$widget_instance->_set( esc_attr( $this->get_id($settings) ) );
				}
			}
            return $widget_instance;
		}

		/**
		 * @since 1.0.0-BETA
		 * @return Widget Render HTML Output
		 */
		public function render($widget_settings = array() ) {
			try{
				$widget_id = $this->get_widget_instance($widget_settings);
				if ( ! empty( $widget_id )){
					$empty_widget_args = [
						'id'            => '',
						'widget_id'     => $widget_id->id_base,
						'before_widget' => '',
						'after_widget'  => '',
						'before_title'  => '<h5>',
						'after_title'   => '</h5>',
					];
					ob_start();
					$this->get_widget_instance($widget_settings)->widget( $empty_widget_args, $widget_settings );
					return ob_get_clean();
				}
			}catch (\Exception $e){
				// Exception
			}
		}

		/**
		 * @since 1.0.0-BETA
		 * @return Widget HTML Template
		*/
		public function get_form($settings = array()) {
			$instance = $this->get_widget_instance();
			ob_start();
			echo '<div class="widget-inner widget-inside media-widget-control">';
				echo '<div class="form wp-core-ui wppb-form-widget">';
					echo '<input type="hidden" class="id_base" name="id_base" value="' . esc_attr( $instance->id_base ) . '" />';
					echo '<input type="hidden" class="widget-id" name="widget-id" value="widget-' . esc_attr( $this->get_id()) . '" />';
					echo '<input type="hidden" name="widget_input_base_name" class="widget-id" value="widget-' . esc_attr( $instance->id_base ) . '['.esc_attr( $this->get_id() ).']" />';
					echo '<div class="widget-content">';
						$instance->form( $settings );
					echo '</div>';
				echo '</div>';
			echo '</div>';
			return ob_get_clean();
		}
	}
}

