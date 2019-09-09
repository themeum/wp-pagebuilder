<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Feature_Box{

	public function get_name(){
		return 'wppb_feature_box';
	}
	public function get_title(){
		return 'Feature Box';
	}
	public function get_icon() {
		return 'wppb-font-rocket';
	}

	// Feature Box Settings Fields
	public function get_settings() {

		$settings = array(
			'layout' => array(
				'type' => 'radioimage',
				'title' => __( 'Layout', 'wp-pagebuilder' ),
				'values' => array(
					'one' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img1.png',
					'two' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img2.png',
					'three' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img3.png',
					'four' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img4.png',
					'five' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img5.png',
					'six' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img6.png',
					'seven' =>  WPPB_DIR_URL.'addons/feature_box/img/feature-img7.png',
				),
				'std' => 'one'
			),
			'title' => array(
				'type' => 'text',
				'title' => __('Title','wp-pagebuilder'),
				'std' => 'Feature Box',
			),
			'heading_selector' => array(
				'type' => 'select',
				'title' => __('Title Tag','wp-pagebuilder'),
				'values' => array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'span' => 'span',
					'p' => 'p',
					'div' => 'div',
				),
				'std' => 'h3',
			),
			'title_link' => array(
				'type' => 'link',
				'std' => array( 'link'=>'','window'=>false,'nofolow'=>false ),
				'title' => __('Link','wp-pagebuilder'),
				'depends' => array(array('title', '!=', '')),
			),
			'title_animation' => array(
				'type' => 'animation',
				'title' => 'Title Animation',
				'std' => array(
					'name' => 'fadeIn',
					'delay' => '300',
					'duration' => '400'
				),
			),
			//subtitle
			'subtitle' => array(
				'type' => 'text',
				'title' => __('Sub title','wp-pagebuilder'),
				'std' => '',
			),
			'subheading_selector' => array(
				'type' => 'select',
				'title' => __('Sub Title Tag','wp-pagebuilder'),
				'values' => array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'span' => 'span',
					'p' => 'p',
					'div' => 'div',
				),
				'std' => 'h4',
			),
			'subtitle_animation' => array(
				'type' => 'animation',
				'title' => 'Sub Title Animation',
				'std' => array(
					'name' => 'fadeIn',  
					'delay' => '300',    
					'duration' => '400'
				),
			),
			//Number 
			'number' => array(
				'type' => 'text',
				'title' => __('Number','wp-pagebuilder'),
				'depends' => array(array('layout', '=', array('seven'))),
				'std' => '01',
			),
			'number_animation' => array(
				'type' => 'animation',
				'title' => 'Number Animation',
				'depends' => array(array('layout', '=', array('seven'))),
				'std' => array(
					'name' => 'fadeIn',   
					'delay' => '300',     
					'duration' => '400' 
				),
			),
			//intro
			'introtext' => array(
				'type' => 'textarea',
				'title' => __('Intro text','wp-pagebuilder'),
				'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer adipiscing erat eget risus sollicitudin pellentesque',
			),
			'intro_animation' => array(
				'type' => 'animation',
				'title' => 'Intro Animation',
				'std' => array(
					'name'      => 'fadeIn',
					'delay'     => '300',
					'duration'  => '400'
				),
			),
			'show_image' => array(
				'type'      => 'switch',
				'title'     => __('Show Image','wp-pagebuilder'),
				'std'       => '0',
                'depends' => array(array('layout', '!=', array('seven')))
			),
			'icon_list' => array(
				'type'      => 'icon',
				'title'     => __('Icon list','wp-pagebuilder'),
				'std'       => 'wppb-font-rocket',
				'depends'   => array(array('show_image', '!=', '1'), array('layout', '!=', array('seven'))),
			),
			'icon_animation' => array(
				'type' => 'animation',
				'title' => 'Icon Animation',
				'std' => array(
					'name' => 'fadeIn',   
					'delay' => '300',     
					'duration' => '400' 
				),
				'depends' => array(array('show_image', '!=', '1')),
			),
			'image_upload' => array(
				'type' => 'media',
				'title' => __('Upload feature image','wp-pagebuilder'),
				'std' => array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-small.jpg' ),
				'depends' => array(array('show_image', '!=', '0')),
			),
			'image_animation' => array(
				'type' => 'animation',
				'title' => 'Image Animation',
				'std' => array(
					'name' => 'fadeIn',   
					'delay' => '300',    
					'duration' => '400' 
				),
				'depends' => array(array('show_image', '!=', '0')),
			),

			'button_text' => array(
				'type' => 'text',
				'title' => __('Button text','wp-pagebuilder'),
				'std' => 'Button',
			),
			'button_link' => array(
				'type' => 'link',
				'title' => __('Button Link','wp-pagebuilder'),
				'std' => array( 'link'=>'#','window'=>false,'nofolow'=>false )
			),
			'btn_icon_list' => array(
				'type' => 'icon',
				'title' => __('Button icon','wp-pagebuilder'),
				'std' => ''
			),
			'icon_position' => array(
				'type' => 'select',
				'title' => __('Button icon position','wp-pagebuilder'),
				'depends' => array(array('btn_icon_list', '!=', '')),
				'values' => array(
					'left' => __('Left','wp-pagebuilder'),
					'right' => __('Right','wp-pagebuilder'),
				),
				'std' => 'left',
			),
			'feature_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-feature-box-content{ text-align: {{data.feature_align}}; }',
				'depends' => array(array('layout', '=', array('one','six'))),
			),

			//box title
			'box_title_color' => array(
				'type' => 'color2',
				'title' => 'Color',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-title, {{SELECTOR}} .wppb-feature-box-title a',
				'tab' => 'style',
				'section' => 'Box Title',
			),
			'box_title_hcolor' => array(
				'type' => 'color2',
				'title' => 'Hover color',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-title:hover, {{SELECTOR}} .wppb-feature-box-title a:hover',
				'tab' => 'style',
				'section' => 'Box Title',
			),
			'box_title_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'20px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '500',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-feature-box-title',
				'section' => 'Box Title',
				'tab' => 'style',
			),
			'title_margin' => array(
				'type'      => 'dimension',
				'title'     => __('Margin','wp-pagebuilder'),
				'tab'       => 'style',
				'section'   => 'Box Title',
				'responsive' => true,
				'unit'      => array( 'px','em','%' ),
				'selector'  => '{{SELECTOR}} .wppb-feature-box-title, {{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title { margin: {{data.title_margin}}; }'
			),
			'title_padding' => array(
				'type'      => 'dimension',
				'title'     => __('padding','wp-pagebuilder'),
				'tab'       => 'style',
				'section'   => 'Box Title',
				'responsive' => true,
				'unit'      => array( 'px','em','%' ),
				'selector'  => '{{SELECTOR}} .wppb-feature-box-title, {{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title { padding: {{data.title_padding}}; }'
			),

			//box sub title
			'box_subtitle_color' => array(
				'type' => 'color2',
				'title' => 'Color',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-subtitle',
				'tab' => 'style',
				'section' => 'Box Sub Title',
			),
			'box_subtitle_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'20px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '500',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-feature-box-subtitle',
				'section' => 'Box Sub Title',
				'tab' => 'style',
			),
			'subtitle_margin' => array(
				'type' => 'dimension',
				'title' => __('Margin','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Box Sub Title',
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-subtitle { margin: {{data.subtitle_margin}}; }'
			),
			'subtitle_padding' => array(
				'type' => 'dimension',
				'title' => __('Padding','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Box Sub Title',
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-subtitle { padding: {{data.subtitle_padding}}; }'
			),

			//Intro text
			'intro_color' => array(
				'type' => 'color',
				'title' => __('color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Intro Text',
				'selector' => '{{SELECTOR}} .wppb-feature-box-intro { color: {{data.intro_color}}; }'
			),
			'intro_size' => array(
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
				'selector' => '{{SELECTOR}} .wppb-feature-box-intro',
				'section' => 'Intro Text',
				'tab' => 'style',
			),
			'intro_margin' => array(
				'type' => 'dimension',
				'title' => __('margin','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Intro Text',
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-intro { margin: {{data.intro_margin}}; }'
			),
			'intro_padding' => array(
				'type' => 'dimension',
				'title' => __('padding','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Intro Text',
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-intro { padding: {{data.intro_padding}}; }'
			),

			//Number text
			'number_color' => array(
				'type' => 'color2',
				'title' => 'color',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-number',
				'tab' => 'style',
				'section' =>'Number',
				'depends' => array(array('layout', '=', array('seven'))),
			),
			'number_horizontal' => array(
				'type' => 'slider',
				'title' => __('Horizontal','wp-pagebuilder'),
				'std' => array(
						'md' => '-25px',
						'sm' => '',
						'xs' => '',
					),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => -10,
							'max' => 10,
							'step' => .1,
						),
						'px' => array(
							'min' => -150,
							'max' => 150,
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
				'section' =>'Number',
				'selector' => '{{SELECTOR}} .wppb-feature-box-number { top: {{data.number_horizontal}}; }',
				'depends' => array(array('layout', '=', array('seven'))),
			),
			'number_vertical' => array(
				'type' => 'slider',
				'title' => __('Vertical','wp-pagebuilder'),
				'std' => array(
						'md' => '15px',
						'sm' => '',
						'xs' => '',
					),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => -10,
							'max' => 10,
							'step' => .1,
						),
						'px' => array(
							'min' => -100,
							'max' => 150,
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
				'section' =>'Number',
				'selector' => '{{SELECTOR}} .wppb-feature-box-number { left: {{data.number_vertical}}; }',
				'depends' => array(array('layout', '=', array('seven'))),
			),
			'number_size' => array(
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
				'selector' => '{{SELECTOR}} .wppb-feature-box-number',
				'section' =>'Number',
				'tab' => 'style',
				'depends' => array(array('layout', '=', array('seven'))),
			),
			'number_padding' => array(
				'type' => 'dimension',
				'title' => __('padding','wp-pagebuilder'),
				'tab' => 'style',
				'section' =>'Number',
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-number { padding: {{data.number_padding}}; }',
				'depends' => array(array('layout', '=', array('seven'))),
			),

			// icon
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Size','wp-pagebuilder'),
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
						'md' => '48px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon i { font-size: {{data.icon_size}}; }'
			),
			'icon_line_height' => array(
				'type' => 'slider',
				'title' => __('Line Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'max' => 300,
				'section' => 'Icon',
				'tab' => 'style',
				'selector' =>'{{SELECTOR}} .wppb-feature-box-icon i { line-height: {{data.icon_line_height}}; }'
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
						'max' => 300,
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
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon { width: {{data.icon_width}}; }'
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
						'max' => 300,
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
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon { height: {{data.icon_height}}; }',
			),
			'icon_color' => array(
				'type' => 'color2',
				'title' => 'Color',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon i',
				'tab' => 'style',
				'section' => 'Icon',
			),
			'icon_hcolor' => array(
				'type' => 'color2',
				'title' => 'Hover Color',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-content:hover .wppb-feature-box-icon i',
				'tab' => 'style',
				'section' => 'Icon',
			),

			'icon_bg' => array(
				'type' => 'color2',
				'title' => 'background',
				'clip' => false,
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon',
				'tab' => 'style',
				'section' => 'Icon',
			),

			'icon_hover_bg' => array(
				'type' => 'color2',
				'title' => 'hover background',
				'clip' => false,
				'selector' => '{{SELECTOR}} .wppb-feature-box-content:hover .wppb-feature-box-icon',
				'tab' => 'style',
				'section' => 'Icon',
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
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon'
			),
			'icon_border_hcolor' => array(
				'type' => 'border',
				'title' => 'hover color',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content:hover .wppb-feature-box-icon'
			),
			'icon_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon',
				'tab' => 'style',
				'section' => 'Icon',
			),
			'icon_hboxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Hover box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-content:hover .wppb-feature-box-icon',
				'tab' => 'style',
				'section' => 'Icon',
			),
			'icon_radius' => array(
				'type' => 'slider',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon { border-radius: {{data.icon_radius}}; }'
			),
			'icon_margin' => array(
				'type' => 'dimension',
				'title' => __('Margin','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'responsive' => true,
				'unit' => array( 'px','em','%' ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-icon { margin: {{data.icon_margin}}; }'
			),

			//image
			'img_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 30,
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
					'md' => '100px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img { width: {{data.img_width}}; max-width:{{data.img_width}} }'
			),
			'img_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 30,
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
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img { height: {{data.img_height}}; }'
			),
			'border_radius' => array(
				'type' => 'dimension',
				'title' => __('Border Radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img { border-radius: {{data.border_radius}}; }'
			),
			'image_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img'
			),
			'img_border_hcolor' => array(
				'type' => 'border',
				'title' => 'Hover Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Image',
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img:hover'
			),
			'img_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img',
				'tab' => 'style',
				'section' => 'Image',
			),
			'img_hboxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'hover box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img:hover',
				'tab' => 'style',
				'section' => 'Image',
			),
			'img_margin' => array(
				'type' => 'dimension',
				'title' => __('margin','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Image',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-feature-box-img img { margin: {{data.img_margin}}; }'
			),

			//button
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
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons',
				'section' => 'Button',
				'tab' => 'style',
			),
			'button_color' => array(
				'type' => 'color',
				'title' => 'Color',
				'std'       => '#ffffff',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons { color: {{data.button_color}}; }',
				'tab' => 'style',
				'section' => 'Button',
			),
			'button_hcolor' => array(
				'type' => 'color',
				'title' => 'Hover Color',
				'std'       => '#ffffff',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons:hover { color: {{data.button_hcolor}}; }',
				'tab' => 'style',
				'section' => 'Button',
			),
			'button_bg' => array(
				'type' => 'color2',
				'title' => 'background',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#0080FE',
					'clip' => false
				),
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons',
				'tab' => 'style',
				'section' => 'Button',
			),
			'button_hover_bg' => array(
				'type' => 'color2',
				'title' => 'hover background',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#0074e6',
					'clip' => false
				),
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons:before',
				'tab' => 'style',
				'section' => 'Button',
			),
			'button_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons'
			),
			'border_hcolor' => array(
				'type' => 'border',
				'title' => 'hover Border',
				'std' => array(
					'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons:hover'
			),
			'buttom_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'std' => array(
					'md' => array( 'top' => '4px', 'right' => '4px', 'bottom' => '4px', 'left' => '4px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons { border-radius: {{data.buttom_radius}}; }'
			),
			'buttom_hradius' => array(
				'type' => 'dimension',
				'title' => __('hover border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'std' => array(
					'md' => array( 'top' => '4px', 'right' => '4px', 'bottom' => '4px', 'left' => '4px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons:hover { border-radius: {{data.buttom_hradius}}; }'
			),
			'button_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons { padding: {{data.button_padding}}; }',
			),
			'btn_margin' => array(
				'type' => 'dimension',
				'title' => __('margin','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-feature-box-content .wppb-btn-addons { margin: {{data.btn_margin}}; }'
			),
			//six
			'bar_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'std' => array(
					'md' => '50%',
					'sm' => '',
					'xs' => '',
				),
				'unit' => array( '%','px','em' ),
				'responsive' => true,
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
				'tab' => 'style',
				'section' => 'Bar Style',
				'selector' => '{{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title:after { width: {{data.bar_width}}; }',
				'depends' => array(array('layout', '=', array('six'))),
			),
			'bar_height' => array(
				'type' => 'slider',
				'title' => __('Bar Height','wp-pagebuilder'),
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
					'md' => '2px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Bar Style',
				'selector' => '{{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title:after { height: {{data.bar_height}}; }',
				'depends' => array(array('layout', '=', array('six'))),
			),
			'bar_horizontal' => array(
				'type' => 'slider',
				'title' => __('Bar Horizontal','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
						'em' => array(
							'min' => -25,
							'max' => 25,
							'step' => .1,
						),
						'px' => array(
							'min' => -200,
							'max' => 200,
							'step' => 1,
						),
						'%' => array(
							'min' => -100,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '100%',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Bar Style',
				'selector' => '{{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title:after { top: {{data.bar_horizontal}}; }',
				'depends' => array(array('layout', '=', array('six'))),
			),
			'bar_vertical' => array(
				'type' => 'slider',
				'title' => __('Bar Vertical','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
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
						'md' => '0%',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Bar Style',
				'selector' => '{{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title:after { left: {{data.bar_vertical}}; }',
				'depends' => array(array('layout', '=', array('six'))),
			),
			'bar_background' => array(
				'type' => 'color2',
				'title' => 'Bar Background',
				'clip' => false,
				'selector' => '{{SELECTOR}} .feature-icontitle-six .wppb-feature-box-title:after',
				'tab' => 'style',
				'section' => 'Bar Style',
				'depends' => array(array('layout', '=', array('six'))),
			),
		);

		return $settings;
	}


	// Feature box Render HTML
	public function render($data = null){
		$settings 				= $data['settings'];
		$layout 				= isset($settings['layout']) ? $settings['layout'] : '';
		$title 					= isset($settings['title']) ? $settings['title'] : '';
		$selector 				= isset($settings["heading_selector"]) ? $settings["heading_selector"] : '';
		$subtitle 				= isset($settings['subtitle']) ? $settings['subtitle'] : '';
		$subselector 			= isset($settings["subheading_selector"]) ? $settings["subheading_selector"] : '';
		$subtitle_animation 	= isset($settings["subtitle_animation"]) ? $settings["subtitle_animation"] : array();
		$number 				= isset($settings["number"]) ? $settings["number"] : '';
		$number_animation 		= isset($settings["number_animation"]) ? $settings["number_animation"] : array();
		$title_link 			= isset($settings['title_link']) ? $settings['title_link'] : array();
		$introtext 				= isset($settings['introtext']) ? $settings['introtext'] : '';
		$intro_animation 		= isset($settings['intro_animation']) ? $settings['intro_animation'] : array();
		$show_image 			= isset($settings['show_image']) ? $settings['show_image'] : '';
		$icon_list 				= isset($settings['icon_list']) ? $settings['icon_list'] : '';
		$icon_animation 		= isset($settings['icon_animation']) ? $settings['icon_animation'] : array();
		$image_upload 			= isset($settings['image_upload']) ? $settings['image_upload'] : array();
		$image_animation 		= isset($settings['image_animation']) ? $settings['image_animation'] : array();
		$title_animation 	    = isset($settings['title_animation']) ? $settings['title_animation'] : array();
		$button_text 			= isset($settings["button_text"]) ? $settings["button_text"] : '';
		$button_link 			= isset($settings['button_link']) ? $settings['button_link'] : array();
		$btn_icon_list 			= isset($settings["btn_icon_list"]) ? $settings["btn_icon_list"] : '';
		$icon_position 			= isset($settings["icon_position"]) ? $settings["icon_position"] : '';
		$feature_align 			= isset($settings["feature_align"]) ? $settings["feature_align"] : '';

		$output = $img_url = $data_media = $data_title = $data_number = $data_subtitle = $data_intro = $btndata = $classlist = $button = '' ;

		$classlist .= (isset($style) && $style) ? ' wppb-btn-' . $style : '';

		if($show_image == 1) {	
			if ( ! empty($image_upload['url']) ) {
				$img_url = $image_upload['url'];
				if( isset( $image_animation['itemOpen'] ) && $image_animation['itemOpen'] ){
					$data_media .= '<div class="wppb-feature-box-img wppb-wow wppb-animated '.esc_attr($image_animation['name']).'" data-wow-duration="'.esc_attr($image_animation['duration']).'ms" data-wow-delay="'.esc_attr($image_animation['delay']).'ms">';
					$data_media .= '<img src="'.esc_url($img_url).'" alt="'. esc_attr($title) .'">';
					$data_media .= '</div>';
				} else {
					$data_media .= '<div class="wppb-feature-box-img">';
					$data_media .= '<img src="'.esc_url($img_url).'" alt="'. esc_attr($title) .'">';
					$data_media .= '</div>';
				}
			}
		} else {
			if( !empty( $icon_list ) ){
				if( isset( $icon_animation['itemOpen'] ) && $icon_animation['itemOpen'] ) {
					$data_media .= '<div class="wppb-feature-box-icon wppb-wow wppb-animated '.esc_attr($icon_animation['name']).'" data-wow-duration="'.esc_attr($icon_animation['duration']).'ms" data-wow-delay="'.esc_attr($icon_animation['delay']).'ms">';
						$data_media .= '<i class="' . esc_attr($icon_list) . '"></i>';
					$data_media .= '</div>';
				} else {
					$data_media .= '<div class="wppb-feature-box-icon">';
						$data_media .= '<i class="' . esc_attr($icon_list) . '"></i>';
					$data_media .= '</div>';
				}
			}
		}

		$selector = $selector ? $selector : "h3";
		$subselector = $subselector ? $subselector : "h4";

		if( ( $title ) ){
			if( !empty($title_link['link']) ){
				$target = $title_link['window'] ? 'target=_blank' : "";
				$nofolow = $title_link['nofolow'] ? 'rel=nofolow' : "";
				if( isset( $title_animation['itemOpen'] )  && $title_animation['itemOpen'] ) {
					$data_title .= '<' .esc_attr($selector). ' class="wppb-feature-box-title wppb-wow wppb-animated '.esc_attr($title_animation['name']).'" data-wow-duration="'.esc_attr($title_animation['duration']).'ms" data-wow-delay="'.esc_attr($title_animation['delay']).'ms"><a '.esc_attr($nofolow).' href="'.esc_url($title_link['link']).'" '.esc_attr($target).'>' . wp_kses_post($title) .'</a></' . esc_attr($selector) . '>';
				} else {
					$data_title .= '<' .esc_attr($selector). ' class="wppb-feature-box-title"><a '.esc_attr($nofolow).' href="'.esc_url($title_link['link']).'" '.esc_attr($target).'>' . wp_kses_post($title) .'</a></' . esc_attr($selector) . '>';
				}
			} else {
				if( isset( $title_animation['itemOpen'] ) && $title_animation['itemOpen'] ) {
					$data_title .= '<' .esc_attr($selector). ' class="wppb-feature-box-title wppb-wow wppb-animated '.esc_attr($title_animation['name']).'" data-wow-duration="'.esc_attr($title_animation['duration']).'ms" data-wow-delay="'.esc_attr($title_animation['delay']).'ms">' . wp_kses_post($title) .'</' . esc_attr($selector) . '>';
				} else {
					$data_title .= '<' .esc_attr($selector). ' class="wppb-feature-box-title">' . wp_kses_post($title) .'</' . esc_attr($selector) . '>';
				}
			}
		}

		if( !empty( $subtitle ) ){
			if( isset( $subtitle_animation['itemOpen'] ) && $subtitle_animation['itemOpen'] ) {
				$data_subtitle .= '<' .esc_attr($subselector). ' class="wppb-feature-box-subtitle wppb-wow wppb-animated '.esc_attr($subtitle_animation['name']).'" data-wow-duration="'.esc_attr($subtitle_animation['duration']).'ms" data-wow-delay="'.esc_attr($subtitle_animation['delay']).'ms">' . wp_kses_post($subtitle) .'</' . esc_attr($subselector) . '>';
			} else {
				$data_subtitle .= '<' .esc_attr($subselector). ' class="wppb-feature-box-subtitle">' . wp_kses_post($subtitle) .'</' . esc_attr($subselector) . '>';
			}
		}

		if ( !empty( $number ) ) {
			if( isset( $number_animation['itemOpen'] ) && $number_animation['itemOpen'] ) {
				$data_number .= '<span class="wppb-feature-box-number wppb-wow wppb-animated '.esc_attr($number_animation['name']).'" data-wow-duration="'.esc_attr($number_animation['duration']).'ms" data-wow-delay="'.esc_attr($number_animation['delay']).'ms">';
					$data_number .= $number;
				$data_number .= '</span>';
			} else {
				$data_number .= '<span class="wppb-feature-box-number">';
					$data_number .= $number;
				$data_number .= '</span>';
			}
		}

		if ( !empty( $introtext ) ) {
			if( isset( $intro_animation['itemOpen'] )  && $intro_animation['itemOpen'] ) {
				$data_intro .= '<div class="wppb-feature-box-intro wppb-wow wppb-animated '.esc_attr($intro_animation['name']).'" data-wow-duration="'.esc_attr($intro_animation['duration']).'ms" data-wow-delay="'.esc_attr($intro_animation['delay']).'ms">';
					$data_intro .= $introtext;
				$data_intro .= '</div>';
			} else {
				$data_intro .= '<div class="wppb-feature-box-intro">';
					$data_intro .= $introtext;
				$data_intro .= '</div>';
			}
		}

		if($icon_position == 'left') {
			$button = (esc_attr($btn_icon_list)) ? '<i class="' . esc_attr($btn_icon_list) . '"></i> <span>' . esc_attr($button_text).'</span>' : '<span>' . esc_attr($button_text). '</span>';
		} else {
			$button = (esc_attr($btn_icon_list)) ? '<span>' . esc_attr($button_text) . '</span> <i class="' . esc_attr($btn_icon_list) . '"></i><span>' : esc_attr($button_text).'</span>';
		}

		if( !empty($button_link['link']) ){
			$btntarget = !empty($button_link['window']) ? 'target=_blank' : 'target=_self';
			$btnnofolow = !empty($button_link['nofolow']) ? 'rel=nofolow' : "";
			$btndata  = '<a '.esc_attr($btntarget).' href="'.esc_url($button_link['link']).'" '.esc_attr($btnnofolow).' class="wppb-btn-addons '.$classlist.'">' . $button  . '</a>';
		}

		$output  .= '<div class="wppb-feature-box-addon">';
			$output  .= '<div class="wppb-feature-box-content">';
			if ( $layout == "two" ) {
				$output  .= '<div class="feature-box-left">';
				$output  .= '<div class="feature-box-left-media">';
				$output  .= $data_media;
				$output  .= '</div>';
				$output  .= '<div class="feature-box-left-body">';
				$output  .= $data_title;
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
				$output  .= '</div>';
				$output  .= '</div>';
			} elseif ( $layout == "three" ) {
				$output  .= '<div class="feature-box-right">';	
				$output  .= '<div class="feature-box-right-body">';
				$output  .= $data_title;
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
				$output  .= '</div>';
				$output  .= '<div class="feature-box-right-media">';
				$output  .= $data_media;
				$output  .= '</div>';
				$output  .= '</div>';
			}
			elseif ( $layout == "four" ) {
				$output  .= '<div class="feature-icontitle-wrap">';	
				$output  .= '<div class="feature-icontitle-left wppb-clearfix">';
				$output  .= $data_media;
				$output  .= $data_title;
				$output  .= '</div>';
				$output  .= '<div class="feature-icontitle-body">';	
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
				$output  .= '</div>';
				$output  .= '</div>';
			} elseif ( $layout == "five" ) {
				$output  .= '<div class="feature-icontitle-wrap">';	
				$output  .= '<div class="feature-icontitle-right wppb-clearfix">';
				$output  .= $data_media;
				$output  .= $data_title;
				$output  .= '</div>';
				$output  .= '<div class="feature-icontitle-body">';	
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
				$output  .= '</div>';
				$output  .= '</div>';
			} elseif ( $layout == "six" ) {
				$output  .= '<div class="feature-icontitle-six">';	
				$output  .= $data_media;
				$output  .= '<div class="feature-title-six">';
				$output  .= $data_title;
				$output  .= '</div>';
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
				$output  .= '</div>';
			} elseif ( $layout == "seven" ) {
				$output  .= '<div class="feature-icontitle-seven">';	
				$output  .= '<div class="feature-title-seven">';
				$output  .= $data_number;
				$output  .= $data_title;
				$output  .= '</div>';
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
				$output  .= '</div>';
			} else {
				$output  .= $data_media;
				$output  .= $data_title;
				$output  .= $data_subtitle;
				$output  .= $data_intro;
				$output  .= $btndata;
			}
			$output  .= '</div>';//wppb-feature-box-content
		$output  .= '</div>';//wppb-feature-box-addon

		return $output;
	}

	// Feature Bix Template
	public function getTemplate(){
		$output = '
		<#
		var data_media = "";
		var data_title = "";
		var data_subtitle = "";
		var data_number = "";
		var data_intro = "";
		var classList = "";
		classList += " wppb-btn-"+data.style;

		var heading_selector = data.heading_selector ? data.heading_selector : "h3";
		var subheading_selector = data.subheading_selector ? data.subheading_selector : "h4";
		if(data.title){
			if( !_.isEmpty( data.link ) ){
				if(data.title_animation.itemOpen) {
					data_title += "<"+heading_selector+" class=\'wppb-feature-box-title wppb-wow wppb-animated " +data.title_animation.name + "\' data-wow-duration="+data.title_animation.duration+"ms data-wow-delay="+data.title_animation.delay+"ms><a href=\'"+ data.link+"\'>"+data.title+"</a></"+heading_selector+">";
				} else {
					data_title += "<"+heading_selector+" class=\'wppb-feature-box-title\'><a href=\'"+ data.link+"\'>"+data.title+"</a></"+heading_selector+">";
				}
			} else {
				if(data.title_animation.itemOpen) {
					data_title += "<"+heading_selector+" class=\'wppb-feature-box-title wppb-wow wppb-animated " +data.title_animation.name + "\' data-wow-duration="+data.title_animation.duration+"ms data-wow-delay="+data.title_animation.delay+"ms>"+data.title+"</"+heading_selector+">";
				} else {
					data_title += "<"+heading_selector+" class=\'wppb-feature-box-title\'>"+data.title+"</"+heading_selector+">";
				}
			}
		}

		if(data.subtitle){
			if(data.subtitle_animation.itemOpen) {
				data_subtitle += "<"+data.subheading_selector+" class=\'wppb-feature-box-subtitle wppb-wow wppb-animated" +data.subtitle_animation.name + "\' data-wow-duration="+data.subtitle_animation.duration+"ms data-wow-delay="+data.subtitle_animation.delay+"ms>"+data.subtitle+"</"+data.subheading_selector+">";
			} else {
				data_subtitle += "<"+data.subheading_selector+" class=\'wppb-feature-box-subtitle\'>"+data.subtitle+"</"+data.subheading_selector+">";
			}
		}
		
		if(data.number){
			if(data.number_animation.itemOpen) {
				data_number += "<span class=\'wppb-feature-box-number wppb-wow wppb-animated " +data.number_animation.name + "\' data-wow-duration="+data.number_animation.duration+"ms data-wow-delay="+data.number_animation.delay+"ms>";
				data_number += data.number;
				data_number += "</span>";
			} else {
				data_number += "<span class=\'wppb-feature-box-number\'>";
				data_number += data.number;
				data_number += "</span>";
			}
		}

		if(data.introtext){
			if(data.intro_animation.itemOpen) {
				data_intro += "<div class=\'wppb-feature-box-intro wppb-wow wppb-animated " +data.intro_animation.name + "\' data-wow-duration="+data.intro_animation.duration+"ms data-wow-delay="+data.intro_animation.delay+"ms>";
				data_intro += data.introtext;
				data_intro += "</div>";
			} else {
				data_intro += "<div class=\'wppb-feature-box-intro\'>";
				data_intro += data.introtext;
				data_intro += "</div>";
			}
		}

		if( data.show_image == 1 ) {	
			if ( data.image_upload.url ) {
				if(data.image_animation.itemOpen) {
					data_media  += "<div class=\'wppb-feature-box-img wppb-wow wppb-animated " +data.image_animation.name + "\' data-wow-duration="+data.image_animation.duration+"ms data-wow-delay="+data.image_animation.delay+"ms>";
					data_media  += "<img src=\'"+data.image_upload.url+"\'>";
					data_media  += "</div>";
				} else {
					data_media  += "<div class=\'wppb-feature-box-img\'>";
					data_media  += "<img src=\'"+data.image_upload.url+"\'>";
					data_media  += "</div>";
				}
			} 
		} else {
			if( data.icon_list ){
				if(data.icon_animation.itemOpen) {
					data_media  += "<div class=\'wppb-feature-box-icon wppb-wow wppb-animated " +data.icon_animation.name + "\' data-wow-duration="+data.icon_animation.duration+"ms data-wow-delay="+data.icon_animation.delay+"ms>";
					data_media  += "<i class=\'"+data.icon_list+"\'></i>";
					data_media  += "</div>";
				} else {
					data_media  += "<div class=\'wppb-feature-box-icon\'>";
					data_media  += "<i class=\'"+data.icon_list+"\'></i>";
					data_media  += "</div>";
				}
			}
		}	
		#>

		<div class="wppb-addon wppb-feature-box-addon">
			<div class="wppb-feature-box-content">
				<# if ( data.layout == "two" ) { #>
					<div class="feature-box-left">
						<div class="feature-box-left-media">
							{{{data_media}}}
						</div>
						<div class="feature-box-left-body">
							{{{data_title}}}
							{{{data_subtitle}}}
							{{{data_intro}}}
							<# if( !__.isEmpty(data.button_link.link) ) { #>
								<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
									<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
								</a>
							<# } #>
						</div>
					</div>
				<# } else if(data.layout == "three"){ #>		
					<div class="feature-box-right">
					<div class="feature-box-right-body">
						{{{data_title}}}
						{{{data_subtitle}}}
						{{{data_intro}}}
						<# if( !__.isEmpty(data.button_link.link) ) { #>
							<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
								<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
							</a>
						<# } #>
					</div>
					<div class="feature-box-right-media">
						{{{data_media}}}
					</div>
				</div>
				<# } else if(data.layout == "four"){ #>		
					<div class="feature-icontitle-wrap">
						<div class="feature-icontitle-left wppb-clearfix">
							{{{data_media}}}
							{{{data_title}}}
						</div>
						<div class="feature-icontitle-body">
							{{{data_subtitle}}}
							{{{data_intro}}}
							<# if( !__.isEmpty(data.button_link.link) ) { #>
								<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
									<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
								</a>
							<# } #>
						</div>
					</div>
					<# } else if(data.layout == "five"){ #>		
						<div class="feature-icontitle-wrap">
							<div class="feature-icontitle-right wppb-clearfix">
								{{{data_title}}}
								{{{data_media}}}
							</div>
							<div class="feature-icontitle-body">
								{{{data_subtitle}}}
								{{{data_intro}}}
								<# if( !__.isEmpty(data.button_link.link) ) { #>
									<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
										<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
									</a>
								<# } #>
							</div>
						</div>
					<# } else if(data.layout == "six"){ #>		
						<div class="feature-icontitle-six">
							{{{data_media}}}
							<div class="feature-title-six">
							{{{data_title}}}
							</div>
							{{{data_subtitle}}}
							{{{data_intro}}}
							<# if( !__.isEmpty(data.button_link.link) ) { #>
								<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
									<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
								</a>
							<# } #>
						</div>
				<# } else if(data.layout == "seven"){ #>		
					<div class="feature-icontitle-seven">
						<div class="feature-title-seven">
						{{{data_number}}}
						{{{data_title}}}
						</div>
						{{{data_subtitle}}}
						{{{data_intro}}}
						<# if( !__.isEmpty(data.button_link.link) ) { #>
							<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
								<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
							</a>
						<# } #>
					</div>
				<# } else { #>			
					{{{data_media}}}
					{{{data_title}}}
					{{{data_subtitle}}}
					{{{data_intro}}}
					<# if( !__.isEmpty(data.button_link.link) ) { #>
						<a {{ data.button_link.link ? "href="+data.button_link.link : "" }} {{ data.button_link.window ? "target=_blank" : "" }} {{ data.button_link.nofolow ? "rel=nofolow" : "" }} class="wppb-btn-addons {{classList}}">
							<# if(data.icon_position == "left" && !_.isEmpty(data.btn_icon_list)) { #><i class="{{ data.btn_icon_list }}"></i> <# } #><span>{{ data.button_text }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.btn_icon_list)) { #> <i class="{{ data.btn_icon_list }}"></i><# } #>
						</a>
					<# } #>
				<# } #>
			</div>
		</div>
		';
		return $output;
	}

}
