<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Video_Popup{

	public function get_name(){
		return 'wppb_video_popup';
	}
	public function get_title(){
		return 'Video Popup';
	}
	public function get_icon() {
		return 'wppb-font-video-camera';
	}
	public function get_enqueue_script(){
		return array( 'jquery.magnific-popup' );
	}
	public function get_enqueue_style(){
		return array('magnific-popup');
	}

	// Video Settings Fields
	public function get_settings() {
		$settings = array(
			'video_url' => array(
				'type' => 'text',
				'title' => __('Video URL','wp-pagebuilder'),
				'std' => 'https://www.youtube.com/watch?v=_dhApw73KYU'
			),
			'before_text' => array(
				'type' => 'text',
				'title' => __('Before Video text','wp-pagebuilder'),
			),
			'after_text' => array(
				'type' => 'text',
				'title' => __('After Video text','wp-pagebuilder'),
			),
			'video_align' => array(
				'type' => 'select',
				'title' => __('Video icon alignment','wp-pagebuilder'),
				'responsive' => true,
				'values' => array(
					'video_left' => __('Left','wp-pagebuilder'),
					'video_center' => __('Center','wp-pagebuilder'),
					'video_right' => __('Right','wp-pagebuilder'),
				),
				'std' => 'video_center',
			),
			//style
			'icon_color' => array(
				'type' => 'color',
				'title' => __('color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon i { color: {{data.icon_color}}; }'
			),
			'icon_hcolor' => array(
				'type' => 'color',
				'title' => __('hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon:hover i { color: {{data.icon_hcolor}}; }'
			),
			'icon_bg_color' => array(
				'type' => 'color',
				'title' => __('background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'std' => '#f5f5f5',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon { background: {{data.icon_bg_color}}; }'
			),
			'icon_bg_hcolor' => array(
				'type' => 'color',
				'title' => __('hover Background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'std' => '#e5e5e5',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon:hover { background: {{data.icon_bg_hcolor}}; }'
			),
			'icon_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon'
			),
			'icon_hover_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'hover box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon:hover'
			),
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Size','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 23,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 350,
							'step' => 1,
						),
						'%' => array(
							'min' => 0,
							'max' => 100,
							'step' => 1,
						),
					),
				'std' => array(
						'md' => '32px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon i { font-size: {{data.icon_size}}; }',
			),
			'icon_line_height' => array(
				'type' => 'slider',
				'title' => __('line height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 23,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 350,
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
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon i { line-height: {{data.icon_line_height}}; }',
			),
			'icon_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 23,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 350,
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
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon { width: {{data.icon_width}}; }',
			),
			'icon_height' => array(
				'type' => 'slider',
				'title' => __('Icon Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 23,
							'step' => .1,
						),
						'px' => array(
							'min' => 0,
							'max' => 350,
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
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon { height: {{data.icon_height}}; }',
			),
			'icon_radius' => array(
				'type' => 'dimension',
				'title' => __('Icon Radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '100px', 'right' => '100px', 'bottom' => '100px', 'left' => '100px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-video-popup-icon { border-radius: {{data.icon_radius}}; }',
			),

			//before text
			'before_color' => array(
				'type' => 'color',
				'title' => __('Before color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Before text',
				'selector' => '{{SELECTOR}} .wppb-video-popup-before-text a, {{SELECTOR}} .wppb-video-popup-before-text a:hover { color: {{data.before_color}}; }'
			),
			'before_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-video-popup-before-text',
				'section' => 'Before text',
				'tab' => 'style',
			),
			'before_margin' => array(
				'type' => 'dimension',
				'title' => 'Before text Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-video-popup-before-text { margin: {{data.before_margin}}; }',
				'section' => 'Before text',
			),

			//after text
			'after_color' => array(
				'type' => 'color',
				'title' => __('After color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'After text',
				'selector' => '{{SELECTOR}} .wppb-video-popup-after-text a,{{SELECTOR}} .wppb-video-popup-after-text a:hover { color: {{data.after_color}}; }'
			),
			'after_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-video-popup-after-text',
				'section' => 'After text',
				'tab' => 'style',
			),
			'after_margin' => array(
				'type' => 'dimension',
				'title' => 'After text Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-video-popup-after-text { margin: {{data.after_margin}}; }',
				'section' => 'After text',
			),
		);
		return $settings;
	}

	// Video popup Render HTML
	public function render($data = null){
		$settings 		= $data['settings'];
		$video_url 		= isset($settings['video_url']) ? $settings['video_url'] : '';
		$before_text 	= isset($settings['before_text']) ? $settings['before_text'] : '';
		$after_text 	= isset($settings['after_text']) ? $settings['after_text'] : '';
		$video_align 	= isset($settings['video_align']) ? $settings['video_align'] : '';
		$output = $video_alignment = '';


			if( isset($video_align['md']) && $video_align['md'] ){
				$video_alignment .=  ( isset($video_align['md'] ) && $video_align['md'] ) ? 'md'.$video_align['md'].' '  : 'mdvideo_center';
			}
			if( isset($video_align['sm']) && $video_align['sm'] ){
				$video_alignment .=  ( isset($video_align['sm'] ) && $video_align['sm'] ) ? 'sm'.$video_align['sm'].' '  : ' smvideo_center';
			}
			if( isset($video_align['xs']) && $video_align['xs'] ){
				$video_alignment .=  ( isset($video_align['xs'] ) && $video_align['xs'] ) ? 'xs'.$video_align['xs'].' '  : ' xsvideo_center';
			}
		
			$output  .= '<div class="wppb-video-popup-addon">';
			$output  .= '<div class="wppb-video-popup-content">';
			$output  .= '<div class="wppb-video-popup-wrap '.esc_attr($video_alignment).'">';
				if($before_text){
					$output  .= '<div class="wppb-video-popup-before-text"><a href="'. esc_url($video_url) .'" class="wppb-video-popup">'.esc_html($before_text).'</a></div>';
				}
				$output  .= '<div class="wppb-video-popup-content">';
					$output .= '<a href="'. esc_url($video_url) .'" class="wppb-video-popup wppb-video-popup-icon"><i class="wppb-font-play-button-alt"></i></a>';
				$output .= '</div>';
				if($after_text){
					$output  .= '<div class="wppb-video-popup-after-text"><a href="'. esc_url($video_url) .'" class="wppb-video-popup">'.esc_html($after_text).'</a></div>';
				}
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';
		return $output;
	}

	// Video popup Template
	public function getTemplate(){
		$output = '
		<#
		var video_alignment = "";
			if(data.video_align["md"]){
				video_alignment +=  data.video_align["md"] ? "md"+data.video_align["md"]+" " : "mdvideo_center";
			}
			if(data.video_align["sm"]){
				video_alignment +=  data.video_align["sm"] ? "sm"+data.video_align["sm"]+" " : " smvideo_center";
			}
			if(data.video_align["xs"]){
				video_alignment +=  data.video_align["xs"] ? "xs"+data.video_align["xs"]+" " : " xsvideo_center";
			}
		#>
		<div class="wppb-video-popup-addon">
			<div class="wppb-video-popup-content">
				<div class="wppb-video-popup-wrap {{video_alignment}}">
					<# if( data.before_text ) { #>
						<div class="wppb-video-popup-before-text"><a href="{{data.video_url}}" class="wppb-video-popup">{{data.before_text}}</a></div>
					<# } #>
					<div class="wppb-video-popup-content">
						<a href="{{data.video_url}}" class="wppb-video-popup wppb-video-popup-icon"><i class="wppb-font-play-button-alt"></i></a>
					</div>
					<# if( data.after_text ) { #>
						<div class="wppb-video-popup-after-text"><a href="{{data.video_url}}" class="wppb-video-popup">{{data.after_text}}</a></div>
					<# } #>
				</div>
			</div>
		</div>
		';
		return $output;
	}

}