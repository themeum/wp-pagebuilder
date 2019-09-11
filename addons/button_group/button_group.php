<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Button_Group{

	public function get_name(){
		return 'wppb_button_group';
	}
	public function get_title(){
		return 'Button Group';
	}
	public function get_icon() {
		return 'wppb-font-button-group';
	}

	// Group Button Settings Fields
	public function get_settings() {

		$settings = array(

			// Repeatable Items
			'button_item' => array(
				'title' => __('Button','wp-pagebuilder'),
				'type' => 'repeatable',
				'label' => 'button_text',
				'std' => array(
					array( 
						'button_text' => 'Button 1',
						'button_link' => array( 'link'=>'#','window'=>false,'nofolow'=>false ),
						'style' => 'primary',
						'btn_size' => 'standard',
						'shape' => 'rounded',
					),
					array(
						'button_text' => 'Button 2',
						'button_link' => array( 'link'=>'#', 'window'=>false, 'nofolow'=>false ),
						'style' => 'info',
						'btn_size' => 'standard',
						'shape' => 'square',
						'icon_list' => 'fas fa-cog',
						'icon_position' => 'left',
					),
					array(
						'button_text' => 'Button 3',
						'button_link' => array( 'link'=>'#','window'=>false,'nofolow'=>false ),
						'style' => 'success',
						'btn_size' => 'standard',
						'shape' => 'rounded',
						'icon_list' => 'fab fa-apple',
						'icon_position' => 'right',
					)
				),
				'attr' => array(
					'button_text' => array(
						'type' => 'text',
						'title' => __('Text','wp-pagebuilder'),
						'std' => 'Button',
					),
					'button_link' => array(
						'type' => 'link',
						'title' => __('Link','wp-pagebuilder'),
						'std' => array( 'link'=>'#','window'=>false,'nofolow'=>false ),
					),
					'style' => array(
						'type' => 'select',
						'title' => __('Style','wp-pagebuilder'),
						'values' => array(
							'primary' => __('Primary','wp-pagebuilder'),
							'success' => __('Success','wp-pagebuilder'),
							'info' => __('Info','wp-pagebuilder'),
							'warning' => __('Warning','wp-pagebuilder'),
							'danger' => __('Danger','wp-pagebuilder'),
							'light' => __('Light','wp-pagebuilder'),
							'dark' => __('Dark','wp-pagebuilder'),
							'link' => __('Link','wp-pagebuilder'),
							'custom' => __('Custom','wp-pagebuilder'),
						),
						'std' => 'primary',
					),
					'button_color' => array(
						'type' => 'color',
						'title' => __('Color','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-btn-addons { color: {{data.button_color}}; }'
					),
					'button_hcolor' => array(
						'type' => 'color',
						'title' => __('Hover color','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-btn-addons:hover { color: {{data.button_hcolor}}; }'
					),
					'button_bg' => array(
						'type' => 'color2',
						'title' => __('Background','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-btn-addons'
					),
					'button_hover_bg' => array(
						'type' => 'color2',
						'title' => __('Hover background','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-btn-custom.wppb-btn-addons:before'
					),
					'btn_size' => array(
						'type' => 'select',
						'title' => __('Size','wp-pagebuilder'),
						'values' => array(
							'standard' => __('Standard','wp-pagebuilder'),
							'large' => __('Large','wp-pagebuilder'),
							'xlarge' => __('Extra Large','wp-pagebuilder'),
							'small' => __('Small','wp-pagebuilder'),
							'xsmall' => __('Extra Small','wp-pagebuilder'),
							'custom' => __('Custom','wp-pagebuilder'),
						),
						'std' => 'standard',
					),
					'button_padding' => array(
						'type' => 'dimension',
						'title' => 'Padding',
						'unit' => array( 'px','em','%' ),
						'depends' => array(array('btn_size', '=', array('custom'))),
						'responsive' => true,
						'selector' => '{{SELECTOR}} .wppb-btn-addons { padding: {{data.button_padding}}; }',
					),
					'shape' => array(
						'type' => 'select',
						'title' => __('Shape','wp-pagebuilder'),
						'values' => array(
							'rounded' => __('Rounded','wp-pagebuilder'),
							'square' => __('Square','wp-pagebuilder'),
							'round' => __('Round','wp-pagebuilder'),
							'custom' => __('Custom','wp-pagebuilder'),
						),
						'std' => 'rounded',
					),
					'buttom_radius' => array(
						'type' => 'dimension',
						'title' => __('Border radius','wp-pagebuilder'),
						'unit' => array( '%','px','em' ),
						'responsive' => true,
						'depends' => array(array('shape', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-btn-addons { border-radius: {{data.buttom_radius}}; }'
					),				
					'icon_list' => array(
						'type' => 'icon',
						'title' => __('Icon','wp-pagebuilder'),
						'std' => ''
					),
					'icon_position' => array(
						'type' => 'select',
						'title' => __('Icon position','wp-pagebuilder'),
						'values' => array(
							'left' => __('Left','wp-pagebuilder'),
							'right' => __('Right','wp-pagebuilder'),
						),
						'std' => 'left',
					),		

					'button_border' => array(
						'type' => 'border',
						'title' => 'Border',
						'std' => array(
							'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
							'borderStyle' => 'solid', 
							'borderColor' => '#cccccc' 
						),
						'selector' => '{{SELECTOR}} .wppb-btn-addons'
					),
					'border_hcolor' => array(
						'type' => 'border',
						'title' => 'Border Hover',
						'std' => array(
							'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
							'borderStyle' => 'solid', 
							'borderColor' => '#cccccc' 
						),
						'selector' => '{{SELECTOR}} .wppb-btn-addons:hover'
					),
				),
			),

			'button_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'std' => array( 'md'=>'center' ),
				'selector' => '{{SELECTOR}} .wppb-button-addon-content{ text-align: {{data.button_align}}; }'
			),

			// Style Area
			'button_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-button-addon-content .wppb-btn-addons',
				'tab' => 'style',
			),

			'button_margin' => array(
				'type' => 'slider',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 15,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 150,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'std' => array(
					'md' => '5px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => array(
					'{{SELECTOR}} .wppb-button-addon-content { margin-left: -{{data.button_margin}}; }',
					'{{SELECTOR}} .wppb-button-addon-content { margin-right: -{{data.button_margin}}; }',
					'{{SELECTOR}} .wppb-button-group { padding-right: {{data.button_margin}}; }',
					'{{SELECTOR}} .wppb-button-group { padding-left: {{data.button_margin}}; }',
				)
			),

		);

		return $settings;
	}
	
	// Group Button Render HTML
	public function render($data = null){
		$settings 			= $data['settings']; 
		$button_item 		= isset($settings["button_item"]) ? $settings["button_item"] : array();

		$output = $button = '' ;
		$output  .= '<div class="wppb-button-group-addon">';
			$output  .= '<div class="wppb-button-addon-content">';
			if (is_array($button_item) && count($button_item)){
				foreach ( $button_item as $key => $value ) {
					$classlist = '';
					if( !empty($value['button_link']['link'])) {
						$output  .= '<div class="wppb-button-group repeater-'.$key.'">';
							$classlist .= ($value['style'] && $value['style']) ? ' wppb-btn-' . $value['style'] : '';
							$classlist .= ($value['shape'] && $value['shape']) ? ' wppb-btn-' . $value['shape'] : '';
							$classlist .= ($value['btn_size'] && $value['btn_size']) ? ' wppb-btn-' . $value['btn_size'] : '';
							$target = $value['button_link']['window'] ? 'target=_blank' : 'target=_self';
							$nofolow = $value['button_link']['nofolow'] ? 'rel=nofolow' : "";

							if( isset($value['icon_position']) == 'left') {
								$button = ( isset($value['icon_list']) && $value['icon_list'] ) ? '<i class="' . esc_attr( $value['icon_list']) . '"></i> ' . esc_attr($value['button_text']) : esc_attr($value['button_text']);
							} elseif ( isset($value['icon_position']) == 'right') {
								$button = ( isset($value['icon_list']) && $value['icon_list'] ) ? esc_attr($value['button_text']) . ' <i class="' . esc_attr( $value['icon_list']) . '"></i>' : esc_attr($value['button_text']);
							} else {
								$button =  esc_attr($value['button_text']);
							}
							$output  .= '<a '.esc_attr($nofolow).' href="'.esc_url($value['button_link']['link']).'" '.esc_attr($target).' class="wppb-btn-addons '.esc_attr($classlist).'">' . $button  . '</a>';
						$output  .= '</div>';
					}
				}
			}
			$output  .= '</div>';
		$output  .= '</div>';

		return $output;
	}

	// Group Button Template
	public function getTemplate(){
		$output = '
		<div class="wppb-button-group-addon">
			<div class="wppb-button-addon-content">
				<#  _.forEach(data.button_item, function(value, key) { 
					var classList = "";
					classList += " wppb-btn-"+value.style;
					classList += " wppb-btn-"+value.shape;
					classList += " wppb-btn-"+value.btn_size;  
					#>
					<div class="wppb-button-group repeater-{{key}}">	
						<# if( value.button_link && value.button_link.link) { #>
							<a {{ value.button_link.link ? "href="+value.button_link.link : "" }} {{ value.button_link.window ? "target=_blank" : "" }} {{ value.button_link.nofolow ? "rel=nofolow" : "" }}  class="wppb-btn-addons {{classList}}">
								<# if(value.icon_list){ #>
									<# if(value.icon_position == "right" ) { #>
										<i class=" {{value.icon_list}}"></i> {{ value.button_text }}
									<# }else{ #>
										{{ value.button_text }} <i class=" {{value.icon_list}}"></i>
									<# } #>
								<# }else{ #>
									{{ value.button_text }} 
								<# } #>
							</a>
						<# } #>
					</div>
				<# }); #>
			</div>
		</div>';
		return $output;
	}

}
