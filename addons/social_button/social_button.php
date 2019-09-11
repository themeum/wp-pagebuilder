<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Social_Button{

	public function get_name(){
		return 'wppb_social_button';
	}
	public function get_title(){
		return 'Social Button';
	}
	public function get_icon() {
		return 'wppb-font-social-button';
	}

	// social button Settings Fields
	public function get_settings() {

		$settings = array(

			'social_item' => array(
				'title' => 'Button List',
				'type' => 'repeatable',
				'label' => 'icon_list',

				'std' => array(
					array( 
						'icon_list'  => 'fab fa-facebook-f',
						'socialurl'  => array( 'link'=>'www.facebook.com','window'=>false,'nofolow'=>false ),
						'socialtext' => 'facebook',
						'style'      => 'primary',
					),
					array(
						'icon_list' => 'fab fa-twitter',
						'socialurl'  => array( 'link'=>'www.twitter.com','window'=>false,'nofolow'=>false ),
						'socialtext' => 'twitter',
						'style' => 'info',
					),
					array(
						'icon_list' => 'fab fa-youtube',
						'socialurl'  => array( 'link'=>'www.youtube.com/user/themeumwp','window'=>false,'nofolow'=>false ),
						'socialtext' => 'youtube',
						'style' => 'danger',
					)
				),
				
				'attr' => array(
					'icon_list' => array(
						'type' => 'iconsocial',
						'title' => 'Title',
						'std' => 'fab fa-facebook-f',
					),
					'socialurl' => array(
						'type' => 'link',
						'title' => __('Social URL','wp-pagebuilder'),
						'std' => array( 'link'=>'#','window'=>false,'nofolow'=>false),
					),
					'socialtext' => array(
						'type' => 'text',
						'title' => __('Social text','wp-pagebuilder'),
					),
					'style' => array(
						'type' => 'select',
						'title' => __('Style','wp-pagebuilder'),
						'values' => array(
							'primary' => __('Primary','wp-pagebuilder'),
							'success' => __('Success','wp-pagebuilder'),
							'info' => __('Info','wp-pagebuilder'),
							'warning' => __('Warning','wp-pagebuilder'),
							'danger' => __('Danger','wp-pagebuilder'),
							'light' => __('Light','wp-pagebuilder'),
							'dark' => __('Dark','wp-pagebuilder'),
							'link' => __('Link','wp-pagebuilder'),
							'custom' => __('Custom','wp-pagebuilder'),
						),
						'std' => 'primary',
					),
					'button_color' => array(
						'type' => 'color',
						'title' => __('Button color','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom','gradient'))),
						'selector' => '{{SELECTOR}} .wppb-social-btn { color: {{data.button_color}}; }'
					),
					'button_hcolor' => array(
						'type' => 'color',
						'title' => __('Button hover color','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom','gradient'))),
						'selector' => '{{SELECTOR}} .wppb-social-btn:hover { color: {{data.button_hcolor}}; }'
					),

					'button_bg' => array(
						'type' => 'color2',
						'std' => array(
							'colorType' => 'color',
							'clip' => false,
						),
						'title' => __('Button Background','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-social-btn'
					),
					'button_hover_bg' => array(
						'type' => 'color2',
						'std' => array(
							'colorType' => 'color',
							'clip' => false,
						),
						'title' => __('Button hover background','wp-pagebuilder'),
						'depends' => array(array('style', '=', array('custom'))),
						'selector' => '{{SELECTOR}} .wppb-social-btn:hover'
					),
					'social_border' => array(
						'type' => 'border',
						'title' => 'Border',
						'std' => array(
							'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
							'borderStyle' => 'solid', 
							'borderColor' => '#cccccc' 
						),
						'selector' => '{{SELECTOR}} .wppb-social-btn'
					),
					'social_hcolor' => array(
						'type' => 'border',
						'title' => 'Hover Border',
						'std' => array(
							'borderWidth' => array( 'top' => '2px', 'right' => '2px', 'bottom' => '2px', 'left' => '2px' ), 
							'borderStyle' => 'solid', 
							'borderColor' => '#cccccc' 
						),
						'selector' => '{{SELECTOR}} .wppb-social-btn:hover'
					),
				),
			),

			'shape' => array(
				'type' => 'select',
				'title' => __('Social Shape','wp-pagebuilder'),
				'values' => array(
					'rounded' => __('Rounded','wp-pagebuilder'),
					'square' => __('Square','wp-pagebuilder'),
					'round' => __('Round','wp-pagebuilder'),
					'custom' => __('Custom','wp-pagebuilder'),
				),
				'std' => 'rounded',
			),

			'social_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'depends' => array(array('shape', '=', array('custom'))),
				'selector' => '{{SELECTOR}} .wppb-social-button li a { border-radius: {{data.social_radius}}; }'
			),
			'hover_social_radius' => array(
				'type' => 'dimension',
				'title' => __('Hover border radius','wp-pagebuilder'),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'depends' => array(array('shape', '=', array('custom'))),
				'selector' => '{{SELECTOR}} .wppb-social-button li a:hover { border-radius: {{data.hover_social_radius}}; }'
			),

			'btn_size' => array(
				'type' => 'select',
				'title' => __('Button Size','wp-pagebuilder'),
				'values' => array(
					'standard' => __('Standard','wp-pagebuilder'),
					'large' => __('Large','wp-pagebuilder'),
					'xlarge' => __('Extra Large','wp-pagebuilder'),
					'small' => __('Small','wp-pagebuilder'),
					'xsmall' => __('Extra Small','wp-pagebuilder'),
					'custom' => __('Custom','wp-pagebuilder'),
				),
				'std' => 'large',
			),
			'social_padding' => array(
				'type' => 'dimension',
				'title' => 'Social Padding',
				'unit' => array( 'px','em','%' ),
				'depends' => array(array('btn_size', '=', array('custom'))),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-social-button li a { padding: {{data.social_padding}}; }',
			),

			'social_align' => array(
				'type' => 'alignment',
				'title' => __('Social alignment','wp-pagebuilder'),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-social-addon-content { text-align: {{data.social_align}}; }'
			),

			//style
			'social_icon_font' => array(
				'type' => 'slider',
				'title' => __('Icon Size','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 10,
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
					'md' => '14px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-social-button li a i { font-size: {{data.social_icon_font}}; }'
			),
			'social_icon_line' => array(
				'type' => 'slider',
				'title' => __('Line height','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 10,
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
					'md' => '20px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-social-button li a i { line-height: {{data.social_icon_line}}; }'
			),

			'social_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Title Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-social-button li a span',
				'tab' => 'style',
			),

			'social_margin' => array(
				'type' => 'slider',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 15,
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
					'md' => '5px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => array(
					'{{SELECTOR}} .wppb-social-button { margin-left: -{{data.social_margin}}; }',
					'{{SELECTOR}} .wppb-social-button { margin-right: -{{data.social_margin}}; }',
					'{{SELECTOR}} .wppb-social-button .wppb-social-button-list { padding-right: {{data.social_margin}}; }',
					'{{SELECTOR}} .wppb-social-button .wppb-social-button-list { padding-left: {{data.social_margin}}; }',
				)
			),
		);

		return $settings;
	}

	//Share Render HTML
	public function render($data = null){
		$settings 		= $data['settings'];

		$social_item    = isset($settings['social_item']) ? $settings['social_item'] : array();
		$shape 			= isset($settings['shape']) ? $settings['shape'] : '';
		$btn_size       = isset($settings['btn_size']) ? $settings['btn_size'] : '';

		$output  = $socialdesign = '' ;
		$socialdesign .= (isset($shape) && $shape) ? ' wppb-social-'.$shape : '';
		$socialdesign .= (isset($btn_size) && $btn_size) ? ' wppb-social-'.$btn_size : '';

		$output  .= '<div class="wppb-social-addon">';
			$output  .= '<div class="wppb-social-addon-content">';
				$output  .= '<ul class="wppb-social-button '.esc_attr($socialdesign).'">';
				if (is_array($social_item) && count($social_item)){
					foreach ( $social_item as $key => $value ) {
						$classlist = '';
						if( isset($value['socialurl']['link'])) {
							$classlist .= ($value['style'] && $value['style']) ? ' wppb-social-' . $value['style'] : '';
							$output  .= '<li class="wppb-social-button-list repeater-'.$key.'">';
							$target = $value['socialurl']['window'] ? 'target=_blank' : 'target=_self';
							$nofolow = $value['socialurl']['nofolow'] ? 'rel=nofolow' : "";
							$output  .= '<a '.esc_attr($nofolow).' href="'.esc_url($value['socialurl']['link']).'" '.esc_attr($target).' class="wppb-social-btn '.esc_attr($classlist).'"><i class="'.esc_attr($value['icon_list']).'"></i><span>'.esc_attr($value['socialtext']).'</span>';
							$output  .= '</a></li>';
						}
					}
				}

				$output  .= '</ul>';
			$output  .= '</div>';
		$output  .= '</div>';//wppb-social-addon

		return $output;
	}

	// Share Template
	public function getTemplate(){
		$output = '
		<#
		var socailDesign = "";
		socailDesign += " wppb-social-"+data.shape;
		socailDesign += " wppb-social-"+data.btn_size;
		#>
		<div class="wppb-social-addon">
			<div class="wppb-social-addon-content">
				<ul class="wppb-social-button wppb-social-{{socailDesign}}">
					<#  _.forEach(data.social_item, function(value, key) { 
						var classList = "";
						classList += " wppb-social-"+value.style;
						#>
						<li class="wppb-social-button-list repeater-{{key}}">
						<a {{ value.socialurl.link ? "href="+value.socialurl.link : "" }} {{ value.socialurl.window ? "target=_blank" : "" }} {{ value.socialurl.nofolow ? "rel=nofolow" : "" }} class="wppb-social-btn {{classList}}">
							<i class="{{ value.icon_list }}"></i><span>{{ value.socialtext }}</span>
						</a></li>
					<# }); #>
				</ul>
			</div>
		</div>
		';
		return $output;
	}

}