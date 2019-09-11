<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Person_Carousel{

	public function get_name(){
		return 'wppb_person_carousel';
	}
	public function get_title(){
		return 'Person Carousel';
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

	// Person Settings Fields
	public function get_settings() {

		$settings = array(
			'person_layout' => array(
				'type' => 'radioimage',
				'title' => 'Layout',
				'values'=> array(
					'layoutone' =>  WPPB_DIR_URL.'addons/person_carousel/img/person-img1.png',
					'layouttwo' =>  WPPB_DIR_URL.'addons/person_carousel/img/person-img2.png',
					'layoutthree' =>  WPPB_DIR_URL.'addons/person_carousel/img/person-img3.png',
					'layoutfour' =>  WPPB_DIR_URL.'addons/person_carousel/img/person-img4.png',
				),
				'std' => 'layoutone',
			),

			'person_list' => array(
				'title' => __('Person List','wp-pagebuilder'),
				'type' => 'repeatable',
				'label' => 'name',
				'std' => array(
					array(
						'image' => array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-large.jpg' ),
						'name' 				=> 'Michel Clark',
						'name_link' => array('link'=>'','window'=>true,'nofolow'=>false),
						'designation' => 'Developer',
						'introtext' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
						'show_social' => '1',
						'icon_list1' => 'fab fa-facebook-f',
						'socialurl1' => '#',
						'icon_list2' => 'fab fa-twitter',
						'socialurl2' => '#',
						'icon_list3' => 'fab fa-flickr',
						'socialurl3' => '#'
					),
					array(
						'image' => array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-medium.jpg' ),
						'name' 				=> 'Jhon Doe',
						'name_link' => array('link'=>'','window'=>true,'nofolow'=>false),
						'designation' => 'Designer',
						'introtext' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
						'show_social' => '1',
						'icon_list1' => 'fab fa-facebook-f',
						'socialurl1' => '#',
						'icon_list2' => 'fab fa-twitter',
						'socialurl2' => '#',
						'icon_list3' => 'fab fa-flickr',
						'socialurl3' => '#'
					),
					array( 
						'image' => array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-medium.jpg' ),
						'name' 				=> 'Stephen Fleming',
						'name_link' => array('link'=>'','window'=>true,'nofolow'=>false),
						'designation' => 'Founder',
						'introtext' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
						'show_social' => '1',
						'icon_list1' => 'fab fa-facebook-f',
						'socialurl1' => '#',
						'icon_list2' => 'fab fa-twitter',
						'socialurl2' => '#',
						'icon_list3' => 'fab fa-flickr',
						'socialurl3' => '#'
					),

				),
				'attr' => array(
					'image' => array(
						'type' => 'media',
						'title' => __('Image','wp-pagebuilder'),
						'std' => array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-medium.jpg' ), 
					),
					'name' => array(
						'type' => 'text',
						'title' => __('Name','wp-pagebuilder'),
						'std' => 'Jhon Doe',
					),
					'name_link' => array(
						'type' => 'link',
						'title' => __('Profile URL','wp-pagebuilder'),
						'std' =>   array('link'=>'','window'=>false,'nofolow'=>false),
					),
					'email' => array(
						'type' => 'text',
						'title' => __('email','wp-pagebuilder'),
						'placeholder' => 'example@example.com',
					),
					'designation' => array(
						'type' => 'text',
						'title' => __('designation','wp-pagebuilder'),
						'std' => 'Designer',
					),
					'introtext' => array(
						'type' => 'textarea',
						'title' => __('Message text','wp-pagebuilder'),
						'std' => 'She was bouncing away, when a cry from the two women, who had turned towards the bed, caused her to look round.',
					),
					'show_social' => array(
						'type' => 'switch',
						'title' => __('Show Social Media URL','wp-pagebuilder'),
						'std' => '1'
					),
					'icon_list1' => array(
						'type' => 'iconsocial',
						'title' => __('Icon 1','wp-pagebuilder'),
						'std' => 'fab fa-facebook-f',
						'depends' => array(array('show_social', '!=', '')),
					),
					'socialurl1' => array(
						'type' => 'text',
						'title' => __('social URL 1','wp-pagebuilder'),
						'std' => '#',
						'depends' => array(array('show_social', '!=', '')),
					),
					'icon_list2' => array(
						'type' => 'iconsocial',
						'title' => __('Icon 2','wp-pagebuilder'),
						'std' => 'fab fa-facebook-f',
						'depends' => array(array('show_social', '!=', '')),
					),
					'socialurl2' => array(
						'type' => 'text',
						'title' => __('social URL 2','wp-pagebuilder'),
						'std' => '#',
						'depends' => array(array('show_social', '!=', '')),
					),
					'icon_list3' => array(
						'type' => 'iconsocial',
						'title' => __('Icon 3','wp-pagebuilder'),
						'std' => 'fab fa-facebook-f',
						'depends' => array(array('show_social', '!=', '')),
					),
					'socialurl3' => array(
						'type' => 'text',
						'title' => __('social URL 3','wp-pagebuilder'),
						'std' => '#',
						'depends' => array(array('show_social', '!=', '')),
					),
					'icon_list4' => array(
						'type' => 'iconsocial',
						'title' => __('Icon 4','wp-pagebuilder'),
						'std' => 'fab fa-facebook-f',
						'depends' => array(array('show_social', '!=', '')),
					),
					'socialurl4' => array(
						'type' => 'text',
						'title' => __('social URL 4','wp-pagebuilder'),
						'std' => '#',
						'depends' => array(array('show_social', '!=', '')),
					),
					'icon_list5' => array(
						'type' => 'iconsocial',
						'title' => __('Icon 4','wp-pagebuilder'),
						'std' => 'fab fa-facebook-f',
						'depends' => array(array('show_social', '!=', '')),
					),
					'socialurl5' => array(
						'type' => 'text',
						'title' => __('social URL 5','wp-pagebuilder'),
						'std' => '#',
						'depends' => array(array('show_social', '!=', '')),
					),
					'icon_list6' => array(
						'type' => 'iconsocial',
						'title' => __('Icon 6','wp-pagebuilder'),
						'std' => 'fab fa-facebook-f',
						'depends' => array(array('show_social', '!=', '')),
					),
					'socialurl6' => array(
						'type' => 'text',
						'title' => __('social URL 6','wp-pagebuilder'),
						'std' => '#',
						'depends' => array(array('show_social', '!=', '')),
					),
				),
			),
			'autoplay_option' => array(
				'type' => 'switch',
				'title' => __('Autoplay Option','wp-pagebuilder'),
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
				'std' => '0',
				'section' => 'Slide Settings',
			),
			'control_nav' => array(
				'type' => 'switch',
				'title' => __('Control Nav','wp-pagebuilder'),
				'std' => '1',
				'section' => 'Slide Settings',
			),
			'control_nav_style' => array(
				'type' => 'select',
				'title' => __('Style','wp-pagebuilder'),
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
			'person_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'section' => 'Slide Settings',
				'selector' => '{{SELECTOR}} .wppb-person-carousel-addon-content{ text-align: {{data.person_align}}; }'
			),

			//style
			'img_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 55,
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
						'md' => '',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-person-addon-img { width: {{data.img_width}}; }',
			),
			'img_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
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
						'md' => '',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-person-addon-img, {{SELECTOR}} .person-layout-layoutone .wppb-person-addon-img { height: {{data.img_height}}; }',
			),
			'img_radius' => array(
				'type' => 'dimension',
				'title' => __('Border Radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-person-addon-img { border-radius: {{data.img_radius}}; }',
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
				'selector' => '{{SELECTOR}} .wppb-person-addon-img'
			),

			//name
			'name_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => true,
				'std' => array(
					'colorType' => 'color',
					'clip' => true,
					'colorColor' => '#666666',
				),
				'section' => 'Name',
				'selector' => '{{SELECTOR}} .wppb-person-name, {{SELECTOR}} .wppb-person-name a'
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
				'selector' => '{{SELECTOR}} .wppb-person-name',
				'section' => 'Name',
				'tab' => 'style',
			),
			'name_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-name { padding: {{data.name_padding}}; }',
				'section' => 'Name',
			),
			'name_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-name { margin: {{data.name_margin}}; }',
				'section' => 'Name',
			),
			//Designation	
			'desgn_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Designation',
				'selector' => '{{SELECTOR}} .wppb-person-designation { color: {{data.desgn_color}}; }'
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
				'selector' => '{{SELECTOR}} .wppb-person-designation',
				'section' => 'Designation',
				'tab' => 'style',
			),
			//email
			'email_color' => array(
				'type' => 'color',
				'title' => __('color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Email',
				'selector' => '{{SELECTOR}} .wppb-person-email { color: {{data.email_color}}; }'
			),
			'email_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-person-email',
				'section' => 'Email',
				'tab' => 'style',
			),
			'email_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-email { margin: {{data.email_margin}}; }',
				'section' => 'Email',
			),

			//intro
			'intro_color' => array(
				'type' => 'color',
				'title' => __('color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Message text',
				'selector' => '{{SELECTOR}} .wppb-person-introtext { color: {{data.intro_color}}; }'
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
				'selector' => '{{SELECTOR}} .wppb-person-introtext',
				'section' => 'Message text',
				'tab' => 'style',
			),
			'message_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-introtext { margin: {{data.message_margin}}; }',
				'section' => 'Message text',
			),

			//social
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Size','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 40,
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
					'md' => '18px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a { font-size: {{data.icon_size}}; }'
			),

			'icon_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 40,
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
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a { width: {{data.icon_width}}; }'
			),

			'icon_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
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
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => array(
					'{{SELECTOR}} .wppb-person-social li a { height: {{data.icon_height}}; }',
					'{{SELECTOR}} .wppb-person-social li a { line-height: {{data.icon_height}}; }',
				)
			),

			'icon_line_height' => array(
				'type' => 'slider',
				'title' => __('Line Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
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
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' =>  '{{SELECTOR}} .wppb-person-social li a { line-height: {{data.icon_line_height}}; }',
			),

			'icon_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' =>'{{SELECTOR}} .wppb-person-social li a { color: {{data.icon_color}}; }',
			),
			'icon_hcolor' => array(
				'type' => 'color',
				'title' => __('Hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' =>'{{SELECTOR}}  .wppb-person-social li a i:hover { color: {{data.icon_hcolor}}; }',
			),
			'icon_bg' => array(
				'type' => 'color',
				'title' => __('background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a { background: {{data.icon_bg}}; }'
			),
			'icon_hover_bg' => array(
				'type' => 'color',
				'title' => __('Hover background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a:hover{ background: {{data.icon_hover_bg}}; }'
			),
			'icon_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '50px', 'right' => '50px', 'bottom' => '50px', 'left' => '50px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a { border-radius: {{data.icon_radius}}; }'
			),
			'icon_border' => array(
				'type' => 'border',
				'title' => 'Icon Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a'
			),
			'border_hcolor' => array(
				'type' => 'border',
				'title' => 'Border hover color',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Social Share',
				'selector' => '{{SELECTOR}} .wppb-person-social li a:hover'
			),

			'share_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-social { margin: {{data.share_margin}}; }',
				'section' => 'Social Share',
			),

			// dots
			'dot_position' => array(
				'type' => 'slider',
				'title' => __('Position','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => -20,
						'max' => 40,
						'step' => .1,
					),
					'px' => array(
						'min' => -200,
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
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Dots Style',
				'depends' => array(array('control_dots', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .slick-dots { bottom: {{data.dot_position}}; }',
			),
			'dot_bg_color' => array(
				'type' => 'color',
				'title' => __('background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .slick-dots li button { background: {{data.dot_bg_color}}; }'
			),
			'dot_bg_hcolor' => array(
				'type' => 'color',
				'title' => __('Hover/active background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .slick-dots li.slick-active button, {{SELECTOR}} .wppb-person-content-carousel .slick-dots li button:hover { background: {{data.dot_bg_hcolor}}; }'
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
						'max' => 10,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 100,
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .slick-dots li button, {{SELECTOR}} .wppb-person-content-carousel .slick-dots li { width: {{data.dot_width}}; }'
			),
			'dot_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
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
						'md' => '16px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Dots Style',
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .slick-dots li button, {{SELECTOR}} .wppb-person-content-carousel .slick-dots li { height: {{data.dot_height}}; }'
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .slick-dots li button { border-radius: {{data.dot_radius}}; }'
			),

			// nav
			'nav_position' => array(
				'type' => 'slider',
				'title' => __('Position','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 55,
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
						'md' => '35%',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev,{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { top: {{data.nav_position}}; }',
			),
			'nav_left_position' => array(
				'type' => 'slider',
				'title' => __('Prev Position','wp-pagebuilder'),
				'unit' => array( 'px','em','%' ),
				'std' => array(
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav_style', '=', 'nav_style2')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel.nav_style2 .wppb-carousel-next { right: {{data.nav_left_position}}; }',
			),
			'nav_right_position' => array(
				'type' => 'slider',
				'title' => __('Next Position','wp-pagebuilder'),
				'unit' => array( 'px','em','%' ),
				'range' => array(
					'em' => array(
						'min' => -50,
						'max' => 80,
						'step' => .1,
					),
					'px' => array(
						'min' => -100,
						'max' => 1000,
						'step' => 1,
					),
					'%' => array(
						'min' => -100,
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
				'depends' => array(array('control_nav_style', '=', 'nav_style3')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel.nav_style3 .wppb-carousel-prev { left: {{data.nav_right_position}}; }',
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev { font-size: {{data.nav_font_size}}; }',
			),
			'nav_color' => array(
				'type' => 'color',
				'title' => __('color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { color: {{data.nav_color}}; }'
			),
			'nav_bg_color' => array(
				'type' => 'color',
				'title' => __('Background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { background: {{data.nav_bg_color}}; }'
			),
			'nav_hcolor' => array(
				'type' => 'color',
				'title' => __('Hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev:hover, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next:hover { color: {{data.nav_hcolor}}; }'
			),
			'nav_bg_hcolor' => array(
				'type' => 'color',
				'title' => __('Background hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev:hover, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next:hover { background: {{data.nav_bg_hcolor}}; }'
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { width: {{data.nav_width}}; }'
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { height: {{data.nav_height}}; }',
			),
			'nav_line_height' => array(
				'type' => 'slider',
				'title' => __('Line Height','wp-pagebuilder'),
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { line-height: {{data.nav_line_height}}; }',
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next { border-radius: {{data.nav_radius}}; }'
			),
			'nav_border' => array(
				'type' => 'border',
				'title' => 'Nav Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Nav Style',
				'depends' => array(array('control_nav', '!=', '')),
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev,{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next'
			),
			'nav_border_hcolor' => array(
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
				'selector' => '{{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-prev:hover, {{SELECTOR}} .wppb-person-content-carousel .wppb-carousel-next:hover'
			),

			//wrapper
			'wrap_background' => array(
				'type' => 'background',
				'title' => '',
				'selector' => '{{SELECTOR}} .wppb-person-addon-content',
				'tab' => 'style',
				'section' => 'Person Wrapper',
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
				'section' => 'Person Wrapper',
				'selector' => '{{SELECTOR}} .wppb-person-addon-content'
			),
			'wrap_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Person Wrapper',
				'selector' => '{{SELECTOR}} .wppb-person-addon-content { border-radius: {{data.wrap_radius}}; }'
			),
			'wrap_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'tab' => 'style',
				'section' => 'Person Wrapper',
				'selector' => '{{SELECTOR}} .wppb-person-addon-content.slick-active'
			),
			'wrap_padding'  => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-addon-content { padding: {{data.wrap_padding}}; }',
				'section' => 'Person Wrapper',
			),
			'wrap_margin' => array(
				'type' => 'slider',
				'title' => __('Margin Right','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 55,
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
						'md' => '20px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Person Wrapper',
				'selector' => array('{{SELECTOR}} .wppb-person-content-carousel .slick-slide { margin-right: {{data.wrap_margin}}; }',
				'{{SELECTOR}} .wppb-person-content-carousel .slick-list { margin-right: -{{data.wrap_margin}}; }')
			),

			'inner_background' => array(
				'type' => 'color',
				'title' => 'Inner content Background',
				'selector' => '{{SELECTOR}} .wppb-person-information-wrap { background: {{data.inner_background}}; }',
				'tab' => 'style',
				'section' => 'Inner content Wrapper',
				'depends' => array(array('person_layout', '=', 'layouttwo')),
			),
			'inner_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Inner content box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-person-information-wrap',
				'section' => 'Inner content Wrapper',
				'depends' => array(array('person_layout', '=', 'layouttwo')),
			),
			'inner_padding'  => array(
				'type' => 'dimension',
				'title' => 'Inner Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .person-layout-layoutone, {{SELECTOR}} .wppb-person-information-wrap { padding: {{data.inner_padding}}; }',
				'section' => 'Inner content Wrapper',
			),
			

		);
		return $settings;
	}

	// Person Render HTML
	public function render($data = null){
		$settings 		    = $data['settings'];

		$person_list        = isset($settings["person_list"]) ? $settings["person_list"] : array();
		$person_layout      = isset($settings['person_layout']) ? $settings['person_layout'] : 'layouttwo';
		$autoplay_option  	= isset($settings['autoplay_option']) ? $settings['autoplay_option'] : '1';
		$control_nav  	 	  = isset($settings['control_nav']) ? $settings['control_nav'] : '1';
		$control_dots  	 	  = isset($settings['control_dots']) ? $settings['control_dots'] : '1';
		$control_nav_style  = isset($settings['control_nav_style']) ? $settings['control_nav_style'] : '';
		$column  	 	 	      = isset($settings['column']) ? $settings['column'] : '';
		$speed_option  	 	 	= isset($settings['speed_option']) ? $settings['speed_option'] : '500';
		$rand               = rand(1000,999999);
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

		$output  .= '<div class="wppb-person-addon">';
			$output  .= '<div class="wppb-person-carousel-addon-content person-layout-'.esc_attr($person_layout).'">';
				$output  .= '<div class="wppb-person-content-carousel wppb-person-'.esc_attr($column).' '.esc_attr($control_nav_style).'" data-col="'.esc_attr($column).'" data-shownav="'.esc_attr($control_nav).'" data-showdots="'.esc_attr($control_dots).'" data-autoplay="'.esc_attr($autoplay_option).'" data-speed="'.esc_attr($speed_option).'">';
					
				if( $person_layout == "layouttwo" ){
						foreach ($person_list as $key => $value ) {
							
							if( !empty(get_wppb_array_value_by_key($value, 'name_link')['link'])) {
								$target = !empty(get_wppb_array_value_by_key($value, 'name_link')['window']) ? 'target=_blank' : 'target=_self';
								$nofolow = !empty(get_wppb_array_value_by_key($value, 'name_link')['nofolow']) ? 'rel=nofolow' : "";
							}

							$output  .= '<div class="wppb-person-addon-content">';

								if ( ! empty($value['image']['url']) ) {
									$img_url = $value['image']['url'];
									$output .= '<div class="wppb-person-image">';
										$output .= '<img class="wppb-person-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr( get_wppb_array_value_by_key($value, 'name') ) .'">';
									$output .= '</div>';
								}
								$output  .= '<div class="wppb-person-information-wrap">';
									$output  .= '<div class="wppb-person-information">';
										if( ! empty(get_wppb_array_value_by_key($value, 'name_link')['link']) ){
											if( get_wppb_array_value_by_key($value, 'name') ){
												$output  .= '<span class="wppb-person-name"><a '.esc_attr($nofolow).' href="'.esc_url($value['name_link']['link']).'" '.esc_attr($target).'>'.$value['name'].'</a></span>';
											}
										} else {
											if( get_wppb_array_value_by_key($value, 'name') ){
												$output  .= '<span class="wppb-person-name">'.$value['name'].'</span>';
											}
										}
										if( get_wppb_array_value_by_key($value, 'designation') ){
											$output  .= '<span class="wppb-person-designation">'.$value['designation'].'</span>';
										}
										if( get_wppb_array_value_by_key($value, 'email') ){
											$output  .= '<span class="wppb-person-email">'.$value['email'].'</span>';
										}
										if( get_wppb_array_value_by_key($value, 'introtext') ){
											$output  .= '<div class="wppb-person-introtext">'.$value['introtext'].'</div>';
										}
									$output  .= '</div>';//wppb-person-information
									if( get_wppb_array_value_by_key($value, 'show_social') == 1 ) {
										$output  .= '<ul class="wppb-person-social">';
											if(get_wppb_array_value_by_key($value, 'socialurl1')){
												$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl1')).'" target="_blank"><i class="'.esc_attr($value['icon_list1']).'"></i></a></li>';
											}
											if(get_wppb_array_value_by_key($value, 'socialurl2')){
												$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl2')).'" target="_blank"><i class="'.esc_attr($value['icon_list2']).'"></i></a></li>';
											}
											if(get_wppb_array_value_by_key($value, 'socialurl3')){
												$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl3')).'" target="_blank"><i class="'.esc_attr($value['icon_list3']).'"></i></a></li>';
											}
											if(get_wppb_array_value_by_key($value, 'socialurl4')){
												$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl4')).'" target="_blank"><i class="'.esc_attr($value['icon_list4']).'"></i></a></li>';
											}
											if(get_wppb_array_value_by_key($value, 'socialurl5')){
												$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl5')).'" target="_blank"><i class="'.esc_attr($value['icon_list5']).'"></i></a></li>';
											}
											if(get_wppb_array_value_by_key($value, 'socialurl6')){
												$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl6')).'" target="_blank"><i class="'.esc_attr($value['icon_list6']).'"></i></a></li>';
											}
										$output  .= '</ul>';
									}
								$output  .= '</div>';

							$output .= '</div>';
						}

					} elseif ( $person_layout == "layoutthree" ) {
						foreach ( $person_list as $key => $value ) {
							if( !empty(get_wppb_array_value_by_key($value, 'name_link')['link'])) {
								$target = !empty(get_wppb_array_value_by_key($value, 'name_link')['window']) ? 'target=_blank' : 'target=_self';
								$nofolow = !empty(get_wppb_array_value_by_key($value, 'name_link')['nofolow']) ? 'rel=nofolow' : "";
							}

							$output  .= '<div class="wppb-person-addon-content">';

								$output  .= '<div class="wppb-person-media">';
									if ( ! empty($value['image']['url']) ) {
										$img_url = $value['image']['url'];
										$output .= '<div class="wppb-person-image">';
											$output .= '<img class="wppb-person-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr( get_wppb_array_value_by_key($value, 'name') ) .'">';
										$output .= '</div>';
									}
									$output  .= '<div class="wppb-person-media-body">';
										$output  .= '<div class="wppb-person-information">';
											if( ! empty(get_wppb_array_value_by_key($value, 'name_link')['link']) ){
												if( get_wppb_array_value_by_key($value, 'name') ){
													$output  .= '<span class="wppb-person-name"><a '.esc_attr($nofolow).' href="'.esc_url($value['name_link']['link']).'" '.esc_attr($target).'>'.$value['name'].'</a></span>';
												}
											} else {
												if( get_wppb_array_value_by_key($value, 'name') ){
													$output  .= '<span class="wppb-person-name">'.$value['name'].'</span>';
												}
											}
											if( get_wppb_array_value_by_key($value, 'designation') ){
												$output  .= '<span class="wppb-person-designation">'.$value['designation'].'</span>';
											}
											if( get_wppb_array_value_by_key($value, 'email') ){
												$output  .= '<span class="wppb-person-email">'.$value['email'].'</span>';
											}
											if( get_wppb_array_value_by_key($value, 'introtext') ){
												$output  .= '<div class="wppb-person-introtext">'.$value['introtext'].'</div>';
											}
										$output  .= '</div>';//wppb-person-information
										if( get_wppb_array_value_by_key($value, 'show_social') == 1 ) {
											$output  .= '<ul class="wppb-person-social">';
												if(get_wppb_array_value_by_key($value, 'socialurl1')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl1')).'" target="_blank"><i class="'.esc_attr($value['icon_list1']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl2')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl2')).'" target="_blank"><i class="'.esc_attr($value['icon_list2']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl3')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl3')).'" target="_blank"><i class="'.esc_attr($value['icon_list3']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl4')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl4')).'" target="_blank"><i class="'.esc_attr($value['icon_list4']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl5')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl5')).'" target="_blank"><i class="'.esc_attr($value['icon_list5']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl6')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl6')).'" target="_blank"><i class="'.esc_attr($value['icon_list6']).'"></i></a></li>';
												}
											$output  .= '</ul>';
										}
									$output  .= '</div>';
								$output  .= '</div>';


							$output .= '</div>';
						}

					} elseif ( $person_layout == "layoutfour" ) {
						foreach ( $person_list as $key => $value ) {
							if( !empty(get_wppb_array_value_by_key($value, 'name_link')['link'])) {
								$target = !empty(get_wppb_array_value_by_key($value, 'name_link')['window']) ? 'target=_blank' : 'target=_self';
								$nofolow = !empty(get_wppb_array_value_by_key($value, 'name_link')['nofolow']) ? 'rel=nofolow' : "";
							}
							$output  .= '<div class="wppb-person-addon-content">';
								$output  .= '<div class="wppb-person-media">';
									if ( ! empty($value['image']['url']) ) {
										$img_url = $value['image']['url'];
										$output .= '<div class="wppb-person-image">';
											$output .= '<img class="wppb-person-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr( get_wppb_array_value_by_key($value, 'name') ) .'">';
										$output .= '</div>';
									}
									$output  .= '<div class="wppb-person-media-body">';
										$output  .= '<div class="wppb-person-information">';
											if( ! empty(get_wppb_array_value_by_key($value, 'name_link')['link']) ){
												if( get_wppb_array_value_by_key($value, 'name') ){
													$output  .= '<span class="wppb-person-name"><a '.esc_attr($nofolow).' href="'.esc_url($value['name_link']['link']).'" '.esc_attr($target).'>'.$value['name'].'</a></span>';
												}
											} else {
												if( get_wppb_array_value_by_key($value, 'name') ){
													$output  .= '<span class="wppb-person-name">'.$value['name'].'</span>';
												}
											}
											if( get_wppb_array_value_by_key($value, 'designation') ){
												$output  .= '<span class="wppb-person-designation">'.$value['designation'].'</span>';
											}
											if( get_wppb_array_value_by_key($value, 'email') ){
												$output  .= '<span class="wppb-person-email">'.$value['email'].'</span>';
											}
											if( get_wppb_array_value_by_key($value, 'introtext') ){
												$output  .= '<div class="wppb-person-introtext">'.$value['introtext'].'</div>';
											}
										$output  .= '</div>';//wppb-person-information
										if( get_wppb_array_value_by_key($value, 'show_social') == 1 ) {
											$output  .= '<ul class="wppb-person-social">';
												if(get_wppb_array_value_by_key($value, 'socialurl1')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl1')).'" target="_blank"><i class="'.esc_attr($value['icon_list1']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl2')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl2')).'" target="_blank"><i class="'.esc_attr($value['icon_list2']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl3')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl3')).'" target="_blank"><i class="'.esc_attr($value['icon_list3']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl4')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl4')).'" target="_blank"><i class="'.esc_attr($value['icon_list4']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl5')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl5')).'" target="_blank"><i class="'.esc_attr($value['icon_list5']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl6')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl6')).'" target="_blank"><i class="'.esc_attr($value['icon_list6']).'"></i></a></li>';
												}
											$output  .= '</ul>';
										}
									$output  .= '</div>';
								$output  .= '</div>';
							$output  .= '</div>';
						}

					} else {
						foreach ( $person_list as $key => $value ) {
							if( !empty(get_wppb_array_value_by_key($value, 'name_link')['link'])) {
								$target = !empty(get_wppb_array_value_by_key($value, 'name_link')['window']) ? 'target=_blank' : 'target=_self';
								$nofolow = !empty(get_wppb_array_value_by_key($value, 'name_link')['nofolow']) ? 'rel=nofolow' : "";
							}
							$output  .= '<div class="wppb-person-addon-content wppb-key-'.$key.'">';
								if ( ! empty($value['image']['url']) ) {
									$img_url = $value['image']['url'];
									$output .= '<div class="wppb-person-image">';
										$output .= '<img class="wppb-person-addon-img" src="'.esc_url($img_url).'" alt="'. esc_attr( get_wppb_array_value_by_key($value, 'name') ) .'">';
									$output .= '</div>';
								}
								$output  .= '<div class="wppb-person-information-wrap">';
									$output  .= '<div class="wppb-person-information">';
										if( ! empty(get_wppb_array_value_by_key($value, 'name_link')['link']) ){
											if( get_wppb_array_value_by_key($value, 'name') ){
												$output  .= '<span class="wppb-person-name"><a '.esc_attr($nofolow).' href="'.esc_url($value['name_link']['link']).'" '.esc_attr($target).'>'.$value['name'].'</a></span>';
											}
										} else {
											if( get_wppb_array_value_by_key($value, 'name') ){
												$output  .= '<span class="wppb-person-name">'.$value['name'].'</span>';
											}
										}
										if( get_wppb_array_value_by_key($value, 'designation') ){
											$output  .= '<span class="wppb-person-designation">'.$value['designation'].'</span>';
										}
										if( get_wppb_array_value_by_key($value, 'email') ){
											$output  .= '<span class="wppb-person-email">'.$value['email'].'</span>';
										}
										if( get_wppb_array_value_by_key($value, 'introtext') ){
											$output  .= '<div class="wppb-person-introtext">'.$value['introtext'].'</div>';
										}
										if( get_wppb_array_value_by_key($value, 'show_social') == 1 ) {
											$output  .= '<ul class="wppb-person-social">';
												if(get_wppb_array_value_by_key($value, 'socialurl1')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl1')).'" target="_blank"><i class="'.esc_attr($value['icon_list1']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl2')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl2')).'" target="_blank"><i class="'.esc_attr($value['icon_list2']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl3')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl3')).'" target="_blank"><i class="'.esc_attr($value['icon_list3']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl4')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl4')).'" target="_blank"><i class="'.esc_attr($value['icon_list4']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl5')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl5')).'" target="_blank"><i class="'.esc_attr($value['icon_list5']).'"></i></a></li>';
												}
												if(get_wppb_array_value_by_key($value, 'socialurl6')){
													$output  .= '<li><a href="'.esc_url(get_wppb_array_value_by_key($value, 'socialurl6')).'" target="_blank"><i class="'.esc_attr($value['icon_list6']).'"></i></a></li>';
												}
											$output  .= '</ul>';
										}
									$output  .= '</div>';//wppb-person-information
								$output  .= '</div>';
							$output  .= '</div>';
						}
					}	
					$output  .= '</div>';
				$output  .= '</div>';
			$output  .= '</div>';

		return $output;
	}

	// Person Template
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
			<div class="wppb-person-addon">
				<div class="wppb-person-carousel-addon-content person-layout-{{data.person_layout}}">
					<div class="wppb-person-content-carousel wppb-person-{{column}} {{control_nav_style}} " data-col="{{column}}" data-shownav="{{control_nav}}" data-showdots="{{control_dots}}" data-autoplay="{{autoplay_option}}" data-speed="{{data.speed_option}}">
						<# if( data.person_layout == "layouttwo" ){ #>
							<#  _.forEach(data.person_list, function(value, key) { #>
								<div class="wppb-person-addon-content">
									<# if ( value.image ) { #>
										<div class="wppb-person-image">
											<img class="wppb-person-addon-img" src="{{value.image.url}}">
										</div>
									<# } #>
									<div class="wppb-person-information-wrap">
										<div class="wppb-person-information">
											<# if( value.name_link ){ #>
												<span class="wppb-person-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{value.name}}</a></span>
											<# } else { #>
												<span class="wppb-person-name">{{value.name}}</span>
											<# } #>
											<# if( value.designation ) { #>
												<span class="wppb-person-designation">{{value.designation}}</span>
											<# } #>
											<# if( value.email ) { #>
												<span class="wppb-person-email">{{value.email}}</span>
											<# } #>
											<# if( value.introtext ) { #>
												<div class="wppb-person-introtext">{{value.introtext}}</div>
											<# } #>

											<# if( value.show_social == 1 ) { #>
												<ul class="wppb-person-social">
													<# if( value.socialurl1 ) { #>
														<li><a href="{{value.socialurl1}}" target="_blank"><i class="{{value.icon_list1}}"></i></a></li>
													<# } #>
													<# if( value.socialurl2 ) { #>
														<li><a href="{{value.socialurl2}}" target="_blank"><i class="{{value.icon_list2}}"></i></a></li>
													<# } #>
													<# if( value.socialurl3 ) { #>
														<li><a href="{{value.socialurl3}}" target="_blank"><i class="{{value.icon_list3}}"></i></a></li>
													<# } #>
													<# if( value.socialurl4 ) { #>
														<li><a href="{{value.socialurl4}}" target="_blank"><i class="{{value.icon_list4}}"></i></a></li>
													<# } #>
													<# if( value.socialurl5 ) { #>
														<li><a href="{{value.socialurl5}}" target="_blank"><i class="{{value.icon_list5}}"></i></a></li>
													<# } #>
													<# if( value.socialurl6 ) { #>
														<li><a href="{{value.socialurl6}}" target="_blank"><i class="{{value.icon_list6}}"></i></a></li>
													<# } #>
												</ul>
											<# } #>
										</div>
									</div>
								</div>
							<# }); #>
						<# } else if( data.person_layout == "layoutthree" ){ #>

							<#  _.forEach(data.person_list, function(value, key) { #>
								<div class="wppb-person-addon-content">
									<div class="wppb-person-media">
										<# if ( value.image ) { #>
											<div class="wppb-person-image">
												<img class="wppb-person-addon-img" src="{{value.image.url}}">
											</div>
										<# } #>
										<div class="wppb-person-media-body">
											<div class="wppb-person-information">
												<# if( value.name_link ){ #>
													<span class="wppb-person-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{value.name}}</a></span>
												<# } else { #>
													<span class="wppb-person-name">{{value.name}}</span>
												<# } #>
												<# if( value.designation ) { #>
													<span class="wppb-person-designation">{{value.designation}}</span>
												<# } #>
												<# if( value.email ) { #>
													<span class="wppb-person-email">{{value.email}}</span>
												<# } #>
												<# if( value.introtext ) { #>
													<div class="wppb-person-introtext">{{value.introtext}}</div>
												<# } #>
											</div>
					
											<# if( value.show_social == 1 ) { #>
												<ul class="wppb-person-social">
													<# if( value.socialurl1 ) { #>
														<li><a href="{{value.socialurl1}}" target="_blank"><i class="{{value.icon_list1}}"></i></a></li>
													<# } #>
													<# if( value.socialurl2 ) { #>
														<li><a href="{{value.socialurl2}}" target="_blank"><i class="{{value.icon_list2}}"></i></a></li>
													<# } #>
													<# if( value.socialurl3 ) { #>
														<li><a href="{{value.socialurl3}}" target="_blank"><i class="{{value.icon_list3}}"></i></a></li>
													<# } #>
													<# if( value.socialurl4 ) { #>
														<li><a href="{{value.socialurl4}}" target="_blank"><i class="{{value.icon_list4}}"></i></a></li>
													<# } #>
													<# if( value.socialurl5 ) { #>
														<li><a href="{{value.socialurl5}}" target="_blank"><i class="{{value.icon_list5}}"></i></a></li>
													<# } #>
													<# if( value.socialurl6 ) { #>
														<li><a href="{{value.socialurl6}}" target="_blank"><i class="{{value.icon_list6}}"></i></a></li>
													<# } #>
												</ul>
											<# } #>
										</div>
									</div>
								</div>

							<# }); #>

						<# } else if( data.person_layout == "layoutfour" ){ #>

								<#  _.forEach(data.person_list, function(value, key) { #>
									<div class="wppb-person-addon-content">
										<div class="wppb-person-media">
											<# if ( value.image ) { #>
												<div class="wppb-person-image">
													<img class="wppb-person-addon-img" src="{{value.image.url}}">
												</div>
											<# } #>
											<div class="wppb-person-media-body">
						
												<div class="wppb-person-information">
													<# if( value.name_link ){ #>
														<span class="wppb-person-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{value.name}}</a></span>
													<# } else { #>
														<span class="wppb-person-name">{{value.name}}</span>
													<# } #>
													<# if( value.designation ) { #>
														<span class="wppb-person-designation">{{value.designation}}</span>
													<# } #>
													<# if( value.email ) { #>
														<span class="wppb-person-email">{{value.email}}</span>
													<# } #>
													<# if( value.introtext ) { #>
														<div class="wppb-person-introtext">{{value.introtext}}</div>
													<# } #>
												</div>
						
												<# if( value.show_social == 1 ) { #>
													<ul class="wppb-person-social">
														<# if( value.socialurl1 ) { #>
															<li><a href="{{value.socialurl1}}" target="_blank"><i class="{{value.icon_list1}}"></i></a></li>
														<# } #>
														<# if( value.socialurl2 ) { #>
															<li><a href="{{value.socialurl2}}" target="_blank"><i class="{{value.icon_list2}}"></i></a></li>
														<# } #>
														<# if( value.socialurl3 ) { #>
															<li><a href="{{value.socialurl3}}" target="_blank"><i class="{{value.icon_list3}}"></i></a></li>
														<# } #>
														<# if( value.socialurl4 ) { #>
															<li><a href="{{value.socialurl4}}" target="_blank"><i class="{{value.icon_list4}}"></i></a></li>
														<# } #>
														<# if( value.socialurl5 ) { #>
															<li><a href="{{value.socialurl5}}" target="_blank"><i class="{{value.icon_list5}}"></i></a></li>
														<# } #>
														<# if( value.socialurl6 ) { #>
															<li><a href="{{value.socialurl6}}" target="_blank"><i class="{{value.icon_list6}}"></i></a></li>
														<# } #>
													</ul>
												<# } #>
											</div>
										</div>
									</div>
								<# }); #>

						<# } else {  #>	
							
							<#  _.forEach(data.person_list, function(value, key) { #>
								<div class="wppb-person-addon-content">
									<# if ( value.image ) { #>
										<div class="wppb-person-image">
											<img class="wppb-person-addon-img" src="{{value.image.url}}">
										</div>
									<# } #>
									<div class="wppb-person-information-wrap">
										<div class="wppb-person-information">
											<# if( value.name_link ){ #>
												<span class="wppb-person-name"><a {{ value.name_link.link ? "href="+value.name_link.link : "" }} {{ value.name_link.window ? "target=_blank" : "" }} {{ value.name_link.nofolow ? "rel=nofolow" : "" }}>{{value.name}}</a></span>
											<# } else { #>
												<span class="wppb-person-name">{{value.name}}</span>
											<# } #>
											<# if( value.designation ) { #>
												<span class="wppb-person-designation">{{value.designation}}</span>
											<# } #>
											<# if( value.email ) { #>
												<span class="wppb-person-email">{{value.email}}</span>
											<# } #>
											<# if( value.introtext ) { #>
												<div class="wppb-person-introtext">{{value.introtext}}</div>
											<# } #>

											<# if( value.show_social == 1 ) { #>
												<ul class="wppb-person-social">
													<# if( value.socialurl1 ) { #>
														<li><a href="{{value.socialurl1}}" target="_blank"><i class="{{value.icon_list1}}"></i></a></li>
													<# } #>
													<# if( value.socialurl2 ) { #>
														<li><a href="{{value.socialurl2}}" target="_blank"><i class="{{value.icon_list2}}"></i></a></li>
													<# } #>
													<# if( value.socialurl3 ) { #>
														<li><a href="{{value.socialurl3}}" target="_blank"><i class="{{value.icon_list3}}"></i></a></li>
													<# } #>
													<# if( value.socialurl4 ) { #>
														<li><a href="{{value.socialurl4}}" target="_blank"><i class="{{value.icon_list4}}"></i></a></li>
													<# } #>
													<# if( value.socialurl5 ) { #>
														<li><a href="{{value.socialurl5}}" target="_blank"><i class="{{value.icon_list5}}"></i></a></li>
													<# } #>
													<# if( value.socialurl6 ) { #>
														<li><a href="{{value.socialurl6}}" target="_blank"><i class="{{value.icon_list6}}"></i></a></li>
													<# } #>
												</ul>
											<# } #>
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