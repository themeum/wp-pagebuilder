<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Text_Block{

	public function get_name(){
		return 'wppb_text_block';
	}
	public function get_title(){
		return 'Text Block';
	}
	public function get_icon() {
		return 'wppb-font-text';
	}

	// text block Settings Fields
	public function get_settings() {

		$settings = array(

			'text' => array(
				'type' => 'editor',
				'title' => __('Content','wp-pagebuilder'),
				'std' => 'Integer adipiscing erat eget risus sollicitudin pellentesque et non erat. Maecenas nibh dolor, malesuada et bibendum a, sagittis accumsan ipsum. Pellentesque ultrices ultrices sapien, nec tincidunt nunc posuere ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam scelerisque tristique dolor vitae tincidunt. Aenean quis massa uada mi elementum elementum. Nec sapien convallis vulputate rhoncus vel dui.'
			),
			'drop_cap' => array(
				'type' => 'switch',
				'title' => __('Drop cap','wp-pagebuilder'),
				'std' => 0
			),
			'align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-text-block-addon { text-align: {{data.align}}; }'
			),

			//style
			'color' => array(
				'type' => 'color',
				'title' => __('Content color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-text-block-content { color: {{data.color}}; }'
			),
			'text_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-text-block-content',
				'tab' => 'style',
			),
			'drop_color' => array(
				'type' => 'color',
				'title' => __('Drop color','wp-pagebuilder'),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-text-block-drop:first-letter { color: {{data.drop_color}}; }',
				'depends' => array( array( 'drop_cap', '=', '1' ) ),
			),
			'drop_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Drop Cap Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'50px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-text-block-drop:first-letter',
				'tab' => 'style',
				'depends' => array( array( 'drop_cap', '=', '1' ) ),
			),
			'drop_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-text-block-drop:first-letter { padding: {{data.drop_padding}}; }',
				'depends' => array( array( 'drop_cap', '=', '1' ) ),
			),
		);
		return $settings;
	}

	// text block Render HTML
	public function render($data = null){
		$settings 		= $data['settings'];
		$text 			= isset($settings['text']) ? $settings['text'] : '';
		$drop_cap 		= isset($settings['drop_cap']) ? $settings['drop_cap'] : '';

		$output = '';
		$drop_cap = (isset($drop_cap) && $drop_cap) ? $drop_cap : 0;
		if($drop_cap){
			$drop_cap = 'wppb-text-block-drop';
		}
		$output  .= '<div class="wppb-text-block-addon">';
		if($text){
			$output .= '<div class="wppb-text-block-content '.esc_attr($drop_cap).'">'. $text.'</div>';
		}
		$output .= '</div>';

		return $output;
	}

	// text block Template
	public function getTemplate(){
		$output = '
		<#
			var drop_cap = "";
			if(data.drop_cap){
				drop_cap = "wppb-text-block-drop";
			}
		#>
		<# if(data.text){ #>
			<div class="wppb-text-block-addon">
				<# if(data.text) { #>
				<div class="wppb-text-block-content {{drop_cap}}"><# print(data.text) #></div>
				<# } #>
			</div>
		<# } #> ';
		return $output;
	}

}