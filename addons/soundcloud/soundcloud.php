<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Soundcloud{

	public function get_name(){
		return 'wppb_soundcloud';
	}
	public function get_title(){
		return 'SoundCloud';
	}
	public function get_icon() {
		return 'wppb-font-soundcloud';
	}

	// image Settings Fields
	public function get_settings() {

		$settings = array(

			'link' => array(
				'type' => 'text',
				'title' => __('SoundCloud URL','wp-pagebuilder'),
				'std' => 'https://soundcloud.com/the-bugle/bugle-179-playas-gon-play',
			),
			'visual_player' => array(
				'type' => 'switch',
				'title' => __('Visual Player','wp-pagebuilder'),
				'std' => '0'
			),
			'autoplay' => array(
				'type' => 'switch',
				'title' => __('Auto Play','wp-pagebuilder'),
				'std' => '0'
			),
			'buy_button' => array(
				'type' => 'switch',
				'title' => __('Buy Button','wp-pagebuilder'),
				'std' => '0'
			),
			'download' => array(
				'type' => 'switch',
				'title' => __('Download','wp-pagebuilder'),
				'std' => '0'
			),
			'share_button' => array(
				'type' => 'switch',
				'title' => __('Share Button','wp-pagebuilder'),
				'std' => '0'
			),
			'play_count' => array(
				'type' => 'switch',
				'title' => __('Play Count','wp-pagebuilder'),
				'std' => '0'
			),
			'username' => array(
				'type' => 'switch',
				'title' => __('Username','wp-pagebuilder'),
				'std' => '0'
			),
			'control_color' => array(
				'type' => 'color',
				'title' => __('Controls Color','wp-pagebuilder'),
				'std' => '#444444',
				'tab' => 'style',
			),
			'height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 100,
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
					'md' => '200px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-soundcloud-content iframe { height: {{data.height}}; }'
			),
		);

		return $settings;
	}


	// Sound Cloud Render HTML
	public function render($data = null){
		$settings 			= $data['settings'];
		$link 				= isset($settings['link']) ? $settings['link'] : '';
		$visual_player 		= isset($settings['visual_player']) ? $settings['visual_player'] : '';
		$autoplay 			= isset($settings['autoplay']) ? $settings['autoplay'] : '';
		$buy_button 		= isset($settings['buy_button']) ? $settings['buy_button'] : '';
		$download 			= isset($settings['download']) ? $settings['download'] : '';
		$share_button 		= isset($settings['share_button']) ? $settings['share_button'] : '';
		$play_count 		= isset($settings['play_count']) ? $settings['play_count'] : '';
		$username 			= isset($settings['username']) ? $settings['username'] : '';
		$control_color 		= isset($settings['control_color']) ? $settings['control_color'] : '';

		$output = '';

		$autoplay = ($autoplay) ? 'true' : 'false';
		$share_button = ($share_button) ? 'true' : 'false';
		$download = ($download) ? 'true' : 'false';
		$username = ($username) ? 'true' : 'false';
		$play_count = ($play_count) ? 'true' : 'false';
		$buy_button = ($buy_button) ? 'true' : 'false';
		$visual_player = ($visual_player) ? 'true' : 'false';

		if( $control_color ) {
			$control_color = str_replace("#","",$control_color);
		}else {
			$control_color = "e46719";
		}

		$output  .= '<div class="wppb-soundcloud-addon">';
			$output  .= '<div class="wppb-soundcloud-content">';
				$output  .= '<iframe';
					$output  .= ' src="https://w.soundcloud.com/player/?url='.esc_attr($link).'&auto_play='.esc_attr($autoplay).'&sharing='.esc_attr($share_button).'&download='.esc_attr($download).'&show_user='.esc_attr($username).'&show_playcount='.esc_attr($play_count).'&buying='.esc_attr($buy_button).'&color='.$control_color.'&visual='.esc_attr($visual_player).'">';
				$output  .= '</iframe>';
			$output  .= '</div>';
		$output  .= '</div>';
	

		return $output;
	}


	// Template
	public function getTemplate(){
		$output = '
		<#
		var autoplay = share_button = download = username = play_count = like_button = buy_button = control_color = visual_player = "";
		autoplay = data.autoplay ? "true" : "false";
		share_button = data.share_button ? "true" : "false";
		download = data.download ? "true" : "false";
		username = data.username ? "true" : "false";
		play_count = data.play_count ? "true" : "false";
		buy_button = data.buy_button ? "true" : "false";
		visual_player = data.visual_player ? "true" : "false";

		if( data.control_color ) {
			control_color = data.control_color;
		}else {
			control_color = "e46719";
		}
		#>
		<div class="wppb-soundcloud-addon">
			<div class="wppb-soundcloud-content">
				<iframe src="https://w.soundcloud.com/player/?url={{data.link}}&auto_play={{autoplay}}&sharing={{share_button}}&download={{download}}&show_user={{username}}&show_playcount={{play_count}}&buying={{buy_button}}&color={{control_color.replace("#", "")}}&visual={{visual_player}}">
			</iframe>
			</div>
		</div>
		';
		return $output;
	}

}