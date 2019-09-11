<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Icon{

	public function get_name(){
		return 'wppb_icon';
	}
	public function get_title(){
		return 'Icon';
	}
	public function get_icon() {
		return 'wppb-font-heart-thin';
	}

	// Icon Settings Fields
	public function get_settings() {

		$settings = array(
			'icon_list' => array(
				'type' => 'icon',
				'title' => __('Icon','wp-pagebuilder'),
				'std' => 'fas fa-home'
			),
			'icon_link' => array(
				'type' => 'link',
				'std' => array( 'link'=>'','window'=>false,'nofolow'=>false ),
				'title' => __('Link','wp-pagebuilder'),
			),
			'icon_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'std' => array( 'md' => 'center', 'sm' => 'center', 'xs' => 'center' ),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-icon-content { text-align: {{data.icon_align}}; }'
			),

			// Style Area
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Size','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 200,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 400,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'std' => array(
					'md' => '36px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner i { font-size: {{data.icon_size}}; }'
			),
			'icon_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 50,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 500,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'std' => array(
					'md' => '100px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner { width: {{data.icon_width}}; }'
			),

			'icon_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 50,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 500,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '100px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'selector' => array(
					'{{SELECTOR}} .wppb-icon-content .wppb-icon-inner { height: {{data.icon_height}}; }',
					'{{SELECTOR}} .wppb-icon-content .wppb-icon-inner i { line-height: {{data.icon_height}}; }',
				)
			),
			'icon_line_height' => array(
				'type' => 'slider',
				'title' => __('Line Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 50,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 500,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '100px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner { line-height: {{data.icon_line_height}}; }',
			),
			'icon_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => true,
				'std' => array(
					'clip' => true,
					'colorType' => 'color',
					'colorColor' => '#ffffff',
				),
				'section' => 'Color',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner i, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner a i'
			),
			'icon_hcolor' => array(
				'type' => 'color2',
				'title' => __('Hover Color','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => true,
				'std' => array(
					'clip' => true,
					'colorType' => 'color',
					'colorColor' => '#ffffff',
				),
				'section' => 'Color',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover i, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover a i'
			),
			'icon_bg' => array(
				'type' => 'color2',
				'title' => __('background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Color',
				'clip' => false,
				'std' => array(
					'clip' => false,
					'colorType' => 'color',
					'colorColor' => '#0080FE',
				),
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner'
			),
			'icon_hover_bg' => array(
				'type' => 'color2',
				'title' => __('Hover background','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => false,
				'std' => array(
					'clip' => false,
					'colorType' => 'color',
					'colorColor' => '#0170dc',
				),
				'section' => 'Color',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner:before, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover'
			),
			'icon_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Border',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner'
			),
			'border_hcolor' => array(
				'type' => 'border',
				'title' => 'Hover Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Border',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:before'
			),
			'icon_radius' => array(
				'type' => 'dimension',
				'title' => 'Border radius',
				'unit' => array( 'px','em','%' ),
				'std' => array(
					'md' => array( 'top' => '100px', 'right' => '100px', 'bottom' => '100px', 'left' => '100px' ), 
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Border Radius',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:before { border-radius: {{data.icon_radius}}; }',
			),
			'icon_hover_radius' => array(
				'type' => 'dimension',
				'title' => 'Hover Border radius',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'std' => array(
					'md' => array( 'top' => '100px', 'right' => '100px', 'bottom' => '100px', 'left' => '100px' ), 
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'tab' => 'style',
				'section' => 'Border Radius',
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover:before { border-radius: {{data.icon_hover_radius}}; }',
			),
			'icon_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Icon box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:before',
				'tab' => 'style',
				'section' => 'Box Shadow',
			),
			'icon_hboxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Icon hover box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'selector' => '{{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover, {{SELECTOR}} .wppb-icon-content .wppb-icon-inner:hover:before',
				'tab' => 'style',
				'section' => 'Box Shadow',
			),
		);

		return $settings;
	}

	// Icon Render HTML
	public function render($data = null){
		$settings 			= $data['settings']; 
		$icon_list 			= isset($settings["icon_list"]) ? $settings["icon_list"] : '';
		$icon_link 	    	= isset($settings["icon_link"]) ? $settings["icon_link"] : array();

		$output = '' ;

		$target = $icon_link['window'] ? 'target=_blank' : "";
		$nofolow = $icon_link['nofolow'] ? 'rel=nofolow' : "";

		$output  .= '<div class="wppb-icon-addon">';
			$output  .= '<div class="wppb-icon-content">';
			if($icon_link['link']) {
				$output  .= '<span class="wppb-icon-inner"><a '.esc_attr($nofolow).' href="'.esc_url($icon_link['link']).'" '.esc_attr($target).'>';
				$output  .= '<i class="' . esc_attr($icon_list) . '"></i>';
				$output  .= '</a></span>';
			} else {
				$output  .= '<span class="wppb-icon-inner"><i class="' . esc_attr($icon_list) . '"></i></span>';
			}
			$output  .= '</div>';
		$output  .= '</div>';

		return $output;
	}

	// Icon Template
	public function getTemplate(){
		$output = '
			<div class="wppb-icon-addon">
				<div class="wppb-icon-content">
					<# if( !__.isEmpty(data.icon_link.link) ) { #>
						<span class="wppb-icon-inner"><a {{ data.icon_link.link ? "href="+data.icon_link.link : "" }} {{ data.icon_link.window ? "target=_blank" : "" }} {{ data.icon_link.nofolow ? "rel=nofolow" : "" }}>
						<i class=" {{data.icon_list}}"></i>
						</a></span>
					<# } else { #>	
						<span class="wppb-icon-inner"><i class=" {{data.icon_list}}"></i></span>
					<# } #>
				</div>
			</div>
		';
		return $output;
	}

}
