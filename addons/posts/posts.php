<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPPB_Addon_Posts_Grid{

	protected $settings = array();

	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
		add_action('wp_ajax_wppb_posts_addon_load_more', array($this, 'wppb_posts_addon_load_more'));
		add_action('wp_ajax_nopriv_wppb_posts_addon_load_more', array($this, 'wppb_posts_addon_load_more'));
	}

	public function get_name(){
		return 'wppb_posts_grid';
	}
	public function get_title(){
		return 'Posts Grid';
	}
	public function get_icon() {
		return 'wppb-font-interface';
	}

	public function enqueue_frontend_scripts(){
		wp_enqueue_style( 'wppb-posts-css', WPPB_DIR_URL.'addons/posts/assets/css/posts-addon.css');
		wp_enqueue_script( 'wppb-posts-addon', WPPB_DIR_URL.'addons/posts/assets/js/posts-addon.js', array('jquery'), false, true );
		wp_localize_script('wppb-posts-addon', 'wppb_posts_addon', array( 'ajax_url'  => admin_url('admin-ajax.php') ) );
	}

	// Settings Fields
	public function get_settings() {
		$settings = array(
			'posts_column' => array(
				'type'      => 'slider',
				'title'     => __('Column','wp-pagebuilder'),
				'responsive' => true,
				'std' => array(
					'md' => '3',
					'sm' => '2',
					'xs' => '1',
				),
				'step' => 1,
				'max' => 6,
				'min' => 1,
			),
			'posts_per_page' => array(
				'type'      => 'number',
				'title'     => __('Posts Per Page','wp-pagebuilder'),
				'std'       => '3'
			),
			'posts_image_size' => array(
				'type'      => 'select',
				'title'     => __('Image Size','wp-pagebuilder'),
				'values'    => wppb_getLall_image_sizes_option(),
				'std'       => 'wppb-medium',
			),
			'posts_title_position' => array(
				'type'      => 'select',
				'title'     => __('Title Position','wp-pagebuilder'),
				'values'    => array(
					'above_meta'       => 'Above Meta',
					'below_meta'       => 'Below Meta',
				),
				'std'       => 'above_meta',
			),
			'posts_title' => array(
				'type' => 'switch',
				'title' => __('Title','wp-pagebuilder'),
				'std' => '1'
			),
			'posts_title_tag' => array(
				'type'      => 'select',
				'title'     => __('Title Tag','wp-pagebuilder'),
				'values'    => array(
					'h1'       => 'H1',
					'h2'       => 'H2',
					'h3'       => 'H3',
					'h4'       => 'H4',
					'h5'       => 'H5',
					'h6'       => 'H6',
					'span' 	   => 'span',
					'p' 		=> 'p',
					'div' 		=> 'div',
				),
				'std'       => 'h3',
			),
			'posts_excerpt' => array(
				'type' => 'switch',
				'title' => __('Excerpt','wp-pagebuilder'),
				'std' => '1'
			),
			'posts_excerpt_length' => array(
				'type'      => 'number',
				'title'     => __('Excerpt Length','wp-pagebuilder'),
				'std'       => '30'
			),
			'posts_metadata' => array(
				'type'      => 'select',
				'multiple'  => true,
				'title'     => __('Meta Data','wp-pagebuilder'),
				'values'    => array(
					'author'        => __('Author','wp-pagebuilder'),
					'date'          => __('Date','wp-pagebuilder'),
					'time'          => __('Time','wp-pagebuilder'),
					'comments'      => __('Comments','wp-pagebuilder'),
					'tags'          => __('Tags','wp-pagebuilder'),
					'categories'    => __('Categories','wp-pagebuilder'),
				),
				'std'       => array('author','date','comments'),
			),
			'posts_separator' => array(
				'type'      => 'text',
				'title'     => __('Separator','wp-pagebuilder'),
				'std'       => '/'
			),
			'posts_read_more' => array(
				'type' => 'switch',
				'title' => __('Read More','wp-pagebuilder'),
				'std' => '1'
			),
			'posts_read_more_text' => array(
				'type'      => 'text',
				'title'     => __('Read More Text','wp-pagebuilder'),
				'std'       => 'Read More »'
			),

			//Query Section
			'post_type' => array(
				'type'      => 'select',
				'title'     => __('Post Type','wp-pagebuilder'),
				'values'    => get_post_types(array('public' => true)),
				'std'       => 'post',
				'section' => 'Advanced_Query',
			),
			'posts_categories' => array(
				'type'      => 'select',
				'multiple'  => true,
				'title'     => __('Categories','wp-pagebuilder'),
				'values'    => wppb_get_category_lists(),
				'std'       => array(),
				'section' => 'Advanced_Query',
			),
			'posts_tags' => array(
				'type'      => 'select',
				'multiple'  => true,
				'title'     => __('Tags','wp-pagebuilder'),
				'values'    => wppb_get_tags_lists(),
				'std'       => array(),
				'section' => 'Advanced_Query',
			),
			'post_order_by' => array(
				'type'      => 'select',
				'title'     => __('Order By','wp-pagebuilder'),
				'values'    => array(
					'title' => __('Title','wp-pagebuilder'),
					'date' => __('Date','wp-pagebuilder'),
					'menu_order' => __('Menu Order','wp-pagebuilder'),
					'comments_count' => __('Comment Count','wp-pagebuilder'),
					'random' => __('Random','wp-pagebuilder'),
				),
				'std'       => 'date',
				'section' => 'Advanced_Query',
			),

			'post_order' => array(
				'type'      => 'select',
				'title'     => __('Order','wp-pagebuilder'),
				'values'    => array(
					'desc' => __('DESC','wp-pagebuilder'),
					'asc' => __('ASC','wp-pagebuilder'),
				),
				'std'       => 'desc',
				'section' => 'Advanced_Query',
			),
			'posts_ids' => array(
				'type'      => 'text',
				'title'     => __('IDS','wp-pagebuilder'),
				'std'       => '',
				'section' => 'Advanced_Query',
			),
			'posts_exclude_ids' => array(
				'type'      => 'text',
				'title'     => __('Exclude IDS','wp-pagebuilder'),
				'std'       => '',
				'section' => 'Advanced_Query',
				'desc' => 'Exclude these ids from the query',
			),

			//Pagination
			'posts_enable_pagination' => array(
				'type' => 'switch',
				'title' => __('Pagination','wp-pagebuilder'),
				'std' => '0',
				'section' => 'Pagination',
			),

			'post_pagination_type' => array(
				'type'      => 'select',
				'title'     => __('Pagination Type','wp-pagebuilder'),
				'values'    => array(
					'numbers_next_previous' => __('Numbers With Next/Previous','wp-pagebuilder'),
					'next_previous' => __('Next/Previous','wp-pagebuilder'),
					'numbers' => __('Numbers','wp-pagebuilder'),
					'load_more' => __('Load More Page Ends','wp-pagebuilder'),
				),
				'std'       => 'numbers_next_previous',
				'section' => 'Pagination',
			),

			// Style Area

			//title
			'post_title_color' => array(
				'type' => 'color',
				'title' => __('Title color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post Title',
				'selector' => '{{SELECTOR}} .wppb-post-grid-title a { color: {{data.post_title_color}}; }'
			),
			'post_title_hcolor' => array(
				'type' => 'color',
				'title' => __('Title hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post Title',
				'selector' => '{{SELECTOR}} .wppb-post-grid-title a:hover { color: {{data.post_title_hcolor}}; }'
			),
			'post_title_size' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'16px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-post-grid-title',
				'section' => 'Post Title',
				'tab' => 'style',
			),
			'title_item_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '10px', 'left' => '0px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-post-grid-title { margin: {{data.title_item_margin}}; }',
				'section' => 'Post Title',
			),

			//post meta
			'post_meta_item_color' => array(
				'type' => 'color',
				'title' => __('Meta item color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post Meta Item',
				'selector' => '{{SELECTOR}} .wppb-post-grid-meta,{{SELECTOR}} .wppb-post-grid-meta a { color: {{data.post_meta_item_color}}; }'
			),
			'post_meta_item_hcolor' => array(
				'type' => 'color',
				'title' => __('Meta item hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post Meta Item',
				'selector' => '{{SELECTOR}} .wppb-post-grid-meta a:hover { color: {{data.post_meta_item_hcolor}}; }'
			),
			'post_meta_item' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'12px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-post-grid-meta',
				'section' => 'Post Meta Item',
				'tab' => 'style',
			),
			'post_meta_item_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-post-grid-meta { margin: {{data.post_meta_item_margin}}; }',
				'section' => 'Post Meta Item',
			),

			//separator
			'post_meta_size' => array(
				'type' => 'slider',
				'title' => __('Font Size','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 10,
						'step' => .1,
					),
					'px' => array(
						'min' => 5,
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
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Meta Separator',
				'selector' => '{{SELECTOR}} .wppb-postmeta-sept { font-size: {{data.post_meta_size}}; }'
			),
			'post_meta_height' => array(
				'type' => 'slider',
				'title' => __('Line height','wp-pagebuilder'),
				'std' => array(
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 10,
						'step' => .1,
					),
					'px' => array(
						'min' => 5,
						'max' => 100,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
						'step' => 1,
					),
				),
				'tab' => 'style',
				'section' => 'Meta Separator',
				'selector' => '{{SELECTOR}} .wppb-postmeta-sept { line-height: {{data.post_meta_height}}; }'
			),
			'post_meta_separator' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Meta Separator',
				'selector' => '{{SELECTOR}} .wppb-postmeta-sept { color: {{data.post_meta_separator}}; }'
			),
			'post_meta_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '8px', 'bottom' => '0px', 'left' => '8px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-postmeta-sept { margin: {{data.post_meta_margin}}; }',
				'section' => 'Meta Separator',
			),

			//image
			'post_img_width' => array(
				'type' => 'slider',
				'title' => __('Image width','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 50,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 500,
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
				'section' => 'Post image',
				'selector' => '{{SELECTOR}} .wppb-post-grid-img img { width: {{data.post_img_width}}; }'
			),
			'post_img_height' => array(
				'type' => 'slider',
				'title' => __('Image height','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 50,
						'step' => .1,
					),
					'px' => array(
						'min' => 0,
						'max' => 500,
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
				'section' => 'Post image',
				'selector' => '{{SELECTOR}} .wppb-post-grid-img img { height: {{data.post_img_height}}; }'
			),
			'post_border_radius' => array(
				'type' => 'dimension',
				'title' => __('Border Radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Post image',
				'selector' => '{{SELECTOR}} .wppb-post-grid-img img { border-radius: {{data.post_border_radius}}; }'
			),
			'post_img_margin' => array(
				'type' => 'dimension',
				'title' => __('margin','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post image',
				'unit' => array( 'px','em','%' ),
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '15px', 'left' => '0px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'selector' => '{{SELECTOR}} .wppb-post-grid-img img { margin: {{data.post_img_margin}}; }'
			),

			//Content
			'post_content_color' => array(
				'type' => 'color',
				'title' => __('Content color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post content',
				'selector' => '{{SELECTOR}} .wppb-post-grid-intro { color: {{data.post_content_color}}; }'
			),
			'post_content_size' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'16px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-post-grid-intro',
				'section' => 'Post content',
				'tab' => 'style',
			),
			'post_content_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'std' => array(
					'md' => array( 'top' => '10px', 'right' => '0px', 'bottom' => '15px', 'left' => '0px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'selector' => '{{SELECTOR}} .wppb-post-grid-intro { margin: {{data.post_content_margin}}; }',
				'section' => 'Post content',
			),

			//Button
			'post_button_color' => array(
				'type' => 'color',
				'title' => __('Button color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn { color: {{data.post_button_color}}; }'
			),
			'post_button_hcolor' => array(
				'type' => 'color',
				'title' => __('Button hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn:hover { color: {{data.post_button_hcolor}}; }'
			),
			'post_btton_bg' => array(
				'type' => 'color2',
				'title' => 'Button background',
				'clip' => false,
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn',
				'tab' => 'style',
				'section' => 'Post button',
			),
			'post_btton_hover_bg' => array(
				'type' => 'color2',
				'title' => 'Button hover background',
				'clip' => false,
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn:hover',
				'tab' => 'style',
				'section' => 'Post button',
			),
			'post_button_size' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'12px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn',
				'section' => 'Post button',
				'tab' => 'style',
			),
			'post_button_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn'
			),
			'post_border_hcolor' => array(
				'type' => 'border',
				'title' => 'hover Border',
				'std' => array(
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn:hover'
			),
			'post_buttom_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn { border-radius: {{data.post_buttom_radius}}; }'
			),
			'post_buttom_hradius' => array(
				'type' => 'dimension',
				'title' => __('hover border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn:hover { border-radius: {{data.post_buttom_hradius}}; }'
			),
			'post_button_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn { margin: {{data.post_button_margin}}; }',
				'section' => 'Post button',
			),
			'post_button_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn { padding: {{data.post_button_padding}}; }',
				'section' => 'Post button',
			),
			'post_button_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Post button',
				'selector' => '{{SELECTOR}} .wppb-post-grid-btn-wrap { text-align: {{data.post_button_align}}; }'
			),

			//Load More
			'post_load_more_color' => array(
				'type' => 'color',
				'title' => __('Button color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Load More',
				'std' => '#fff',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn { color: {{data.post_load_more_color}}; }'
			),
			'post_load_more_hcolor' => array(
				'type' => 'color',
				'title' => __('Button hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Load More',
				'std' => '#fff',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn:hover { color: {{data.post_load_more_hcolor}}; }'
			),
			'post_load_more_bg' => array(
				'type' => 'color2',
				'title' => 'Button background',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#3666E4',
					'clip' => false
				),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn',
				'tab' => 'style',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'section' => 'Load More',
			),
			'post_load_more_hover_bg' => array(
				'type' => 'color2',
				'title' => 'Button hover background',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#2a55c5',
					'clip' => false
				),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn:hover',
				'tab' => 'style',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'section' => 'Load More',
			),
			'post_load_more_size' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'12px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn',
				'section' => 'Load More',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'tab' => 'style',
			),
			'post_load_more_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Load More',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn'
			),
			'post_loadmore_border_hcolor' => array(
				'type' => 'border',
				'title' => 'hover Border',
				'std' => array(
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#cccccc' 
				),
				'tab' => 'style',
				'section' => 'Load More',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn:hover'
			),
			'post_load_more_radius' => array(
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
				'section' => 'Load More',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn { border-radius: {{data.post_load_more_radius}}; }'
			),
			'post_load_more_hradius' => array(
				'type' => 'dimension',
				'title' => __('hover border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Load More',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn:hover { border-radius: {{data.post_load_more_hradius}}; }'
			),
			'post_load_more_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn { margin: {{data.post_load_more_margin}}; }',
				'section' => 'Load More',
			),
			'post_load_more_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'std' => array(
					'md' => array( 'top' => '10px', 'right' => '25px', 'bottom' => '10px', 'left' => '25px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-loadmore-btn { padding: {{data.post_load_more_padding}}; }',
				'section' => 'Load More',
			),
			'post_load_more_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Load More',
				'std' => array( 'md' => 'center', 'sm' => '', 'xs' => '' ),
				'depends' => array(array('post_pagination_type', '=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-pagination{ text-align: {{data.post_load_more_align}}; }'
			),

			//Navigation
			'post_nav_color' => array(
				'type' => 'color',
				'title' => __('Navigation color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Navigation',
				'std' => '#000',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link { color: {{data.post_nav_color}}; }'
			),
			'post_nav_hcolor' => array(
				'type' => 'color',
				'title' => __('Navigation hover color','wp-pagebuilder'),
				'tab' => 'style',
				'std' => '#fff',
				'section' => 'Navigation',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link:hover,{{SELECTOR}} .paginate-active { color: {{data.post_nav_hcolor}}; }'
			),
			'post_nav_bg' => array(
				'type' => 'color2',
				'title' => 'Navigation background',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#fff',
					'clip' => false
				),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link',
				'tab' => 'style',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'section' => 'Navigation',
			),
			'post_nav_hover_bg' => array(
				'type' => 'color2',
				'title' => 'Navigation hover background',
				'clip' => false,
				'std' => array(
					'colorType' => 'color',
					'colorColor' => '#3666E4',
					'clip' => false
				),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link:hover, {{SELECTOR}} .paginate-active',
				'tab' => 'style',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'section' => 'Navigation',
			),
			'post_nav_size' => array(
				'type' => 'typography',
				'title' => __('Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'12px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link',
				'section' => 'Navigation',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'tab' => 'style',
			),
			'post_navborder' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#f5f5f5' 
				),
				'tab' => 'style',
				'section' => 'Navigation',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link'
			),
			'post_nav_border_hcolor' => array(
				'type' => 'border',
				'title' => 'hover Border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ), 
					'borderStyle' => 'solid', 
					'borderColor' => '#3666E4' 
				),
				'tab' => 'style',
				'section' => 'Navigation',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link:hover,{{SELECTOR}} .paginate-active'
			),
			'post_nav_radius' => array(
				'type' => 'dimension',
				'title' => __('Border radius','wp-pagebuilder'),
				'unit' => array( '%','px','em' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Navigation',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link { border-radius: {{data.post_nav_radius}}; }'
			),
			'post_nav_margin' => array(
				'type' => 'dimension',
				'title' => 'Margin',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '5px', 'bottom' => '0px', 'left' => '0px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link { margin: {{data.post_nav_margin}}; }',
				'section' => 'Navigation',
			),
			'post_nav_padding' => array(
				'type' => 'dimension',
				'title' => 'Padding',
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'std' => array(
					'md' => array( 'top' => '5px', 'right' => '15px', 'bottom' => '5px', 'left' => '15px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'selector' => '{{SELECTOR}} .wppb-posts-paginate-link { padding: {{data.post_nav_padding}}; }',
				'section' => 'Navigation',
			),
			'post_nav_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Navigation',
				'std' => array( 'md' => 'center', 'sm' => '', 'xs' => '' ),
				'depends' => array(array('post_pagination_type', '!=', array('load_more'))),
				'selector' => '{{SELECTOR}} .wppb-posts-addon-pagination{ text-align: {{data.post_nav_align}}; }'
			),

		);

		return $settings;
	}


	// Posts Render HTML
	public function render($data = null){
		$settings 				= $data['settings'];

		$this->settings = $settings;
		add_filter('excerpt_more', array($this, 'excerpt_more_text'), 30);
		add_filter('excerpt_length', array($this, 'excerpt_length'), 30);

		$posts_layout           = isset($settings['posts_layout']) ? $settings['posts_layout'] : '';
		$posts_column        	= isset($settings['posts_column']) ? $settings['posts_column'] : '3';
		$posts_title_position   = isset($settings['posts_title_position']) ? $settings['posts_title_position'] : 'above_meta';
		$posts_per_page         = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : '-1';
		$posts_image_size       = isset($settings['posts_image_size']) ? $settings['posts_image_size'] : 'wppb-medium';
		$posts_image_position   = isset($settings['posts_image_position']) ? $settings['posts_image_position'] : '';
		$posts_title            = (bool) isset($settings['posts_title']) ? $settings['posts_title'] : false;
		$posts_title_tag        = isset($settings['posts_title_tag']) ? $settings['posts_title_tag'] : 'h3';
		$posts_excerpt          = (bool) isset($settings['posts_excerpt']) ? $settings['posts_excerpt'] : false;
		$posts_excerpt_length   = isset($settings['posts_excerpt_length']) ? $settings['posts_excerpt_length'] : 30;
		$posts_metadata         = isset($settings['posts_metadata']) ? $settings['posts_metadata'] : array();
		$posts_separator        = isset($settings['posts_separator']) ? $settings['posts_separator'] : '/';
		$posts_separator        = '<span class="wppb-postmeta-sept">'.$posts_separator.'</span>';
		$posts_read_more        = (bool) isset($settings['posts_read_more']) ? $settings['posts_read_more'] : false;
		$posts_read_more_text   = isset($settings['posts_read_more_text']) ? $settings['posts_read_more_text'] : __('Read More »', 'wp-pagebuilder');

		//Advance Query
		$post_type              = isset($settings['post_type']) ? $settings['post_type'] : 'post';
		$posts_categories       = isset($settings['posts_categories']) ? $settings['posts_categories'] : array();
		$posts_tags             = isset($settings['posts_tags']) ? $settings['posts_tags'] : array();
		$post_order_by          = isset($settings['post_order_by']) ? $settings['post_order_by'] : 'date';
		$post_order             = isset($settings['post_order']) ? $settings['post_order'] : 'desc';
		$posts_ids              = isset($settings['posts_ids']) ? $settings['posts_ids'] : false;
		$posts_exclude_ids      = isset($settings['posts_exclude_ids']) ? $settings['posts_exclude_ids'] : false;

		//Pagination
		$posts_enable_pagination      = (bool) isset($settings['posts_enable_pagination']) ? $settings['posts_enable_pagination'] : false;
		$post_pagination_type      = isset($settings['post_pagination_type']) ? $settings['post_pagination_type'] : 'numbers_next_previous';

		//Query Arguments
		$args = array(
			'post_type'         => $post_type,
			'post_status'       => 'publish',
			'posts_per_page'    => $posts_per_page,
			'orderby'           => $post_order_by,
			'order'             => $post_order,
		);

		//pagination
		if ($posts_enable_pagination){
			$paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
			$current_page = $paged;
			$args['paged'] = $paged;
			$paged = $paged+1;
		}

		if ($posts_ids){
			$args['post__in'] = explode(',', $posts_ids);
		}
		if ($posts_exclude_ids){
			$args['post__not_in'] = explode(',', $posts_exclude_ids);
		}
		if (is_array($posts_categories) && count($posts_categories)){
			$args['category__in'] = $posts_categories;
		}
		if (is_array($posts_tags) && count($posts_tags)){
			$args['tag__in'] = $posts_tags;
		}

		$the_query = new WP_Query( $args );

		ob_start();
		if ( $the_query->have_posts() ) {
			?>
	
            <div class="wppb-posts-addon">
                <div class="wppb-posts-addon-content">
					<div class="wppb-addons-col">
						<?php 
						if ( ! is_array($posts_metadata)){
							$posts_metadata = explode(',', $posts_metadata);
						}

						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$post_title = get_the_title();
							$post_excerpt = get_the_excerpt();
							$post_permalink = get_the_permalink();

							//MetaData
							$meta_data_print = '';
							if (count($posts_metadata)) {
								$meta_data              = array();
								if (in_array('author', $posts_metadata)){
									$meta_data['author']    = get_the_author();
								}
								if (in_array('date', $posts_metadata)) {
									$meta_data['date'] = get_the_date();
								}
								if (in_array('time', $posts_metadata)) {
									$meta_data['time'] = get_the_time();
								}
								if (in_array('comments', $posts_metadata)) {
									$meta_data['comments'] = get_comments_number() . ' ' . __( 'Comments', 'wp-pagebuilder' );
								}
								if (in_array('tags', $posts_metadata)) {
									if ( get_the_tag_list() ) {
										$meta_data['tags'] = get_the_tag_list( '', ', ' );
									}
								}
								if (in_array('categories', $posts_metadata)) {
									if ( get_the_category_list() ) {
										$meta_data['categories'] = get_the_category_list( ', ' );
									}
								}
								$meta_data_arr   = apply_filters( 'wppn_posts_addon_meta_data', $meta_data );
								$meta_data_print = implode( "{$posts_separator}", $meta_data_arr );
							}
							//Post feature Image
							$img_url = get_the_post_thumbnail_url(get_the_ID(), $posts_image_size);
							?>
							<div class="wppb-addons-col-md<?php echo $posts_column['md'];?> wppb-addons-col-sm<?php echo $posts_column['sm'];?> wppb-addons-col-xs<?php echo $posts_column['xs'];?>">
								
								<?php

								echo '<div class="wppb-post-grid-wrap wppb-post-grid-one">';
								if(has_post_thumbnail()) {
									echo '<div class="wppb-post-grid-img">';
									echo "<a href='{$post_permalink}'><img src='{$img_url}' alt='{$post_title}'/></a>";
									echo '</div>';//wppb-post-grid-img
								}
								echo '<div class="wppb-post-grid-content">';
								if($posts_title_position == 'above_meta') {
									if ($posts_title){
										echo "<$posts_title_tag class='wppb-post-grid-title'><a href='{$post_permalink}'>{$post_title}</a></$posts_title_tag>";
									}
								}
								if (count($posts_metadata)){
									echo "<div class='wppb-post-grid-meta'>{$meta_data_print} </div>";
								}
								if($posts_title_position == 'below_meta') {
									if ($posts_title){
										echo "<$posts_title_tag class='wppb-post-grid-title'><a href='{$post_permalink}'>{$post_title}</a></$posts_title_tag>";
									}
								}
								if ($posts_excerpt){
									echo "<div class='wppb-post-grid-intro'>{$post_excerpt}</div>";
								}
								if ($posts_read_more){
									echo "<div class='wppb-post-grid-btn-wrap'><a class='wppb-post-grid-btn' href='{$post_permalink}'>{$posts_read_more_text}</a></div>";
								}
								echo '</div>';//wppb-post-grid-content
								echo '</div>';//wppb-post-grid-wrap
								?>
							</div> <!--/.wppb-addons-col-->
							<?php
						}
						wp_reset_postdata();
						?>
					</div><!--/.wppb-posts-addon-content-->

					<?php
					if ($posts_enable_pagination) {
						$max_pages = $the_query->max_num_pages;
						$data_paged = ($paged > $max_pages) ? $max_pages : $paged;

						echo "<div class='wppb-posts-addon-pagination'>";

							$big        = 999999999; // need an unlikely integer
							$translated = __( 'Page', 'wp-pagebuilder' ); // Supply translatable string

							$pagination = paginate_links( array(
								'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'             => '?paged=%#%',
								'current'            => max( 1, get_query_var( 'paged' ) ),
								'total'              => $the_query->max_num_pages,
								'before_page_number' => '<span class="screen-reader-text">' . $translated . ' </span>',
								'type' => 'array'
							) );
							$previous_page = $paged - 2;

							if ($post_pagination_type === 'numbers_next_previous'){
								if ($current_page > 1){
									echo "<a href='#' class='wppb-posts-paginate-link' data-paged='{$previous_page}'><i class='fas fa-angle-left'></i></a>";
								}else{
									echo "<span class='wppb-posts-paginate-link wppb-posts-paginate-link-disable'><i class='fas fa-angle-left'></i></span>";
								}

								for ($i = 1; $i <= $max_pages; $i++){
									$active_class = ( $i == $current_page ) ? 'paginate-active' : '';
									echo "<a href='#' class='wppb-posts-paginate-link {$active_class}' data-paged='{$i}'>{$i}</a>";
								}
								if ( $current_page < $max_pages){
									echo "<a href='#' class='wppb-posts-paginate-link' data-paged='{$data_paged}'><i class='fas fa-angle-right'></i></a>";
								}else{
									echo "<span class='wppb-posts-paginate-link wppb-posts-paginate-link-disable'><i class='fas fa-angle-right'></i></span>";
								}
							}
							if ($post_pagination_type === 'numbers') {
								for ($i = 1; $i <= $max_pages; $i++){
									$active_class = ( $i == $current_page ) ? 'paginate-active' : '';
									echo "<a href='#' class='wppb-posts-paginate-link {$active_class}' data-paged='{$i}'>{$i}</a>";
								}
							}
							if ($post_pagination_type === 'next_previous') {
								if ($current_page > 1){
									echo "<a href='#' class='wppb-posts-paginate-link' data-paged='{$previous_page}'><i class='fas fa-angle-left'></i></a>";
								}else{
									echo "<span class='wppb-posts-paginate-link wppb-posts-paginate-link-disable'><i class='fas fa-angle-left'></i></span>";
								}

								if ( $current_page < $max_pages){
									echo "<a href='#' class='wppb-posts-paginate-link' data-paged='{$data_paged}'><i class='fas fa-angle-right'></i></a>";
								}else{
									echo "<span class='wppb-posts-paginate-link wppb-posts-paginate-link-disable'><i class='fas fa-angle-right'></i></span>";
								}
							}
							if ($post_pagination_type === 'load_more'){
								echo '<a href="#" data-paged="'.$paged.'" class="wppb-posts-addon-loadmore-btn">'.__( 'Load More', 'wp-pagebuilder' ).'</a>';
							}
						echo '</div>';//wppb-posts-addon-pagination
						
					}
					?>
            </div><!--/.wppb-posts-addon-->
        </div><!--/.wppb-posts-addon-->
			<?php
		}

		return ob_get_clean();
	}

	public function excerpt_length(){
		return isset($this->settings['posts_excerpt_length']) ? $this->settings['posts_excerpt_length'] : 30;
	}

	public function excerpt_more_text($more){
		return '';
	}

	public function wppb_posts_addon_load_more(){
	    $addon_id   = sanitize_text_field($_POST['addon_id']);
	    $page_id    = sanitize_text_field($_POST['page_id']);
	    $paged      = sanitize_text_field($_POST['paged']);

	    $addon = wppb_get_saved_addon_settings($addon_id, $page_id);

	    echo $this->render($addon);
        die();
    }

}