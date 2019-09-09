<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Layout_Generator')){
	class WPPB_Layout_Generator{
		public function generate($settings = array()){
			ob_start();
			if( !empty( $settings ) ){
				$this->generate_layout($settings);
			}
			return ob_get_clean();
		}

		public function row_stretch_class($setting = array(), $affected_row = 'row-parent'){
			$row_dynamic_class = " wppb-row-{$setting['id']} ";
			if ($affected_row === 'row-parent'){
			    if (isset($setting['settings']['row_screen']) && ( $setting['settings']['row_screen'] === 'row-stretch'
                                                                 || $setting['settings']['row_screen'] === 'row-container-stretch'
                                                                 || $setting['settings']['row_screen'] === 'container-stretch-no-gutter' ) ){
			        return $row_dynamic_class;
			    }
            }elseif ($affected_row === 'container'){
			    if ( ! isset($setting['settings']['row_screen']) || $setting['settings']['row_screen'] === 'row-default'){
			        return $row_dynamic_class. ' wppb-container-row-default';
                }
            }
            return '';
        }

		public function generate_layout($settings = array()){

			foreach ( $settings as $setting ){
				if ( ! $setting['visibility'] ) continue;

				$animation_attr = '';
				$animation_class = '';
				if ( ! empty($setting['settings']['row_animation'])){
					// Animation On
					$animation_settings = (object) $setting['settings']['row_animation'];
					if ( ! empty($animation_settings->itemOpen) && $animation_settings->itemOpen){
						$animation_class = " wppb-wow {$animation_settings->name} ";
						$animation_attr = " data-wow-duration='{$animation_settings->duration}ms' data-wow-delay='{$animation_settings->delay}ms' ";
					}
				}

				$full_container_stretch = array();
				if ( ! empty($setting['settings']['row_screen']) ){
					if( $setting['settings']['row_screen']=== 'row-container-stretch' ){
						$full_container_stretch[] = 'wppb-container-full';
					}else if( $setting['settings']['row_screen']=== 'container-stretch-no-gutter' ){
						array_push( $full_container_stretch, 'wppb-container-full', 'wppb-contaner-no-gutter' );
					}
                }

				$parent_row_class = $this->row_stretch_class($setting);
				$row_container_class = $this->row_stretch_class($setting, 'container');

				$row_css_id = isset($setting['settings']['row_id']) ? 'id="'.$setting['settings']['row_id'].'"' : '';
				$row_css_class = isset($setting['settings']['row_class']) ? $setting['settings']['row_class']: '';
				?>
                <div <?php echo $row_css_id; ?> class="wppb-row-parent <?php echo $parent_row_class.$animation_class.$row_css_class; ?>" <?php echo $animation_attr; ?> >
					
					<?php if( !empty($setting['settings']['row_shape'])  && $setting['settings']['row_shape']['itemOpenShape'] == 1 && $setting['settings']['row_screen'] != 'row-default' ){ ?>
                        <div class="wppb-shape-container wppb-top-shape">
							<?php echo file_get_contents( WPPB_DIR_URL.'assets/shapes/'.$setting['settings']['row_shape']['shapeStyle'].'.svg' ); ?>
						</div>
					<?php } ?>
					<?php if( !empty($setting['settings']['row_shape_bottom'])  && $setting['settings']['row_shape_bottom']['itemOpenShape'] == 1 && $setting['settings']['row_screen'] != 'row-default' ){ ?>
                        <div class="wppb-shape-container wppb-bottom-shape">
							<?php echo file_get_contents( WPPB_DIR_URL.'assets/shapes/'.$setting['settings']['row_shape_bottom']['shapeStyle'].'.svg' ); ?>
						</div>
					<?php } ?>

					<?php 
						if( isset( $setting['settings']['row_background'] ) ){
							if( isset( $setting['settings']['row_background']['bgVideo']['url'] ) || isset( $setting['settings']['row_background']['bgExternalVideo'] ) ){
								echo $this->bg_video( $setting['settings']['row_background'] );
							}
						}
					?>
					
					<div class="wppb-container <?php echo $row_container_class.implode( ' ', $full_container_stretch ); ?>">
						<?php if( !empty($setting['settings']['row_shape'])  && $setting['settings']['row_shape']['itemOpenShape'] == 1 && $setting['settings']['row_screen'] == 'row-default' ){ ?>
							<div class="wppb-shape-container wppb-top-shape">
								<?php echo file_get_contents( WPPB_DIR_URL.'assets/shapes/'.$setting['settings']['row_shape']['shapeStyle'].'.svg' ); ?>
							</div>
						<?php } ?>
						<?php if( !empty($setting['settings']['row_shape_bottom'])  && $setting['settings']['row_shape_bottom']['itemOpenShape'] == 1 && $setting['settings']['row_screen'] == 'row-default' ){ ?>
							<div class="wppb-shape-container wppb-bottom-shape">
								<?php echo file_get_contents( WPPB_DIR_URL.'assets/shapes/'.$setting['settings']['row_shape_bottom']['shapeStyle'].'.svg' ); ?>
							</div>
						<?php } ?>
	
                        <div class="wppb-row">
							<?php
							if( ! empty($setting['columns']) ){
								foreach ($setting['columns'] as $col){
									if ( ! $col['visibility']){
										continue;
									}

									$col_css_class = '';
									$col_css_id = '';
									if (isset($col['settings']['col_id'])){
										$col_css_id = $col['settings']['col_id'];
                                    }
									if (isset($col['settings']['col_class'])){
										$col_css_class = $col['settings']['col_class'];
									}

									$col_animation_class = '';
									$col_animation_data = '';

									if ( isset($col['settings']['col_animation']['itemOpen'])){
                                        $enable_col_animation = (int) $col['settings']['col_animation']['itemOpen'];
                                        $col_animation = $col['settings']['col_animation'];

										if ($enable_col_animation) {
											$col_animation_class 	= isset( $col_animation['name'] ) ? 'wppb-wow ' . $col_animation['name'] : '';
											$delay    				= isset( $col_animation['delay'] ) ? $col_animation['delay'] : '';
											$duration 				= isset( $col_animation['duration'] ) ? $col_animation['duration'] : '';
											$col_animation_data 	= " data-wow-delay='{$delay}ms'  data-wow-duration='{$duration}ms' ";
                                        }
                                    }
									?>
                                    <div <?php if ($col_css_id) echo 'id="'.$col_css_id.'"'; ?> class="wppb-column-parent wppb-column-parent-view wppb-col-<?php echo $col['id']; ?> <?php echo $col_css_class; ?> <?php echo $col_animation_class; ?>" <?php echo $col_animation_data;?> >
                                        <div class="wppb-column">
					
											<?php 
												if( isset( $col['settings']['col_background'] ) ){
													if( isset( $col['settings']['col_background']['bgVideo']['url'] ) || isset( $col['settings']['col_background']['bgExternalVideo'] ) ){
														echo $this->bg_video( $col['settings']['col_background'] );
													}
												}
											?>

                                            <div class="wppb-builder-addons">
												<?php
												$addons_count = 0;
												if ( ! empty($col['addons'])){
													$addons_count = count($col['addons']);
												}

												if ($addons_count){
													foreach ($col['addons'] as $addon){
														$addon_type = '';
														if ( ! empty($addon['type'])){
															$addon_type = $addon['type'];
														}

														if ($addon_type === 'inner_row'){
															$this->generate_inner_section($addon);
														}else{
															if ( isset($addon['visibility']) && $addon['visibility'] == true ) {
															    $addon_animation_class = '';
															    $addon_animation_data = "";
															    if (isset($addon['settings']['addon_animation'])){
                                                                    $is_enable_animation = 0;
                                                                    if (isset($addon['settings']['addon_animation']['itemOpen'])){
                                                                        $is_enable_animation = (int) $addon['settings']['addon_animation']['itemOpen'];
                                                                    }

                                                                    if ($is_enable_animation) {
	                                                                    $addon_animation_class 	= isset( $addon['settings']['addon_animation']['name'] ) ? ' wppb-wow ' . $addon['settings']['addon_animation']['name'] : '';
	                                                                    $delay    				= isset( $addon['settings']['addon_animation']['delay'] ) ? $addon['settings']['addon_animation']['delay'] : '';
	                                                                    $duration 				= isset( $addon['settings']['addon_animation']['duration'] ) ? $addon['settings']['addon_animation']['duration'] : '';
	                                                                    $addon_animation_data 	= " data-wow-delay='{$delay}ms'  data-wow-duration='{$duration}ms' ";
                                                                    }
                                                                }

																//Get id
																$addon_id = '';
															    $addon_class_for_widget = '';
																if ( $addon_type === 'addon' ) {
																	$addon_id = ! empty( $addon['id'] ) ? $addon['id'] : '';
																} elseif ( $addon_type === 'widget' ) {
																	$addon_id = ! empty( $addon['settings']['wppb_widget_id'] ) ? $addon['settings']['wppb_widget_id'] : '';
																	$addon_class_for_widget = " wppb-addon-{$addon_id}";
																}

																$base_name_id = '';
																if ( ! empty( $addon['settings']['wppb_widget_id_base'] ) ) {
																	$base_name_id = $addon['settings']['wppb_widget_id_base'];
																} elseif ( ! empty( $addon['name'] ) ) {
																	$base_name_id = $addon['name'];
																}

																$addon_css_class = isset($addon['settings']['addon_class']) ? ' '.$addon['settings']['addon_class'] : '';
																$addon_css_id = isset($addon['settings']['addon_id']) ? ' id="'.$addon['settings']['addon_id'].'"' : '';

																echo "<div{$addon_css_id} class='wppb-builder-addon wppb-{$addon_type}-{$addon_id}{$addon_class_for_widget}{$addon_animation_class}{$addon_css_class}' {$addon_animation_data} data-addon-id='{$addon_id}'>";

                                                                echo "<div class='wppb-{$addon_type}'>";

																if ( $addon_type === 'addon' ) {
																	$addon_instantce = addon_instance( $addon['name'] );
																	if ( method_exists( $addon_instantce, 'render' ) ) {
																		echo $addon_instantce->render( $addon );
																	}
																} elseif ( $addon_type === 'widget' ) {
																	if ( ! empty( $addon['settings'] ) ) {
																		$widget_instance = WPPB::$instance->wppb_widget;
																		echo $widget_instance->render( $addon['settings'] );
																	}
																}
																echo "</div>";
																echo '</div>';
															}
														}
													}
												}
												?>
                                            </div>
                                        </div>
                                    </div>
									<?php
								} //foreach column
							} //if ($columns_count)
							?>
                        </div>

                    </div>
                </div>
				<?php
			} //foreach ( $settings as $setting )
		}

		public function generate_inner_section($setting = array()){
			if ( ! $setting['visibility']){
				return;
			}

			$columns_count = 0;
			if ( ! empty($setting['columns'])){
				$columns_count = count($setting['columns']);
			}

			$animation_attr = '';
			$animation_class = '';
			if ( ! empty($setting['settings']['row_animation'])){
				//Animation On
				$animation_settings = (object) $setting['settings']['row_animation'];
				if ( ! empty($animation_settings->itemOpen) && $animation_settings->itemOpen){
					$animation_class = ' wppb-wow wppb-animated '.$animation_settings->name;
					if( $animation_settings->duration ){ $animation_attr .= ' data-wow-duration="'.$animation_settings->duration.'ms"'; }
					if( $animation_settings->delay ){ $animation_attr .= ' data-wow-delay="'.$animation_settings->delay.'ms"'; }
				}
			}
			$row_css_id = isset($setting['settings']['row_id']) ? 'id="'.$setting['settings']['row_id'].'"' : '';
			$row_css_class = isset($setting['settings']['row_class']) ? $setting['settings']['row_class']: '';
			?>
            <div <?php echo $row_css_id; ?> class="wppb-row-parent wppb-inner-row-parent wppb-row-<?php echo $setting['id'].$animation_class; ?> <?php echo $row_css_class; ?>"<?php echo $animation_attr; ?>>
			
			<?php 
				if( isset( $setting['settings']['row_background'] ) ){
					if( isset( $setting['settings']['row_background']['bgVideo']['url'] ) || isset( $setting['settings']['row_background']['bgExternalVideo'] ) ){
						echo $this->bg_video( $setting['settings']['row_background'] );
					}
				}
			?>
			
				<div class="wppb-container">
                    <div class="wppb-row">
						<?php
						if ($columns_count){
							foreach ($setting['columns'] as $col){
								if ( ! $col['visibility']){
									continue;
								}

								$col_class = $col['class_name'];

								/**
								 * Get css ID and class from settings
								 */
								$col_css_class = '';
								$col_css_id = '';
								if (isset($col['settings']['col_id'])){
									$col_css_id = $col['settings']['col_id'];
								}
								if (isset($col['settings']['col_class'])){
									$col_css_class = $col['settings']['col_class'];
								}

								$col_animation_data = '';

								if ( ! empty($col['settings']['col_animation']['itemOpen'])){
									$enable_col_animation = (int) $col['settings']['col_animation']['itemOpen'];
									$col_animation = $col['settings']['col_animation'];

									if ($enable_col_animation) {
										$col_css_class .= isset( $col_animation['name'] ) ? ' wppb-wow wppb-animated ' . $col_animation['name'] : '';
										$col_animation_data .= isset( $col_animation['delay'] ) ? ' data-wow-delay='.$col_animation['delay'].'ms' : '';
										$col_animation_data .= isset( $col_animation['duration'] ) ? ' data-wow-duration='.$col_animation['duration'].'ms' : '';
									}
								}

								?>
                                <div <?php if ($col_css_id) echo 'id="'.$col_css_id.'"'; ?> class="wppb-column-parent wppb-column-parent-view wppb-col-<?php echo $col['id']; ?> <?php echo $col_css_class; ?> " <?php echo $col_animation_data; ?>>
                                    <div class="wppb-column">
                                        <div class="wppb-builder-addons">
											<?php
											$addons_count = 0;
											if ( ! empty($col['addons'])){
												$addons_count = count($col['addons']);
											}

											if ($addons_count){
												foreach ($col['addons'] as $addon){
													$addon_type = '';
													if ( ! empty($addon['type'])){
														$addon_type = $addon['type'];
													}
													

                                                    if ( isset($addon['visibility']) && $addon['visibility'] == true ) {

	                                                    $addon_animation_class = '';
	                                                    $addon_animation_data = "";
	                                                    if (isset($addon['settings']['addon_animation'])){
		                                                    $addon_animation_class = isset($addon['settings']['addon_animation']['name']) ? ' wppb-wow wppb-animated ' . $addon['settings']['addon_animation']['name'] : '';
		                                                    $delay = isset($addon['settings']['addon_animation']['delay']) ? $addon['settings']['addon_animation']['delay'] : '';
		                                                    $duration = isset($addon['settings']['addon_animation']['duration']) ? $addon['settings']['addon_animation']['duration'] : '';
		                                                    $addon_animation_data = " data-wow-delay='{$delay}ms'  data-wow-duration='{$duration}ms' ";
	                                                    }


	                                                    //Get id
	                                                    $addon_id = '';
	                                                    if ( $addon_type === 'widget' ) {
		                                                    $addon_id = ! empty( $addon['settings']['wppb_widget_id'] ) ? $addon['settings']['wppb_widget_id'] : '';
	                                                    } else {
		                                                    $addon_id = ! empty( $addon['id'] ) ? $addon['id'] : '';
	                                                    }

	                                                    $base_name_id = '';
	                                                    if ( ! empty( $addon['settings']['wppb_widget_id_base'] ) ) {
		                                                    $base_name_id = $addon['settings']['wppb_widget_id_base'];
	                                                    } elseif ( ! empty( $addon['name'] ) ) {
		                                                    $base_name_id = $addon['name'];
	                                                    }

	                                                    $addon_css_class = isset($addon['settings']['addon_class']) ? $addon['settings']['addon_class'] : '';
	                                                    $addon_css_id = isset($addon['settings']['addon_id']) ? 'id="'.$addon['settings']['addon_id'].'"' : '';


	                                                    echo "<div {$addon_css_id} class='wppb-builder-addon wppb-addon-{$addon_id} {$addon_css_class} {$addon_animation_class} ' {$addon_animation_data}  >";

	                                                    echo "<div class='wppb-{$addon_type}'>";

	                                                    if ( $addon_type === 'widget' ) {
		                                                    if ( ! empty( $addon['settings'] ) ) {
			                                                    $widget_instance = WPPB::$instance->wppb_widget;
			                                                    echo $widget_instance->render( $addon['settings'] );
		                                                    }
	                                                    } else {
		                                                    $addon_instantce = addon_instance( $addon['name'] );
		                                                    if ( method_exists( $addon_instantce, 'render' ) ) {
			                                                    echo $addon_instantce->render( $addon );
		                                                    }
	                                                    }
	                                                    echo "</div>";

	                                                    echo '</div>';
                                                    }

												}
											}
											?>
                                        </div>
                                    </div>
                                </div>
								<?php
							} //foreach column
						} //if ($columns_count)
						?>
                    </div>
                </div>
            </div>
			<?php
		}


		/**
		 * @param null $video_settings
		 *
		 * @return string
		 */
		public function bg_video( $video_settings = null ){
            if ( !isset( $video_settings['videoType'] ) ){ return ''; }
			if ( $video_settings['videoType'] === 'local'){
			    if ( ! isset($video_settings['bgVideo']['url'])){ return ''; }
				return '<div class="wppb-video-bg-wrap"><video class="wppb-video-bg" autoPlay muted loop><source src="'.$video_settings['bgVideo']['url'].'" /></video></div>';
			}elseif( $video_settings['videoType'] === 'external' && $video_settings['bgExternalVideo'] ){
				$videoData = wp_oembed_get( $video_settings['bgExternalVideo'] );
				if (strpos( $video_settings['bgExternalVideo'] , 'yout') !== false) {
					return '<div class="wppb-video-bg-wrap">'.str_replace( "?feature=oembed", "?feature=oembed&autoplay=1", $videoData ).'</div>';
				}
				if (strpos( $video_settings['bgExternalVideo'], 'vimeo') !== false) {
					return '<div class="wppb-video-bg-wrap">'.str_replace( "?", "?autoplay=1&loop=1&", $videoData ).'</div>';
				}
				return '<div class="wppb-video-bg-wrap">'.$videoData.'</div>';
			}
		}
	}
}