<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Testimonial{

	public function get_name(){
		return 'wppb_testimonial';
	}
	public function get_title(){
		return 'Testimonial';
	}
	public function get_icon() {
		return 'wppb-font-quote';
	}

	// Testimonial Settings Fields
	public function get_settings() {

		$settings = array(

			'testimonial_layout' => array(
				'type' => 'radioimage',
				'title' => 'Layout',
				'values'=> array(
					'one' =>  WPPB_DIR_URL.'addons/testimonial/img/testimonial-img1.png',
					'two' =>  WPPB_DIR_URL.'addons/testimonial/img/testimonial-img2.png',
					'three' =>  WPPB_DIR_URL.'addons/testimonial/img/testimonial-img3.png',
					'four' =>  WPPB_DIR_URL.'addons/testimonial/img/testimonial-img4.png',
				),
				'std' => 'one',
			),

			'image' => array(
				'type' => 'media',
				'title' => __('Image','wp-pagebuilder'),
				'std'=> array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-small.jpg' ),
			),

			'name' => array(
				'type' => 'text',
				'title' => __('Name','wp-pagebuilder'),
				'std' => 'John Doe',
			),
			'name_link' => array(
				'type' => 'link',
				'title' => __('Link','wp-pagebuilder'),
				'std' =>   array('link'=>'','window'=>true,'nofolow'=>false),
			),
			'designation' => array(
				'type' => 'text',
				'title' => __('Designation','wp-pagebuilder'),
				'std' => 'Designer',
			),
			'introtext' => array(
				'type' => 'textarea',
				'title' => __('Message text','wp-pagebuilder'),
				'std' => 'She was bouncing away, when a cry from the two women, who had turned towards the bed, caused her to look round.',
			),

			'testimonial_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content{ text-align: {{data.testimonial_align}}; }'
			),

			//style
			'img_width' => array(
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
						'md' => '50px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-img { width: {{data.img_width}}; }',
			),
			'img_height' => array(
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
						'md' => '50px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-img { height: {{data.img_height}}; }',
			),
			'img_radius' => array(
				'type' => 'dimension',
				'title' => __('Border Radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '100px', 'right' => '100px', 'bottom' => '100px', 'left' => '100px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-img { border-radius: {{data.img_radius}}; }',
			),
			'image_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#cccccc'
				),
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-img'
			),
			'image_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-img { margin: {{data.image_margin}}; }'
			),
			//name
			'name_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Name',
				'selector' => '{{SELECTOR}} .wppb-testimonial-name, {{SELECTOR}} .wppb-testimonial-name a { color: {{data.name_color}}; }'
			),
			'name_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-testimonial-name',
				'section' => 'Name',
				'tab' => 'style',
			),
			'name_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-name { margin: {{data.name_margin}}; }',
				'section' => 'Name',
			),

			//Designation
			'desgn_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Designation',
				'selector' => '{{SELECTOR}} .wppb-testimonial-designation { color: {{data.desgn_color}}; }'
			),
			'desgn_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'12px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-testimonial-designation',
				'section' => 'Designation',
				'tab' => 'style',
			),

			//intro
			'intro_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Message text',
				'selector' => '{{SELECTOR}} .wppb-testimonial-introtext { color: {{data.intro_color}}; }'
			),
			'intro_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-testimonial-introtext, {{SELECTOR}} .testimonial-layout-four .wppb-testimonial-introtext',
				'section' => 'Message text',
				'tab' => 'style',
			),
			'message_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-introtext, {{SELECTOR}} .testimonial-layout-four .wppb-testimonial-introtext { margin: {{data.message_margin}}; }',
				'section' => 'Message text',
			),

			//intro
			'quote_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Quote Style',
				'depends' => array(array('testimonial_layout', '=', array('four'))),
				'selector' => '{{SELECTOR}} .testimonial-layout-four .wppb-testimonial-quote { color: {{data.quote_color}}; }'
			),
			'quote_fontsize' => array(
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
					'md' => '48px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Quote Style',
				'depends' => array(array('testimonial_layout', '=', array('four'))),
				'selector' => '{{SELECTOR}} .testimonial-layout-four .wppb-testimonial-quote { font-size: {{data.quote_fontsize}}; }'
			),
			'quote_line_height' => array(
				'type' => 'slider',
				'title' => __('Line height','wp-pagebuilder'),
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
					'md' => '48px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Quote Style',
				'depends' => array(array('testimonial_layout', '=', array('four'))),
				'selector' => '{{SELECTOR}} .testimonial-layout-four .wppb-testimonial-quote { line-height: {{data.quote_line_height}}; }'
			),

			//wrapper
			'wrap_background' => array(
				'type' => 'background',
				'title' => '',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content',
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
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
				'section' => 'Testimonial Wrapper',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content'
			),
			'wrap_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content { border-radius: {{data.wrap_radius}}; }'
			),

			'wrap_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Box shadow',
				'std' => array(
					'shadowValue' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ),
					'shadowColor' => '#ffffff'
				),
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content',
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
			),
			'wrap_hover_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'hover box shadow',
				'std' => array(
					'shadowValue' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ),
					'shadowColor' => '#ffffff'
				),
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content:hover',
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
			),

			'wrap_padding'  => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-addon-content { padding: {{data.wrap_padding}}; }',
				'section' => 'Testimonial Wrapper',
			),

		);

		return $settings;
	}


	// Testimonial Render HTML
	public function render($data = null){
		$settings 					= $data['settings'];

		$image 						= isset($settings['image']) ? $settings['image'] : array();
		$name 						= isset($settings['name']) ? $settings['name'] : '';
		$name_link 					= isset($settings['name_link']) ? $settings['name_link'] : array();
		$designation 				= isset($settings['designation']) ? $settings['designation'] : '';
		$introtext 					= isset($settings['introtext']) ? $settings['introtext'] : '';
		$testimonial_layout 		= isset($settings['testimonial_layout']) ? $settings['testimonial_layout'] : '';

		$output = $img_url = '' ;

		if(! empty($image['url'])){
			$img_url = $image['url'];
		}

		$name_link_url = is_array($name_link) ? $name_link['link'] : $name_link;

		$target = ( isset($name_link['window']) && $name_link['window'] ) ? 'target=_blank' : "";
		$nofolow = ( isset($name_link['nofolow']) && $name_link['nofolow'] ) ? 'rel=nofolow' : "";

		$output  .= '<div class="wppb-testimonial-addon">';
		$output  .= '<div class="wppb-testimonial-addon-content testimonial-layout-'.esc_attr($testimonial_layout).'">';

		if( $testimonial_layout == "two" ){
			$output  .= '<div class="wppb-testimonial-content">';
			if($img_url) {
				$output  .= '<div class="wppb-testimonial-image">';
				$output  .= '<img class="wppb-testimonial-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr($name) .'">';
				$output  .= '</div>';
			}
			if($introtext) {
				$output  .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($introtext) . '</div>';
			}
			if($name || $designation) {
				$output  .= '<div class="wppb-testimonial-title">';
				if( $name_link_url ){
					if($name){ $output .= '<h4 class="wppb-testimonial-name"><a '.esc_attr($nofolow).' href="'.esc_url($name_link_url).'" '.esc_attr($target).'>' . wp_kses_post($name) .'</a></h4>';}
				} else {
					if($name){ $output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($name) .'</h4>';}
				}
				if($designation) {
					$output  .= '<span class="wppb-testimonial-designation">' . wp_kses_post($designation) . '</span>';
				}
				$output  .= '</div>';//wppb-testimonial-title
			}
			$output  .= '</div>';

		} elseif ( $testimonial_layout == "three" ) {
			$output  .= '<div class="wppb-testimonial-content">';
			if($introtext) {
				$output  .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($introtext) . '</div>';
			}
			if($img_url) {
				$output  .= '<div class="wppb-testimonial-image">';
				$output  .= '<img class="wppb-testimonial-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr($name) .'">';
				$output  .= '</div>';
			}
			if($name || $designation) {
				$output  .= '<div class="wppb-testimonial-title">';
				if( $name_link_url ){
					if($name){ $output .= '<h4 class="wppb-testimonial-name"><a '.esc_attr($nofolow).' href="'.esc_url($name_link_url).'" '.esc_attr($target).'>' . wp_kses_post($name) .'</a></h4>';}
				} else {
					if($name){ $output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($name) .'</h4>';}
				}
				if($designation) {
					$output  .= '<span class="wppb-testimonial-designation">' . wp_kses_post($designation) . '</span>';
				}
				$output  .= '</div>';//wppb-testimonial-title
			}
			$output  .= '</div>';


		} elseif ( $testimonial_layout == "four" ) {
			$output  .= '<div class="wppb-testimonial-content">';
			$output  .= '<span class="wppb-testimonial-quote wppb-font-quote"></span>';
			if($introtext) {
				$output  .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($introtext) . '</div>';
			}
			if($img_url) {
				$output  .= '<div class="wppb-testimonial-image">';
				$output  .= '<img class="wppb-testimonial-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr($name) .'">';
				$output  .= '</div>';
			}
			if($name || $designation) {
				$output  .= '<div class="wppb-testimonial-title">';
				if( $name_link_url ){
					if($name){ $output .= '<h4 class="wppb-testimonial-name"><a '.esc_attr($nofolow).' href="'.esc_url($name_link_url).'" '.esc_attr($target).'>' . wp_kses_post($name) .'</a></h4>';}
				} else {
					if($name){ $output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($name) .'</h4>';}
				}
				if($designation) {
					$output  .= '<span class="wppb-testimonial-designation">' . wp_kses_post($designation) . '</span>';
				}
				$output  .= '</div>';//wppb-testimonial-title
			}
			$output  .= '</div>';

		} else {
			$output  .= '<div class="wppb-testimonial-content">';
			if($introtext) {
				$output  .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($introtext) . '</div>';
			}

			if($name || $designation) {
				$output  .= '<div class="wppb-testimonial-information">';
				if($img_url) {
					$output  .= '<div class="wppb-testimonial-image">';
					$output  .= '<img class="wppb-testimonial-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr($name) .'">';
					$output  .= '</div>';
				}
				$output  .= '<div class="wppb-testimonial-title">';
				if( $name_link_url ){
					if($name){ $output .= '<h4 class="wppb-testimonial-name"><a '.esc_attr($nofolow).' href="'.esc_url($name_link_url).'" '.esc_attr($target).'>' . wp_kses_post($name) .'</a></h4>';}
				} else {
					if($name){ $output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($name) .'</h4>';}
				}
				if($designation) {
					$output  .= '<span class="wppb-testimonial-designation">' . wp_kses_post($designation) . '</span>';
				}
				$output  .= '</div>';//wppb-testimonial-title
				$output  .= '</div>';//wppb-testimonial-information
			}
			$output  .= '</div>';

		}

		$output  .= '</div>';//wppb-testimonial-addon-content
		$output  .= '</div>';//wppb-testimonial-addon

		return $output;
	}

	// Testimonial Template
	public function getTemplate(){
		$output = '

		<div class="wppb-testimonial-addon">
			<div class="wppb-testimonial-addon-content testimonial-layout-{{data.testimonial_layout}}">

				<# if( data.testimonial_layout == "two" ){ #>
					<div class="wppb-testimonial-content">
						<# if( data.image.url ) { #>
							<div class="wppb-testimonial-image">
								<img class="wppb-testimonial-addon-img" src="{{data.image.url}}">
							</div>
						<# } #>

						<# if( data.introtext ) { #>
							<div class="wppb-testimonial-introtext">{{{data.introtext}}}</div>
						<# } #>

						<# if( data.name || data.designation ) { #>
							<div class="wppb-testimonial-title">
								<# if( !__.isEmpty(data.name_link.link) ) { #>
									<h4 class="wppb-testimonial-name"><a {{ data.name_link.link ? "href="+data.name_link.link : "" }} {{ data.name_link.window ? "target=_blank" : "" }} {{ data.name_link.nofolow ? "rel=nofolow" : "" }} >{{{ data.name }}}</a></h4>
								<# } else { #>
									<h4 class="wppb-testimonial-name">{{{ data.name }}}</h4>
								<# } #>
								<# if( data.designation ) { #>
									<span class="wppb-testimonial-designation">{{{data.designation}}}</span>
								<# } #>
							</div>
						<# } #>
					</div>

				<# } else if( data.testimonial_layout == "three" ){ #>
					<div class="wppb-testimonial-content">
						<# if( data.introtext ) { #>
							<div class="wppb-testimonial-introtext">{{{data.introtext}}}</div>
						<# } #>

						<# if( data.image.url ) { #>
							<div class="wppb-testimonial-image">
								<img class="wppb-testimonial-addon-img" src="{{data.image.url}}">
							</div>
						<# } #>

						<# if( data.name || data.designation ) { #>
							<div class="wppb-testimonial-title">
								<# if( !__.isEmpty(data.name_link.link) ) { #>
									<h4 class="wppb-testimonial-name"><a {{ data.name_link.link ? "href="+data.name_link.link : "" }} {{ data.name_link.window ? "target=_blank" : "" }} {{ data.name_link.nofolow ? "rel=nofolow" : "" }} >{{{ data.name }}}</a></h4>
								<# } else { #>
									<h4 class="wppb-testimonial-name">{{{ data.name }}}</h4>
								<# } #>
								<# if( data.designation ) { #>
									<span class="wppb-testimonial-designation">{{{data.designation}}}</span>
								<# } #>
							</div>
						<# } #>	
					</div>	

					<# } else if( data.testimonial_layout == "four" ){ #>
						<div class="wppb-testimonial-content">
							<span class="wppb-testimonial-quote wppb-font-quote"></span>
							<# if( data.introtext ) { #>
								<div class="wppb-testimonial-introtext">{{{data.introtext}}}</div>
							<# } #>
	
							<# if( data.image.url ) { #>
								<div class="wppb-testimonial-image">
									<img class="wppb-testimonial-addon-img" src="{{data.image.url}}">
								</div>
							<# } #>
	
							<# if( data.name || data.designation ) { #>
								<div class="wppb-testimonial-title">
									<# if( !__.isEmpty(data.name_link.link) ) { #>
										<h4 class="wppb-testimonial-name"><a {{ data.name_link.link ? "href="+data.name_link.link : "" }} {{ data.name_link.window ? "target=_blank" : "" }} {{ data.name_link.nofolow ? "rel=nofolow" : "" }} >{{{ data.name }}}</a></h4>
									<# } else { #>
										<h4 class="wppb-testimonial-name">{{{ data.name }}}</h4>
									<# } #>
									<# if( data.designation ) { #>
										<span class="wppb-testimonial-designation">{{{data.designation}}}</span>
									<# } #>
								</div>
							<# } #>	
						</div>	
					
				<# } else {  #>	
					<div class="wppb-testimonial-content">
						<# if( data.introtext ) { #>
							<div class="wppb-testimonial-introtext">{{{data.introtext}}}</div>
						<# } #>
						<# if( data.name || data.designation ) { #>
							<div class="wppb-testimonial-information">
								<# if( data.image.url ) { #>
									<div class="wppb-testimonial-image">
										<img class="wppb-testimonial-addon-img" src="{{data.image.url}}">
									</div>
								<# } #>
								<div class="wppb-testimonial-title">
									<# if( !__.isEmpty(data.name_link.link) ) { #>
										<h4 class="wppb-testimonial-name"><a {{ data.name_link.link ? "href="+data.name_link.link : "" }} {{ data.name_link.window ? "target=_blank" : "" }} {{ data.name_link.nofolow ? "rel=nofolow" : "" }} >{{{ data.name }}}</a></h4>
									<# } else { #>
										<h4 class="wppb-testimonial-name">{{{ data.name }}}</h4>
									<# } #>
									<# if( data.designation ) { #>
										<span class="wppb-testimonial-designation">{{{data.designation}}}</span>
									<# } #>
								</div>
							</div>
						<# } #>
					</div>

				<# } #>

			</div>
		</div>
	';
		return $output;
	}

}