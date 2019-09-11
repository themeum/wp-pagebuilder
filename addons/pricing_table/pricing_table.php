<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Pricing_Table{

	public function get_name(){
		return 'wppb_pricing_table';
	}
	public function get_title(){
		return 'Pricing Table';
	}
	public function get_icon() {
		return 'wppb-font-pricing-table';
	}

	// Pricing Settings Fields
	public function get_settings() {

		$settings = array(
			'pricing_layout' => array(
				'type' => 'radioimage',
				'title' => 'Select layout',
				'values'=> array(
					'one' =>  WPPB_DIR_URL.'addons/pricing_table/img/pricing-img1.png',
					'two' =>  WPPB_DIR_URL.'addons/pricing_table/img/pricing-img2.png',
					'three' =>  WPPB_DIR_URL.'addons/pricing_table/img/pricing-img3.png',
				),
				'std' => 'one',
			),
			'title' => array(
				'type' => 'text',
				'title' => __('Title','wp-pagebuilder'),
				'std' => 'Standards',
			),
			'subtitle' => array(
				'type' => 'text',
				'title' => __('Sub title','wp-pagebuilder'),
				'std' => 'Best plan for you',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'currency' => array(
				'type' => 'text',
				'title' => __('Currency symbol','wp-pagebuilder'),
				'std' => '$',
			),
			'pricing' => array(
				'type' => 'text',
				'title' => __('Sales Price','wp-pagebuilder'),
				'std' => '89',
			),
			'sales' => array(
				'type' => 'text',
				'title' => __('Regular Price','wp-pagebuilder'),
				'std' => '',
			),
			'period' => array(
				'type' => 'text',
				'title' => __('Period','wp-pagebuilder'),
				'std' => '/ Month',
			),
			'pt_icon_list' => array(
				'type' => 'icon',
				'title' => __('Icon list','wp-pagebuilder'),
				'std' => 'far fa-star',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'pricing_feature' => array(
				'title' => __('Pricing Features','wp-pagebuilder'),
				'type' => 'repeatable',
				'label' => 'feature_text',
				'std' => array(
					array( 
						'feature_text' => 'One year support',
						'icon_list' => 'fas fa-check',
						'icon_list_color' => '#23c131'
					),
					array( 
						'feature_text' => 'Unlimited ready theme',
						'icon_list' => 'fas fa-times',
						'icon_list_color' => '#ff0000'
					),
					array( 
						'feature_text' => 'Unlimited Free addons',
						'icon_list' => 'fas fa-check',
						'icon_list_color' => '#23c131'
					),
					array( 
						'feature_text' => 'Five site support',
						'icon_list' => 'fas fa-check',
						'icon_list_color' => '#23c131'
					),
				),
				'attr' => array(
					'feature_text' => array(
						'type' => 'text',
						'title' => __('Title','wp-pagebuilder'),
						'std' => 'One year support'
					),
					'icon_list' => array(
						'type' => 'icon',
						'title' => __('Icon','wp-pagebuilder'),
						'std' => 'fas fa-check'
					),
					'icon_list_color' => array(
						'type' => 'color',
						'title' => __('Icon color','wp-pagebuilder'),
						'selector' => '{{SELECTOR}} .wppb-pricing-list i { color: {{data.icon_list_color}}; }'
					),
				),
			),			

			'button_text' => array(
				'type' => 'text',
				'title' => __('Button text','wp-pagebuilder'),
				'std' => 'Buy Now',
				'placeholder'=> 'Button',
			),
			'btn_link' => array(
				'type' => 'link',
				'title' => __('Button Link','wp-pagebuilder'),
				'std' => array('link'=>'#','window'=>true,'nofolow'=>false),
				'depends' => array(array('button_text', '!=', '')),
			),
			'icon_list' => array(
				'type' => 'icon',
				'title' => __('Button icon','wp-pagebuilder'),
				'std' => '',
				'depends' => array(array('button_text', '!=', '')),
			),
			'icon_position' => array(
				'type' => 'select',
				'title' => __('Button icon position','wp-pagebuilder'),
				'depends' => array(array('icon_list', '!=', '')),
				'values' => array(
					'left' => __('Left','wp-pagebuilder'),
					'right' => __('Right','wp-pagebuilder'),
				),
				'std' => 'left',
			),

			'aditional_info' => array(
				'type' => 'text',
				'title' => __('Aditional Info','wp-pagebuilder'),
				'std' => 'Support Time 24 hrs',
			),

			'pricing_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'std' => array( 'md' => 'center', 'sm' => 'center', 'xs' => 'center' ),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content{ text-align: {{data.pricing_align}}; }'
			),

			// Style Area
			'pricing_content_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Pricing Feature',
				'selector' => '{{SELECTOR}} .wppb-pricing-feature { color: {{data.pricing_content_color}}; }'
			),
			'pricing_content_odd' => array(
				'type' => 'color',
				'title' => __('Odd number bg color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Pricing Feature',
				'selector' => '{{SELECTOR}} .wppb-pricing-feature div:nth-child(odd) .wppb-pricing-list { background: {{data.pricing_content_odd}}; }'
			),
			'pricing_content_even' => array(
				'type' => 'color',
				'title' => __('Even number bg color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Pricing Feature',
				'selector' => '{{SELECTOR}} .wppb-pricing-feature div:nth-child(even) .wppb-pricing-list { background: {{data.pricing_content_even}}; }'
			),
			'content_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-pricing-feature',
				'section' => 'Pricing Feature',
				'tab' => 'style',
			),
			'content_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-feature { margin: {{data.content_margin}}; }',
				'section' => 'Pricing Feature',
			),
			'content_border' => array(
				'type' => 'border',
				'title' => 'Border bottom',
				'std' => array(
					'borderWidth' => array( 'bottom' => '1px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#e5e5e5' 
				),
				'tab' => 'style',
				'section' => 'Pricing Feature',
				'selector' => '{{SELECTOR}} .wppb-pricing-list'
			),

			//title
			'title_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Pricing Title',
				'selector' => '{{SELECTOR}} .wppb-pricing-title, {{SELECTOR}} .pricing-layout-two .wppb-pricing-title, {{SELECTOR}} .pricing-layout-one .wppb-pricing-title { color: {{data.title_color}}; }'
			),
			'title_bg' => array(
				'type' => 'color2',
				'title' => __('Background','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#36ADFF',
					'clip' => false,
				),
				'section' => 'Pricing Title',
				'selector' => '{{SELECTOR}} .pricing-layout-two .wppb-pricing-title-wrap,{{SELECTOR}} .pricing-layout-one .wppb-pricing-title-wrap',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'title_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'28px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-pricing-title',
				'section' => 'Pricing Title',
				'tab' => 'style',
			),
			'title_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'unit' => array( 'px','%','em' ),
				'section' => 'Pricing Title',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
				'selector' => '{{SELECTOR}} .wppb-pricing-title-wrap { border-radius: {{data.title_radius}}; }'
			),
			'title_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-title-wrap { padding: {{data.title_padding}}; }',
				'section' => 'Pricing Title',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'title_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-title { margin: {{data.title_margin}}; }',
				'section' => 'Pricing Title',
			),
			
			//sub title
			'pricing_subtitle' => array(
				'type' => 'color',
				'title' => __('Pricing sub Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Pricing Sub title',
				'selector' => '{{SELECTOR}} .wppb-pricing-subtitle,{{SELECTOR}} .pricing-layout-two .wppb-pricing-subtitle, {{SELECTOR}} .pricing-layout-one .wppb-pricing-subtitle { color: {{data.pricing_subtitle}}; }',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'subtitle_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'28px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-pricing-subtitle',
				'section' => 'Pricing Sub title',
				'tab' => 'style',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'subtitle_margin' => array(
				'type' => 'slider',
				'title' => __('Margin bottom','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 25,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 200,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '10px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Pricing Sub title',
				'selector' => '{{SELECTOR}} .wppb-pricing-subtitle { margin-bottom: {{data.subtitle_margin}}; display: block; }',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),	

			//Icon
			'icon_color' => array(
				'type' => 'color',
				'title' => __('Icon','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i { color: {{data.icon_color}}; }'
			),
			'icon_bg' => array(
				'type' => 'color',
				'title' => __('Icon Background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i { background: {{data.icon_bg}}; }'
			),
			'icon_section_bg' => array(
				'type' => 'color2',
				'title' => __('Icon section background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#2399ea',
					'clip' => false,
				),
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon,{{SELECTOR}} .pricing-layout-two .wppb-pricing-table-icon,{{SELECTOR}} .pricing-layout-one .wppb-pricing-table-icon',
				'depends' => array(array('pricing_layout', '!=', array('three'))),
			),
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Icon Size','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 100,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 300,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '20px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i { font-size: {{data.icon_size}}; }'
			),
			'icon_line_height' => array(
				'type' => 'slider',
				'title' => __('Icon line height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 100,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 300,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '60px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i { line-height: {{data.icon_line_height}}; }'
			),
			'icon_width' => array(
				'type' => 'slider',
				'title' => __('Icon Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 300,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '60px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i { width: {{data.icon_width}}; }'
			),
			'icon_height' => array(
				'type' => 'slider',
				'title' => __('Icon Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 300,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '60px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i{ height: {{data.icon_height}}; }'
			),
			'icon_border' => array(
				'type' => 'border',
				'title' => 'Icon Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i'
			),
			'icon_radius' => array(
				'type' => 'dimension',
				'title' => __('Icon border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '100px', 'right' => '100px', 'bottom' => '100px', 'left' => '100px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon i { border-radius: {{data.icon_radius}}; }'
			),
			'icon_section_padding' => array(
				'type' => 'dimension',
				'title' => 'Icon padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-table-icon { padding: {{data.icon_section_padding}}; }',
				'section' => 'Icon',
			),

			//currency symbol
			'pricing_symbol' => array(
				'type' => 'color',
				'title' => __('Currency symbol color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Currency symbol',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-title-currency { color: {{data.pricing_symbol}}; }'
			),
			'currency_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'28px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-title-currency',
				'section' => 'Currency symbol',
				'tab' => 'style',
			),

			//pricing sales	
			'pricing_sales' => array(
				'type' => 'color',
				'title' => __('Pricing sales color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Sales',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-title-sales, {{SELECTOR}} .wppb-pricing-addon-content .wppb-title-sales-wrapper .wppb-title-currency{ color: {{data.pricing_sales}}; }'
			),
			'sales_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'16px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-title-sales',
				'section' => 'Sales',
				'tab' => 'style',
			),
			//pricing text	
			'pricing_color' => array(
				'type' => 'color',
				'title' => __('Pricing text color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Pricing',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-pricing-text { color: {{data.pricing_color}}; }'
			),
			'pricing_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'32px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-pricing-text',
				'section' => 'Pricing',
				'tab' => 'style',
			),	
			'pricing_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-text { margin: {{data.pricing_margin}}; }',
				'section' => 'Pricing',
			),
	
			//pricing priods	
			'period_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Period',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-title-period { color: {{data.period_color}}; }',
			),
			'period_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-title-period',
				'section' => 'Period',
				'tab' => 'style',
			),

			//button	
			'button_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing',
				'section' => 'Button',
				'tab' => 'style',
			),

			'button_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'std'     => '#ffffff',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing { color: {{data.button_color}}; }'
			),

			'button_hcolor' => array(
				'type' => 'color',
				'title' => __('Hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'std'     => '#ffffff',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing:hover { color: {{data.button_hcolor}}; }'
			),

			'button_bg' => array(
				'type' => 'color',
				'title' => __('Background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'std'     => '#36ADFF',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing{ background: {{data.button_bg}}; }'
			),

			'button_hover_bg' => array(
				'type' => 'color',
				'title' => __('Hover background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'std'     => '#0074e6',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing:hover{ background: {{data.button_hover_bg}}; }'
			),
			'button_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing'
			),
			'button_border_hcolor' => array(
				'type' => 'border',
				'title' => 'Border hover',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing:hover'
			),
			'button_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing { border-radius: {{data.button_radius}}; }'
			),
			'button_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing { padding: {{data.button_padding}}; }',
				'section' => 'Button',
			),
			'button_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content .wppb-btn-pricing { margin: {{data.button_margin}}; }',
				'section' => 'Button',
			),
			'button_display' => array(
				'type' => 'select',
				'title' => __('Button display','wp-pagebuilder'),
				'values' => array(
					'btnblock' => __('Block','wp-pagebuilder'),
					'btninlineblock' => __('Inline Block','wp-pagebuilder'),
					'btninline' => __('Inline','wp-pagebuilder'),
				),
				'std' => 'btninlineblock',
				'tab' => 'style',
				'section' => 'Button',
			),
			//Additional	
			'addition_text' => array(
				'type' => 'color',
				'title' => __('Text color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Addition Info',
				'selector' => '{{SELECTOR}} .wppb-title-aditional-info { color: {{data.addition_text}}; }',
			),
			'addition_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-title-aditional-info',
				'section' => 'Addition Info',
				'tab' => 'style',
			),

			//wrap
			'wrap_background' => array(
				'type' => 'background',
				'title' => '',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content',
				'tab' => 'style',
				'section' => 'Price Wrapper',
			),
			'wrap_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Price Wrapper',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content'
			),
			'wrap_border_hcolor' => array(
				'type' => 'color',
				'title' => __('hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Price Wrapper',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content:hover{ border-color: {{data.button_border_hcolor}}; }'
			),
			'wrap_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'unit' => array( 'px','%','em' ),
				'section' => 'Price Wrapper',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content { border-radius: {{data.wrap_radius}}; }'
			),
			'wrap_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content { padding: {{data.wrap_padding}}; }',
				'section' => 'Price Wrapper',
			),
			'wrap_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-addon-content { margin: {{data.wrap_margin}}; }',
				'section' => 'Price Wrapper',
			),

			//two title wrap
			'two_title_background' => array(
				'type' => 'background',
				'title' => '',
				'selector' => '{{SELECTOR}} .wppb-pricing-content-one,{{SELECTOR}} .wppb-pricing-content-two',
				'tab' => 'style',
				'section' => 'Content wrap',
				'depends' => array(array('pricing_layout', '=', array('one','two'))),
			),
			'two_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Content wrap',
				'selector' => '{{SELECTOR}} .wppb-pricing-content-one, {{SELECTOR}} .wppb-pricing-content-two',
				'depends' => array(array('pricing_layout', '=', array('one','two'))),
			),
			'two_border_hcolor' => array(
				'type' => 'color',
				'title' => __('hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Content wrap',
				'selector' => '{{SELECTOR}} .wppb-pricing-content-one:hover, {{SELECTOR}} .wppb-pricing-content-two:hover{ border-color: {{data.button_border_hcolor}}; }',
				'depends' => array(array('pricing_layout', '=', array('one','two'))),
			),
			'two_title_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'unit' => array( 'px','%','em' ),
				'section' => 'Content wrap',
				'depends' => array(array('pricing_layout', '=', array('one','two'))),
				'selector' => '{{SELECTOR}} .wppb-pricing-content-one,{{SELECTOR}} .wppb-pricing-content-two { border-radius: {{data.two_title_radius}}; }'
			),
			'two_title_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-pricing-content-one, {{SELECTOR}} .wppb-pricing-content-two { padding: {{data.two_title_padding}}; }',
				'section' => 'Content wrap',
				'depends' => array(array('pricing_layout', '=', array('one','two'))),
			),
		);

		return $settings;
	}

	// Pricing Render HTML
	public function render($data = null){
		$settings 			= $data['settings'];

		$title 				= isset($settings["title"]) ? $settings["title"] : '';
		$subtitle 			= isset($settings["subtitle"]) ? $settings["subtitle"] : '';
		$pt_icon_list 		= isset($settings["pt_icon_list"]) ? $settings["pt_icon_list"] : '';
		$pricing 			= isset($settings["pricing"]) ? $settings["pricing"] : '';
		$sales 				= isset($settings["sales"]) ? $settings["sales"] : '';
		$currency 			= isset($settings["currency"]) ? $settings["currency"] : '';
		$period 			= isset($settings["period"]) ? $settings["period"] : '';
		$aditional_info 	= isset($settings["aditional_info"]) ? $settings["aditional_info"] : '';
		$btn_link 			= isset($settings["btn_link"]) ? $settings["btn_link"] : array();
		$button_text 		= isset($settings["button_text"]) ? $settings["button_text"] : '';
		$icon_list 			= isset($settings["icon_list"]) ? $settings["icon_list"] : '';
		$icon_position 		= isset($settings["icon_position"]) ? $settings["icon_position"] : '';
		$pricing_feature 	= isset($settings["pricing_feature"]) ? $settings["pricing_feature"] : array();
		$pricing_layout 	= isset($settings["pricing_layout"]) ? $settings["pricing_layout"] : '';
		$button_display 	= isset($settings["button_display"]) ? $settings["button_display"] : 'btnblock';

		$output = $button = $data_pt_media = '';

		if( $pt_icon_list ){
			$data_pt_media  .= '<div class="wppb-pricing-table-icon">';
			$data_pt_media  .= '<i class="' . esc_attr($pt_icon_list) . '"></i>';
			$data_pt_media  .= '</div>';
		}
		if( $icon_position == 'left' ) {
			$button = (esc_attr($icon_list)) ? '<i class="' . esc_attr($icon_list) . '"></i> ' . esc_attr($button_text) : esc_attr($button_text);
		} elseif( $icon_position == 'right' ){
			$button = (esc_attr($icon_list)) ? esc_attr($button_text) . ' <i class="' . esc_attr($icon_list) . '"></i>' : esc_attr($button_text);
		} else {
			$button = (esc_attr($icon_list)) ? esc_attr($button_text) : esc_attr($button_text);
		}
		$target = !empty($btn_link['window']) ? "_blank" : "_self";
		$nofolow = ! empty($btn_link['nofolow']) ? 'rel="nofollow"' : " ";

		$output  .= '<div class="wppb-pricing-addon">';
			$output  .= '<div class="wppb-pricing-addon-content pricing-layout-'.esc_attr($pricing_layout).'">';
				
				if( $pricing_layout == "two" ){
					$output  .= '<div class="wppb-pricing-content-two">';
						if( !empty($title) ){
							$output  .= '<div class="wppb-pricing-title-wrap">';
								if( !empty($title) ){
									$output  .= '<h3 class="wppb-pricing-title">'.wp_kses_post($title).'</h3>';
								}
								if( !empty($subtitle) ){	
									$output  .= '<span class="wppb-pricing-subtitle">'.wp_kses_post($subtitle).'</span>';
								}
								if( !empty($pricing) || !empty($sales) || !empty($currency) || !empty($period) ){
									$output  .= '<div class="wppb-pricing-content">';	
										if( !empty($pricing) ){
											$output  .= '<div class="wppb-pricing-text-wrapper">';
												if( !empty($sales) ){
													$output  .= '<span class="wppb-title-sales-wrapper">';
														if( !empty($currency) ){
															$output  .= '<span class="wppb-title-currency">'.esc_attr($currency).'</span>';
														}
														$output  .= '<span class="wppb-title-sales">'.esc_attr($sales).'</span>';
														$output  .= '</span>';
												}
												if( !empty($currency) ){
													$output  .= '<sup><span class="wppb-title-currency">'.esc_attr($currency).'</span></sup>';
												}
												if( !empty($pricing) ){
													$output  .= '<span class="wppb-pricing-text">'.$pricing.'</span>';
												}
												if( !empty($period) ){
													$output  .= '<sub class="wppb-title-period">'.esc_attr($period).'</sub>';
												}
											$output  .= '</div>';
										}
									$output  .= '</div>';
								}
							$output  .= '</div>';	
						}
						$output  .= $data_pt_media;

						if ( is_array($pricing_feature) && count($pricing_feature)){
							$output  .= '<div class="wppb-pricing-feature">';
							foreach ( $pricing_feature as $key => $value ) {
								$output  .= '<div class="repeater-'.$key.'">';
									$output  .= '<div class="wppb-pricing-list">';
									if( ! empty( $value['icon_list'] ) ) {
										$output  .= '<i class="'.$value['icon_list'].'"></i>';
									}
									if( ! empty( $value['feature_text'] ) ) {
										$output  .= '<span>'.$value['feature_text'].'</span>';
									}
									$output  .= '</div>';
								$output  .= '</div>';
							}
							$output  .= '</div>';
						}
	
						if( !empty($btn_link['link']) ) {
							$output  .= '<a class="wppb-btn-pricing wppb-'.esc_attr($button_display).'" '.$nofolow.' href="' . esc_url($btn_link['link']) . '" target="'.esc_attr($target).'">' . $button  . '</a>';
						}
	
						if( !empty($aditional_info) ){
							$output  .= '<span class="wppb-title-aditional-info">'.wp_kses_post($aditional_info).'</span>';
						}

					$output  .= '</div>';//wppb-pricing-content-two

				} elseif ( $pricing_layout == "three" ) {

					if( !empty($title) || !empty($subtitle) ){
						$output  .= '<div class="wppb-pricing-title-wrap">';
							if( !empty($title) ){
								$output  .= '<h3 class="wppb-pricing-title">'.wp_kses_post($title).'</h3>';
							}
							$output  .= '</div>';
					}

					if( !empty($pricing) || !empty($sales) || !empty($currency) || !empty($period) ){
						$output  .= '<div class="wppb-pricing-content">';	

							if( !empty($pricing) ){
								$output  .= '<div class="wppb-pricing-text-wrapper">';
									if( !empty($sales) ){
										$output  .= '<span class="wppb-title-sales-wrapper">';
											if( !empty($currency) ){
												$output  .= '<span class="wppb-title-currency">'.esc_attr($currency).'</span>';
											}
											$output  .= '<span class="wppb-title-sales">'.esc_attr($sales).'</span>';
											$output  .= '</span>';
									}

									if( !empty($currency) ){
										$output  .= '<sup><span class="wppb-title-currency">'.esc_attr($currency).'</span></sup>';
									}
									if( !empty($pricing) ){
										$output  .= '<span class="wppb-pricing-text">'.$pricing.'</span>';
									}
									if( !empty($period) ){
										$output  .= '<sub class="wppb-title-period">'.esc_attr($period).'</sub>';
									}
								$output  .= '</div>';
							}
						$output  .= '</div>';
					}

					if ( is_array($pricing_feature) && count($pricing_feature)){
						$output  .= '<div class="wppb-pricing-feature">';
							foreach ( $pricing_feature as $key => $value ) {
								$output  .= '<div class="repeater-'.$key.'">';
									$output  .= '<div class="wppb-pricing-list">';
									if( ! empty( $value['icon_list'] ) ) {
										$output  .= '<i class="'.$value['icon_list'].'"></i>';
									}
									if( ! empty( $value['feature_text'] ) ) {
										$output  .= '<span>'.$value['feature_text'].'</span>';
									}
									$output  .= '</div>';
								$output  .= '</div>';
							}
						$output  .= '</div>';
					}

					if( !empty($btn_link['link']) ) {
						$output  .= '<a class="wppb-btn-pricing  wppb-'.esc_attr($button_display).'" '.$nofolow.' href="' . esc_url($btn_link['link']) . '" target="'.esc_attr($target).'">' . $button  . '</a>';
					}

					if( !empty($aditional_info) ){
						$output  .= '<span class="wppb-title-aditional-info">'.wp_kses_post($aditional_info).'</span>';
					}

				} else {
					$output  .= '<div class="wppb-pricing-content-one">';
						if( !empty($title) ){
							$output  .= '<div class="wppb-pricing-title-wrap">';
								if( !empty($title) ){
									$output  .= '<h3 class="wppb-pricing-title">'.wp_kses_post($title).'</h3>';
								}
								if( !empty($subtitle) ){	
									$output  .= '<span class="wppb-pricing-subtitle">'.wp_kses_post($subtitle).'</span>';
								}
								$output  .= '</div>';
						}

						$output  .= $data_pt_media;

						if( !empty($pricing) || !empty($sales) || !empty($currency) || !empty($period) ){
							$output  .= '<div class="wppb-pricing-content">';	

								if( !empty($pricing) ){
									$output  .= '<div class="wppb-pricing-text-wrapper">';
										if( !empty($sales) ){
											$output  .= '<span class="wppb-title-sales-wrapper">';
												if( !empty($currency) ){
													$output  .= '<span class="wppb-title-currency">'.esc_attr($currency).'</span>';
												}
												$output  .= '<span class="wppb-title-sales">'.esc_attr($sales).'</span>';
												$output  .= '</span>';
										}

										if( !empty($currency) ){
											$output  .= '<sup><span class="wppb-title-currency">'.esc_attr($currency).'</span></sup>';
										}
										if( !empty($pricing) ){
											$output  .= '<span class="wppb-pricing-text">'.$pricing.'</span>';
										}
										if( !empty($period) ){
											$output  .= '<sub class="wppb-title-period">'.esc_attr($period).'</sub>';
										}
									$output  .= '</div>';
								}
							$output  .= '</div>';
						}
						if ( isset($pricing_feature) && count($pricing_feature)){
							$output  .= '<div class="wppb-pricing-feature">';
							foreach ( $pricing_feature as $key => $value ) {
								$output  .= '<div class="repeater-'.$key.'">';
									$output  .= '<div class="wppb-pricing-list">';
									if( ! empty( $value['icon_list'] ) ) {
										$output  .= '<i class="'.$value['icon_list'].'"></i>';
									}
									if( ! empty( $value['feature_text'] ) ) {
										$output  .= '<span>'.$value['feature_text'].'</span>';
									}
									$output  .= '</div>';
								$output  .= '</div>';
							}
							$output  .= '</div>';
						}

						if( !empty($btn_link['link']) ) {
							$output  .= '<a class="wppb-btn-pricing  wppb-'.esc_attr($button_display).'" '.$nofolow.' href="' . esc_url($btn_link['link']) . '" target="'.esc_attr($target).'">' . $button  . '</a>';
						}

						if( !empty($aditional_info) ){
							$output  .= '<span class="wppb-title-aditional-info">'.wp_kses_post($aditional_info).'</span>';
						}
					$output .= '</div>';	
				}
			$output  .= '</div>';
		$output  .= '</div>';

		return $output;
	}

	// headline Template
	public function getTemplate(){
		$output = '
		<#
			var data_pt_media = "";
			if( data.pt_icon_list ){
				data_pt_media  += "<div class=\'wppb-pricing-table-icon\'>";
				data_pt_media  += "<i class=\' "+data.pt_icon_list+"\'></i>";
				data_pt_media  += "</div>";
			}
			if(data.featured_check == "1"){
				featured_check = "wppb-pricing-featured";
			} else {
				featured_check = "";
			}
		#>
		
		<div class="wppb-pricing-addon">
			<div class="wppb-pricing-addon-content pricing-layout-{{data.pricing_layout}}">

				<# if( data.pricing_layout == "two" ){ #>
					<div class="wppb-pricing-content-two">
						<div class="wppb-pricing-title-wrap">
							<# if( !_.isEmpty(data.title) ){ #>	
								<h3 class="wppb-pricing-title">{{data.title}}</h3>
							<# } #>
							<# if( !_.isEmpty(data.subtitle) ){ #>	
								<span class="wppb-pricing-subtitle">{{data.subtitle}}</span>
							<# } #>
							<# if( !_.isEmpty(data.pricing) || !_.isEmpty(data.currency) ){ #>
								<div class="wppb-pricing-content">			
									<# if( !_.isEmpty(data.pricing) ){ #>
										<div class="wppb-pricing-text-wrapper">
											<# if( !_.isEmpty(data.sales) ){ #>
												<span class="wppb-title-sales-wrapper">
													<# if( !_.isEmpty(data.currency) ){ #>
														<span class="wppb-title-currency">{{data.currency}}</span>
													<# } #>
													<span class="wppb-title-sales">{{data.sales}}</span>
												</span>
											<# } #>
											<# if( !_.isEmpty(data.currency) ){ #>
												<sup><span class="wppb-title-currency">{{data.currency}}</span></sup>
											<# } #>
											<# if( !_.isEmpty(data.pricing) ){ #>
											<span class="wppb-pricing-text">{{data.pricing}}</span>
											<# } #>
											<# if( !_.isEmpty(data.period) ){ #>
												<sub class="wppb-title-period">{{data.period}}</sub>
											<# } #>
										</div>
									<# } #>
								</div>
							<# } #>
						</div>	
						{{{data_pt_media}}}

					<div class="wppb-pricing-feature">
						<#  _.forEach(data.pricing_feature, function(value, key) { #>
							<div class="repeater-{{key}}"><div class="wppb-pricing-list"><i class=" {{value.icon_list}}"></i><span>{{value.feature_text}}</span></div></div>
						<# }); #>
					</div>
	
					<# if( data.btn_link.link ){ #>	
						<a class="wppb-btn-pricing wppb-{{ data.button_display }}" {{ data.btn_link.nofolow ? "rel=\"nofollow\"" : "" }} href="{{data.btn_link.link}}" target="{{data.btn_link.window ? "_blank" : "_self"}}">
						<# if(data.icon_position == "left" && !_.isEmpty(data.icon_list)) { #><i class=" {{ data.icon_list }}"></i> <# } #>{{data.button_text}}<# if(data.icon_position == "right" && !_.isEmpty(data.icon_list)) { #> <i class=" {{ data.icon_list }}"></i><# } #>
						</a>
					<# } #>
	
					<# if( !_.isEmpty(data.aditional_info) ){ #>
						<span class="wppb-title-aditional-info">{{data.aditional_info}}</span>
					<# } #>
						
				</div>	

			<# } else if( data.pricing_layout == "three" ){ #>

					<div class="wppb-pricing-title-three">
						<# if( !_.isEmpty(data.title) ){ #>	
							<h3 class="wppb-pricing-title">{{data.title}}</h3>
						<# } #>
					</div>

					<# if( !_.isEmpty(data.pricing) || !_.isEmpty(data.currency) ){ #>
						<div class="wppb-pricing-content">			
							<# if( !_.isEmpty(data.pricing) ){ #>
								<div class="wppb-pricing-text-wrapper">
									<# if( !_.isEmpty(data.sales) ){ #>
										<span class="wppb-title-sales-wrapper">
											<# if( !_.isEmpty(data.currency) ){ #>
												<span class="wppb-title-currency">{{data.currency}}</span>
											<# } #>
											<span class="wppb-title-sales">{{data.sales}}</span>
										</span>
									<# } #>
									<# if( !_.isEmpty(data.currency) ){ #>
										<sup><span class="wppb-title-currency">{{data.currency}}</span></sup>
									<# } #>
									<# if( !_.isEmpty(data.pricing) ){ #>
									<span class="wppb-pricing-text">{{data.pricing}}</span>
									<# } #>
									<# if( !_.isEmpty(data.period) ){ #>
										<sub class="wppb-title-period">{{data.period}}</sub>
									<# } #>
								</div>
							<# } #>
						</div>
					<# } #>

					<div class="wppb-pricing-feature">
						<#  _.forEach(data.pricing_feature, function(value, key) { #>
							<div class="repeater-{{key}}"><div class="wppb-pricing-list"><i class=" {{value.icon_list}}"></i><span>{{value.feature_text}}</span></div></div>
						<# }); #>
					</div>

					<# if( data.btn_link.link ){ #>	
						<a class="wppb-btn-pricing wppb-{{ data.button_display }}" {{ data.btn_link.nofolow ? "rel=\"nofollow\"" : "" }} href="{{data.btn_link.link}}" target="{{data.btn_link.window ? "_blank" : "_self"}}">
						<# if(data.icon_position == "left" && !_.isEmpty(data.icon_list)) { #><i class=" {{ data.icon_list }}"></i> <# } #>{{data.button_text}}<# if(data.icon_position == "right" && !_.isEmpty(data.icon_list)) { #> <i class=" {{ data.icon_list }}"></i><# } #>
						</a>
					<# } #>

					<# if( !_.isEmpty(data.aditional_info) ){ #>
						<span class="wppb-title-aditional-info">{{data.aditional_info}}</span>
					<# } #>

				<# } else { #>
					<div class="wppb-pricing-content-two">
						<div class="wppb-pricing-title-wrap">
							<# if( !_.isEmpty(data.title) ){ #>	
								<h3 class="wppb-pricing-title">{{data.title}}</h3>
							<# } #>
							<# if( !_.isEmpty(data.subtitle) ){ #>	
								<span class="wppb-pricing-subtitle">{{data.subtitle}}</span>
							<# } #>
						</div>

						{{{data_pt_media}}}

						<# if( !_.isEmpty(data.pricing) || !_.isEmpty(data.currency) ){ #>
							<div class="wppb-pricing-content">			
								<# if( !_.isEmpty(data.pricing) ){ #>
									<div class="wppb-pricing-text-wrapper">
										<# if( !_.isEmpty(data.sales) ){ #>
											<span class="wppb-title-sales-wrapper">
												<# if( !_.isEmpty(data.currency) ){ #>
													<span class="wppb-title-currency">{{data.currency}}</span>
												<# } #>
												<span class="wppb-title-sales">{{data.sales}}</span>
											</span>
										<# } #>
										<# if( !_.isEmpty(data.currency) ){ #>
											<sup><span class="wppb-title-currency">{{data.currency}}</span></sup>
										<# } #>
										<# if( !_.isEmpty(data.pricing) ){ #>
										<span class="wppb-pricing-text">{{data.pricing}}</span>
										<# } #>
										<# if( !_.isEmpty(data.period) ){ #>
											<sub class="wppb-title-period">{{data.period}}</sub>
										<# } #>
									</div>
								<# } #>
							</div>
						<# } #>

						<div class="wppb-pricing-feature">
							<#  _.forEach(data.pricing_feature, function(value, key) { #>
								<div class="repeater-{{key}}"><div class="wppb-pricing-list"><i class=" {{value.icon_list}}"></i><span>{{value.feature_text}}</span></div></div>
							<# }); #>
						</div>

						<# if( data.btn_link.link ){ #>	
							<a class="wppb-btn-pricing wppb-{{ data.button_display }}" {{ data.btn_link.nofolow ? "rel=\"nofollow\"" : "" }} href="{{data.btn_link.link}}" target="{{data.btn_link.window ? "_blank" : "_self"}}">
							<# if(data.icon_position == "left" && !_.isEmpty(data.icon_list)) { #><i class=" {{ data.icon_list }}"></i> <# } #>{{data.button_text}}<# if(data.icon_position == "right" && !_.isEmpty(data.icon_list)) { #> <i class=" {{ data.icon_list }}"></i><# } #>
							</a>
						<# } #>

						<# if( !_.isEmpty(data.aditional_info) ){ #>
							<span class="wppb-title-aditional-info">{{data.aditional_info}}</span>
						<# } #>
					</div>	
				<# } #>	
				</div>
			</div>
		';
		return $output;
	}
}