<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Progress_Bar{

	public function get_name(){
		return 'wppb_progress_bar';
	}
	public function get_title(){
		return 'Progress Bar';
	}
	public function get_icon() {
		return 'wppb-font-progress-bar';
	}

	// Progress bar Settings Fields
	public function get_settings() {

		$settings = array(
			'progress_layout' => array(
				'type' => 'radioimage',
				'title' => 'Layout',
				'values'=> array(
					'one' =>  WPPB_DIR_URL.'addons/progress_bar/img/progress-img1.png',
					'two' =>  WPPB_DIR_URL.'addons/progress_bar/img/progress-img2.png',
					'three' =>  WPPB_DIR_URL.'addons/progress_bar/img/progress-img3.png',
				),
				'std' => 'one',
			),
			'title' => array(
				'type' => 'text',
				'title' => __('Title','wp-pagebuilder'),
				'std' => 'WordPress'
			),
			'progress_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'range' => array(
					'min' => 0,
					'max' => 100,
					'step' => 1,
				),
				'std' => '50',
				'responsive' => false,
			),
			'progress_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'range' => array(
					'min' => 5,
					'max' => 100,
					'step' => 1,
				),
				'std' => '20',
				'responsive' => false,
				'depends' => array(array('progress_layout', '!=', array('three'))),
				'selector' => '{{SELECTOR}} .wppb-progress{ height: {{data.progress_height}}px; }'
			),
			'stripped' => array(
				'type' => 'switch',
				'title' => __('Show Striped','wp-pagebuilder'),
				'std' => '0'
			),
			'show_title' => array(
				'type' => 'switch',
				'title' => __('Show title','wp-pagebuilder'),
				'std' => '1'
			),
			'show_percent' => array(
				'type' => 'switch',
				'title' => __('Show percentage','wp-pagebuilder'),
				'std' => '1'
			),			

			//style
			'border_radius' => array(
				'type' => 'dimension',
				'title' => __('Border Radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-progress { border-radius: {{data.border_radius}}; }'
			),
			'overlay_radius' => array(
				'type' => 'dimension',
				'title' => __('Overlay Radius','wp-pagebuilder'),
				'unit' => array( 'px','em','%' ),
				'std' => array(
					'md' => array( 'top' => '4px', 'right' => '4px', 'bottom' => '4px', 'left' => '4px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-progress-bar { border-radius: {{data.overlay_radius}}; }'
			),
			'style' => array(
				'type' => 'select',
				'title' => 'Select Style',
				'values' => array(
					'primary' => __('Primary','wp-pagebuilder'),
					'success' => __('Success','wp-pagebuilder'),
					'info' => __('Info','wp-pagebuilder'),
					'warning' => __('Warning','wp-pagebuilder'),
					'danger' => __('Danger','wp-pagebuilder'),
					'light' => __('Light','wp-pagebuilder'),
					'dark' => __('Dark','wp-pagebuilder'),
					'custom' => __('Custom','wp-pagebuilder'),
				),
				'std' => 'primary',
				'tab' => 'style',
				'section' => 'Style',
			),
			'progress_bg' => array(
				'type' => 'color2',
				'title' => __('Custom background color','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#f5f5f5',
					'clip' => false,
				),
				'selector' => '{{SELECTOR}} .wppb-progress',
				'depends' => array(array('style', '=', array('custom'))),
				'section' => 'Style',
			),
			'progress_bg_overlay' => array(
				'type' => 'color2',
				'title' => __('Custom overlay background','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#3D88E4',
					'clip' => false,
				),
				'selector' => '{{SELECTOR}} .wppb-progress-bar',
				'depends' => array(array('style', '=', array('custom'))),
				'section' => 'Style',
			),

			//title
			'title_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => true,
				'std' => array(
					'clip' => true,
					'colorType' => 'color',
					'colorColor' => '#333',
				),
				'section' => 'Title',
				'selector' => '{{SELECTOR}} .wppb-progress-label'
			),

			'font_fontstyle' => array(
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
				'section' => 'Title',
				'selector' => '{{SELECTOR}} .wppb-progress-label',
				'tab' => 'style',
			),
			'title_margin_bottom' => array(
				'type' => 'slider',
				'title' => __('Margin bottom','wp-pagebuilder'),
				'range' => array(
					'min' => 0,
					'max' => 150,
					'step' => 1,
				),
				'std' => 4,
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Title',
				'selector' => '{{SELECTOR}} .wppb-progress-label { margin-bottom: {{data.title_margin_bottom}}px; }'
			),

			//Percentage
			'percent_text_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'clip' => true,
				'tab' => 'style',
				'std' => array(
					'clip' => true,
					'colorType' => 'color',
					'colorColor' => '#333',
				),
				'section' => 'Percentage',
				'selector' => '{{SELECTOR}} .wppb-progress-percent, {{SELECTOR}} .progressbar-layout-two .wppb-progress-bar span, {{SELECTOR}} .progressbar-layout-three .wppb-progress-bar span'
			),
			'percent_text_bg' => array(
				'type' => 'color',
				'title' => __('Box Background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Percentage',
				'depends' => array(array('progress_layout', '=', array('three'))),
				'selector' => array(
					'{{SELECTOR}} .progressbar-layout-three .wppb-progress-bar span { background: {{data.percent_text_bg}}; }',
					'{{SELECTOR}} .progressbar-layout-three .wppb-progress-bar span:after { border-color: {{data.percent_text_bg}} rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) rgba(0, 0, 0, 0); }',
				),
			),
			'percent_fontstyle' => array(
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
				'section' => 'Percentage',
				'selector' => '{{SELECTOR}} .wppb-progress-percent',
				'tab' => 'style',
			),
			'percent_margin_bottom' => array(
				'type' => 'slider',
				'title' => __('Margin bottom','wp-pagebuilder'),
				'range' => array(
					'min' => -80,
					'max' => 100,
					'step' => 1,
				),
				'std' => 4,
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Percentage',
				'selector' => array(
					'{{SELECTOR}} .wppb-progress-percent { margin-bottom: {{data.percent_margin_bottom}}px; }',
					'{{SELECTOR}} .progressbar-layout-one .wppb-progress-bar span { top: {{data.percent_margin_bottom}}px; }',
				)
			),
		);

		return $settings;
	}


	// Progress bar Render HTML
	public function render($data = null){
		$settings 			= $data['settings'];

		$title 				= isset($settings['title']) ? $settings['title'] : '';
		$progress_width  	= isset($settings['progress_width']) ? $settings['progress_width'] : '';
		$style 				= isset($settings['style']) ? $settings['style'] : '';
		$stripped 			= isset($settings['stripped']) ? $settings['stripped'] : '';
		$show_title 		= isset($settings['show_title']) ? $settings['show_title'] : '';
		$show_percent 		= isset($settings['show_percent']) ? $settings['show_percent'] : '';
		$progress_layout 	= isset($settings['progress_layout']) ? $settings['progress_layout'] : '';

		$output = $show_percent_content = $show_title_content = '';

		$stripped = (isset($stripped) && $stripped) ? $stripped : 0;
		$progress_width = (isset($progress_width) && $progress_width) ? $progress_width : 50;
		if($stripped){
			$stripped = 'wppb-progress-bar-striped';
		}
		$output  .= '<div class="wppb-progress-bar-addon">';
			$output  .= '<div class="wppb-progressbar-addon-content progressbar-layout-'.esc_attr($progress_layout).'">';

			if( $progress_layout == "two" ){
				if($show_title == 1){
					$show_title_content  = esc_attr($title);
				}
				if( ($show_title == 1) ){
					$output  .= '<div class="wppb-progress-label wppb-clearfix">'.  $show_title_content .'</div>';
				}
				$output .= '<div class="wppb-progress">';
					$output .= '<div class="wppb-progress-bar wppb-progress-bar-'. esc_attr($style) . ' ' . esc_attr($stripped) .'" style="width:'. (int) esc_attr($progress_width).'%">';
					if($show_percent == 1){
						$output .= '<span class="wppb-progress-percent">'. (int) esc_attr($progress_width) .'%</span>';
					}
					$output .= '</div>';
				$output .= '</div>';//wppb-progress

			} elseif ( $progress_layout == "three" ) {

				if($show_title == 1){
					$show_title_content  = esc_attr($title);
				}
				if( ($show_title == 1) ){
					$output  .= '<div class="wppb-progress-label wppb-clearfix">'.  $show_title_content .'</div>';
				}
				$output .= '<div class="wppb-progress">';
					$output .= '<div class="wppb-progress-bar wppb-progress-bar-'. esc_attr($style) . ' ' . esc_attr($stripped) .'" style="width:'. (int) esc_attr($progress_width).'%">';
					if($show_percent == 1){
						$output .= '<span class="wppb-progress-percent">'. (int) esc_attr($progress_width) .'%</span>';
					}
					$output .= '</div>';
				$output .= '</div>';//wppb-progress

			} else {

				if($show_title == 1){
					$show_title_content  = esc_attr($title);
				}
				if( ($show_title == 1)){
					$output  .= '<div class="wppb-progress-label wppb-clearfix">'.  $show_title_content .'</div>';
				}
				$output .= '<div class="wppb-progress">';
					$output .= '<div class="wppb-progress-bar wppb-progress-bar-'. esc_attr($style) . ' ' . esc_attr($stripped) .'" style="width:'. (int) esc_attr($progress_width).'%">';
					if($show_percent == 1){
						$output .= '<span class="wppb-progress-percent">'. (int) esc_attr($progress_width) .'%</span>';
					}
					$output .= '</div>';
				$output .= '</div>';//wppb-progress

			}

			$output .= '</div>';//wppb-progressbar-addon-content
		$output .= '</div>';//wppb-progress-bar-addon 

		return $output;
	}

	// Progress Bar Template
	public function getTemplate(){
		$output = '
			<#
				var stripped = "";
				if(data.stripped == 1){
					stripped = "wppb-progress-bar-striped";
				}
			#>
			<# 
			var show_title_content = "";
			if(data.show_title == 1){ 
				show_title_content = data.title;
			 } #>	

			<# 
			var show_percent_content = "";
			if(data.show_percent == 1){   
				show_percent_content =  data.progress_width ? data.progress_width : "50";
			} #>		

			<div class="wppb-progress-bar-addon">
				<div class="wppb-progressbar-addon-content progressbar-layout-{{data.progress_layout}}">

				<# if( data.progress_layout == "two" ){ #>

					<# if( (data.show_title==1) ) { #>
						<div class="wppb-progress-label wppb-clearfix">{{show_title_content}} 
						</div>
					<# } #>
					<div class="wppb-progress">
						<div class="wppb-progress-bar wppb-progress-bar-{{data.style}} {{stripped}}" style="width: {{data.progress_width}}%">
							<# if(data.show_percent == 1) { #>	
								<span class="wppb-progress-percent"> {{show_percent_content}}% </span>
							<# } #>
						</div>
					</div>

				<# } else if( data.progress_layout == "three" ){ #>	

					<# if( (data.show_title==1) ) { #>
						<div class="wppb-progress-label wppb-clearfix">{{show_title_content}} 
						</div>
					<# } #>
					<div class="wppb-progress">
						<div class="wppb-progress-bar wppb-progress-bar-{{data.style}} {{stripped}}" style="width: {{data.progress_width}}%">
						<# if(data.show_percent == 1) { #>	
							<span class="wppb-progress-percent"> {{show_percent_content}}% </span>
						<# } #>
						</div>
					</div>

				<# } else {  #>	

					<# if( (data.show_title==1) ) { #>
						<div class="wppb-progress-label wppb-clearfix">{{show_title_content}} 
						</div>
					<# } #>
					<div class="wppb-progress">
						<div class="wppb-progress-bar wppb-progress-bar-{{data.style}} {{stripped}}" style="width: {{data.progress_width}}%">							
						<# if(data.show_percent == 1) { #>	
							<span class="wppb-progress-percent"> {{show_percent_content}}% </span>
						<# } #>
						</div>
					</div>

				<# } #>

				</div>
			</div>
		';
		return $output;
	}
}