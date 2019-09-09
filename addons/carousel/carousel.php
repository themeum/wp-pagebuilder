<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists('WPPB_Addon_Carousel')) {
	class WPPB_Addon_Carousel {

		public function __construct() {
			//Register scripts
			add_action('wp_enqueue_scripts', array($this, 'register_required_script'));
			add_action('wppb_enqueue_scripts', array($this, 'register_required_script'));

			//Load scripts at builder
			add_action('wppb_enqueue_scripts', array($this, 'add_scripts'));
		}

		public function register_required_script(){
			wp_register_script('thm.carousel.slick.main', WPPB_DIR_URL.'addons/carousel/assets/libraries/slick/slick.min.js', array('jquery'), false, true);
			wp_register_script('thm.carousel.main', WPPB_DIR_URL.'addons/carousel/assets/js/slick-slider-animation.js', array('jquery'), false, true);
			wp_register_script('thm.slider.custom.main', WPPB_DIR_URL.'addons/carousel/assets/js/thm-slider-main.js', array('thm.carousel.slick.main'), false, true);
			wp_register_style('thm.carousel.animate', WPPB_DIR_URL.'addons/carousel/assets/libraries/animate.css/animate.min.css');
			wp_register_style('thm.carousel.slick', WPPB_DIR_URL.'addons/carousel/assets/libraries/slick/slick.min.css');
			wp_register_style('thm.carousel.slick.theme', WPPB_DIR_URL.'addons/carousel/assets/libraries/slick/slick-theme.min.css');
			wp_register_style('thm.carousel.style', WPPB_DIR_URL.'addons/carousel/assets/css/slider.css');
		}

		//Add Frontend builder Script
		public function add_scripts(){
			$scripts = $this->get_enqueue_script();
			$styles = $this->get_enqueue_style();

			if (is_array($scripts) && count($scripts)){
				foreach ($scripts as $script){
					wp_enqueue_script($script);
				}
			}

			if (is_array($styles) && count($styles)){
				foreach ($styles as $style){
					wp_enqueue_style($style);
				}
			}
		}


		public function get_enqueue_script(){
			return array( 'thm.carousel.slick.main', 'thm.carousel.main', 'thm.slider.custom.main' );
		}

		public function get_enqueue_style(){
			return array( 'thm.carousel.animate', 'thm.carousel.slick', 'thm.carousel.slick.theme', 'thm.carousel.style' );
		}


		public function get_name() {
			return 'wppb_carousel';
		}

		public function get_title() {
			return 'Carousel';
		}

		public function get_icon() {
			return 'wppb-font-full-slider';
		}

		// Settings Fields
		public function get_settings() {

			$settings = array(
				'arrow_option' => array(
					'type' => 'switch',
					'title' => __('Navigation Option','wp-pagebuilder'),
					'std' => '1',
					'section' => 'Slider Settings',
				),
				'control_option' => array(
					'type' => 'switch',
					'title' => __('Control Option','wp-pagebuilder'),
					'std' => '1',
					'section' => 'Slider Settings',
				),
				'autoplay_option' => array(
					'type' => 'switch',
					'title' => __('Autoplay Option','wp-pagebuilder'),
					'std' => '1',
					'section' => 'Slider Settings',
				),
				'animated_speed' => array(
					'type' => 'number',
					'title' => __('Animated Speed','wp-pagebuilder'),
					'std' => '600',
					'section' => 'Slider Settings',
					'depends' => array(array('autoplay_option', '=', '1')),
				),
				'slide_height' => array(
					'type' => 'slider',
					'title' => __('Slider Height','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
					'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 90,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 1200,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
					'std' => array(
						'md' => '600px',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'section' => 'Slider Settings',
					'selector' => '{{SELECTOR}} .wppb-carousel-content-wrap { height: {{data.slide_height}}; }',
				),
				'carosuel_list' => array(
					'title' => __('Carousel','wp-pagebuilder'),
					'type' => 'repeatable',
					'label' => 'title',
					'std' => array(
						array(
							'title' => 'Unique',
							'subtitle' => 'International Graphic Design',
							'content' => 'Page builder layouts for your next project. Includes carefully crafted pre built blocks and templates. We are reaching new milestones and we appreciate the continued support from everyone.',
							'slider_type' => 'right_media',
							'media_type'  => 'media_image',
							'imageupload' => array('url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-medium.jpg' ),
							'video_url'  => 'https://www.youtube.com/watch?v=EKDZ7pvNSLs',
							'intro_color' => '#656565',
							'button_text' => 'Get Started',
							'button_link' => array( 'link'=>'#','window'=>false,'nofolow'=>false ),
							'btn_color'   => '#fff',
							'btn_hover_color'   => '#fff',
							'slide_height' => array(
								'md' => '600px',
								'sm' => '',
								'xs' => '',
							),
							'title_color' => '#000',
							'subtitle_color' => '#151515',
							'carosuel_bg' =>array(
								'bgType' => 'color',
								'bgColor' => '#fff',
							),
							'btn_background' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#26c266',
							),
							'btn_hover_background' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#1fa957',
							),
							'btn_radius' => array(
								'md' => '3px',
								'sm' => '',
								'xs' => '',
							),
							'btn_padding' => array(
								'md' => array( 'top' => '8px', 'right' => '25px', 'bottom' => '8px', 'left' => '25px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),

						),
						array(
							'title' => 'Structure',
							'subtitle' => 'Drag and Drop Builder',
							'content' => 'Page builder layouts for your next project. Includes carefully crafted pre built blocks and templates. We are reaching new milestones and we appreciate the continued support from everyone.',
							'slider_type' => 'left_media',
							'media_type'  => 'media_image',
							'imageupload' => array('url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-medium.jpg' ),
							'video_url'  => 'https://www.youtube.com/watch?v=EKDZ7pvNSLs',
							'intro_color' => '#656565',
							'button_text' => 'Learn More',
							'button_link' => array( 'link'=>'#','window'=>false,'nofolow'=>false ),
							'slide_height' => array(
								'md' => '600px',
								'sm' => '',
								'xs' => '',
							),
							'carosuel_bg' =>array(
								'bgType' => 'color',
								'bgColor' => '#fff',
							),
							'title_color' => '#000',
							'subtitle_color' => '#151515',
							'btn_color'   => '#fff',
							'btn_hover_color'   => '#fff',
							'btn_background' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#3666E4',
							),
							'btn_hover_background' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#2955ca',
							),
							'btn_radius' => array(
								'md' => '3px',
								'sm' => '',
								'xs' => '',
							),
							'btn_padding' => array(
								'md' => array( 'top' => '8px', 'right' => '25px', 'bottom' => '8px', 'left' => '25px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
						),
					),

					'attr' => array(
						'slider_type' => array(
							'type' => 'select',
							'title' => __('Content Type','wp-pagebuilder'),
							'values' => array(
								'center_content' => __('Only Content','wp-pagebuilder'),
								'right_media' => __('Right Media','wp-pagebuilder'),
								'left_media' => __('Left Media','wp-pagebuilder'),
							),
							'std' => 'right_media',
							'section' => 'Slide',
						),
						'media_type' => array(
							'type' => 'select',
							'title' => __('Type','wp-pagebuilder'),
							'values' => array(
								'media_image' => __('Image','wp-pagebuilder'),
								'media_video' => __('Video','wp-pagebuilder'),
							),
							'std' => 'media_image',
							'section' => 'Slide',
							'depends' => array(array('slider_type', '=', array('right_media','left_media'))),
						),
						'imageupload' => array(
							'type' => 'media',
							'title' => __('Upload content image','wp-pagebuilder'),
							'section' => 'Slide',
							'std' => array( 'url' => WPPB_DIR_URL.'assets/img/placeholder/wppb-medium.jpg' ),
							'depends' => array(array('media_type', '=', array('media_image'))),
						),
						'image_animation'=> array(
							'type' => 'animation',
							'title' => 'Image Animation',
							'section' => 'Slide',
							'std' => array(
								'name' => 'wow animated fadeIn',
								'delay' => '300',
								'duration' => '400'
							),
							'depends' => array(array('media_type', '=', array('media_image'))),
						),
						'video_url' => array(
							'type' => 'text',
							'title' => __('Video URL','wp-pagebuilder'),
							'std' => 'https://www.youtube.com/watch?v=EKDZ7pvNSLs',
							'depends' => array(array('media_type', '=', array('media_video'))),
							'section' => 'Slide',
						),
						'video_info' => array(
							'type' => 'switch',
							'title' => __('Hide video info','wp-pagebuilder'),
							'std' => '1',
							'depends' => array(array('media_type', '=', array('media_video'))),
							'section' => 'Slide',
						),
						'video_animation'=> array(
							'type' => 'animation',
							'title' => 'Video Animation',
							'section' => 'Slide',
							'std' => array(
								'name' => 'wow animated fadeIn',
								'delay' => '300',
								'duration' => '400'
							),
							'depends' => array(array('media_type', '=', array('media_video'))),
						),
						'content_align' => array(
							'type' => 'alignment',
							'title' => __('Content Alignment','wp-pagebuilder'),
							'std' => array( 'md' => 'center', 'sm' => '', 'xs' => '' ),
							'responsive' => true,
							'selector' => '{{SELECTOR}} .wppb-carousel-content-in { text-align: {{data.content_align}}; }',
							'section' => 'Slide',
						),

						//title
						'title' => array(
							'type' => 'text',
							'title' => __('Title','wp-pagebuilder'),
							'section' => 'Title',
							'std'=> 'Slide Title',
						),
						'selector' => array(
							'type' => 'select',
							'title' => __('Title Tag','wp-pagebuilder'),
							'values' => array(
								'h1' => 'h1',
								'h2' => 'h2',
								'h3' => 'h3',
								'h4' => 'h4',
								'h5' => 'h5',
								'h6' => 'h6',
							),
							'std' => 'h2',
							'section' => 'Title',
						),
						'title_animation'=> array(
							'type' => 'animation',
							'title' => 'Animation',
							'section' => 'Title',
							'std' => array(
								'name' => 'wow animated fadeIn',
								'delay' => '300',
								'duration' => '400'
							),
						),
						'title_color' => array(
							'type' => 'color',
							'title' => __('Title color','wp-pagebuilder'),
							'section' => 'Title',
							'selector' => '{{SELECTOR}} .wppb-carousel-title { color: {{data.title_color}}; }'
						),
						'title_fontstyle' => array(
							'type' => 'typography',
							'title' => 'Title font',
							'std' => array(
								'fontFamily' => '',
								'fontSize' => [ 'md'=>'25px', 'sm'=>'', 'xs'=>'' ],
								'lineHeight' => [ 'md'=>'', 'sm'=>'', 'xs'=>'' ],
								'fontWeight' => '700',
								'textTransform' => '',
								'fontStyle' => '',
								'letterSpacing' => [ 'md'=>'0px', 'sm'=>'', 'xs'=>'' ],
							),
							'selector' => '{{SELECTOR}} .wppb-carousel-title',
							'section' => 'Title',
						),
						'title_margin' => array(
							'type' => 'dimension',
							'title' => 'Title Margin',
							'std' => array(
								'md' => array( 'top' => '15px', 'right' => '15px', 'bottom' => '15px', 'left' => '15px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Title',
							'selector' => '{{SELECTOR}} .wppb-carousel-title{ margin: {{data.title_margin}}; }'
						),

						//sub title
						'subtitle' => array(
							'type' => 'textarea',
							'title' => __('Subtitle','wp-page-builder'),
							'section' => 'Subtitle',
							'std' => 'WordPress page builder',
						),
						'subselector' => array(
							'type' => 'select',
							'title' => __( 'Sub Title Tag','wp-pagebuilder' ),
							'values' => array(
								'h1' => 'h1',
								'h2' => 'h2',
								'h3' => 'h3',
								'h4' => 'h4',
								'h5' => 'h5',
								'h6' => 'h6',
							),
							'std' => 'h3',
							'section' => 'Subtitle',
						),
						'subtitle_animation'=> array(
							'type' => 'animation',
							'title' => 'Sub Title Animation',
							'section' => 'Subtitle',
							'std' => array(
								'name' => 'wow animated fadeInDown',
								'delay' => '300',
								'duration' => '400'
							),
						),
						'subtitle_color' => array(
							'type' => 'color',
							'title' => __('Sub title color','wp-page-builder'),
							'section' => 'Subtitle',
							'selector' => '{{SELECTOR}} .wppb-carousel-subtitle { color: {{data.subtitle_color}}; }'
						),
						'subtitle_fontstyle' => array(
							'type' => 'typography',
							'title' => 'Sub title font',
							'std' => array(
								'fontFamily' => '',
								'fontSize' => [ 'md'=>'18px', 'sm'=>'', 'xs'=>'' ],
								'lineHeight' => [ 'md'=>'', 'sm'=>'', 'xs'=>'' ],
								'fontWeight' => '700',
								'textTransform' => '',
								'fontStyle' => '',
								'letterSpacing' => [ 'md'=>'0px', 'sm'=>'', 'xs'=>'' ],
							),
							'selector' => '{{SELECTOR}} .wppb-carousel-subtitle',
							'section' => 'Subtitle',
						),
						'subtitle_margin' => array(
							'type' => 'dimension',
							'title' => 'Sub title margin',
							'std' => array(
								'md' => array( 'top' => '15px', 'right' => '15px', 'bottom' => '15px', 'left' => '15px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Subtitle',
							'selector' => '{{SELECTOR}} .wppb-carousel-subtitle{ margin: {{data.subtitle_margin}}; }'
						),

						//content
						'content' => array(
							'type' => 'textarea',
							'title' => __('Add content','wp-pagebuilder'),
							'std' => '1 year customer support',
							'section' => 'Content',
						),
						'content_animation'=> array(
							'type' => 'animation',
							'title' => 'Content Animation',
							'section' => 'Content',
							'std' => array(
								'name' => 'wow animated fadeIn',
								'delay' => '300',
								'duration' => '400'
							),
						),
						'intro_color' => array(
							'type' => 'color',
							'title' => __('Content text color','wp-pagebuilder'),
							'section' => 'Content',
							'selector' => '{{SELECTOR}} .wppb-carousel-content { color: {{data.intro_color}}; }'
						),
						'intro_fontstyle' => array(
							'type' => 'typography',
							'title' => 'Content font',
							'std' => array(
								'fontFamily' => '',
								'fontSize' => [ 'md'=>'14px', 'sm'=>'', 'xs'=>'' ],
								'lineHeight' => [ 'md'=>'', 'sm'=>'', 'xs'=>'' ],
								'fontWeight' => '700',
								'textTransform' => '',
								'fontStyle' => '',
								'letterSpacing' => [ 'md'=>'0px', 'sm'=>'', 'xs'=>'' ],
							),
							'selector' => '{{SELECTOR}} .wppb-carousel-content',
							'section' => 'Content',
						),
						'intro_margin' => array(
							'type' => 'dimension',
							'title' => 'Content margin',
							'std' => array(
								'md' => array( 'top' => '15px', 'right' => '15px', 'bottom' => '15px', 'left' => '15px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Content',
							'selector' => '{{SELECTOR}} .wppb-carousel-content { margin: {{data.intro_margin}}; }'
						),

						// button one
						'button_text' => array(
							'type' => 'text',
							'title' => __('Button text','wp-pagebuilder'),
							'section' => 'Button one',
							'std' => 'button'
						),
						'button_link' => array(
							'type' => 'link',
							'title' => __('Button link','wp-pagebuilder'),
							'section' => 'Button one',
						),
						'btn_animation1'=> array(
							'type' => 'animation',
							'title' => 'Button 1 Animation',
							'section' => 'Button one',
							'std' => array(
								'name' => 'wow animated fadeInLeft',
								'delay' => '300',
								'duration' => '400'
							),
						),
						'btn_fontstyle' => array(
							'type' => 'typography',
							'title' => 'Button font',
							'std' => array(
								'fontFamily' => '',
								'fontSize' => [ 'md'=>'14px', 'sm'=>'', 'xs'=>'' ],
								'lineHeight' => [ 'md'=>'', 'sm'=>'', 'xs'=>'' ],
								'fontWeight' => '700',
								'textTransform' => '',
								'fontStyle' => '',
								'letterSpacing' => [ 'md'=>'0px', 'sm'=>'', 'xs'=>'' ],
							),
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1',
							'section' => 'Button one',
						),
						'btn_color' => array(
							'type' => 'color',
							'title' => __('Button Color','wp-pagebuilder'),
							'clip' => true,
							'std' => '#fff',
							'section' => 'Button one',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1 { color: {{data.btn_color}}; }'
						),
						'btn_hover_color' => array(
							'type' => 'color',
							'title' => __('Button Hover Color','wp-pagebuilder'),
							'section' => 'Button one',
							'clip' => true,
							'std' => '#fff',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1:hover { color: {{data.btn_hover_color}}; }'
						),
						'btn_background' => array(
							'type' => 'color2',
							'title' => __('Button Background','wp-pagebuilder'),
							'section' => 'Button one',
							'clip' => false,
							'std' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#26c266',
							),
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1'
						),
						'btn_hover_background' => array(
							'type' => 'color2',
							'title' => __('Button Hover Background','wp-pagebuilder'),
							'section' => 'Button one',
							'clip' => false,
							'std' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#1fa957',
							),
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1:before, {{SELECTOR}} .wppb-btn-carousel1:hover'
						),
						'button_border' => array(
							'type' => 'border',
							'title' => 'Button Border',
							'std' => [
								'borderWidth' => ['top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px'],
								'borderStyle' => 'solid',
								'borderColor' => '#cccccc'
							],
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1, {{SELECTOR}} .wppb-btn-carousel1:before',
							'section' => 'Button one',
						),
						'border_hcolor' => array(
							'type' => 'border',
							'title' => 'Button hover color',
							'std' => array(
								'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
								'borderStyle' => 'solid',
								'borderColor' => '#cccccc'
							),
							'tab' => 'style',
							'section' => 'Button one',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1:hover, {{SELECTOR}} .wppb-btn-carousel1:hover:before'
						),
						'btn_radius' => array(
							'type' => 'dimension',
							'title' => __('Border Radius','wp-pagebuilder'),
							'unit' => array( 'px','%','em' ),
							'std' => array(
								'md' => array( 'top' => '4px', 'right' => '4px', 'bottom' => '4px', 'left' => '4px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
							),
							'responsive' => true,
							'section' => 'Button one',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1, {{SELECTOR}} .wppb-btn-carousel1:before { border-radius: {{data.btn_radius}}; }'
						),
						'btn_padding' => array(
							'type' => 'dimension',
							'title' => 'Button padding',
							'std' => array(
								'md' => array( 'top' => '10px', 'right' => '15px', 'bottom' => '10px', 'left' => '15px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Button one',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1 { padding: {{data.btn_padding}}; }'
						),
						'btn_margin' => array(
							'type' => 'dimension',
							'title' => 'Button margin',
							'std' => array(
								'md' => array( 'top' => '0', 'right' => '5px', 'bottom' => '0', 'left' => '0' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Button one',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel1 { margin: {{data.btn_margin}}; }'
						),

						//btn two
						'button_text2' => array(
							'type' => 'text',
							'title' => __('Button text 2','wp-pagebuilder'),
							'section' => 'Button two',
							'std' => 'button'
						),
						'button_link2' => array(
							'type' => 'link',
							'title' => __('Button link 2','wp-pagebuilder'),
							'section' => 'Button two',
						),
						'btn_animation2'=> array(
							'type' => 'animation',
							'title' => 'Button 2 Animation',
							'section' => 'Button two',
							'std' => array(
								'name' => 'wow animated fadeInRight',
								'delay' => '300',
								'duration' => '400'
							),
						),
						'btn_fontstyle2' => array(
							'type' => 'typography',
							'title' => 'Button 2 font style',
							'std' => array(
								'fontFamily' => '',
								'fontSize' => [ 'md'=>'14px', 'sm'=>'', 'xs'=>'' ],
								'lineHeight' => [ 'md'=>'', 'sm'=>'', 'xs'=>'' ],
								'fontWeight' => '700',
								'textTransform' => '',
								'fontStyle' => '',
								'letterSpacing' => [ 'md'=>'', 'sm'=>'', 'xs'=>'' ],
							),
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2',
							'section' => 'Button two',
						),
						'btn_color2' => array(
							'type' => 'color',
							'title' => __('Button Color 2','wp-pagebuilder'),
							'clip' => true,
							'std' => '#fff',
							'section' => 'Button two',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2 { color: {{data.btn_color2}}; }'
						),
						'btn_hover_color2' => array(
							'type' => 'color',
							'title' => __('Button Hover Color 2','wp-pagebuilder'),
							'section' => 'Button two',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2:hover { color: {{data.btn_hover_color2}}; }'
						),
						'btn_background2' => array(
							'type' => 'color2',
							'title' => __('Button Background 2','wp-pagebuilder'),
							'section' => 'Button two',
							'clip' => false,
							'std' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#3666E4',
							),
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2'
						),
						'btn_hover_background2' => array(
							'type' => 'color2',
							'title' => __('Button Hover Background 2','wp-pagebuilder'),
							'section' => 'Button two',
							'clip' => false,
							'std' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#2955ca',
							),
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2:before, {{SELECTOR}} .wppb-btn-carousel2:hover'
						),

						'button_border2' => array(
							'type' => 'border',
							'title' => 'Button 2 Border',
							'std' => [
								'borderWidth' => ['top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px'],
								'borderStyle' => 'solid',
								'borderColor' => '#cccccc'
							],
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2, {{SELECTOR}} .wppb-btn-carousel2:before',
							'section' => 'Button two',
						),
						'button_border2_hover' => array(
							'type' => 'border',
							'title' => 'Border hover',
							'std' => array(
								'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
								'borderStyle' => 'solid',
								'borderColor' => '#cccccc'
							),
							'tab' => 'style',
							'section' => 'Button two',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2:hover, {{SELECTOR}} .wppb-btn-carousel2:hover:before'
						),
						'btn_radius2' => array(
							'type' => 'dimension',
							'title' => __('Border 2 Radius','wp-pagebuilder'),
							'unit' => array( 'px','%','em' ),
							'responsive' => true,
							'section' => 'Button two',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2, {{SELECTOR}} .wppb-btn-carousel2:before { border-radius: {{data.btn_radius2}}; }'
						),
						'btn_padding2' => array(
							'type' => 'dimension',
							'title' => 'Button 2 padding',
							'std' => array(
								'md' => array( 'top' => '10px', 'right' => '15px', 'bottom' => '10px', 'left' => '15px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Button two',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2 { padding: {{data.btn_padding2}}; }'
						),
						'btn_margin2' => array(
							'type' => 'dimension',
							'title' => 'Button 2 margin',
							'std' => array(
								'md' => array( 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '5px' ),
								'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
								'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
							),
							'unit' => array( 'px','em','%' ),
							'responsive' => true,
							'section' => 'Button two',
							'selector' => '{{SELECTOR}} .wppb-btn-carousel2 { margin: {{data.btn_margin2}}; }'
						),

						//style
						'carosuel_bg' => array(
							'type' => 'background',
							'title' => __('Background image','wp-pagebuilder'),
							'section' => 'Background',
							'std' => '',
							'selector' => '{{SELECTOR}} .wppb-carousel-content-wrap',
						),
						'overlay_en' => array(
							'type' => 'switch',
							'title' => __('Overlay hide','wp-pagebuilder'),
							'std' => '0',
							'section' => 'Background',
						),
						'carosuel_bg_overlay' => array(
							'type' => 'color2',
							'title' => __('Background Image overlay','wp-pagebuilder'),
							'section' => 'Background',
							'clip' => false,
							'std' => array(
								'clip' => false,
								'colorType' => 'color',
								'colorColor' => '#3666E4',
							),
							'depends' => array(array('overlay_en', '=', '1')),
							'selector' => '{{SELECTOR}} .wppb-carousel-overlay'
						),
					),
				),


				// nav
				'nav_color' => array(
					'type' => 'color',
					'title' => __('Nav Color','wp-pagebuilder'),
					'tab' => 'style',
					'section' => 'Nav',
					'std'     => '#fff',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-arrow { color: {{data.nav_color}}; }',
				),
				'nav_bg' => array(
					'type' => 'color2',
					'title' => __('Nav Background','wp-pagebuilder'),
					'tab' => 'style',
					'section' => 'Nav',
					'clip' => false,
					'std' => array(
						'clip' => false,
						'colorType' => 'color',
						'colorColor' => '#252525',
					),
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-arrow',
				),
				'nav_width' => array(
					'type' => 'slider',
					'title' => __('Nav width','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
					'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 10,
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
						'md' => '40px',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Nav',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-arrow { width: {{data.nav_width}}; }'
				),
				'nav_height' => array(
					'type' => 'slider',
					'title' => __('Nav height','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
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
					'std' => array(
						'md' => '40px',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Nav',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-arrow { height: {{data.nav_height}}; }{{SELECTOR}} .wppb-carousel .slick-arrow { line-height: {{data.nav_height}}; }'
				),
				'nav_radius' => array(
					'type' => 'dimension',
					'title' => __('Border Radius','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
					'std' => array(
						'md' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ),
						'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
						'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Nav',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-arrow { border-radius: {{data.nav_radius}}; }'
				),
				'nav_position' => array(
					'type' => 'slider',
					'title' => __('Nav Position','wp-pagebuilder'),
					'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 10,
							'step' => .1,
						),
						'px' => array(
							'min' => -100,
							'max' => 350,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
					'unit' => array( 'px','%','em' ),
					'std' => array(
						'md' => '50%',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Nav',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-arrow { top: {{data.nav_position}}; }'
				),
				// style
				'dot_bg' => array(
					'type' => 'color2',
					'title' => __('Dots Background','wp-pagebuilder'),
					'tab' => 'style',
					'section' => 'Dots',
					'clip' => false,
					'std' => array(
						'clip' => false,
						'colorType' => 'color',
						'colorColor' => '#3666E4',
					),
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-dots li button',
				),
				'dots_width' => array(
					'type' => 'slider',
					'title' => __('Dots width','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
					'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 10,
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
						'md' => '40px',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Dots',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-dots li button,{{SELECTOR}} .wppb-carousel .slick-dots li{ width: {{data.dots_width}}; }'
				),
				'dots_height' => array(
					'type' => 'slider',
					'title' => __('Dots height','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
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
					'std' => array(
						'md' => '5px',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Dots',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-dots li button,{{SELECTOR}} .wppb-carousel .slick-dots li{ height: {{data.dots_height}}; }'
				),
				'dots_radius' => array(
					'type' => 'dimension',
					'title' => __('Border Radius','wp-pagebuilder'),
					'unit' => array( 'px','%','em' ),
					'std' => array(
						'md' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ),
						'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
						'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Dots',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-dots li button{ border-radius: {{data.dots_radius}}; }'
				),
				'dots_position' => array(
					'type' => 'slider',
					'title' => __('Dots Position','wp-pagebuilder'),
					'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 10,
							'step' => .1,
						),
						'px' => array(
							'min' => -100,
							'max' => 350,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
					'unit' => array( 'px','%','em' ),
					'std' => array(
						'md' => '35px',
						'sm' => '',
						'xs' => '',
					),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Dots',
					'selector' => '{{SELECTOR}} .wppb-carousel .slick-dots { bottom: {{data.dots_position}}; }'
				),
				'content_padding' => array(
					'type' => 'dimension',
					'title' => 'Content padding',
					'std' => array(
						'md' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
						'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
						'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					),
					'unit' => array( 'px','em','%' ),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Content',
					'selector' => '{{SELECTOR}} .wppb-carousel-content-in { padding: {{data.content_padding}}; }'
				),
				'content_margin' => array(
					'type' => 'dimension',
					'title' => 'Content margin',
					'std' => array(
						'md' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
						'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
						'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					),
					'unit' => array( 'px','em','%' ),
					'responsive' => true,
					'tab' => 'style',
					'section' => 'Content',
					'selector' => '{{SELECTOR}} .wppb-carousel-content-in { margin: {{data.content_margin}}; }'
				),
			);

			return $settings;
		}

		// Alert Render HTML
		public function render($data = null){
			$output = '';
			$settings = $data['settings'];

			$attrSettings = $settings;
			unset($attrSettings['carosuel_list']);

			$items = isset($settings["carosuel_list"]) ? $settings["carosuel_list"] : array();

			ob_start();

			?>
            <div class="wppb-carousel-addon">
            <div class="wppb-carousel-addon-content">
                <div class="wppb-carousel stick-dots" data-addon-id="<?php echo $data['id'];?>" data-settings="<?php echo esc_attr(json_encode($attrSettings));  ?>" >

					<?php foreach ( $items as $key => $value ) {

					//selector
					$selector    = get_wppb_array_value_by_key( $value, 'selector' ) ? get_wppb_array_value_by_key( $value, 'selector' ) : "h2";
					$subselector = get_wppb_array_value_by_key( $value, 'subselector' ) ? get_wppb_array_value_by_key( $value, 'subselector' ) : "h3";

					// button
					if ( ! empty( get_wppb_array_value_by_key( $value, 'button_link' )['link'] ) ) {
						$target  = ! empty( get_wppb_array_value_by_key( $value, 'button_link' )['window'] ) ? 'target=_blank' : 'target=_self';
						$nofolow = ! empty( get_wppb_array_value_by_key( $value, 'button_link' )['nofolow'] ) ? 'rel=nofolow' : "";
					}
					if ( ! empty( get_wppb_array_value_by_key( $value, 'button_link2' )['link'] ) ) {
						$target2  = ! empty( get_wppb_array_value_by_key( $value, 'button_link2' )['window'] ) ? 'target=_blank' : 'target=_self';
						$nofolow2 = ! empty( get_wppb_array_value_by_key( $value, 'button_link2' )['nofolow'] ) ? 'rel=nofolow' : "";
					}

					//video
					$video_url = get_wppb_array_value_by_key( $value, 'video_url' );
					if ( $video_url ) {
						$video = parse_url( $video_url );
						switch ( $video['host'] ) {
							case 'youtu.be':
								$id  = trim( $video['path'], '/' );
								$videosrc = '//www.youtube.com/embed/' . $id . '?&showinfo=' . get_wppb_array_value_by_key( $value, 'video_info' );
								break;

							case 'www.youtube.com':
							case 'youtube.com':
								parse_str( $video['query'], $query );
								$id  = $query['v'];
								$videosrc = '//www.youtube.com/embed/' . $id . '?&showinfo=' . get_wppb_array_value_by_key( $value, 'video_info' );
								break;

							case 'vimeo.com':
							case 'www.vimeo.com':
								$id  = trim( $video['path'], '/' );
								$videosrc = "//player.vimeo.com/video/{$id}";
						}
					}

					// animation
					$titleAnimation = '';
					if (!empty($value['title_animation']['itemOpen'])){
						$enableAnimation = (bool) $value['title_animation']['itemOpen'];
						if ($enableAnimation && ! empty( $value['title_animation']['name'])){
							$titleAnimation = "data-animation-in='{$value['title_animation']['name']}'";
						}
					}
					$SubtitleAnimation = '';
					if (!empty($value['subtitle_animation']['itemOpen'])){
						$enableAnimation = (bool) $value['subtitle_animation']['itemOpen'];
						if ($enableAnimation && ! empty( $value['subtitle_animation']['name'])){
							$SubtitleAnimation = "data-animation-in='{$value['subtitle_animation']['name']}'";
						}
					}
					$ContentAnimation = '';
					if (!empty($value['content_animation']['itemOpen'])){
						$enableAnimation = (bool) $value['content_animation']['itemOpen'];
						if ($enableAnimation && ! empty( $value['content_animation']['name'])){
							$ContentAnimation = "data-animation-in='{$value['content_animation']['name']}'";
						}
					}
					$ImageAnimation = '';
					if (!empty($value['image_animation']['itemOpen'])){
						$enableAnimation = (bool) $value['image_animation']['itemOpen'];
						if ($enableAnimation && ! empty( $value['image_animation']['name'])){
							$ImageAnimation = "data-animation-in='{$value['image_animation']['name']}'";
						}
					}
					$VideoAnimation = '';
					if (!empty($value['video_animation']['itemOpen'])){
						$enableAnimation = (bool) $value['video_animation']['itemOpen'];
						if ($enableAnimation && ! empty( $value['video_animation']['name'])){
							$VideoAnimation = "data-animation-in='{$value['video_animation']['name']}'";
						}
					}
					$Button1Animation = '';
					if (!empty($value['btn_animation1']['itemOpen'])){
						$enableAnimation = (bool) $value['btn_animation1']['itemOpen'];
						if ($enableAnimation && ! empty( $value['btn_animation1']['name'])){
							$Button1Animation = "data-animation-in='{$value['btn_animation1']['name']}'";
						}
					}
					$Button2Animation = '';
					if (!empty($value['btn_animation2']['itemOpen'])){
						$enableAnimation = (bool) $value['btn_animation2']['itemOpen'];
						if ($enableAnimation && ! empty( $value['btn_animation2']['name'])){
							$Button2Animation = "data-animation-in='{$value['btn_animation2']['name']}'";
						}
					}


					$ImageMedia = '';
					if ( get_wppb_array_value_by_key( $value, 'media_type' ) == "media_video" ) {
						if ( $video_url ) {
							$ImageMedia .= '<div class="wppb-video-slide">';
							$ImageMedia .= '<iframe height="280" width:="100%" class="wppb-embed-responsive-item" src="' . $videosrc . '" allowFullScreen></iframe>';
							$ImageMedia .= '</div>';
						} else {
							if ( ! empty($value['imageupload']['url'])){
								$ImageMedia .= '<img src="'.$value['imageupload']['url'].'" class="animated" '.$ImageAnimation.' alt="image" />';
							}
						}
					} else {
						if ( ! empty($value['imageupload']['url'])){
							$ImageMedia .= '<img src="'.$value['imageupload']['url'].'" class="animated" '.$ImageAnimation.' alt="image" />';
						}
					}

					// button 1
					$button1 = '';
					if ( ! empty( get_wppb_array_value_by_key( $value, 'button_link' )['link'] ) ) {
						$button1 .= '<a ' . esc_attr( $nofolow ) . ' href="' . esc_url( $value['button_link']['link'] ) . '" ' . esc_attr( $target ) . ' class="animated wppb-carousel-btn wppb-btn-carousel1" '.$Button1Animation.'>' . get_wppb_array_value_by_key( $value, 'button_text' ) . '</a>';
					}

					//button 2
					$button2 = '';
					if ( ! empty( get_wppb_array_value_by_key( $value, 'button_link2' )['link'] ) ) {
						$button2 .= '<a ' . esc_attr( $nofolow2 ) . ' href="' . esc_url( $value['button_link2']['link'] ) . '" ' . esc_attr( $target2 ) . ' class="animated wppb-carousel-btn wppb-btn-carousel2" '.$Button2Animation.'>' . get_wppb_array_value_by_key( $value, 'button_text2' ) . '</a>';
					}

					?>
            <div class="slick-slide-item repeater-<?php echo $key;?>">
              <div class="wppb-carousel-content-wrap <?php echo get_wppb_array_value_by_key( $value, 'slider_type' );?>">

							<?php if( get_wppb_array_value_by_key( $value, 'overlay_en' ) == 1 ) { ?>
                                <div class="wppb-carousel-overlay"></div>
							<?php } ?>
                            <div class="wppb-container">
								<?php if ( get_wppb_array_value_by_key( $value, 'slider_type' ) == "left_media" ) { ?>
                                    <div class="wppb-carousel-media wppb-carousel-media-left">
										<?php echo $ImageMedia;?>
                                    </div>
								<?php } ?>
								<?php if ( get_wppb_array_value_by_key( $value, 'slider_type' ) == "center_content" ) { ?>
                                <div class="wppb-carousel-content-in wppb-carousel-content-middle">
									<?php } else { ?>
                                    <div class="wppb-carousel-content-in">
										<?php } ?>
										<?php echo '<' . esc_attr( $selector ) . ' class="animated wppb-carousel-title" '.$titleAnimation.'>' . get_wppb_array_value_by_key( $value, 'title' ) . '</' . esc_attr( $selector ) . '>';?>
										<?php echo '<' . esc_attr( $subselector ) . ' class="animated wppb-carousel-subtitle" '.$SubtitleAnimation.'>' . get_wppb_array_value_by_key( $value, 'subtitle' ) . '</' . esc_attr( $subselector ) . '>';?>
										<?php echo '<div class="animated wppb-carousel-content" '.$SubtitleAnimation.'>' . get_wppb_array_value_by_key( $value, 'content' ) . '</div>';?>
										<?php echo $button1; ?>
										<?php echo $button2; ?>
                                    </div> <!--/.wppb-carousel-content-in-->
									<?php if ( get_wppb_array_value_by_key( $value, 'slider_type' ) == "right_media" ) { ?>
                                        <div class="wppb-carousel-media wppb-carousel-media-right">
											<?php echo $ImageMedia;?>
                                        </div>
									<?php } ?>
                                </div> <!--/.wppb-container-->
                            </div> <!--/.wppb-carousel-content-wrap-->
                        </div> <!--/.repeater-->
						<?php } ?>
                    </div> <!--/.wppb-carousel-->
                </div> <!--/.wppb-carousel-addon-content-->
            </div> <!--/.wppb-carousel-addon-->

			<?php $output .= ob_get_clean();
			return $output;
		}

		// Carousel Template
		public function getTemplate(){
			$output = '
			<div class="wppb-carousel-addon">
				<div class="wppb-carousel-addon-content">
					<div class="wppb-carousel stick-dots" data-addon-id="{{data.id}}">
						<#  _.forEach(data.carosuel_list, function(value, key) { #>
							<#
							let videoUrl = value.video_url || ""
							let videosrc = "";
							if ( videoUrl ) {
								let tempAchor = document.createElement("a")
									tempAchor.href = videoUrl
								let videoObj = {
									host    :   tempAchor.hostname,
									path    :   tempAchor.pathname,
									query   :   tempAchor.search.substr(tempAchor.search.indexOf("?") + 1)
								}
								switch( videoObj.host ){
									case "youtu.be":
										var videoId = videoObj.path.trim();
											videosrc = "//www.youtube.com/embed"+ videoId + "?&showinfo="+value.video_info
										break;
									case "www.youtube.com":
									case "youtube.com":
										var queryStr = videoObj.query.split("=");
											videosrc = "//www.youtube.com/embed/"+ queryStr[1] + "?&showinfo="+value.video_info
										break;
									case "www.vimeo.com":
									case "vimeo.com":
										var videoId = videoObj.path.trim();
											videosrc = "//player.vimeo.com/video"+ videoId
										break;
								}
							}

							var ImageMedia = "";
							if ( value.media_type == "media_video" ) {
								if ( videoUrl ) {
									ImageMedia  = "<div class=\'wppb-video-slide\'><iframe height=\'280\' width:=\'100%\' class=\'wppb-embed-responsive-item\' src=\'"+videosrc+"\' allowFullScreen></iframe></div>";
								}
							} else {
								if ( value.imageupload ) {
									ImageMedia  = "<img src=\'"+value.imageupload.url+"\' />";
								}
							}

							var selector = value.selector ? value.selector : "h2";
							var subselector = value.subselector ? value.subselector : "h3";
						#>

							<div class="slick-slide-item repeater-{{key}}">
								<div class="wppb-carousel-content-wrap {{value.slider_type}}">
									<# if( value.overlay_en == 1 ) { #>
										<div class="wppb-carousel-overlay"></div>
									<# } #>
									<div class="wppb-container">

										<# if ( value.slider_type == "left_media" ) { #>
										<div class="wppb-carousel-media wppb-carousel-media-left">
											{{{ImageMedia}}}
										</div>
										<# } #>

										<# if ( value.slider_type == "center_content" ) { #>
											<div class="wppb-carousel-content-in wppb-carousel-content-middle">
										<# } else { #>
											<div class="wppb-carousel-content-in">
										<# } #>
										
											<{{selector}} class="animated wppb-carousel-title" <# if(value.title_animation) { #> data-animation-in="{{ value.title_animation.name }}" data-delay-in="{{value.title_animation.delay}}ms" data-duration-in="{{value.title_animation.duration}}ms" <# } #>  >{{{value.title}}}</{{selector}}>
											<{{subselector}} class="animated wppb-carousel-subtitle" <# if(value.subtitle_animation) { #> data-animation-in="{{ value.subtitle_animation.name }}"  data-delay-in="{{value.subtitle_animation.delay}}ms" data-duration-in="{{value.subtitle_animation.duration}}ms" <# } #> >{{{value.subtitle}}}</{{subselector}}>
											<div class="animated wppb-carousel-content" <# if(value.content_animation) { #> 
											data-animation-in="{{ value.content_animation.name }}" data-delay-in="{{value.content_animation.delay}}ms" data-duration-in="{{value.content_animation.duration}}ms" <# } #>  >{{{value.content}}} </div>
											<# if( value.button_link && value.button_link.link ){ #>
												<# if(value.btn_animation1) { #>
													<a {{ value.button_link.link ? "href="+value.button_link.link : "" }} {{ value.button_link.window ? "target=_blank" : "" }} {{ value.button_link.nofolow ? "rel=nofolow" : "" }}  class="animated wppb-carousel-btn wppb-btn-carousel1" data-animation-in="{{ value.btn_animation1.name }}" data-delay-in="{{value.btn_animation1.delay}}ms" data-duration-in="{{value.btn_animation1.duration}}ms" >
														{{ value.button_text }}
													</a>
												<# } else { #>
													<a {{ value.button_link.link ? "href="+value.button_link.link : "" }} {{ value.button_link.window ? "target=_blank" : "" }} {{ value.button_link.nofolow ? "rel=nofolow" : "" }}  class="animated wppb-carousel-btn wppb-btn-carousel1">
														{{ value.button_text }}
													</a>
												<# } #>
											<# } #>
											<# if( value.button_link2 && value.button_link2.link ){ #>
												<# if(value.btn_animation2) { #>
													<a {{ value.button_link2.link ? "href="+value.button_link2.link : "" }} {{ value.button_link2.window ? "target=_blank" : "" }} {{ value.button_link2.nofolow ? "rel=nofolow" : "" }}  class="animated wppb-carousel-btn wppb-btn-carousel2" data-animation-in="{{ value.btn_animation2.name }}" data-delay-in="{{value.btn_animation2.delay}}ms" data-duration-in="{{value.btn_animation2.duration}}ms" >
														{{ value.button_text2 }}
													</a>
												<# } else { #>
													<a {{ value.button_link2.link ? "href="+value.button_link2.link : "" }} {{ value.button_link2.window ? "target=_blank" : "" }} {{ value.button_link2.nofolow ? "rel=nofolow" : "" }}  class="animated wppb-carousel-btn wppb-btn-carousel2">
														{{ value.button_text2 }}
													</a>
												<# } #>
											<# } #>
										</div>
										<# if ( value.slider_type == "right_media" ) { #>
											<div class="wppb-carousel-media wppb-carousel-media-right">
												{{{ImageMedia}}}
											</div>
										<# } #>
									</div>	
						        </div>
						    </div>
						<# }); #>
					</div>
				</div>
			</div>
		';
			return $output;
		}


	}
}