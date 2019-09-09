<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Testimonial_Carousel{
	public function get_name(){
		return 'wppb_testimonial_carousel';
	}
	public function get_title(){
		return 'Testimonial Carousel';
	}
	public function get_icon() {
		return 'wppb-font-full-slider';
	}

	public function get_enqueue_script(){
		return array('wppb-slick-slider');
	}

	public function get_enqueue_style(){
		return array('wppb-slick-slider-css', 'wppb-slick-slider-css-theme');
	}
	// Testimonial Settings Fields
	public function get_settings() {

		$settings = array(

			'testimonial_layout' => array(
				'type' => 'radioimage',
				'title' => 'Layout',
				'values'=> array(
					'layoutone' =>  WPPB_DIR_URL.'addons/testimonial_carousel/img/testimonial-img1.png',
					'layouttwo' =>  WPPB_DIR_URL.'addons/testimonial_carousel/img/testimonial-img2.png',
					'layoutthree' =>  WPPB_DIR_URL.'addons/testimonial_carousel/img/testimonial-img3.png',
					'layoutfour' =>  WPPB_DIR_URL.'addons/testimonial_carousel/img/testimonial-img4.png',
				),
				'std' => 'layoutone',
			),

			'testimonial_list' => array(
				'title' => __('Testimonial Item','wp-pagebuilder'),
				'type' => 'repeatable',
				'label' => 'name',
				'std' => array(
					array(
						'image' => array( 'url' =>  WPPB_DIR_URL.'assets/img/placeholder/wppb-small.jpg' ),
						'name' => 'Michel Clark',
						'name_link' => array( 'link'=>'#' ),
						'designation' => 'Developer',
						'introtext' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
					),
					array(
						'image' => array( 'url' =>  WPPB_DIR_URL.'assets/img/placeholder/wppb-small.jpg' ),
						'name' => 'John Doe',
						'name_link' => array( 'link'=>'#' ),
						'designation' => 'Designer',
						'introtext' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
					),
					array(
						'image' => array( 'url' =>  WPPB_DIR_URL.'assets/img/placeholder/wppb-small.jpg' ),
						'name' => 'Stephen Fleming',
						'name_link' => array( 'link'=>'#' ),
						'designation' => 'Founder',
						'introtext' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
					),

				),
				'attr' => array(
					'image' => array(
						'type' => 'media',
						'title' => __('Image','wp-pagebuilder'),
						'std' => array( 'url' =>  WPPB_DIR_URL.'assets/img/placeholder/wppb-small.jpg' ),
					),
					'name' => array(
						'type' => 'text',
						'title' => __('Name','wp-pagebuilder'),
						'std' => 'John Doe',
					),
					'name_link' => array(
						'type' => 'link',
						'title' => __('Link','wp-pagebuilder'),
						'std' =>   array( 'link'=>'#' ),
					),
					'designation' => array(
						'type' => 'text',
						'title' => __('Designation','wp-pagebuilder'),
						'std' => 'Designer',
					),
					'introtext' => array(
						'type' => 'textarea',
						'title' => __('Message Text','wp-pagebuilder'),
						'std' => 'She was bouncing away, when a cry from the two women, who had turned towards the bed, caused her to look round.',
					),
				),
      ),

			'autoplay_option' => array(
				'type' => 'switch',
				'title' => __('Autoplay','wp-pagebuilder'),
				'std' => '1',
				'section' => 'Slide Settings',
			),
			'speed_option' => array(
				'type' => 'number',
				'title' => __('Animated Speed','wp-pagebuilder'),
				'std' => '600',
				'section' => 'Slide Settings',
				'depends' => array(array('autoplay_option', '=', '1')),
			),
			'control_dots' => array(
				'type' => 'switch',
				'title' => __('Control Dots','wp-pagebuilder'),
				'std' => '1',
				'section' => 'Slide Settings',
			),
			'control_nav' => array(
				'type' => 'switch',
				'title' => __('Control Nav','wp-pagebuilder'),
				'std' => '0',
				'section' => 'Slide Settings',
			),
			'control_nav_style' => array(
				'type' => 'select',
				'title' => __('Nav Style','wp-pagebuilder'),
				'values' => array(
					'nav_style1' => __('Nav Style 1','wp-pagebuilder'),
					'nav_style2' => __('Nav Style 2','wp-pagebuilder'),
					'nav_style3' => __('Nav Style 3','wp-pagebuilder'),
					'nav_style4' => __('Nav Style 4','wp-pagebuilder'),
				),
				'std' => 'nav_style1',
				'depends' => array(array('control_nav', '!=', '')),
				'section' => 'Slide Settings',
			),
			'column' => array(
				'type' => 'select',
				'title' => __('Column','wp-pagebuilder'),
				'values' => array(
					'1' => __('Column 1','wp-pagebuilder'),
					'2' => __('Column 2','wp-pagebuilder'),
					'3' => __('Column 3','wp-pagebuilder'),
					'4' => __('Column 4','wp-pagebuilder'),
					'5' => __('Column 5','wp-pagebuilder'),
					'6' => __('Column 6','wp-pagebuilder'),
				),
				'std' => '1',
				'section' => 'Slide Settings',
			),
			'testimonial_align' => array(
				'type' => 'alignment',
				'title' => __('Testimonial alignment','wp-pagebuilder'),
				'responsive' => true,
				'section' => 'Slide Settings',
				'selector' => '{{SELECTOR}} .wppb-testimonial-carousel-addon-content{ text-align: {{data.testimonial_align}}; }'
			),

			//style
			'img_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'std' => array(
					'md' => '50px',
					'sm' => '',
					'xs' => '',
				),
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
				'title' => __('color','wp-pagebuilder'),
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
				'title' => __('Text color','wp-pagebuilder'),
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
				'selector' => '{{SELECTOR}} .wppb-testimonial-introtext',
				'section' => 'Message text',
				'tab' => 'style',
			),
			'message_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-introtext { margin: {{data.message_margin}}; }',
				'section' => 'Message text',
			),

			//intro
			'quote_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Quote Style',
				'depends' => array(array('testimonial_layout', '=', array('layoutfour'))),
				'selector' => '{{SELECTOR}} .testimonial-layout-layoutfour .wppb-testimonial-quote { color: {{data.quote_color}}; }'
			),
			'quote_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .testimonial-layout-layoutfour .wppb-testimonial-quote',
				'section' => 'Quote Style',
				'depends' => array(array('testimonial_layout', '=', array('layoutfour'))),
				'tab' => 'style',
			),

			// dots
			'dot_position' => array(
				'type' => 'slider',
				'title' => __('Position','wp-pagebuilder'),
				'responsive' => true,
				'max' => 550,
				'min' => -200,
				'range' => array(
					'em' => array(
						'min' => -20,
						'max' => 50,
						'step' => .1,
					),
					'px' => array(
						'min' => -220,
						'max' => 550,
						'step' => 1,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
						'step' => 1,
					),
				),
				'tab' => 'style',
				'std' => array(
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'unit' => array( '%','px','em' ),
				'section' => 'Dots Style',
				'depends' => array(array('control_dots', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots { bottom: {{data.dot_position}}; }',
			),
			'dot_bg_color' => array(
				'type' => 'color',
				'title' => __('background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li button { background: {{data.dot_bg_color}}; }'
			),
			'dot_bg_hcolor' => array(
				'type' => 'color',
				'title' => __('hover/active background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li.slick-active button,{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li button:hover { background: {{data.dot_bg_hcolor}}; }'
			),
			'dot_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => '16px',
					'sm' => '',
					'xs' => '',
				),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 5,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 50,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li button, {{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li { width: {{data.dot_width}}; }'
			),
			'dot_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => '16px',
					'sm' => '',
					'xs' => '',
				),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 5,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 50,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li button, {{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li { height: {{data.dot_height}}; }'
			),
			'dot_margin' => array(
				'type' => 'dimension',
				'title' => __('Dot Margin','wp-pagebuilder'),
				'tab'=> 'style',
				'section' => __('Dots Style','wp-pagebuilder'),
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li { margin: {{data.dot_margin}}; }'
			),
			'dot_radius' => array(
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
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .slick-dots li button { border-radius: {{data.dot_radius}}; }'
			),

			// nav
			'nav_position' => array(
				'type' => 'slider',
				'title' => __('Position','wp-pagebuilder'),
				'responsive' => true,
				'unit' => array( '%','px','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 550,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '0px',
						'sm' => '',
						'xs' => '',
					),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-carousel-addon-content .wppb-testimonial-content-carousel .wppb-carousel-prev,{{SELECTOR}} .wppb-testimonial-carousel-addon-content .wppb-testimonial-content-carousel .wppb-carousel-next { top: {{data.nav_position}}; }',
			),
			'nav_left_position' => array(
				'type' => 'slider',
				'title' => __('Prev Position','wp-pagebuilder'),
				'unit' => array( 'px','em','%' ),
				'range' => array(
						'em' => array(
							'min' => -10,
							'max' => 20,
							'step' => .1,
						),
						'px' => array(
							'min' => -200,
							'max' => 1000,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav_style', '=', array('nav_style1','nav_style2'))),
				'selector' => '{{SELECTOR}} .wppb-testimonial-carousel-addon-content .wppb-testimonial-content-carousel .wppb-carousel-next { left: {{data.nav_left_position}}; }',
			),
			'nav_right_position' => array(
				'type' => 'slider',
				'title' => __('Next Position','wp-pagebuilder'),
				'responsive' => true,
				'std' => array(
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'tab' => 'style',
				'unit' => array( 'px','em','%' ),
				'range' => array(
					'em' => array(
						'min' => -10,
						'max' => 20,
						'step' => .1,
					),
					'px' => array(
						'min' => -200,
						'max' => 1000,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'section' => 'Nav Style',
				'depends' => array(array('control_nav_style', '=', array('nav_style1','nav_style3'))),
				'selector' => '{{SELECTOR}} .wppb-testimonial-carousel-addon-content .wppb-testimonial-content-carousel .wppb-carousel-prev { right: {{data.nav_right_position}}; }',
			),

			'nav_font_size' => array(
				'type' => 'slider',
				'title' => __('Nav Font Size','wp-pagebuilder'),
				'responsive' => true,
				'std' => array(
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'tab' => 'style',
				'unit' => array( 'px','em','%' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 5,
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
				'section' => 'Nav Style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev { font-size: {{data.nav_font_size}}; }',
			),

			'nav_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next { color: {{data.nav_color}}; }'
			),
			'nav_bg_color' => array(
				'type' => 'color',
				'title' => __('background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next { background: {{data.nav_bg_color}}; }'
			),
			'nav_hcolor' => array(
				'type' => 'color',
				'title' => __('hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev:hover, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next:hover { color: {{data.nav_hcolor}}; }'
			),
			'nav_bg_hcolor' => array(
				'type' => 'color',
				'title' => __('background hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev:hover, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next:hover { background: {{data.nav_bg_hcolor}}; }'
			),
			'nav_width' => array(
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
						'md' => '30px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next { width: {{data.nav_width}}; }'
			),
			'nav_height' => array(
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
						'md' => '30px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => array(
					'{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next { height: {{data.nav_height}}; }',
					'{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next { line-height: {{data.nav_height}}; }',
				)
			),
			'nav_radius' => array(
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
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next { border-radius: {{data.nav_radius}}; }'
			),
			'nav_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#cccccc'
				),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev,{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next'
			),
			'border_hcolor' => array(
				'type' => 'border',
				'title' => 'Border hover color',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#cccccc'
				),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-prev:hover,{{SELECTOR}} .wppb-testimonial-content-carousel .wppb-carousel-next:hover'
			),

			//wrapper
			'wrap_background' => array(
				'type' => 'background',
				'title' => '',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content .wppb-testimonial-content-in',
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
				'selector' => '{{SELECTOR}} .wppb-testimonial-content .wppb-testimonial-content-in'
			),
			'wrap_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content .wppb-testimonial-content-in { border-radius: {{data.wrap_radius}}; }'
			),
			'wrap_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content.slick-active .wppb-testimonial-content-in'
			),
			'wrap_padding'  => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-testimonial-content .wppb-testimonial-content-in { padding: {{data.wrap_padding}}; }',
				'section' => 'Testimonial Wrapper',
			),

			'wrap_margin' => array(
				'type' => 'slider',
				'title' => __('Margin Right','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 150,
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
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Testimonial Wrapper',
				'selector' => array('{{SELECTOR}} .wppb-testimonial-content-carousel .slick-slide { margin-right: {{data.wrap_margin}}; }',
					'{{SELECTOR}} .wppb-testimonial-content-carousel .slick-list { margin-right: -{{data.wrap_margin}}; }')
			),

		);
		return $settings;
	}

	// Testimonial Render HTML
	public function render($data = null){
		$settings 			 = $data['settings'];

		$testimonial_list    = isset($settings["testimonial_list"]) ? $settings["testimonial_list"] : array();
		$testimonial_layout  = isset($settings['testimonial_layout']) ? $settings['testimonial_layout'] : '';
		$autoplay_option  	 = isset($settings['autoplay_option']) ? $settings['autoplay_option'] : '';
		$control_nav  	 	 = isset($settings['control_nav']) ? $settings['control_nav'] : '';
		$control_dots  	 	 = isset($settings['control_dots']) ? $settings['control_dots'] : '';
		$control_nav_style   = isset($settings['control_nav_style']) ? $settings['control_nav_style'] : '';
		$speed_option   = isset($settings['speed_option']) ? $settings['speed_option'] : '500';
		$column  	 	 	 = isset($settings['column']) ? $settings['column'] : '';

		$rand = rand(1000,999999);
		$output = '';

		if( $autoplay_option == '1'){
			$autoplay_option = "true";
		} else {
			$autoplay_option = "false";
		}
		if( $control_dots == '1'){
			$control_dots = "true";
		} else {
			$control_dots = "false";
		}
		if( $control_nav == '1'){
			$control_nav = "true";
		} else {
			$control_nav = "false";
		}
		$column = (isset($column) && $column) ? $column : 1;
		$control_nav_style = (isset($control_nav_style) && $control_nav_style) ? $control_nav_style : 'nav_style1';

		$output  .= '<div class="wppb-testimonial-addon">';
		$output  .= '<div class="wppb-testimonial-carousel-addon-content testimonial-layout-'.esc_attr($testimonial_layout).'">';
		$output  .= '<div class="wppb-testimonial-content-carousel wppb-testimonial-'.esc_attr($column).' '.esc_attr($control_nav_style).'" data-col="'.esc_attr($column).'" data-shownav="'.esc_attr($control_nav).'" data-showdots="'.esc_attr($control_dots).'" data-autoplay="'.esc_attr($autoplay_option).'" data-speed="'.esc_attr($speed_option).'">';

		if (is_array($testimonial_list) && count($testimonial_list)) {
			if ( $testimonial_layout == "layouttwo" ) {
				foreach ( $testimonial_list as $key => $value ) {
					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						$target  = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['window'] ) ? 'target=_blank' : 'target=_self';
						$nofolow = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['nofolow'] ) ? 'rel=nofolow' : "";
					}

					$output .= '<div class="wppb-testimonial-content">';
					$output .= '<div class="wppb-testimonial-content-in">';
					if ( ! empty( $value['image']['url'] ) ) {
						$img_url = $value['image']['url'];
						$output  .= '<div class="wppb-testimonial-image">';
						$output  .= '<img class="wppb-testimonial-addon-img" src="' . esc_url( $img_url ) . '" alt="' . esc_attr( get_wppb_array_value_by_key( $value, 'name' ) ) . '">';
						$output  .= '</div>';
					}
					if ( get_wppb_array_value_by_key( $value, 'introtext' ) ) {
						$output .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($value['introtext']) . '</div>';
					}
					$output .= '<div class="wppb-testimonial-title">';
					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name"><a ' . esc_attr( $nofolow ) . ' href="' . esc_url( $value['name_link']['link'] ) . '" ' . esc_attr( $target ) . '>' . $value['name'] . '</a></h4>';
						}
					} else {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($value['name']) . '</h4>';
						}
					}
					if ( get_wppb_array_value_by_key( $value, 'designation' ) ) {
						$output .= '<span class="wppb-testimonial-designation">' . wp_kses_post($value['designation']) . '</span>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
				}

			} elseif ( $testimonial_layout == "layoutthree" ) {
				foreach ( $testimonial_list as $key => $value ) {

					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						$target  = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['window'] ) ? 'target=_blank' : 'target=_self';
						$nofolow = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['nofolow'] ) ? 'rel=nofolow' : "";
					}

					$output .= '<div class="wppb-testimonial-content">';
					$output .= '<div class="wppb-testimonial-content-in">';
					if ( get_wppb_array_value_by_key( $value, 'introtext' ) ) {
						$output .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($value['introtext']) . '</div>';
					}
					if ( ! empty( $value['image']['url'] ) ) {
						$img_url = $value['image']['url'];
						$output  .= '<div class="wppb-testimonial-image">';
						$output  .= '<img class="wppb-testimonial-addon-img" src="' . esc_url( $img_url ) . '" alt="' . esc_attr( get_wppb_array_value_by_key( $value, 'name' ) ) . '">';
						$output  .= '</div>';
					}
					$output .= '<div class="wppb-testimonial-title">';
					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name"><a ' . esc_attr( $nofolow ) . ' href="' . esc_url( $value['name_link']['link'] ) . '" ' . esc_attr( $target ) . '>' . $value['name'] . '</a></h4>';
						}
					} else {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($value['name']) . '</h4>';
						}
					}
					if ( get_wppb_array_value_by_key( $value, 'designation' ) ) {
						$output .= '<span class="wppb-testimonial-designation">' . wp_kses_post($value['designation']) . '</span>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';

				}

			} elseif ( $testimonial_layout == "layoutfour" ) {
				foreach ( $testimonial_list as $key => $value ) {

					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						$target  = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['window'] ) ? 'target=_blank' : 'target=_self';
						$nofolow = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['nofolow'] ) ? 'rel=nofolow' : "";
					}

					$output .= '<div class="wppb-testimonial-content">';
					$output .= '<div class="wppb-testimonial-content-in">';
					$output .= '<span class="wppb-testimonial-quote wppb-font-quote"></span>';
					if ( get_wppb_array_value_by_key( $value, 'introtext' ) ) {
						$output .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($value['introtext']) . '</div>';
					}
					if ( ! empty( $value['image']['url'] ) ) {
						$img_url = $value['image']['url'];
						$output  .= '<div class="wppb-testimonial-image">';
						$output  .= '<img class="wppb-testimonial-addon-img" src="' . esc_url( $img_url ) . '" alt="' . esc_attr( get_wppb_array_value_by_key( $value, 'name' ) ) . '">';
						$output  .= '</div>';
					}
					$output .= '<div class="wppb-testimonial-title">';
					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name"><a ' . esc_attr( $nofolow ) . ' href="' . esc_url( $value['name_link']['link'] ) . '" ' . esc_attr( $target ) . '>' . $value['name'] . '</a></h4>';
						}
					} else {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($value['name']) . '</h4>';
						}
					}
					if ( get_wppb_array_value_by_key( $value, 'designation' ) ) {
						$output .= '<span class="wppb-testimonial-designation">' . wp_kses_post($value['designation']) . '</span>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';

				}

			} else {
				foreach ( $testimonial_list as $key => $value ) {
					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						$target  = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['window'] ) ? 'target=_blank' : 'target=_self';
						$nofolow = ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['nofolow'] ) ? 'rel=nofolow' : "";
					}
					$output .= '<div class="wppb-testimonial-content">';
					$output .= '<div class="wppb-testimonial-content-in">';
					if ( get_wppb_array_value_by_key( $value, 'introtext' ) ) {
						$output .= '<div class="wppb-testimonial-introtext">' . wp_kses_post($value['introtext']) . '</div>';
					}
					$output .= '<div class="wppb-testimonial-information">';
					if ( ! empty( $value['image']['url'] ) ) {
						$img_url = $value['image']['url'];
						$output  .= '<div class="wppb-testimonial-image">';
						$output  .= '<img class="wppb-testimonial-addon-img" src="' . esc_url( $img_url ) . '" alt="' . esc_attr( get_wppb_array_value_by_key( $value, 'name' ) ) . '">';
						$output  .= '</div>';
					}
					$output .= '<div class="wppb-testimonial-title">';
					if ( ! empty( get_wppb_array_value_by_key( $value, 'name_link' )['link'] ) ) {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name"><a ' . esc_attr( $nofolow ) . ' href="' . esc_url( $value['name_link']['link'] ) . '" ' . esc_attr( $target ) . '>' . $value['name'] . '</a></h4>';
						}
					} else {
						if ( get_wppb_array_value_by_key( $value, 'name' ) ) {
							$output .= '<h4 class="wppb-testimonial-name">' . wp_kses_post($value['name']) . '</h4>';
						}
					}
					if ( get_wppb_array_value_by_key( $value, 'designation' ) ) {
						$output .= '<span class="wppb-testimonial-designation">' . wp_kses_post($value['designation']) . '</span>';
					}
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';
				}
			}
		}
		$output  .= '</div>';
		$output  .= '</div>';
		$output  .= '</div>';

		return $output;
	}

	// Testimonial Template
	public function getTemplate(){
		$output = '
			<#
			var rand = Math.floor(Math.random() * 1000);

			var autoplay_option = "";
			if(data.autoplay_option == 1){
				autoplay_option = "true";
			} else {
				autoplay_option = "false";
			}
			var control_dots = "";
			if(data.control_dots == 1){
				control_dots = "true";
			} else {
				control_dots = "false";
			}
			var control_nav = "";
			if(data.control_nav == 1){
				control_nav = "true";
			} else {
				control_nav = "false";
			}
			column =  data.column ? data.column : "1";
			control_nav_style =  data.control_nav_style ? data.control_nav_style : "nav_style1";
			#>
			<div class="wppb-testimonial-addon">
				<div class="wppb-testimonial-carousel-addon-content testimonial-layout-{{data.testimonial_layout}}">
					<div class="wppb-testimonial-content-carousel wppb-testimonial-{{column}} {{control_nav_style}} " data-col="{{column}}" data-shownav="{{control_nav}}" data-showdots="{{control_dots}}" data-autoplay="{{autoplay_option}}" data-speed="{{data.speed_option}}">
						<# if( data.testimonial_layout == "layouttwo" ){ #>
							<#  _.forEach(data.testimonial_list, function(value, key) { #>
								<div class="wppb-testimonial-content">
									<div class="wppb-testimonial-content-in">
										<# if ( value.image ) { #>
											<div class="wppb-testimonial-image">
												<img class="wppb-testimonial-addon-img" src="{{value.image.url}}">
											</div>
										<# } #>
										<div class="wppb-testimonial-introtext">{{{value.introtext}}}</div>
										<div class="wppb-testimonial-title">
											<# if( value.name_link ){ #>
												<h4 class="wppb-testimonial-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{{value.name}}}</a></h4>
											<# } else { #>
												<h4 class="wppb-testimonial-name">{{{value.name}}}</h4>
											<# } #>
											<span class="wppb-testimonial-designation">{{{value.designation}}}</span>
										</div>
									</div>
								</div>
							<# }); #>
						<# } else if( data.testimonial_layout == "layoutthree" ){ #>

							<#  _.forEach(data.testimonial_list, function(value, key) { #>
								<div class="wppb-testimonial-content">
									<div class="wppb-testimonial-content-in">
										<div class="wppb-testimonial-introtext">{{{value.introtext}}}</div>
										<# if ( value.image ) { #>
											<div class="wppb-testimonial-image">
												<img class="wppb-testimonial-addon-img" src="{{value.image.url}}">
											</div>
										<# } #>
										<div class="wppb-testimonial-title">
											<# if( value.name_link ){ #>
												<h4 class="wppb-testimonial-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{{value.name}}}</a></h4>
											<# } else { #>
												<h4 class="wppb-testimonial-name">{{{value.name}}}</h4>
											<# } #>
											<span class="wppb-testimonial-designation">{{{value.designation}}}</span>
										</div>
									</div>
								</div>
							<# }); #>

						<# } else if( data.testimonial_layout == "layoutfour" ){ #>

								<#  _.forEach(data.testimonial_list, function(value, key) { #>
									<div class="wppb-testimonial-content">
										<div class="wppb-testimonial-content-in">
											<span class="wppb-testimonial-quote wppb-font-quote"></span>
											<div class="wppb-testimonial-introtext">{{{value.introtext}}}</div>
											<# if ( value.image ) { #>
												<div class="wppb-testimonial-image">
													<img class="wppb-testimonial-addon-img" src="{{value.image.url}}">
												</div>
											<# } #>
											<div class="wppb-testimonial-title">
												<# if( value.name_link ){ #>
													<h4 class="wppb-testimonial-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{{value.name}}}</a></h4>
												<# } else { #>
													<h4 class="wppb-testimonial-name">{{{value.name}}}</h4>
												<# } #>
												<span class="wppb-testimonial-designation">{{{value.designation}}}</span>
											</div>
										</div>
									</div>
								<# }); #>

						<# } else {  #>

							<#  _.forEach(data.testimonial_list, function(value, key) { #>
								<div class="wppb-testimonial-content">
									<div class="wppb-testimonial-content-in">
										<div class="wppb-testimonial-introtext">{{{value.introtext}}}</div>
										<div class="wppb-testimonial-information">
											<# if ( value.image ) { #>
												<div class="wppb-testimonial-image">
													<img class="wppb-testimonial-addon-img" src="{{value.image.url}}">
												</div>
											<# } #>
											<div class="wppb-testimonial-title">
												<# if( value.name_link ){ #>
													<h4 class="wppb-testimonial-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{{value.name}}}</a></h4>
												<# } else { #>
													<h4 class="wppb-testimonial-name">{{{value.name}}}</h4>
												<# } #>
												<span class="wppb-testimonial-designation">{{{value.designation}}}</span>
											</div>
										</div>
									</div>
								</div>

							<# }); #>

						<# } #>

					</div>
				</div>
			</div>
		';
		return $output;
	}

}