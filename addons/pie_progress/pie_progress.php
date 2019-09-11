<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Pie_Progress{

	public function get_name(){
		return 'wppb_pie_progress';
	}
	public function get_title(){
		return 'Pie Progress';
	}
	public function get_icon() {
		return 'wppb-font-pie-progress';
	}
	public function get_enqueue_script(){
		return array( 'jquery.easypiechart','jquery.inview' );
	}
	
	// Pie Progress Settings Fields
	public function get_settings() {

		$settings = array(
			'show_icon_title' => array(
				'type' => 'radioimage',
				'title' => 'Layout',
				'values'=> array(
					'0' =>  WPPB_DIR_URL.'addons/pie_progress/img/pie-img1.png',
					'1' =>  WPPB_DIR_URL.'addons/pie_progress/img/pie-img2.png',
					'2' =>  WPPB_DIR_URL.'addons/pie_progress/img/pie-img3.png',
				),
				'std' => '0',
			),

			'progress_percentage' => array(
				'type' => 'slider',
				'title' => __('Percentage','wp-pagebuilder'),
				'std' => 75,
				'responsive' => false,
				'range' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
				),
			),
			'progress_size' => array(
				'type' => 'slider',
				'title' => __('Bar size','wp-pagebuilder'),
				'std' => 150,
				'responsive' => false,
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 40,
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
				'selector' => '{{SELECTOR}} .wppb-pie-chart { height: {{data.progress_size}}px; width: {{data.progress_size}}px; }',
			),
			'progress_width' => array(
				'type' => 'slider',
				'title' => __('Border width','wp-pagebuilder'),
				'responsive' => false,
				'range' => array(
					'min' => 0,
					'max' => 20,
					'step' => 1,
				),
			),
			'progress_title' => array(
				'type' => 'text',
				'title' => __('Title','wp-pagebuilder'),
				'std' => 'WordPress',
				'depends' => array(array('show_icon_title', '=', '1')),
			),
			'icon_list' => array(
				'type' => 'icon',
				'title' => __('Icon list','wp-pagebuilder'),
				'std' => 'fas fa-star',
				'depends' => array(array('show_icon_title', '=', '2')),
			),

			'align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'std' => array( 'md' => 'center', 'sm' => 'center', 'xs' => 'center' ),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-pie-progress-addon-content { text-align: {{data.align}}; }'
			),

			//style
			'progress_bar' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'std'=> '#F1F8FF',
			),
			'progress_bar_active' => array(
				'type' => 'color',
				'title' => __('Active color','wp-pagebuilder'),
				'tab' => 'style',
				'std'=> '#22A1FB',
			),
			'title_color' => array(
				'type' => 'color2',
				'title' => '',
				'tab' => 'style',
				'clip' => true,
				'std' => array(
					'clip' => true,
					'colorType' => 'color',
					'colorColor' => '#333',
				),
				'section' => 'Title and Percentage',
				'selector' => '{{SELECTOR}} .wppb-chart-title, {{SELECTOR}} .wppb-pie-chart .wppb-chart-percent'
			),
			'title_style' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'16px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '600',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'section' => 'Title and Percentage',
				'selector' => '{{SELECTOR}} .wppb-chart-title, {{SELECTOR}} .wppb-pie-chart .wppb-chart-percent',
				'tab' => 'style',
			),

			// icon
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Size','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
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
				'std' => array(
						'md' => '20px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-chart-icon i { font-size: {{data.icon_size}}; }'
			),
			'icon_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-chart-icon span i{ color: {{data.icon_color}}; }'
			),
			'icon_bg' => array(
				'type' => 'color',
				'title' => __('background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-chart-icon span i{ background: {{data.icon_bg}}; }'
			),
			'icon_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
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
						'md' => '50px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-chart-icon span i{ width: {{data.icon_width}}; }'
			),
			'icon_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
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
						'md' => '50px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => array(
					'{{SELECTOR}} .wppb-chart-icon span i{ height: {{data.icon_height}}; }',
					'{{SELECTOR}} .wppb-chart-icon i { line-height: {{data.icon_height}}; }',
				)
			),
			'icon_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '100px', 'right' => '100px', 'bottom' => '100px', 'left' => '100px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}}  .wppb-chart-icon span i{ border-radius: {{data.icon_radius}}; }'
			),
		);

		return $settings;
	}


	// Pie Progress Render HTML
	public function render($data = null){
		$settings 				= $data['settings'];

		$progress_percentage 	= isset($settings['progress_percentage']) ? $settings['progress_percentage'] : '';
		$progress_size 			= isset($settings['progress_size']) ? $settings['progress_size'] : '';
		$progress_width  		= isset($settings['progress_width']) ? $settings['progress_width'] : '';
		$show_icon_title 		= isset($settings['show_icon_title']) ? $settings['show_icon_title'] : 1;
		$icon_list 				= isset($settings['icon_list']) ? $settings['icon_list'] : '';
		$progress_title 		= isset($settings['progress_title']) ? $settings['progress_title'] : '';
		$progress_bar 			= isset($settings['progress_bar']) ? $settings['progress_bar'] : '';
		$progress_bar_active 	= isset($settings['progress_bar_active']) ? $settings['progress_bar_active'] : '';

		$output = '';

		if ( is_array ($progress_size ) ) {
			$progress_size =  ( isset($progress_size['md'] ) && $progress_size['md'] ) ? $progress_size['md']  : 150;
		} else {
			$progress_size = (isset($progress_size) && $progress_size) ? $progress_size : 150;;
		}

		if ( is_array ( $progress_percentage ) ) {
			$progress_percentage = (isset($progress_percentage['md']) && $progress_percentage['md']) ? $progress_percentage['md'] : 75;
		} else {
			$progress_percentage = (isset($progress_percentage) && $progress_percentage) ? $progress_percentage : 75;
		}

		if ( is_array ( $progress_width ) ) {
			$progress_width = (isset($progress_width['md']) && $progress_width['md']) ? $progress_width['md'] : 5;
		} else {
			$progress_width = (isset($progress_width) && $progress_width) ? $progress_width : 5;
		}

		$output  .= '<div class="wppb-pie-progress-addon">';
			$output  .= '<div class="wppb-pie-progress-addon-content wppb-clearfix">';

				$output .= '<div class="wppb-pie-chart" data-size="'. (int) $progress_size .'" data-percent="'.$progress_percentage.'" data-width="'.$progress_width.'" data-barcolor="'.$progress_bar_active.'" data-trackcolor="'.$progress_bar.'">';

					if( $show_icon_title == 1 ) {
						if( $progress_title ) {
							$output .= '<div class="wppb-chart-title"><span>'.esc_attr($progress_title).'</span></div>';
						}
					} elseif ( $show_icon_title == 2 ) {
						if( $icon_list ) {
							$output .= '<div class="wppb-chart-icon"><span><i class="'.esc_attr($icon_list).'"></i></span></div>';
						}
					} else {
						$output .= '<div class="wppb-chart-percent"><span></span></div>';
					}

				$output .= '</div>';

			$output .= '</div>';//wppb-pie-progress-addon-content
		$output .= '</div>';//wppb-pie-progress-addon 

		return $output;
	}

	// Pie Progress Template
	public function getTemplate(){
		$output = '
		<#
		var progress_size;
		if(_.isObject(data.progress_size) ){
			progress_size = parseInt(data.progress_size.md) ;
		}else{
			progress_size =  parseInt(data.progress_size) ? parseInt(data.progress_size) : "150";;
		}

		var progress_percentage;
		if(_.isObject(data.progress_percentage) ){
			progress_percentage = parseInt(data.progress_percentage.md) ;
		}else{
			progress_percentage =  parseInt(data.progress_percentage) ? parseInt(data.progress_percentage) : "75";
		}

		var progress_width;
		if(_.isObject(data.progress_width) ){
			progress_width = parseInt(data.progress_width.md) ;
		}else{
			progress_width = parseInt(data.progress_width) ? parseInt(data.progress_width) : "5";;
		}

		#>
			<div class="wppb-pie-progress-addon">
				<div class="wppb-pie-progress-addon-content wppb-clearfix">

				<div class="wppb-pie-chart" data-size="{{progress_size}}" data-percent="{{progress_percentage}}" data-width="{{progress_width}}" data-barcolor="{{data.progress_bar_active}}" data-trackcolor="{{data.progress_bar}}">
				
					<#
					if( data.show_icon_title == 1 ) {
						if( data.progress_title ) { #>
							<div class="wppb-chart-title"><span>{{data.progress_title}}</span></div>
						<# }
					} else if ( data.show_icon_title == 2 ) {
						if(data.icon_list) { #>
							<div class="wppb-chart-icon"><span><i class="{{data.icon_list}}"></i></span></div>
						<# }
					} else { #>
						<div class="wppb-chart-percent"><span></span></div>
					<# } #>
					
				</div>

				</div>
			</div>
		';
		return $output;
	}
}