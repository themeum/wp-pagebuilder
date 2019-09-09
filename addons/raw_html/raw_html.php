<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Raw_Html{

	public function get_name(){
		return 'wppb_raw_html';
	}
	public function get_title(){
		return 'Raw HTML';
	}
	public function get_icon() {
		return 'wppb-font-html5';
	}

	// image Settings Fields
	public function get_settings() {

		$settings = array(
			'rawhtml' => array(
				'type' => 'textarea',
				'title' => __('Content','wp-pagebuilder'),
				'std' => '<p>Insert raw html here.<br/>Here is an example of hyperlink <a href="http://www.themeum.com">Themeum</a></p>'
			),

			'align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-raw-html-content { text-align: {{data.align}}; }'
			),

			//style
			'color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-raw-html-content { color: {{data.color}}; }'
			),
			'link_color' => array(
				'type' => 'color',
				'title' => __('Link Color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-raw-html-content a { color: {{data.link_color}}; }'
			),
			'link_hcolor' => array(
				'type' => 'color',
				'title' => __('Link Hover Color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-raw-html-content a:hover { color: {{data.link_hcolor}}; }'
			),

			'typo_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-raw-html-content',
				'tab' => 'style',
			)
		);

		return $settings;
	}


	// Raw HTML Render HTML
	public function render($data = null){
		$settings 		= $data['settings'];
		$rawhtml 		= isset($settings['rawhtml']) ? $settings['rawhtml'] : '';
		$output = '';
		$output  .= '<div class="wppb-raw-html-addon">';
			if($rawhtml){
				$output .= '<div class="wppb-raw-html-content">'. $rawhtml .'</div>';
			}
		$output .= '</div>';

		return $output;
	}

	// raw Template
	public function getTemplate(){
		$output = '
		<div class="wppb-raw-html-addon">
			<div class="wppb-raw-html-content">
				{{{ data.rawhtml }}}
			</div>
		</div>
		';
		return $output;
	}

}