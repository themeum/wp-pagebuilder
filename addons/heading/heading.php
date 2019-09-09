<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Heading{

	public function get_name(){
		return 'wppb_heading';
	}
	public function get_title(){
		return 'Heading';
	}
	public function get_icon() {
		return 'wppb-font-heading';
	}

	// headline Settings Fields
	public function get_settings() {

		$settings = array(

			'title' => array(
				'type' => 'textarea',
				'title' => __('Title','wp-pagebuilder'),
				'std' => 'This is Title',
			),

			'title_selector' => array(
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
				'std' => 'h2',
			),
			'title_link' => array(
				'type' => 'link',
				'title' => __('Link','wp-pagebuilder'),
				'std' =>   array('link'=>'','window'=>false,'nofolow'=>false),
			),
			'align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-addon-title { text-align: {{data.align}}; }'
			),
			'title_color' => array(
				'type' => 'color2',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'clip' => true,
				'std' => array( 'colorType' => 'color', 'clip' => true, 'colorColor' => '' ),
				'selector' => '{{SELECTOR}} .wppb-addon-title, {{SELECTOR}} .wppb-addon-title a'
			),
			'title_link_hcolor' => array(
				'type' => 'color',
				'title' => __('link hover color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-addon-title a:hover{ color: {{data.title_link_hcolor}}; }'
			),
			'title_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'28px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-addon-title',
				'tab' => 'style',
			)

		);

		return $settings;
	}

	// Headline Render HTML
	public function render($data = null){
		$settings 		= $data['settings']; 
		$title_selector = isset($settings["title_selector"]) ? $settings["title_selector"] : 'h2';
		$title 			= isset($settings["title"]) ? $settings["title"] : '';
		$title_link 	= isset($settings["title_link"]) ? $settings["title_link"] : array();

		$output = '';

		$target = !empty($title_link['window']) ? 'target=_blank' : "";
		$nofolow = !empty($title_link['nofolow']) ? 'rel=nofolow' : "";

			$output  .= '<div class="wppb-headline-addon">';
				$output  .= '<div class="wppb-headline-content">';
				if( !empty($title_link['link']) ){
					$output .= '<' .esc_attr($title_selector). ' class="wppb-addon-title"><a '.esc_attr($nofolow).' href="'.esc_url($title_link['link']).'" '.esc_attr($target).'>' . wp_kses_post($title) .'</a></' . esc_attr($title_selector) . '>';
				} else {
					$output .= '<' .esc_attr($title_selector ). ' class="wppb-addon-title">' . wp_kses_post($title) .'</' . esc_attr($title_selector) . '>';
				}
				$output .= '</div>';
			$output .= '</div>';
		return $output;
	}

	// headline Template
	public function getTemplate(){
		$output = '
		<# var title_selector = data.title_selector ? data.title_selector : "h2" #>
			<div class="wppb-headline-addon">
				<div class="wppb-headline-content">
					<# if( !__.isEmpty(data.title_link) && data.title_link.link ) { #>
						<{{ title_selector }} class="wppb-addon-title"><a {{ data.title_link.link ? "href="+data.title_link.link : "" }} {{ data.title_link.window ? "target=_blank" : "" }} {{ data.title_link.nofolow ? "rel=nofolow" : "" }} >{{{ data.title }}}</a></{{ title_selector }}>
					<# } else { #>
						<{{ title_selector }} class="wppb-addon-title">{{{ data.title }}}</{{ title_selector }}>
					<# } #>
				</div>
			</div>
		';
		return $output;
	}

}
