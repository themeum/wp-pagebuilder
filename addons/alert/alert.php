<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Alert{

	public function get_name(){
		return 'wppb_alert';
	}
	public function get_title(){
		return 'Alert';
	}
	public function get_icon() {
		return 'wppb-font-alert';
	}

	// Settings Fields
	public function get_settings() {

		$settings = array(
			'alert_title' => array(
				'type' => 'text',
				'title' => __('Title','wp-pagebuilder'),
				'std' => 'Alert Addon',
			),
			'alert_description' => array(
				'type' => 'textarea',
				'title' => __('Description','wp-pagebuilder'),
				'std' => 'Duis mollis est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.',
			),
			'alert_close' => array(
				'type' => 'switch',
				'title' => __('Show Close Button','wp-pagebuilder'),
				'std' => '1'
			),
			//style tab
			'alert_style' => array(
				'type' => 'select',
				'title' => __('Alert style','wp-pagebuilder'),
				'values' => array(
					'primary' => __('Primary','wp-pagebuilder'),
					'success' => __('Success','wp-pagebuilder'),
					'info' => __('Info','wp-pagebuilder'),
					'warning' => __('Warning','wp-pagebuilder'),
					'danger' => __('Danger','wp-pagebuilder'),
					'light' => __('Light','wp-pagebuilder'),
					'dark' => __('Dark','wp-pagebuilder'),
					'custom' => __('Custom','wp-pagebuilder'),
				),
				'std' => 'info',
				'tab' => 'style',
			),
			'content_color' => array(
				'type' => 'color',
				'title' => __('Content background color','wp-pagebuilder'),
				'tab' => 'style',
				'depends' => array( array( 'alert_style', '=', 'custom' ) ),
				'selector' => '{{SELECTOR}} .wppb-alert-addon-content{ background: {{data.content_color}}; }'
			),
			'close_color' => array(
				'type' => 'color',
				'title' => __('Close color','wp-pagebuilder'),
				'tab' => 'style',
				'std' => '#e02e2e',
				'selector' => '{{SELECTOR}} .wppb-close-alert { color: {{data.close_color}}; }'
			),
			'close_hcolor' => array(
				'type' => 'color',
				'title' => __('Close hover color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-close-alert:hover { color: {{data.close_hcolor}}; }'
			),

			'title_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Title',
				'depends' => array( array( 'alert_style', '=', 'custom' ) ),
				'selector' => '{{SELECTOR}} .wppb-alert-title { color: {{data.title_color}}; }'
			),
			'title_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'16px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '600',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-alert-title',
				'tab' => 'style',
				'section' => 'Title',
			),

			'desc_color' => array(
				'type' => 'color',
				'title' => __('Description color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Description',
				'depends' => array( array( 'alert_style', '=', 'custom' ) ),
				'selector' => '{{SELECTOR}} .wppb-alert-desc { color: {{data.desc_color}}; }'
			),
			'desc_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'16px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '600',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-alert-desc',
				'tab' => 'style',
				'section' => 'Description',
			),

			'alert_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Spacing',
				'selector' => '{{SELECTOR}} .wppb-alert-addon-content { padding: {{data.alert_padding}}; }'
			),
			'alert_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Spacing',
				'selector' => '{{SELECTOR}} .wppb-alert-addon-content { border-radius: {{data.alert_radius}}; }'
			),
		);

		return $settings;
	}


	// Alert Render HTML
	public function render($data = null){
		$settings 				= $data['settings'];
		$alert_title 			= isset($settings['alert_title']) ? $settings['alert_title'] : '';
		$alert_description 		= isset($settings['alert_description']) ? $settings['alert_description'] : '';
		$alert_close 			= (bool) isset($settings['alert_close']) ? $settings['alert_close'] : false;
		$alert_style 			= isset($settings['alert_style']) ? $settings['alert_style'] : 'info';
		$output = '';

		$output  .= '<div class="wppb-alert-addon">';
			$output  .= '<div class="wppb-alert-addon-content wppb-alert-'.esc_attr($alert_style).'">';
			if ($alert_title) {
				$output .= '<span class="wppb-alert-title">' . esc_attr($alert_title) .'</span>';
			}
			if ($alert_description) {
				$output .= '<span class="wppb-alert-desc">' . esc_attr($alert_description) . '</span>';
			}
			if ($alert_close == 1) {
				$output .= '<button type="button" class="wppb-close-alert" data-dismiss="wppb-alert"><span aria-hidden="true">&times;</span></button>';
			}
			$output .= '</div>';
		$output .= '</div>';
		return $output;
	}

	// alert Template
	public function getTemplate(){
		$output = '
			<div class="wppb-alert-addon">
				<div class="wppb-alert-addon-content wppb-alert-{{ data.alert_style }}">
					<# if(data.alert_title) { #>
					<span class="wppb-alert-title">{{ data.alert_title }}</span>
					<# } #>
					<# if(data.alert_description) { #>
					<span class="wppb-alert-desc">{{ data.alert_description }}</span>
					<# } #>
					<# if(data.alert_close == 1) { #>
						<button type="button" class="wppb-close-alert" data-dismiss="wppb-alert"><span aria-hidden="true">&times;</span></button>
					<# } #>
				</div>
			</div>';
		return $output;
	}

}