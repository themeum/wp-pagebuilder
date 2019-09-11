<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Tab{

	public function get_name(){
		return 'wppb_tab';
	}
	public function get_title(){
		return 'Tab';
	}
	public function get_icon() {
		return 'wppb-font-tabs';
	}

	// Tab Settings Fields
	public function get_settings() {
		$settings = array(
			'tabtype' => array(
				'type' => 'radioimage',
				'title' => 'Type',
				'values'=> array(
					'horizontal' =>  WPPB_DIR_URL.'addons/tab/img/tab-img1.png',
					'vertical' =>  WPPB_DIR_URL.'addons/tab/img/tab-img2.png',
				),
				'std' => 'horizontal',
			),
			'horizontal_align' => array(
				'type' => 'select',
				'title' => __('Horizontal Alignment','wp-pagebuilder'),
				'depends' => array(array('tabtype', '=', 'horizontal')),
				'values' => array(
					'horizontalleft' => __('Left','wp-pagebuilder'),
					'horizontalcenter' => __('Center','wp-pagebuilder'),
					'horizontalright' => __('Right','wp-pagebuilder'),
				),
				'std' => 'horizontalleft',
			),
			'vertical_position' => array(
				'type' => 'select',
				'title' => __('Navbar Position','wp-pagebuilder'),
				'depends' => array(array('tabtype', '=', 'vertical')),
				'values' => array(
					'verticalleft' => __('Left','wp-pagebuilder'),
					'verticalright' => __('Right','wp-pagebuilder'),
				),
				'std' => 'verticalleft',
			),
			'navbar_width' => array(
				'type' => 'slider',
				'title' => __('Nav Bar width','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
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
				'selector' => '{{SELECTOR}} .vertical-tab ul.wppb-tab-nav, {{SELECTOR}} .horizontal-tab .wppb-tab-nav-list { width: {{data.navbar_width}}; }'
			),

			'tab_list' => array(
				'title' => __('Add Tab Item','wp-pagebuilder'),
				'type' => 'repeatable',
				'label' => 'title',
				'std' => array(
					array(
						'title' => 'Page Builder',
						'icon_list' => 'far fa-star',
						'icon_position' => 'left',
						'content' => 'Reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
					),
					array(
						'title' => 'Drag and Drop',
						'icon_list' => 'fas fa-arrows-alt',
						'icon_position' => 'right',
						'content' => 'Anim pariatur cliche reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
					),
					array(
						'title' => 'WordPress Theme',
						'icon_position' => 'right',
						'content' => 'Cliche reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor',
					),
				),
				'attr' => array(
					'title' => array(
						'type' => 'text',
						'title' => __('Title','wp-pagebuilder'),
						'std' => 'WP page builder'
					),
					'subtitle' => array(
						'type' => 'text',
						'title' => __('Sub title','wp-pagebuilder'),
						'std' => 'Plenty of elements'
					),
					'icon_list' => array(
						'type' => 'icon',
						'title' => __('Icon','wp-pagebuilder'),
						'std' => 'fas fa-home'
					),
					'icon_position' => array(
						'type' => 'select',
						'title' => __('Icon position','wp-pagebuilder'),
						'depends' => array(array('icon_list', '!=', '')),
						'values' => array(
							'left' => __('Left','wp-pagebuilder'),
							'right' => __('Right','wp-pagebuilder'),
							'top' => __('Top','wp-pagebuilder'),
							'bottom' => __('Bottom','wp-pagebuilder'),
						),
						'std' => 'left',
					),
					'content' => array(
						'type' => 'editor',
						'title' => __('Content','wp-pagebuilder'),
						'std' => 'Anim pariatur cliche reprehenderit enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor'
					),
				),
			),

			//nav bar wrap
			'nav_bar_wrap_bg' => array(
				'type' => 'color',
				'title' => __('Background Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav bar wrap',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav { background: {{data.nav_bar_wrap_bg}}; }'
			),

			'nav_wrap_radius' => array(
				'type' => 'dimension',
				'title' => 'Border Radius',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar wrap',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav { border-radius: {{data.nav_wrap_radius}}; }'
			),
			'nav_wrap_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar wrap',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav { padding: {{data.nav_wrap_padding}}; }'
			),
			'nav_wrap_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar wrap',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav { margin: {{data.nav_wrap_margin}}; }'
			),

			//nav bar item
			'nav_bar_bg' => array(
				'type' => 'color',
				'title' => __('Background Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav bar item',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap { background: {{data.nav_bar_bg}}; }'
			),
			'nav_hover_bg' => array(
				'type' => 'color',
				'title' => __('Hover background Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav bar item',
				'std'   => '#fafafa',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list:hover .wppb-tab-nav-list-wrap { background: {{data.nav_hover_bg}}; }'
			),
			'nav_active_bg' => array(
				'type' => 'color',
				'title' => __('Active background Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Nav bar item',
				'std'   => '#fff',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list.active .wppb-tab-nav-list-wrap { background: {{data.nav_active_bg}}; }'
			),
			'nav_active_boxshadow' => array(
				'type' => 'boxshadow',
				'title' => 'Active box shadow',
                'std' => array(
                    'shadowValue' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '5px', 'left' => '0px' ),
                    'shadowColor' => 'rgba(0,0,0,.3)'
                ),
				'tab' => 'style',
				'section' => 'Nav bar item',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list.active .wppb-tab-nav-list-wrap,{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list:hover .wppb-tab-nav-list-wrap'
			),
			'nav_radius' => array(
				'type' => 'dimension',
				'title' => 'Border Radius',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar item',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap { border-radius: {{data.nav_radius}}; }'
			),
			'nav_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar item',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap { margin: {{data.nav_margin}}; }'
			),
			'nav_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'std' => array(
					'md' => array( 'top' => '15px', 'right' => '20px', 'bottom' => '15px', 'left' => '20px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar item',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap { padding: {{data.nav_padding}}; }'
			),
			'navbar_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Nav bar item',
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap { text-align: {{data.navbar_align}}; }'
			),

			//border
			'navbar_border' => array(
				'type' => 'border',
				'title' => 'Nav wrapper border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '0', 'right' => '0', 'bottom' => '1px', 'left' => '0' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Border',
				'depends' => array(array('tabtype', '=', 'horizontal')),
				'selector' => '{{SELECTOR}} .wppb-tab-nav', 
			),
			'navbar_list_border' => array(
				'type' => 'border',
				'title' => 'Nav list border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '0px', 'bottom' => '1px', 'left' => '1px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Border',
				'depends' => array(array('tabtype', '=', 'horizontal')),
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap', 
			),
			'navbar_list_border_last' => array(
				'type' => 'border',
				'title' => 'Nav last child Border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Border',
				'depends' => array(array('tabtype', '=', 'horizontal')),
				'selector' => '{{SELECTOR}} ul.wppb-tab-nav .wppb-tab-nav-list:last-child .wppb-tab-nav-list-wrap', 
			),
			'navbar_vertical_wrap_border' => array(
				'type' => 'border',
				'title' => 'Vertical Wrap item Border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Border',
				'depends' => array(array('tabtype', '=', 'vertical')),
				'selector' => '{{SELECTOR}} .vertical-tab ul.wppb-tab-nav', 
			),
			'navbar_vertical_list_border' => array(
				'type' => 'border',
				'title' => 'Vartical list items',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Border',
				'depends' => array(array('tabtype', '=', 'vertical')),
				'selector' => '{{SELECTOR}} .vertical-tab ul.wppb-tab-nav .wppb-tab-nav-list .wppb-tab-nav-list-wrap', 
			),
			'content_border' => array(
				'type' => 'border',
				'title' => 'Content border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Border',
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap'
			),

			//title
			'title_style' => array(
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
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-tab-title-content',
				'section' => 'Title',
			),
			'title_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Title',
				'selector' => '{{SELECTOR}} .wppb-tab-title-content { color: {{data.title_color}}; }'
			),
			'title_active_color' => array(
				'type' => 'color',
				'title' => __('Active Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Title',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list.active .wppb-tab-title-content,{{SELECTOR}} .wppb-tab-nav-list:hover .wppb-tab-title-content{ color: {{data.title_active_color}}; }'
			),
			'title_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Title',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list .wppb-tab-title-content { margin: {{data.title_margin}}; }'
			),

			//subtitle
			'subtitle_style' => array(
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
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-tab-subtitle-content',
				'section' => 'Sub title',
			),
			'subtitle_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Sub title',
				'selector' => '{{SELECTOR}} .wppb-tab-subtitle-content { color: {{data.subtitle_color}}; }'
			),
			'subtitle_active_color' => array(
				'type' => 'color',
				'title' => __('Active color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Sub title',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list.active .wppb-tab-subtitle-content,{{SELECTOR}} .wppb-tab-nav-list:hover .wppb-tab-subtitle-content{ color: {{data.subtitle_active_color}}; }'
			),
			'subtitle_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Sub title',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list .wppb-tab-subtitle-content { margin: {{data.subtitle_margin}}; }'
			),

			//icon
			'icon_size' => array(
				'type' => 'slider',
				'title' => __('Size','wp-pagebuilder'),
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
					'md' => '14px',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i { font-size: {{data.icon_size}}; }'
			),
			'icon_line_height' => array(
				'type' => 'slider',
				'title' => __('Line height','wp-pagebuilder'),
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
						'md' => '14px',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i { line-height: {{data.icon_line_height}}; }'
			),
			'icon_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i { color: {{data.icon_color}}; }'
			),
			'icon_active_color' => array(
				'type' => 'color',
				'title' => __('Active/hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list.active i,{{SELECTOR}} .wppb-tab-nav-list:hover i { color: {{data.icon_active_color}}; }'
			),

			'icon_bg_color' => array(
				'type' => 'color',
				'title' => __('Background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i{ background: {{data.icon_bg_color}}; }'
			),

			'icon_bg_active_color' => array(
				'type' => 'color',
				'title' => __('Active/hover Background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list.active i,{{SELECTOR}} .wppb-tab-nav-list:hover i { background: {{data.icon_bg_active_color}}; }'
			),

			'icon_width' => array(
				'type' => 'slider',
				'title' => __('Width','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
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
				'std' => array(
						'md' => '',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i { width: {{data.icon_width}}; }'
			),
			'icon_height' => array(
				'type' => 'slider',
				'title' => __('Height','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'range' => array(
						'em' => array(
							'min' => 0,
							'max' => 20,
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
				'std' => array(
						'md' => '',
						'sm' => '',
						'xs' => '',
					),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => array(
					'{{SELECTOR}} .wppb-tab-nav-list i { height: {{data.icon_height}}; }',
					'{{SELECTOR}} .wppb-tab-nav-list i { line-height: {{data.icon_height}}; }',
				)
			),

			'icon_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'responsive' => false,
				'tab' => 'style',
				'unit' => array( '%','px','em' ),
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i { border-radius: {{data.icon_radius}}; }'
			),

			'icon_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'std' => array( 'md' => 'center', 'sm' => 'center', 'xs' => 'center' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i { text-align: {{data.icon_align}}; }'
			),
			'icon_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'sm' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'xs' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Icon',
				'selector' => '{{SELECTOR}} .wppb-tab-nav-list i{ margin: {{data.icon_margin}}; }'
			),

			//content
			'content_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Tab Content',
				'std' => '#000',
				'selector' => '{{SELECTOR}} .wppb-tab-content { color: {{data.content_color}}; }'
			),
			'content_bg' => array(
				'type' => 'color',
				'title' => __('Background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Tab Content',
				'std' => '#fff',
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap { background: {{data.content_bg}}; }'
			),
			'content_style' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'tab' => 'style',
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '700',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap',
				'section' => 'Tab Content',
			),

			'content_radius' => array(
				'type' => 'dimension',
				'title' => 'Border Radius',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Tab Content',
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap{ border-radius: {{data.content_radius}}; }'
			),
//			'margin_bottom' => array(
//				'type' => 'slider',
//				'title' => __('Margin','wp-pagebuilder'),
//				'unit' => array( 'px','%','em' ),
//				'range' => array(
//						'em' => array(
//							'min' => 0,
//							'max' => 5,
//							'step' => .1,
//						),
//						'px' => array(
//							'min' => 0,
//							'max' => 20,
//							'step' => 1,
//						),
//						'%' => array(
//							'min' => 0,
//							'max' => 100,
//							'step' => 1,
//						),
//					),
//				'responsive' => true,
//				'tab' => 'style',
//				'section' => 'Tab Content',
//				'selector' => '{{SELECTOR}} .wppb-tab-nav li { margin-bottom: -{{data.margin_bottom}}; }'
//			),
			'content_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'sm' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'xs' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Tab Content',
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap{ margin: {{data.content_margin}}; }'
			),
			'content_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'std' => array(
					'md' => array( 'top' => '15px', 'right' => '15px', 'bottom' => '15px', 'left' => '15px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Tab Content',
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap{ padding: {{data.content_padding}}; }'
			),
			'content_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Tab Content',
				'selector' => '{{SELECTOR}} .wppb-tab-content-wrap { text-align: {{data.content_align}}; }'
			),
		);

		return $settings;
	}

	// Tab Render HTML
	public function render($data = null){
		$settings 			 = $data['settings'];

		$tab_list 			 = isset($settings["tab_list"]) ? $settings["tab_list"] : array();
		$tabtype 			 = isset($settings["tabtype"]) ? $settings["tabtype"] : '';
		$vertical_position 	 = isset($settings["vertical_position"]) ? $settings["vertical_position"] : '';
		$horizontal_align 	 = isset($settings["horizontal_align"]) ? $settings["horizontal_align"] : '';
		$rand = rand(1000,999999);
		$output = $classlist = '';

		$classlist .= (isset($tabtype) && $tabtype) ? $tabtype.'-tab' : 'horizontal-tab';
		if( $horizontal_align ) {
			$classlist .= (isset($horizontal_align) && $horizontal_align) ? ' ' . $horizontal_align : ' horizontalcenter ';
		}
		if( $vertical_position ) {
			$classlist .= (isset($vertical_position) && $vertical_position) ? ' ' . $vertical_position : ' verticalleft ';
		}

		$output  .= '<div class="wppb-tab-addon">';
		$output  .= '<div class="wppb-tab-addon-content '. $classlist.' ">';
		$output  .= '<ul class="wppb-tab-nav">';
		if (is_array($tab_list) && count($tab_list)) {
			foreach ( $tab_list as $key => $value ) {
				$activeClass = ( $key == 0 ) ? "active" : "";
				$output      .= '<li class="wppb-tab-nav-list wppb-nav-' . get_wppb_array_value_by_key( $value, 'icon_position' ) . ' ' . $activeClass . '" data-tab="tab-' . $key . $rand . '">';
				$output      .= '<div class="wppb-tab-nav-list-wrap">';
				$output      .= '<div>';
				if ( get_wppb_array_value_by_key( $value, 'icon_position' ) == "left" || get_wppb_array_value_by_key( $value, 'icon_position' ) == "top" ) {
					if ( ! empty( $value['icon_list'] ) ) {
						$output .= '<i class="' . $value['icon_list'] . '"></i>';
					}
				}
				if ( get_wppb_array_value_by_key( $value, 'title' ) ) {
					$output .= '<span class="wppb-tab-title-content">' . $value['title'] . '</span>';
				}
				if ( get_wppb_array_value_by_key( $value, 'icon_position' ) == "right" ) {
					if ( get_wppb_array_value_by_key( $value, 'icon_list' ) ) {
						$output .= '<i class="' . $value['icon_list'] . '"></i>';
					}
				}
				if ( get_wppb_array_value_by_key( $value, 'subtitle' ) ) {
					$output .= '<span class="wppb-tab-subtitle-content">' . $value['subtitle'] . '</span>';
				}
				if ( get_wppb_array_value_by_key( $value, 'icon_position' ) == "bottom" ) {
					if ( get_wppb_array_value_by_key( $value, 'icon_list' ) ) {
						$output .= '<i class="' . $value['icon_list'] . '"></i>';
					}
				}
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</li>';
			}
		}
		$output  .= '</ul>';

		$output  .= '<div class="wppb-tab-content-wrap">';
		if (is_array($tab_list) && count($tab_list)) {
			foreach ( $tab_list as $key => $value ) {
				$activeContent = ( $key == 0 ) ? "active" : "";
				$output        .= '<div id="tab-' . $key . $rand . '" class="wppb-tab-content ' . $activeContent . '">';
				$output        .= $value['content'];
				$output        .= '</div>';
			}
		}
		$output  .= '</div>';
		$output  .= '</div>';
		$output  .= '</div>';

		return $output;
	}

	// Tab Template
	public function getTemplate(){
		$output = '
			<#
			var rand = Math.floor(Math.random() * 1000);
			var classList = "";
			classList += data.tabtype ? data.tabtype+"-tab" : " horizontal-tab"; 
			if(data.vertical_position){  
				classList += data.vertical_position ? " "+ data.vertical_position : " verticalleft";   
			}
			if(data.horizontal_align){  
				classList += " "+data.horizontal_align ? " "+ data.horizontal_align : " horizontalcenter";
			}

			#>
			<div class="wppb-tab-addon">
				<div class="wppb-tab-addon-content {{classList}}">
					<ul class="wppb-tab-nav">
						<#  _.forEach(data.tab_list, function(value, key) { #>
							<# var activeClass = (key == 0) ? "active" : ""; #>
							<li class="wppb-tab-nav-list wppb-nav-{{value.icon_position}} {{ activeClass }}" data-tab="tab-{{key+rand}}">
								<div class="wppb-tab-nav-list-wrap">
									<div>
										<# if(value.icon_position == "left" && !_.isEmpty(value.icon_list)) { #> <i class="{{ value.icon_list }}"></i><# } #><# if(value.icon_position == "top" && !_.isEmpty(value.icon_list)) { #> <i class="{{ value.icon_list }}"></i><# } #><span class="wppb-tab-title-content">{{value.title}}</span><# if(value.icon_position == "right" && !_.isEmpty(value.icon_list)) { #> <i class="{{ value.icon_list }}"></i><# } #><span class="wppb-tab-subtitle-content">{{value.subtitle}}</span><# if(value.icon_position == "bottom" && !_.isEmpty(value.icon_list)) { #> <i class="{{ value.icon_list }}"></i><# } #>
									</div>
								</div>
							</li>
						<# }); #>
					</ul>
					<div class="wppb-tab-content-wrap">
					<#  _.forEach(data.tab_list, function(value, key) { #>
							<# var activeContent = (key == 0) ? "active" : ""; #>
							<div id="tab-{{key+rand}}" class="wppb-tab-content {{activeContent}}">
								{{{value.content}}}
							</div>
					<# }); #>
					</div>
				</div>
			</div>
		';
		return $output;
	}

}