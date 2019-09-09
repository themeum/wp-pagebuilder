<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPPB_Base_Data' ) ) {
	class WPPB_Base_Data {
		// Addons List & Category return
		public function addons_data(){
			$default_addon = array(
				'wppb_accordion', 'wppb_alert', 'wppb_animated_number', 'wppb_block_number', 'wppb_button', 'wppb_button_group',
				'wppb_form', 'wppb_feature_box', 'wppb_flip_box', 'wppb_heading', 'wppb_icon', 'wppb_image',
				'wppb_image_hover', 'wppb_person', 'wppb_person_carousel', 'wppb_pie_progress', 'wppb_posts_grid', 'wppb_pricing_table',
				'wppb_progress_bar', 'wppb_raw_html', 'wppb_social_button', 'wppb_soundcloud', 'wppb_tab', 'wppb_testimonial',
				'wppb_testimonial_carousel', 'wppb_text_block', 'wppb_video', 'wppb_video_popup','wppb_carousel'
			);

			$available_addons = wppb_helper()->get_addon_classes();

			$addons_list = array();
			if( !empty($available_addons) ){
				foreach ($available_addons as $addon) {

					if ( ! class_exists($addon)){
						trigger_error(" Uncaught Error: Class ‘{$addon}’ not found, you are trying to add an addon class to filter name 'wppb_available_addons' which does not exist in your system");
						continue;
					}

					$data = new $addon();
					$addon_name = $data->get_name();
					$addon_settings = $data->get_settings();
					$addon_icons = ( method_exists( $data , 'get_icon' ) ?  $data->get_icon() : 'wppb-font-wordpress' );
					$addons_list[$addon_name] = array(
						"type" 		=> "content",
						"addon_name"=> $addon_name,
						"title" 	=> $data->get_title(),
						"name" 		=> $data->get_name(),
						"category"  => ( method_exists( $data , 'get_category_name' ) ? $data->get_category_name() : '' ),
						"visibility"=> true,
						"icon"		=> $addon_icons,
						"attr"		=> array( 'general' => $addon_settings ),
						"defaultAddon" => ( in_array( $data->get_name(), $default_addon ) ? true : false )
					);

					if( method_exists($addon, 'getTemplate') ){
						$addons_list[$addon_name]['js_template'] = true;
					} else {
						$addons_list[$addon_name]['js_template'] = false;
					}
				}
			}
			return array( 'addons' => $addons_list );
		}


		public function getSvgShapes() {
			$shape_path = WPPB_DIR_PATH .'assets/shapes';
			$shapes = glob( $shape_path . '/*.svg' );
			$shapeArray = array();
			if( count( $shapes ) ){
				foreach($shapes as $shape){
					$shapeArray[str_replace( array( '.svg',$shape_path.'/' ), '', $shape)] = base64_encode(file_get_contents( $shape ));
				}
			}
			return $shapeArray;
		}

		public function global_attr(){
			$global_attribute = array(
				'style' => array(
					'initialize_empty'=> array(
						'type' => 'firstid',
						'title' => 'ID',
						'desc' => 'Place your ID in this section',
						'std' => '0',
					),
				),
				'advanced' => array(
					'addon_id' => array(
						'type' => 'text',
						'title' => 'ID',
						'desc' => 'Place your ID in this section',
						'std' => '',
					),
					'addon_class' => array(
						'type' => 'text',
						'title' => 'Class',
					),
					'addon_z_index' => array(
						'type' => 'slider',
						'title' => 'z-index',
						'range' => array(
							'min' => -10000,
							'max' => 10000,
							'step' => 1,
						),
						'selector' => '.wppb-builder-container {{SELECTOR}}{ z-index: {{data.addon_z_index}}; }',
					),
					'addon_padding' => array(
						'type' => 'dimension',
						'title' => 'Padding',
						'unit' => array( 'px','em','%' ),
						'responsive' => true,
						'selector' => '{{SELECTOR}}{ padding: {{data.addon_padding}}; }',
						'section' => 'Style',
					),
					'addon_margin' => array(
						'type' => 'dimension',
						'title' => 'Margin',
						'unit' => array( 'px','em','%' ),
						'responsive' => true,
						'selector' => '{{SELECTOR}}{ margin: {{data.addon_margin}}; }',
						'section' => 'Style',
					),
					'addon_background'=> array(
						'type' => 'background',
						'title' => 'Background',
						'selector' => '{{SELECTOR}}',
						'section' => 'Background',
					),
					'addon_color_opacity'=> array(
						'type' => 'color2',
						'title' => 'Add Overlay Color',
						'std' => '#00aeff',
						'selector' => '{{SELECTOR}}:after',
						'section' => 'Overlay',
          			),
					'addon_opacity' => array(
						'type' => 'slider',
						'title' => 'Overlay Opacity',
						'range' => array(
							'min' => 0,
							'max' => 1,
							'step' => .01,
            		),
						'selector' => '{{SELECTOR}}:after{ content: " "; z-index: 0; display: block; position: absolute; height: 100%; top: 0; left: 0; right: 0; opacity:{{data.addon_opacity}}; }',
						'section' => 'Overlay',
					),
					'addon_color_blend' => array(
						'type' => 'select',
						'title' => 'Blend Mode',
						'values' => array(
							'normal' => 'Normal',
							'multiply' => 'Multiply',
							'screen' => 'Screen',
							'overlay' => 'Overlay',
							'darken' => 'Darken',
							'lighten' => 'Lighten',
							'color-dodge' => 'Color Dodge',
							'saturation' => 'Saturation',
							'luminosity' => 'Luminosity',
							'color' => 'Color',
							'color-burn' => 'Color Burn',
							'exclusion' => 'Exclusion',
							'hue' => 'Hue',
						),
						'section' => 'Overlay',
						'selector' => '{{SELECTOR}}:after{ mix-blend-mode:{{data.addon_color_blend}}; }',
					),
					'addon_border' => array(
						'type' => 'border',
						'title' => 'Border',
						'std' => array(
							'itemOpenBorder'=> 0,
							'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
							'borderStyle' => 'solid',
							'borderColor' => '#cccccc'
						),
						'selector' => '{{SELECTOR}}',
						'section' => 'Border',
					),
					'addon_border_hover' => array(
						'type' => 'border',
						'title' => 'Border Hover',
						'std' => array(
							'itemOpenBorder' => 0,
							'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
							'borderStyle' => 'solid',
							'borderColor' => '#cccccc'
						),
						'selector' => '{{SELECTOR}}:hover',
						'section' => 'Border',
					),
					'addon_border_radius_check' => array(
						'type' => 'switch',
						'title' => 'Border Radius',
						'std' => '0',
						'section' => 'Border Radius',
					),
					'addon_border_radius' => array(
						'type' => 'dimension',
						'title' => 'Border Radius',
						'unit' => array( 'px','em','%' ),
						'responsive' => true,
						'selector' => '{{SELECTOR}}, {{SELECTOR}}:after{ border-radius: {{data.addon_border_radius}}; overflow:hidden; }',
						'section' => 'Border Radius',
						'depends' => array( array( 'addon_border_radius_check', '=', '1' ) ),
					),
					'addon_border_radius_hover' => array(
						'type' => 'dimension',
						'title' => 'Hover Border Radius',
						'unit' => array( 'px','em','%' ),
						'responsive' => true,
						'selector' => '{{SELECTOR}}:hover, {{SELECTOR}}:hover:after{ border-radius: {{data.addon_border_radius_hover}};overflow:hidden; }',
						'section' => 'Border Radius',
						'depends' => array( array( 'addon_border_radius_check', '=', '1' ) ),
					),
					'addon_boxshadow' => array(
						'type' => 'boxshadow',
						'title' => 'Box Shadow',
                        'std' => array(
                            'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                            'shadowColor' => 'rgba(0,0,0,.3)'
                        ),
						'selector' => '{{SELECTOR}}',
						'section' => 'Box Shadow',
					),
					'addon_boxshadow_hover' => array(
						'type' => 'boxshadow',
						'title' => 'Box Shadow Hover',
                        'std' => array(
                            'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                            'shadowColor' => 'rgba(0,0,0,.3)'
                        ),
						'selector' => '{{SELECTOR}}:hover',
						'section' => 'Box Shadow',
					),
					'addon_animation' => array(
						'type' => 'animation',
						'title' => 'Animation',
						'section' => 'Animation',
					),
					'addon_wrap_opacity' => array(
						'type' => 'slider',
						'title' => 'Opacity',
						'range' => array(
							'min' => 0,
							'max' => 1,
							'step' => .01,
						),
						'selector' => '{{SELECTOR}} .wppb-addon{ opacity:{{data.addon_wrap_opacity}}; }',
						'section' => 'Opacity',
					),
					'addon_wrap_opacity_hover' => array(
						'type' => 'slider',
						'title' => 'Hover Opacity',
						'range' => array(
							'min' => 0,
							'max' => 1,
							'step' => .01,
						),
						'selector' => '{{SELECTOR}} .wppb-addon:hover{ opacity:{{data.addon_wrap_opacity_hover}}; }',
						'section' => 'Opacity',
					),
					'addon_hidden_xs' => array(
						'type' => 'switch',
						'title' => 'Hidden on Mobile',
						'section' => 'Responsive',
						'std' => '0',
					),
					'addon_hidden_sm' => array(
						'type' => 'switch',
						'title' => 'Hidden on Tablet',
						'section' => 'Responsive',
						'std' => '0',
					),
					'addon_hidden_md' => array(
						'type' => 'switch',
						'title' => 'Hidden on desktop',
						'section' => 'Responsive',
						'std' => '0',
					),
					'addon_hidden_lg' => array(
						'type' => 'switch',
						'title' => 'Hidden on Large Device',
						'section' => 'Responsive',
						'std' => '0',
					),
					'addon_display' => array(
						'type' => 'select',
						'title' => __('Display','wp-pagebuilder'),
						'values' => array(
							'inline' => 'Inline',
							'block' => 'Block',
							'inline-block' => 'Inline Block',
							'inherit' => 'Inherit',
							'initial' => 'Initial',
						),
						'section' => 'Display',
						'selector' => '{{SELECTOR}}{ display: {{data.addon_display}} ; }',
					),
					'addon_custom_css' => array(
						'type' => 'textarea',
						'title' => __('Custom CSS','wp-pagebuilder'),
						'section' => 'Custom CSS',
						'placeholder' => __('Use {{SELECTOR}} before the selector to wrap element. Otherwise it works globally.','wp-pagebuilder'),
						'desc' => __('Use {{SELECTOR}} before the selector to wrap element. Otherwise it works globally.','wp-pagebuilder')
					),
				),
			);
			return $global_attribute;
		}


		function column_settings(){
			$colSettings = array(
				'type'  => 'content',
				'title' => 'Section',
				'attr'  => array(
					'general' => array(
						'col_height' => array(
							'type' => 'slider',
							'title' => 'Min Height',
							'std' => array( 'md'=>'0px','sm'=>'0px','xs'=>'0px' ),
							'unit' => array( 'px','em','%' ),
							'range' => array(
								'em' => array(
									'min' => 0,
									'max' => 250,
									'step' =>.1,
								),
								'px' => array(
									'min' => 0,
									'max' => 2000,
									'step' =>1,
								),
								'%' => array(
									'min' => 0,
									'max' => 100,
									'step' => 1,
								),
							),
							'responsive' => true,
							'selector' => '.wppb-row > {{SELECTOR}}.wppb-column-parent { min-height: {{data.col_height}}; }'
						),
						'col_content' => array(
							'type' => 'select',
							'title' => 'Content position',
							'values' => array(
								'' => 'Default',
								'flex-start' => 'Top',
								'center' => 'Middle',
								'flex-end' => 'Bottom',
							),
							'std' => '',
							'multiple' => false,
							'selector' => '{{SELECTOR}} .wppb-column { display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: {{data.col_content}}; -ms-flex-align: {{data.col_content}}; align-items: {{data.col_content}}; }'
						),
						'col_custom_width' => array(
							'type' => 'columnWidth',
							'title' => 'Width',
							'range' => array(
								'min' => 10,
								'max' => 100,
								'step' => 1,
							),
							'responsive' => true,
							'selector' => '.wppb-column-parent{{SELECTOR}} { width: {{data.col_custom_width}}%; }'
						),
						'col_addons_space' => array(
							'type' => 'slider',
							'title' => 'Addons Space',
							'std' => array(
								'md'=>'0',
								'sm'=>'',
								'xs'=>''
							),
							'unit' => array( 'px','em','%' ),
							'range' => array(
								'em' => array(
									'min' => 0,
									'max' => 20,
									'step' => .1,
								),
								'px' => array(
									'min' => 0,
									'max' => 250,
									'step' => 1,
								),
								'%' => array(
									'min' => 0,
									'max' => 100,
									'step' => 1,
								),
							),
							'responsive' => true,
							'selector' => '{{SELECTOR}} .wppb-column .wppb-builder-addon{ margin-bottom: {{data.col_addons_space}}; }'
						),
						'col_animation' => array(
							'type' => 'animation',
							'title' => 'Animation',
							'section' => 'Animation',
						),
					),
					'style' => array(
						'col_padding' => array(
							'type' => 'dimension',
							'title' => 'Padding',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'selector' => '.wppb-builder-container .wppb-row > .wppb-column-parent{{SELECTOR}} .wppb-column { padding: {{data.col_padding}}; }'
						),
						'col_margin' => array(
							'type' => 'dimension',
							'title' => 'Margin',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'selector' => '.wppb-builder-container .wppb-row > .wppb-column-parent{{SELECTOR}} .wppb-column { margin: {{data.col_margin}}; }'
						),
						'col_border' => array(
							'type' => 'border',
							'title' => 'Border',
							'std' => array(
								'itemOpenBorder' => 1,
								'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
								'borderStyle' => 'solid',
								'borderColor' => '#f5f5f5'
							),
							'selector' => '{{SELECTOR}} .wppb-column',
							'section' => 'Border',
						),
						'col_border_hover' => array(
							'type' => 'border',
							'title' => 'Hover Border',
							'std' => array(
								'itemOpenBorder' => 1,
								'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
								'borderStyle' => 'solid',
								'borderColor' => '#e5e5e5'
							),
							'selector' => '{{SELECTOR}} .wppb-column:hover',
							'section' => 'Border',
						),
						'col_boxshadow' => array(
							'type' => 'boxshadow',
							'title' => 'Box shadow',
							'std' => array(
								'itemOpenShadow' => true,
								'shadowValue' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ), 
								'shadowColor' => '#f5f5f5' 
							),
							'section' => 'Box shadow',
							'selector' => '{{SELECTOR}} > .wppb-column,{{SELECTOR}} > div > .wppb-column'
						),
						'col_boxshadow:hover' => array(
							'type' => 'boxshadow',
							'title' => 'Hover box shadow',
							'std' => array(
								'itemOpenShadow' => true,
								'shadowValue' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ), 
								'shadowColor' => '#f5f5f5' 
							),
							'section' => 'Box shadow',
							'selector' => '{{SELECTOR}} > .wppb-column:hover, {{SELECTOR}} > div > .wppb-column:hover'
						),
						'col_border_radius_check' => array(
							'type' => 'switch',
							'title' => 'Border Radius',
							'section' => 'Border Radius',
							'std' => '0'
						),
						'col_border_radius' => array(
							'type' => 'dimension',
							'title' => 'Border Radius',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'depends' => array(array('col_border_radius_check', '=', '1')),
							'selector' => '{{SELECTOR}} .wppb-column,{{SELECTOR}} .wppb-column:after{ border-radius: {{data.col_border_radius}} ; }',
							'section' => 'Border Radius',
						),
						'col_border_radius_hover' => array(
							'type' => 'dimension',
							'title' => 'Hover Border Radius',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'depends' => array(array('col_border_radius_check', '=', '1')),
							'selector' => '{{SELECTOR}} .wppb-column:hover,{{SELECTOR}} .wppb-column:hover:after{ border-radius: {{data.col_border_radius_hover}} ; }',
							'section' => 'Border Radius',
						),
						'col_background'=> array(
							'type' => 'background',
							'title' => 'Background',
							'video' => true,
							'selector' => '{{SELECTOR}} .wppb-column',
							'section' => 'Background',
						),
						'col_color_opacity'=> array(
							'type' => 'color2',
							'title' => 'Add Overlay Color',
							'std' => '#00aeff',
							'selector' => '{{SELECTOR}} .wppb-column:after',
							'section' => 'Overlay',
						),
						'col_opacity' => array(
							'type' => 'slider',
							'title' => 'Overlay Opacity',
							'range' => array(
								'min' => 0,
								'max' => 1,
								'step' => .01,
							),
							'selector' => '{{SELECTOR}} .wppb-column:after{transition: 300ms; content: " "; display: block; position: absolute; height: 100%; top: 0; left: 0; right: 0; opacity: {{data.col_opacity}}; }',
							'section' => 'Overlay',
						),
						'col_color_blend' => array(
							'type' => 'select',
							'title' => 'Blend Mode',
							'values' => array(
								'normal' => 'Normal',
								'multiply' => 'Multiply',
								'screen' => 'Screen',
								'overlay' => 'Overlay',
								'darken' => 'Darken',
								'lighten' => 'Lighten',
								'color-dodge' => 'Color Dodge',
								'saturation' => 'Saturation',
								'luminosity' => 'Luminosity',
								'color' => 'Color',
								'color-burn' => 'Color Burn',
								'exclusion' => 'Exclusion',
								'hue' => 'Hue',
							),
							'section' => 'Overlay',
							'selector' => '{{SELECTOR}} .wppb-column:after{ mix-blend-mode:{{data.col_color_blend}}; }',
						),
					),
					'advanced' => array(
						'col_id' => array(
							'type' => 'text',
							'title' => 'Column ID',
						),
						'col_class' => array(
							'type' => 'text',
							'title' => 'Class',
						),
						'col_z_index' => array(
							'type' => 'slider',
							'title' => 'z-index',
							'range' => array(
								'min' => -10000,
								'max' => 10000,
								'step' => 1,
							),
							'selector' => '.wppb-row .wppb-column-parent{{SELECTOR}} .wppb-column{ z-index: {{data.col_z_index}}; }',
						),
						'col_hidden_xs' => array(
							'type' => 'switch',
							'title' => 'Hidden on Mobile',
							'section' => 'Responsive',
							'std' => '0',
						),
						'col_hidden_sm' => array(
							'type' => 'switch',
							'title' => 'Hidden on Tablet',
							'section' => 'Responsive',
							'std' => '0',
						),
						'col_hidden_md' => array(
							'type' => 'switch',
							'title' => 'Hidden on desktop',
							'section' => 'Responsive',
							'std' => '0',
						),
						'col_hidden_lg' => array(
							'type' => 'switch',
							'title' => 'Hidden on Large Device',
							'section' => 'Responsive',
							'std' => '0',
						),
						'col_custom_css'=> array(
							'type' => 'textarea',
							'title' => __('Custom CSS','wp-pagebuilder'),
							'section' => 'Custom CSS',
							'placeholder' => __('Use {{SELECTOR}} before the selector to wrap element. Otherwise it works globally.','wp-pagebuilder'),
							'desc' => __('Use {{SELECTOR}} before the selector to wrap element. Otherwise it works globally.','wp-pagebuilder'),
						),
					)
				)
			);
			return $colSettings;
		}

		function row_settings(){
			$rowSettings = array(
				'type' => 'content',
				'title' => 'Section',
				'default' => array( 'row_screen' => 'row-default' ),
				'attr' => array(
					'general' => array(
						'row_screen' => array(
							'type' => 'select',
							'title' => 'Screen',
							'values' => array(
								'row-default' => 'Default',
								'row-stretch' => 'Row Stretch',
								'row-container-stretch' => 'Row and Container Stretch',
								'container-stretch-no-gutter' => 'Container Stretch Without Gutter',
							),
							'std' => 'row-stretch',
							'multiple' => false,
						),
						'row_height' => array(
							'type' => 'slider',
							'title' => 'Min height',
							'range' => array(
								'min' => 1,
								'max' => 2500,
								'step' => 1,
							),
							'responsive' => true,
							'selector' => '{{SELECTOR}}{ min-height: {{data.row_height}}px; }'
						),
						'row_content' => array(
							'type' => 'select',
							'title' => 'Content position',
							'values' => array(
								'' => 'Default',
								'flex-start' => 'Top',
								'center' 	    => 'Middle',
								'flex-end' => 'Bottom',
							),
							'std' => '',
							'multiple' => false,
							'selector' => '{{SELECTOR}}{ display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: {{data.row_content}}; -ms-flex-align: {{data.row_content}}; align-items: {{data.row_content}}; }'
						),
						'row_custom_width' => array(
							'type' => 'slider',
							'title' => 'Custom width',
							'range' => array(
								'min' => 0,
								'max' => 2500,
								'step' => 1,
							),
							'responsive' => true,
							'selector' => '.wppb-builder-container#wppb-builder-container .wppb-row-parent{{SELECTOR}} > .wppb-container,.wppb-builder-container#wppb-builder-container .wppb-row-parent  .wppb-container{{SELECTOR}} { max-width: {{data.row_custom_width}}px;margin-left: auto;margin-right: auto; }'
						),
						'row_custom_gutter' => array(
							'type' => 'slider',
							'title' => 'Gutter',
							'range' => array(
								'min' => 0,
								'max' => 200,
								'step' => 1,
							),
							'std' => '30',
							'division' => 2,
							'responsive' => true,
							'selector' => array('.wppb-row-parent {{SELECTOR}}.wppb-container > .wppb-row, .wppb-row-parent{{SELECTOR}} .wppb-container > .wppb-row { margin-left:  -{{data.row_custom_gutter}}px; margin-right: -{{data.row_custom_gutter}}px; }',
							'.wppb-builder-container {{SELECTOR}} .wppb-row .wppb-column-parent-editor .wppb-column { margin-left: {{data.row_custom_gutter}}px; margin-right: {{data.row_custom_gutter}}px; }',
							'.wppb-builder-container {{SELECTOR}} .wppb-row .wppb-column-parent-view { padding-left: {{data.row_custom_gutter}}px; padding-right: {{data.row_custom_gutter}}px; }',
							'.wppb-builder-container#wppb-builder-container .wppb-row-parent{{SELECTOR}} > .wppb-container,.wppb-builder-container#wppb-builder-container .wppb-row-parent  .wppb-container{{SELECTOR}} { padding-left: {{data.row_custom_gutter}}px; padding-right: {{data.row_custom_gutter}}px; }')
						),
						'row_animation' => array(
							'type' => 'animation',
							'title' => 'Animation',
							'section' => 'Animation',
						),
					),
					'style' => array(
						'row_padding' => array(
							'type' => 'dimension',
							'title' => 'Padding',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'selector' => '.wppb-builder-container > div > div > .wppb-row-parent{{SELECTOR}},.wppb-builder-container > .wppb-row-parent{{SELECTOR}}, .wppb-builder-container#wppb-builder-container > .wppb-row-parent .wppb-container{{SELECTOR}}, .wppb-builder-container#wppb-builder-container .wppb-row-placeholder > .wppb-row-parent > .wppb-container{{SELECTOR}}, .wppb-builder-container .wppb-inner-row-parent{{SELECTOR}} { padding: {{data.row_padding}}; }'
						),
						'row_margin' => array(
							'type' => 'dimension',
							'title' => 'Margin',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'selector' => '{{SELECTOR}}{ margin: {{data.row_margin}}; }'
						),
						'row_boxshadow' => array(
							'type' => 'boxshadow',
							'title' => 'Box Shadow',
                            'std' => array(
                                'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                                'shadowColor' => 'rgba(0,0,0,.3)'
                            ),
							'selector' => '{{SELECTOR}}',
							'section' => 'Box Shadow',
						),
						'row_boxshadow_hover' => array(
							'type' => 'boxshadow',
							'title' => 'Box Shadow hover',
                            'std' => array(
                                'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                                'shadowColor' => 'rgba(0,0,0,.3)'
                            ),
							'selector' => '{{SELECTOR}}:hover',
							'section' => 'Box Shadow',
						),
						'row_border' => array(
							'type' => 'border',
							'title' => 'Border',
							'std' => array(
								'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
								'borderStyle' => 'solid',
								'borderColor' => '#cccccc'
							),
							'selector' => '{{SELECTOR}}',
							'section' => 'Border',
						),
						'row_border_hover' => array(
							'type' => 'border',
							'title' => 'Hover Border',
							'std' => array(
								'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
								'borderStyle' => 'solid',
								'borderColor' => '#cccccc'
							),
							'selector' => '{{SELECTOR}}:hover',
							'section' => 'Border',
						),
						'row_border_radius_check' => array(
							'type' => 'switch',
							'title' => 'Border Radius',
							'section' => 'Border Radius',
							'std' => '0'
						),
						'row_border_radius' => array(
							'type' => 'dimension',
							'title' => 'Border Radius',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'depends' => array(array('row_border_radius_check', '=', '1')),
							'selector' => '{{SELECTOR}}{ border-radius: {{data.row_border_radius}} ; }',
							'section' => 'Border Radius',
						),
						'row_border_radius_hover' => array(
							'type' => 'dimension',
							'title' => 'Hover Border Radius',
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'depends' => array(array('row_border_radius_check', '=', '1')),
							'selector' => '{{SELECTOR}}:hover{ border-radius: {{data.row_border_radius_hover}} ; }',
							'section' => 'Border Radius',
						),
						'row_background'=> array(
							'type' => 'background',
							'title' => 'Background',
							'video' => true,
							'selector' => '{{SELECTOR}}',
							'section' => 'Background',
						),
						'row_color_opacity'=> array(
							'type' => 'color2',
							'title' => 'Overlay Background Color',
							'std' => '#00aeff',
							'selector' => '{{SELECTOR}}:after',
							'section' => 'Overlay',
						),
						'row_overlay_media' => array(
							'type' => 'media',
							'title' => 'Overlay Image',
							'section' => 'Overlay',
							'selector' => '{{SELECTOR}}:after{ background-image: url("{{data.row_overlay_media}}"); }',
						),
						'row_overlay_position' => array(
							'type' => 'select',
							'title' => 'Image Position',
							'values' => array(
								'' => 'Default',
								'left top' => 'left top',
								'left center' => 'left center',
								'left bottom' => 'left bottom',
								'right top' => 'right top',
								'right center' => 'right center',
								'right bottom' => 'right bottom',
								'center top' => 'center top',
								'center center' => 'center center',
								'center bottom' => 'center bottom',
							),
							'section' => 'Overlay',
							'selector' => '{{SELECTOR}}:after{ background-position: {{data.row_overlay_position}}; }',
						),
						'row_overlay_size' => array(
							'type' => 'select',
							'title' => 'Image Size',
							'values' => array(
								'' => 'Default',
								'cover' => 'Cover',
								'auto' => 'Auto',
								'contain' => 'Contain',
							),
							'section' => 'Overlay',
							'selector' => '{{SELECTOR}}:after{ background-size: {{data.row_overlay_size}}; }',
						),
						'row_opacity' => array(
							'type' => 'slider',
							'title' => 'Overlay Opacity',
							'range' => array(
								'min' => 0,
								'max' => 1,
								'step' => .01,
							),
							'selector' => '{{SELECTOR}}:after{content: " "; display: block; position: absolute; height: 100%; top: 0; left: 0; right: 0; z-index: -1; opacity: {{data.row_opacity}}; }',
							'section' => 'Overlay',
						),
						'row_color_blend' => array(
							'type' => 'select',
							'title' => 'Blend Mode',
							'values' => array(
								'normal' => 'Normal',
								'multiply' => 'Multiply',
								'screen' => 'Screen',
								'overlay' => 'Overlay',
								'darken' => 'Darken',
								'lighten' => 'Lighten',
								'color-dodge' => 'Color Dodge',
								'saturation' => 'Saturation',
								'luminosity' => 'Luminosity',
								'color' => 'Color',
								'color-burn' => 'Color Burn',
								'exclusion' => 'Exclusion',
								'hue' => 'Hue',
							),
							'section' => 'Overlay',
							'selector' => '{{SELECTOR}}:after{ mix-blend-mode:{{data.row_color_blend}}; }',
						),
						'row_shape' => array(
							'type' => 'shape',
							'title' => 'Shape Top',
							'selector' => '{{SELECTOR}}',
							'section' => 'Shape',
						),
						'row_shape_bottom' => array(
							'type' => 'shape',
							'title' => 'Shape Bottom',
							'selector' => '{{SELECTOR}}',
							'section' => 'Shape',
						),
					),
					'advanced' => array(
						'row_id' => array(
							'type' => 'text',
							'title' => 'Row ID',
						),
						'row_class' => array(
							'type' => 'text',
							'title' => 'Class',
						),
						'row_z_index' => array(
							'type' => 'slider',
							'title' => 'z-index',
							'range' => array(
								'min' => 0,
								'max' => 10000,
								'step' => 1,
							),
							'std' => 0,
							'selector' => '{{SELECTOR}}{ z-index: {{data.row_z_index}}; }',
						),
						'row_hidden_xs' => array(
							'type' => 'switch',
							'title' => 'Hidden on Mobile',
							'section' => 'Responsive',
							'std' => '0',
						),
						'row_hidden_sm' => array(
							'type' => 'switch',
							'title' => 'Hidden on Tablet',
							'section' => 'Responsive',
							'std' => '0',
						),
						'row_hidden_md' => array(
							'type' => 'switch',
							'title' => 'Hidden on desktop',
							'section' => 'Responsive',
							'std' => '0',
						),
						'row_hidden_lg' => array(
							'type' => 'switch',
							'title' => 'Hidden on Large Device',
							'section' => 'Responsive',
							'std' => '0',
						),
						'row_custom_css' => array(
							'type' => 'textarea',
							'title' => __('Custom CSS','wp-pagebuilder'),
							'section' => 'Custom CSS',
							'placeholder' =>  __('Use {{SELECTOR}} before the selector to wrap element. Otherwise it works globally.','wp-pagebuilder'),
							'desc' =>  __('Use {{SELECTOR}} before the selector to wrap element. Otherwise it works globally.','wp-pagebuilder'),
						),
					),
				),
			);
			return $rowSettings;
		}

		public function widgetLists(){
			global $wp_widget_factory;
			$widgets = array();
			foreach( $wp_widget_factory->widgets as $key => $widget ) {
				$widgets[$key] = array(
					'id_base' => $widget->id_base,
					'name' => $widget->name,
					'option_name' => $widget->option_name,
					'number' => $widget->number,
					'id' => $widget->id,
				);
			}

			return $widgets;

		}



	}

}