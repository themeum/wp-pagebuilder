<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Animated_Number{

	public function get_name(){
		return 'wppb_animated_number';
	}
	public function get_title(){
		return 'Animated Number';
	}
	public function get_icon(){
		return 'wppb-font-magic-wand';
	}
	public function get_enqueue_script(){
		return array( 'jquery.inview' );
	}

	// Animated Settings Fields
	public function get_settings() {

		$settings = array(
			'animated_layout' => array(
				'type' => 'radioimage',
				'title' => 'Layout',
				'values'=> array(
					'one' =>  WPPB_DIR_URL.'addons/animated_number/img/number-img1.jpg',
					'two' =>  WPPB_DIR_URL.'addons/animated_number/img/number-img2.jpg',
				),
				'std' => 'one',
			),
			'digit' => array(
				'type' => 'text',
				'title' => __('Counter digit','wp-pagebuilder'),
				'std' => '500'
			),
			'digit_animation' => array(
				'type' => 'animation',
				'title' => 'Digit Animation',
				'std' => array(
					'name' => 'fadeIn',   
					'delay' => '300',    
					'duration' => '400'
				),
			),
			'duration' => array(
				'type' => 'text',
				'title' => __('Animation duration','wp-pagebuilder'),
				'std' => '1000',
			),
			'counter_title' => array(
				'type' => 'text',
				'title' => __('Counter title','wp-pagebuilder'),
				'std' => 'WordPress'
			),
			'title_animation' => array(
				'type' => 'animation',
				'title' => 'Counter Animation',
				'std' => array(
					'name' => 'fadeIn',   
					'delay' => '300',  
					'duration' => '400' 
				),
			),
			'prefix_text' => array(
				'type' => 'text',
				'title' => __('Prefix Text','wp-pagebuilder'),
				'std' => ''
			),
			'additional' => array(
				'type' => 'text',
				'title' => __('Suffix Text','wp-pagebuilder'),
				'std' => '+'
			),
			'counter_align' => array(
				'type' => 'alignment',
				'title' => __('Counter alignment','wp-pagebuilder'),
				'std' => array( 'md' => 'center', 'sm' => 'center', 'xs' => 'center' ),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-animated-counter-content { text-align: {{data.counter_align}}; }'
			),

			//number style	
			'number_color' => array(
				'type' => 'color2',
				'title' => __('Number color','wp-pagebuilder'),
				'tab' => 'style',
				'section' =>'Number',
				'clip' => true,
				'std' => array(
					'colorType' => 'color',
					'clip' => true,
					'colorColor' => '#101010',
				),
				'selector' => '{{SELECTOR}} .wppb-counter-number'
			),
			'number_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'60px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-counter-number',
				'section' =>'Number',
				'tab' => 'style',
			),
			'number_margin' => array(
				'type' => 'dimension',
				'title' => 'Number Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-counter-number { margin: {{data.number_margin}}; }',
				'section' =>'Number',
			),

			//title style	
			'title_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Title',
				'clip' => true,
				'std' => array(
					'colorType' => 'color',
					'clip' => true,
					'colorColor' => '#101010',
				),
				'selector' => '{{SELECTOR}} .wppb-count-number-title'
			),
			'title_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'18px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-count-number-title',
				'section' => 'Title',
				'tab' => 'style',
			),
			'title_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-count-number-title { margin: {{data.title_margin}}; }',
				'section' => 'Title',
			),

			//Suffix style	
			'additional_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Suffix',
				'clip' => true,
				'std' => array(
					'colorType' => 'color',
					'clip' => true,
					'colorColor' => '#101010',
				),
				'depends' => array(array('additional', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-addition'
			),
			'additional_fontstyle' => array(
				'type' => 'typography',
				'title' => __('typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'60px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'depends' => array(array('additional', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-addition',
				'section' => 'Suffix',
				'tab' => 'style',
			),
			'additional_space_horizontal' => array(
				'type' => 'slider',
				'title' => __('Space Horizontal','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => -5,
						'max' => 23,
						'step' => .1,
					),
					'px' => array(
						'min' => -120,
						'max' => 120,
						'step' => 1,
					),
					'%' => array(
						'min' => -10,
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
				'section' => 'Suffix',
				'depends' => array(array('additional', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-addition { left: {{data.additional_space_horizontal}}; }',
			),
			'additional_space_vertical' => array(
				'type' => 'slider',
				'title' => __('Space vertically','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => -5,
						'max' => 23,
						'step' => .1,
					),
					'px' => array(
						'min' => -50,
						'max' => 150,
						'step' => 1,
					),
					'%' => array(
						'min' => -10,
						'max' => 100,
						'step' => 1,
					),
				),
				'std' => array(
					'md' => '0px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Suffix',
				'depends' => array(array('additional', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-addition { top: {{data.additional_space_vertical}}; }',
			),


			// Prefix style	
			'prefix_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Prefix',
				'clip' => true,
				'std' => array(
					'colorType' => 'color',
					'clip' => true,
					'colorColor' => '#101010',
				),
				'depends' => array(array('prefix_text', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-prefix'
			),
			'prefix_fontstyle' => array(
				'type' => 'typography',
				'title' => __('typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'60px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'depends' => array(array('prefix_text', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-prefix',
				'section' => 'Prefix',
				'tab' => 'style',
			),
			'prefix_space_horizontal' => array(
				'type' => 'slider',
				'title' => __('Space Horizontal','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => -5,
						'max' => 23,
						'step' => .1,
					),
					'px' => array(
						'min' => -120,
						'max' => 120,
						'step' => 1,
					),
					'%' => array(
						'min' => -10,
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
				'section' => 'Prefix',
				'depends' => array(array('prefix_text', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-prefix { left: {{data.prefix_space_horizontal}}; }',
			),
			'prefix_space_vertical' => array(
				'type' => 'slider',
				'title' => __('Space vertically','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => -5,
						'max' => 23,
						'step' => .1,
					),
					'px' => array(
						'min' => -50,
						'max' => 150,
						'step' => 1,
					),
					'%' => array(
						'min' => -10,
						'max' => 100,
						'step' => 1,
					),
				),
				'std' => array(
					'md' => '0px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Prefix',
				'depends' => array(array('prefix_text', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-count-number-prefix { top: {{data.prefix_space_vertical}}; }',
			),

		);
		return $settings;
	}

	// Animated Render HTML
	public function render($data = null){
		$settings 				= $data['settings'];
		$title 					= isset($settings['counter_title']) ? $settings['counter_title'] : '';
		$duration  				= (int) isset($settings['duration']) ? $settings['duration'] : 1000;
		$digit 					= (int) isset($settings['digit']) ? $settings['digit'] : 500;
		$animated_layout 		= isset($settings['animated_layout']) ? $settings['animated_layout'] : 'one';
		$digit_animation 		= (bool) isset($settings['digit_animation']) ? $settings['digit_animation'] : false;
		$title_animation 		= isset($settings['title_animation']) ? $settings['title_animation'] : '';
		$additional 			= isset($settings['additional']) ? $settings['additional'] : '';
		$prefix_text     		= isset($settings['prefix_text']) ? $settings['prefix_text'] : '';

		$output = '';

		$output  .= '<div class="wppb-animated-counter-addon">';
			$output  .= '<div class="wppb-animated-counter-content animated-layout-'.esc_attr($animated_layout).'">';
			if( $animated_layout == "two" ){
				if($title){
					if( isset( $digit_animation['itemOpen'] ) &&  $digit_animation['itemOpen'] ) {
						$output  .= '<div class="wppb-count-number-title wppb-wow wppb-animated '.esc_attr($digit_animation['name']).'" data-wow-duration="'.esc_attr($digit_animation['duration']).'ms" data-wow-delay="'.esc_attr($digit_animation['delay']).'ms">'.esc_html($title).'</div>';
					} else {
						$output  .= '<div class="wppb-count-number-title">'.esc_html($title).'</div>';
					}
				}
				if($digit){ 
					if($prefix_text) {
						$output  .= '<div class="wppb-count-number-prefix">'.esc_html($additional).'</div>';
					}
					if( isset( $title_animation['itemOpen'] ) && $title_animation['itemOpen'] ) {
						$output  .= '<div class="wppb-counter-number wppb-wow wppb-animated '.esc_attr($title_animation['name']).'" data-wow-duration="'.esc_attr($title_animation['duration']).'ms" data-wow-delay="'.esc_attr($title_animation['delay']).'ms" data-digit="'.esc_attr($digit).'" data-duration="'.esc_attr($duration).'">0</div>';
					} else {
						$output  .= '<div class="wppb-counter-number" data-digit="'.esc_attr($digit).'" data-duration="'.esc_attr($duration).'">0</div>';
					}
					if($additional) {
						$output  .= '<div class="wppb-count-number-addition">'.esc_html($additional).'</div>';
					}
				}	
			} else {
				if($digit){ 
					if($prefix_text) {
						$output  .= '<div class="wppb-count-number-prefix">'.esc_html($additional).'</div>';
					}
					if(isset( $digit_animation['itemOpen'] ) && $digit_animation['itemOpen'] ) {
						$output  .= '<div class="wppb-counter-number wppb-wow wppb-animated '.esc_attr($digit_animation['name']).'" data-wow-duration="'.esc_attr($digit_animation['duration']).'ms" data-wow-delay="'.esc_attr($digit_animation['delay']).'ms" data-digit="'.esc_attr($digit).'" data-duration="'.esc_attr($duration).'">0</div>';
					} else {
						$output  .= '<div class="wppb-counter-number" data-digit="'.esc_attr($digit).'" data-duration="'.esc_attr($duration).'">0</div>';
					}
					if($additional) {
						$output  .= '<div class="wppb-count-number-addition">'.esc_html($additional).'</div>';
					}
				}

				if($title){
					if(isset( $title_animation['itemOpen'] ) && $title_animation['itemOpen'] ) {
						$output  .= '<div class="wppb-count-number-title wppb-wow wppb-animated '.esc_attr($title_animation['name']).'" data-wow-duration="'.esc_attr($title_animation['duration']).'ms" data-wow-delay="'.esc_attr($title_animation['delay']).'ms">'.esc_html($title).'</div>';
					} else {
						$output  .= '<div class="wppb-count-number-title">'.esc_html($title).'</div>';
					}
				}
			}	
			$output .= '</div>';//wppb-animated-counter-content
		$output .= '</div>';//wppb-animated-counter-addon
		return $output;
	}

	// Animated Template
	public function getTemplate(){
		$output = '
		<div class="wppb-animated-counter-addon">
			<div class="wppb-animated-counter-content animated-layout-{{data.animated_layout}}">
				<# if( data.animated_layout == "two" ){ #>
					<# if(data.counter_title){ #>
						<# if(data.title_animation.itemOpen) { #>
							<div class="wppb-count-number-title wppb-wow wppb-animated {{ data.title_animation.name }}" data-wow-duration="{{ data.title_animation.duration }}ms" data-wow-delay="{{ data.title_animation.delay }}ms">{{ data.counter_title }}</div>
						<# } else { #>
							<div class="wppb-count-number-title">{{ data.counter_title }}</div>
						<# } #>
					<# } #>
					<# if(data.digit){ #>
						<# if(data.prefix_text){ #>
							<div class="wwppb-count-number-prefix">{{ data.prefix_text }}</div>
						<# } #>
						<# if(data.digit_animation.itemOpen) { #>
							<div class="wppb-counter-number wppb-wow wppb-animated {{ data.digit_animation.name }}" data-wow-duration="{{ data.digit_animation.duration }}ms" data-wow-delay="{{ data.digit_animation.delay }}ms" data-digit="{{ data.digit }}" data-duration="{{ data.duration }}">0</div>
						<# } else { #>
							<div class="wppb-counter-number" data-digit="{{ data.digit }}" data-duration="{{ data.duration }}">0</div>
						<# } #>
						<# if(data.additional){ #>
							<div class="wppb-count-number-addition">{{ data.additional }}</div>
						<# } #>
					<# } #>	
				<# } else {  #>	
					<# if(data.digit){ #>
						<# if(data.prefix_text){ #>
							<div class="wppb-count-number-prefix">{{ data.prefix_text }}</div>
						<# } #>
						<# if(data.digit_animation.itemOpen) { #>
							<div class="wppb-counter-number wppb-wow wppb-animated {{ data.digit_animation.name }}" data-wow-duration="{{ data.digit_animation.duration }}ms" data-wow-delay="{{ data.digit_animation.delay }}ms" data-digit="{{ data.digit }}" data-duration="{{ data.duration }}">0</div>
						<# } else { #>
							<div class="wppb-counter-number" data-digit="{{ data.digit }}" data-duration="{{ data.duration }}">0</div>
						<# } #>
						<# if(data.additional){ #>
							<div class="wppb-count-number-addition">{{ data.additional }}</div>
						<# } #>
					<# } #>	
					<# if(data.counter_title){ #>
						<# if(data.title_animation.itemOpen) { #>
							<div class="wppb-count-number-title wppb-wow wppb-animated {{ data.title_animation.name }}" data-wow-duration="{{ data.title_animation.duration }}ms" data-wow-delay="{{ data.title_animation.delay }}ms">{{ data.counter_title }}</div>
						<# } else { #>
							<div class="wppb-count-number-title">{{ data.counter_title }}</div>
						<# } #>
					<# } #>
				<# } #>
			</div>
		</div>
		';
		return $output;
	}
}