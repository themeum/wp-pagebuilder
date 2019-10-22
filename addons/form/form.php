<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function wppb_contact_form( $type ){
	$wppb_cf7s = get_posts( 'post_type="'.$type.'"&numberposts=-1' );
	$wppb_contact_forms = array();
	if ( $wppb_cf7s ) {
		foreach ( $wppb_cf7s as $wppb_cf7 ) {
			$wppb_contact_forms[$wppb_cf7->ID] =  $wppb_cf7->post_title;
		}
	}
	return $wppb_contact_forms;
}

class WPPB_Addon_Form{

	public function __construct() {
		//Register scripts
		add_action('wp_enqueue_scripts', array($this, 'register_required_script'));
		add_action('wppb_enqueue_scripts', array($this, 'register_required_script'));

		//Load scripts at builder
		add_action('wppb_enqueue_scripts', array($this, 'add_scripts'));

		//Process Form
		add_action('wp_ajax_wppb_form_process', array($this, 'wppb_form_process'));
		add_action('wp_ajax_nopriv_wppb_form_process', array($this, 'wppb_form_process'));

		add_action('wp_ajax_wppb_form_addon', array($this, 'wppb_shortcode_form_render'));
	}

	public function get_name(){
		return 'wppb_form';
	}
	public function get_title(){
		return 'Form';
	}
	public function get_icon() {
		return 'wppb-font-envelope';
	}

	public function register_required_script(){
		wp_register_script('wppb-form.main.js', WPPB_DIR_URL.'addons/form/assets/js/main.js', array('jquery'), false, true);
		wp_localize_script('wppb-form.main.js', "wppb_form", array('ajax_url' => admin_url('admin-ajax.php'), 'form_addon_dir_url' => WPPB_DIR_URL.'addons/form/'));


		$pageID = get_the_ID();
		if ($pageID){
			if (wppb_helper()->is_wppb_single() && ! wppb_helper()->is_editor_screen() && ! wppb_helper()->is_load_editor_iframe() ){
				$reCapchaJS = 'https://www.google.com/recaptcha/api.js';

				$savedAddons = wppb_get_saved_addons_by_name('wppb_form', $pageID);
				$isGoogleRecaptchaEnable = false;

				if (is_array($savedAddons) && count($savedAddons)){
					foreach ($savedAddons as $saved_addon){
						$s = $saved_addon['settings'];
						if (isset($s['enable_google_recaptcha'])){
							$isEnable = (bool) $s['enable_google_recaptcha'];
							if ($isEnable){
								$isGoogleRecaptchaEnable = true;
								break;
							}
						}
					}
				}
				if ($isGoogleRecaptchaEnable){
					wp_enqueue_script('wppb-form-google-recaptcha.js', $reCapchaJS, array('jquery'), false, true);
				}
			}
		}
	}

	public function get_enqueue_script(){
		return array( 'wppb-form.main.js', 'wppb-form-google-recaptcha');
	}

	public function get_enqueue_style(){
		return array();
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


	// Contact Form 7 Settings Fields
	public function get_settings() {

		$compatible_plugins = $this->get_compatible_plugins();

		$admin_email = get_option('admin_email');

		$settings = array(
			'form_type' => array(
				'type' => 'select',
				'title' => 'Select Plugin',
				'placeholder'=> 'Select Placeholder',
				'values' => $compatible_plugins,
				'std' => 'wppb_default_form',
				'multiple' => false,
			),
			'cf7_form' => array(
				'type' => 'select',
				'title' => __('Contact form 7','wp-pagebuilder'),
				'values' => wppb_contact_form( 'wpcf7_contact_form' ),
				'depends' => array(array('form_type', '=', array('cf7_form'))),
			),
			'we_form' => array(
				'type' => 'select',
				'title' => __('WeForm','wp-pagebuilder'),
				'values' => wppb_contact_form( 'wpuf_contact_form' ),
				'depends' => array(array('form_type', '=', array('we_form'))),
			),

			'wppb_default_form' => array(
				'title' => __('Form Fields','wp-pagebuilder'),
				'type' => 'repeatable',
				'label' => 'label',
				'std' => array(
					array(
						'label' => 'First Name',
						'field_type' => 'text',
						'placeholder' => 'First Name',
						'field_width' => array(
							'md' => '50%',
							'sm' => '',
							'xs' => '',
						),
					),
					array(
						'label' => 'Last Name',
						'field_type' => 'text',
						'placeholder' => 'Last Name',
						'field_width' => array(
							'md' => '50%',
							'sm' => '',
							'xs' => '',
						),
					),
					array(
						'label' => 'Email',
						'field_type' => 'email',
						'placeholder' => 'Email',
						'require'     => '1',
						'field_width' => array(
							'md' => '50%',
							'sm' => '',
							'xs' => '',
						),
					),
					array(
						'label' => 'Subject',
						'field_type' => 'text',
						'placeholder' => 'Subject',
						'field_width' => array(
							'md' => '50%',
							'sm' => '',
							'xs' => '',
						),
					),
					array(
						'label' => 'Comment',
						'field_type' => 'textarea',
						'placeholder' => 'Add Comment Here',
						'field_width' => array(
							'md' => '100%',
							'sm' => '',
							'xs' => '',
						),
					),
				),
				'attr' => array(
					'label' => array(
						'type' => 'text',
						'title' => __('Label','wp-pagebuilder'),
					),

					'field_id' => array(
						'type' => 'text',
						'title' => __('Field ID','wp-pagebuilder'),
						'desc' => __('Define the unique ID of this field. Use only English characters without special characters and spaces.', 'wp-pagebuilder')
					),

					'placeholder' => array(
						'type' => 'text',
						'title' => __('Placeholder','wp-pagebuilder'),
						'std' => '',
						'depends' => array(array('field_type', '=', array('text', 'email', 'textarea'))),
					),

					'require' => array(
						'type' => 'switch',
						'title' => __('Required Field', 'wp-pagebuilder'),
						'std' => '1',
						'desc' => __('Define whether the field should be required or optional', 'wp-pagebuilder'),
					),

					'field_width' => array(
						'type' 		  => 'slider',
						'title' 	  => 'Field Width',
						'unit' 		  => array( 'px','em','%' ),
						'range' => array(
							'em' => array(
								'min' => 0,
								'max' => 50,
								'step' => .1,
							),
							'px' => array(
								'min' => 1,
								'max' => 400,
								'step' => 1,
							),
							'%' => array(
								'min' => 0,
								'max' => 100,
								'step' => 1,
							),
						),
						'std'		  => array(
							'md' => '50%',
							'sm' => '50%',
						),
						'responsive'  => true,
						'selector' => '{{SELECTOR}} { width: {{data.field_width}}; }',
					),
					'field_type' => array(
						'type' => 'select',
						'title' => 'Field Type',
						'values' => array(
							'text'      => 'Text',
							'email'     => 'E-Mail',
							'radio'     => 'Radio',
							'checkbox'  => 'Checkbox',
							'textarea'  => 'Textarea',
							'select'    => 'Dropdown',
						),
						'std' => 'text',
					),
					'radio_field_options' => array(
						'title'     => __('Add Option', 'wp-pagebuilder'),
						'type'      => 'repeatable',
						'label' => 'label',
						'std'       => array(),
						'attr' => array(
							'label' => array(
								'type' => 'text',
								'title' => __('Radio Name','wp-pagebuilder'),
								'std' => '',
							),
						),
						'depends' => array(array('field_type', '=', 'radio')),
					),
					'checkbox_field_options' => array(
						'title'     => __('Add Option', 'wp-pagebuilder'),
						'type'      => 'repeatable',
						'std'       => array(),
						'label' => 'label',
						'attr' => array(
							'label' => array(
								'type' => 'text',
								'title' => __('Checkbox Name','wp-pagebuilder'),
								'std' => '',
							),
						),
						'depends' => array(array('field_type', '=', 'checkbox')),
					),

					'select_options' => array(
						'title'     => __('Select Option', 'wp-pagebuilder'),
						'type'      => 'repeatable',
						'std'       => array(),
						'label' => 'label',
						'attr' => array(
							'label' => array(
								'type' => 'text',
								'title' => __('Option Name','wp-pagebuilder'),
								'std' => '',
							),
						),
						'depends' => array(array('field_type', '=', 'select')),
					),
				),
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),

			'wppb_default_form_to_email' => array(
				'type' => 'text',
				'title' => __('Recipient E-Mail','wp-pagebuilder'),
				'std' => $admin_email,
				'section' => 'Email',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'wppb_default_form_from_email' => array(
				'type' => 'text',
				'title' => __('From E-Mail','wp-pagebuilder'),
				'std' => $admin_email,
				'section' => 'Email',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'wppb_default_form_subject' => array(
				'type' => 'text',
				'title'     => __('Subject','wp-pagebuilder'),
				'std'       => __('A new query has been placed at {datetime}','wp-pagebuilder'),
				'section'   => 'Email',
				'desc' => __('You can set veraible for date time, available variable, <strong>{date}, {time}, {datetime}</strong>', 'wp-pagebuilder'),
				'depends'   => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'email_format' => array(
				'type' => 'textarea',
				'title' => __('Message Format', 'wp-pagebuilder'),
				'std' => '',
				'section' => 'Email',
				'desc' => __('Custom Message format for this form, should be use like, <strong>My Message is {Message}</strong>', 'wp-pagebuilder'),
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'success_message' => array(
				'type' => 'text',
				'title' => __('Success Message','wp-pagebuilder'),
				'std' => '',
				'section' => 'Email',
				'desc' => __('Type the message you want to display after successful form submission. Leave blank for default', 'wp-pagebuilder'),
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),

			'enable_redirect_url' => array(
				'type' => 'switch',
				'title' => __('Enable Redirect URL', 'wp-pagebuilder'),
				'std' => '0', // value 0 or 1,
				'section' => 'Redirect',
				'desc' => __('Define whether the field should be required or optional', 'wp-pagebuilder'),
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'redirect_url' => array(
				'type' => 'text',
				'title' => __('Redirect URL','wp-pagebuilder'),
				'std' => '',
				'section' => 'Redirect',
				'desc' => __('Your redirect URL will be here', 'wp-pagebuilder'),
				'depends' => array(array('form_type', '=', 'wppb_default_form'), array('enable_redirect_url', '=', '1') ),
			),

			'enable_simple_recaptcha' => array(
				'type' => 'switch',
				'title' => __('Enable Simple ReCAPTCHA', 'wp-pagebuilder'),
				'std' => '0', // value 0 or 1,
				'section' => 'Security',
				'desc' => __('Enable or disable Simple ReCAPTCHA', 'wp-pagebuilder'),
				'depends' => array(array('form_type', '=', array('wppb_default_form')), array('enable_google_recaptcha', '!=', '1')),
			),
			'enable_google_recaptcha' => array(
				'type' => 'switch',
				'title' => __('Enable Google ReCAPTCHA', 'wp-pagebuilder'),
				'std' => '0', // value 0 or 1,
				'section' => 'Security',
				'desc' => __('Enable or disable Google ReCAPTCHA', 'wp-pagebuilder'),
				'depends' => array(array('form_type', '=', array('wppb_default_form')), array('enable_simple_recaptcha', '!=', '1')),
			),
			/*
			'wppb_form_recaptcha_question' => array(
				'type' => 'text',
				'title' => __('Set Question','wp-pagebuilder'),
				'std' => '3+6',
				'desc' => __('Set your question which will answer by form user, such as {addition 3+6 ?} ', 'wp-pagebuilder'),
				'section' => 'Security',
				'depends' => array(array('form_type', '=', array('wppb_default_form')), array('enable_simple_recaptcha', '=', '1')),
			),

			'wppb_form_recaptcha_answer' => array(
				'type' => 'text',
				'title' => __('Set Answer','wp-pagebuilder'),
				'std' => '9',
				'desc' => __('Users answer have to match with this', 'wp-pagebuilder'),
				'section' => 'Security',
				'depends' => array(array('form_type', '=', array('wppb_default_form')), array('enable_simple_recaptcha', '=', '1')),
			),*/

			'google_recaptcha_site_key' => array(
				'type' => 'text',
				'title' => __('Site key','wp-pagebuilder'),
				'std' => '',
				'desc' => __('Use this in the HTML code your site serves to users.', 'wp-pagebuilder'),
				'section' => 'Security',
				'depends' => array(array('form_type', '=', array('wppb_default_form')), array('enable_google_recaptcha', '=', '1')),
			),
			'google_recaptcha_secret_key' => array(
				'type' => 'text',
				'title' => __('Secret key','wp-pagebuilder'),
				'std' => '',
				'desc' => __('Use this for communication between your site and Google. Be sure to keep it a secret.', 'wp-pagebuilder'),
				'section' => 'Security',
				'depends' => array(array('form_type', '=', array('wppb_default_form')), array('enable_google_recaptcha', '=', '1')),
			),

			'button_text' => array(
				'type' => 'text',
				'title' => __('Button text','wp-pagebuilder'),
				'std' => 'Submit Form',
				'section' => 'Button',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'icon_list' => array(
				'type' => 'icon',
				'title' => __('Button icon','wp-pagebuilder'),
				'std' => '',
				'section' => 'Button',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'icon_position' => array(
				'type' => 'select',
				'title' => __('Button icon position','wp-pagebuilder'),
				'depends' => array(array('icon_list', '!=', '')),
				'values' => array(
					'left' => __('Left','wp-pagebuilder'),
					'right' => __('Right','wp-pagebuilder'),
				),
				'std' => 'left',
				'section' => 'Button',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'fullwidth_button' => array(
				'type' => 'select',
				'section' => 'Button',
				'title' => __('Full Width','wp-pagebuilder'),
				'values' => array(
					'full-yes' => __('Yes','wp-pagebuilder'),
					'full-no' => __('No','wp-pagebuilder'),
				),
				'std' => 'no',
			),

			// form style
			'vertical_form_space' => array(
				'type' => 'slider',
				'title' => __('Vertical Spacing','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 15,
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
					'md' => '15px',
					'sm' => '',
					'xs' => ''
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Form Style',
				'selector' => array(
					'{{SELECTOR}} .wppb-form-field-item-wrap { margin-left: -{{data.vertical_form_space}}; }',
					'{{SELECTOR}} .wppb-form-field-item-wrap { margin-right: -{{data.vertical_form_space}}; }',
					'{{SELECTOR}} .wppb-form-field-repeat { padding-left: {{data.vertical_form_space}}; }',
					'{{SELECTOR}} .wppb-form-field-repeat { padding-right: {{data.vertical_form_space}}; }',
				),
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'horizontal_form_space' => array(
				'type' => 'slider',
				'title' => __('Horizontal Spacing','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'range' => array(
					'em' => array(
						'min' => 0,
						'max' => 15,
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
					'md' => '25px',
					'sm' => '',
					'xs' => ''
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Form Style',
				'selector' => array(
					'{{SELECTOR}} .wppb-form-field-repeat { margin-bottom: {{data.horizontal_form_space}}; }',
				),
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),
			'input_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Input Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields select, {{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} select, {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea',
				'depends' => array(array('label_show', '=', '1')),
				'section' => 'Form Style',
				'tab' => 'style',
			),
			'input_color' => array(
				'type' => 'color',
				'title' => __('Input color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Form Style',
				'std' => '#454545',
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields select, {{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} select, {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea { color: {{data.input_color}}; }'
			),
			'input_shadow' => array(
				'type' => 'boxshadow',
				'tab' => 'style',
				'section' => 'Form Style',
				'title' => __('Input Boxshadow','wp-pagebuilder'),
				'std' => array(
						'shadowValue'=> array( 'top' => '0px', 'right' => '0px', 'bottom' => '10px', 'left' => '0px' ), 
						'shadowColor' 	=> '#333' 
					),
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields select, {{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} select, {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea'
			),
			'paceholder_color' => array(
				'type' => 'color',
				'title' => __('Placeholder color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Form Style',
				'std' => '#d5d5d5',
				'selector' => '{{SELECTOR}} .wppb-form-field-input input::-webkit-input-placeholder, {{SELECTOR}} .wppb-form-field-email input[type=email]::-webkit-input-placeholder, {{SELECTOR}} .wppb-form-field-textarea textarea::-webkit-input-placeholder, span.wppb-form-field-item.wppb-form-field-select select { color: {{data.paceholder_color}}; }'
			),
			'input_bg' => array(
				'type' => 'color',
				'title' => __('Input background color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Form Style',
				'std' => '',
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields select, {{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} select, {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea { background: {{data.input_bg}}; }'
			),
			'radio_bg' => array(
				'type' => 'color',
				'title' => __('Radio/Checkbok active bg color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Form Style',
				'std' => '#00a7ff',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
				'selector' => '{{SELECTOR}} .wppb-form-field-radio input[type="radio"]:checked + label:before, {{SELECTOR}} .wppb-form-field-checkbox input[type="checkbox"]:checked + label:before  { background: {{data.radio_bg}}; }'
			),
			'input_border' => array(
				'type' => 'border',
				'title' => 'Input Border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#e5e5e5'
				),
				'tab' => 'style',
				'section' => 'Form Style',
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} select, {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea'
			),
			'input_focus_color' => array(
				'type' => 'border',
				'title' => __('Input focus boder color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Form Style',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '1px', 'right' => '1px', 'bottom' => '1px', 'left' => '1px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#3666E4'
				),
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields select:focus, {{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea:focus, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url]:focus, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email]:focus, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text]:focus, {{SELECTOR}} select:focus, {{SELECTOR}} input[type=text]:focus, {{SELECTOR}} input[type=email]:focus, {{SELECTOR}} textarea:focus, {{SELECTOR}} .wppb-form-field-input input:focus, {{SELECTOR}} .wppb-form-field-email input:focus, {{SELECTOR}} .wppb-form-field-textarea textarea:focus'
			),
			'input_radius' => array(
				'type' => 'dimension',
				'title' => __('Input border radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '3px', 'right' => '3px', 'bottom' => '3px', 'left' => '3px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Form Style',
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea, span.wppb-form-field-item.wppb-form-field-select select { border-radius: {{data.input_radius}}; }'
			),
			'input_padding' => array(
				'type' => 'dimension',
				'title' => 'Input padding',
				'std' => array(
					'md' => array( 'top' => '10px', 'right' => '15px', 'bottom' => '10px', 'left' => '15px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'section' => 'Form Style',
				'tab' => 'style',
				'selector' => '{{SELECTOR}} ul.wpuf-form li .wpuf-fields textarea, {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=url], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=email], {{SELECTOR}} ul.wpuf-form li .wpuf-fields input[type=text], {{SELECTOR}} input[type=text], {{SELECTOR}} input[type=email], {{SELECTOR}} textarea, {{SELECTOR}} .wppb-form-field-input input, {{SELECTOR}} .wppb-form-field-email input, {{SELECTOR}} .wppb-form-field-textarea textarea, span.wppb-form-field-item.wppb-form-field-select select { padding: {{data.input_padding}}; }'
			),
			'textarea_resize' => array(
				'type' => 'switch',
				'title' => __('Textarea resize','wp-pagebuilder'),
				'std' => '0',
				'tab' => 'style',
				'section' => 'Form Style',
			),

			//label style
			'label_show' => array(
				'type' => 'switch',
				'title' => __('Label button','wp-pagebuilder'),
				'std' => '1',
				'tab' => 'style',
				'section' => 'Label',
			),
			'label_fontstyle' => array(
				'type' => 'typography',
				'title' => __('Label Typography','wp-pagebuilder'),
				'std' => array(
					'fontFamily' => '',
					'fontSize' => array( 'md'=>'14px', 'sm'=>'', 'xs'=>'' ),
					'lineHeight' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
					'fontWeight' => '400',
					'textTransform' => '',
					'fontStyle' => '',
					'letterSpacing' => array( 'md'=>'', 'sm'=>'', 'xs'=>'' ),
				),
				'selector' => '{{SELECTOR}} .wppb-form-field-label, {{SELECTOR}} .wppb-global-form-content label, {{SELECTOR}} label',
				'depends' => array(array('label_show', '=', '1')),
				'section' => 'Label',
				'tab' => 'style',
			),
			'label_color' => array(
				'type' => 'color',
				'title' => __('label Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Label',
				'std'     => '#353535',
				'depends' => array(array('label_show', '=', '1')),
				'selector' => '{{SELECTOR}} .wppb-form-field-label, {{SELECTOR}} .wppb-global-form-content label, {{SELECTOR}} label { color: {{data.label_color}}; min-height: 24px; min-width: 20px; }'
			),

			'label_margin' => array(
				'type' => 'dimension',
				'title' => 'Label margin',
				'std' => array(
					'md' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '10px', 'left' => '0px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Label',
				'depends' => array(array('label_show', '=', '1')),
				'selector' => '{{SELECTOR}} .wppb-form-field-label, {{SELECTOR}} .wppb-global-form-content label, {{SELECTOR}} label { margin: {{data.label_margin}}; }'
			),

			//button style
			'button_fontstyle' => array(
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
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]',
				'section' => 'Button',
				'tab' => 'style',
			),
			'button_color' => array(
				'type' => 'color',
				'title' => __('Color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'std'     => '#ffffff',
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit] { color: {{data.button_color}}; }'
			),
			'button_hcolor' => array(
				'type' => 'color',
				'title' => __('Hover color','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'std'     => '#ffffff',
				'selector' => '{{SELECTOR}} .wppb-btn-forms:hover, {{SELECTOR}} .wpcf7-submit:hover, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]:hover { color: {{data.button_hcolor}}; }'
			),
			'button_bg' => array(
				'type' => 'color2',
				'title' => __('Background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'clip' => false,
				'std' => array(
					'clip' => false,
					'colorType' => 'color',
					'colorColor' => '#23cf5f',
				),
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]'
			),

			'button_hover_bg' => array(
				'type' => 'color2',
				'title' => __('Hover background','wp-pagebuilder'),
				'tab' => 'style',
				'section' => 'Button',
				'clip' => false,
				'std' => array(
					'clip' => false,
					'colorType' => 'color',
					'colorColor' => '#1fae51',
				),
				'selector' => '{{SELECTOR}} .wppb-btn-forms:before, {{SELECTOR}} .wpcf7-submit:hover, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]:hover'
			),
			'button_border' => array(
				'type' => 'border',
				'title' => 'Border',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#cccccc'
				),
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]'
			),
			'button_border_hcolor' => array(
				'type' => 'border',
				'title' => 'Border hover',
				'std' => array(
					'itemOpenBorder' => 1,
					'borderWidth' => array( 'top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px' ),
					'borderStyle' => 'solid',
					'borderColor' => '#cccccc'
				),
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-btn-forms:hover, {{SELECTOR}} .wpcf7-submit:hover, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]:hover'
			),
			'button_radius' => array(
				'type' => 'dimension',
				'title' => __('Button radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit] { border-radius: {{data.button_radius}}; }'
      ),
      'button_hover_radius' => array(
				'type' => 'dimension',
				'title' => __('Button hover radius','wp-pagebuilder'),
				'unit' => array( 'px','%','em' ),
				'std' => array(
					'md' => array( 'top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ), 
				),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-btn-forms:hover, {{SELECTOR}} .wpcf7-submit:hover, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit]:hover { border-radius: {{data.button_hover_radius}}; }'
			),
			'button_padding' => array(
				'type' => 'dimension',
				'title' => 'Button padding',
				'std' => array(
					'md' => array( 'top' => '10px', 'right' => '20px', 'bottom' => '10px', 'left' => '20px' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'section' => 'Button',
				'tab' => 'style',
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit] { padding: {{data.button_padding}}; }'
			),
			'button_margin' => array(
				'type' => 'dimension',
				'title' => 'Button margin',
				'std' => array(
					'md' => array( 'top' => '15px', 'right' => '0px', 'bottom' => '0', 'left' => '0' ),
					'sm' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
					'xs' => array( 'top' => '', 'right' => '', 'bottom' => '', 'left' => '' ),
				),
				'unit' => array( 'px','em','%' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-btn-forms, {{SELECTOR}} .wpcf7-submit, {{SELECTOR}} .wpuf-form-add.wpuf-style ul.wpuf-form .wpuf-submit input[type=submit] { margin: {{data.button_margin}}; }'
			),
			'button_align' => array(
				'type' => 'alignment',
				'title' => __('Alignment','wp-pagebuilder'),
				'std' => array( 'md' => 'left', 'sm' => '', 'xs' => '' ),
				'responsive' => true,
				'tab' => 'style',
				'section' => 'Button',
				'selector' => '{{SELECTOR}} .wppb-form-btn-wrap { text-align: {{data.button_align}}; }',
				'depends' => array(array('form_type', '=', array('wppb_default_form'))),
			),

		);
		return $settings;
	}

	/**
	 * Get the compatible Plugins
	 */
	public function get_compatible_plugins(){
		if ( ! function_exists('is_plugin_active')){
			include ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins = array();
		$plugins['wppb_default_form'] = 'Default Form';

		//Contact Form 7
		$isContactForm7 = is_plugin_active('contact-form-7/wp-contact-form-7.php');
		$isWeForm = is_plugin_active('weforms/weforms.php');
		$isNinjaForm = is_plugin_active('ninja-forms/ninja-forms.php');
		if ($isContactForm7){
			$plugins['cf7_form'] = 'Contact Form 7';
		}else{
			$plugins['cf7_form_not_installed'] = 'Contact Form 7 (not installed)';
		}

		//We form
		if ($isWeForm){
			$plugins['we_form'] = 'weForms';
		}else{
			$plugins['we_form_not_installed'] = 'weForms (not installed)';
		}
		return $plugins;
	}


	public function generateDefaultForm($data = array()){
		$settings 				= $data['settings'];
		$classlist				= '';
		$form_type 				= isset($settings["form_type"]) ? $settings["form_type"] : '';
		$button_text 			= isset($settings["button_text"]) ? $settings["button_text"] : 'Submit Form';
		$icon_list 				= isset($settings["icon_list"]) ? $settings["icon_list"] : '';
		$icon_position 			= isset($settings["icon_position"]) ? $settings["icon_position"] : '';
		$textarea_resize 		= isset($settings["textarea_resize"]) ? $settings["textarea_resize"] : '';
		$fullwidth_button 		= isset($settings["fullwidth_button"]) ? $settings["fullwidth_button"] : '';
		
		$classlist .= (isset($fullwidth_button) && $fullwidth_button) ? ' wppb-btn-' . $fullwidth_button : '';

		if ( $form_type !== 'wppb_default_form'){
			return '';
		}

		$enableSimpleRecaptcha = (bool) isset($settings['enable_simple_recaptcha']) ? $settings['enable_simple_recaptcha'] : false;
		$enableGoogleRecaptcha = (bool) isset($settings['enable_google_recaptcha']) ? $settings['enable_google_recaptcha'] : false;

		$input_items = isset($settings['wppb_default_form']) ? $settings['wppb_default_form'] : array();

		$form_data = array();
		$form_data['addon_id'] = $data['id'];
		$form_data['page_id'] = get_the_ID();

		$htmlForm = '';
		ob_start();
		if (is_array($input_items) && count($input_items)){
			?>
            <form method="post" enctype="multipart/form-data" class="wppb-form-addon">
				<?php wp_nonce_field( 'wppb_form_submit_action', 'wppb_form_nonce_field' ); ?>
                <input type="hidden" name="wppb_form_data" value="<?php echo esc_attr(json_encode($form_data)); ?>">
                <div class="wppb-form-msg"></div>
                <div class="wppb-form-field-item-wrap">
					<?php
					foreach ($input_items as  $fieldIndex => $field){
						$fieldAttr = ' ';
						$fieldAttrA = array();
						if ( ! empty($field['placeholder'])){
							$fieldAttrA['placeholder'] = $field['placeholder'];
						}
						if ( isset($field['require']) && (int) $field['require'] === 1) {
							$fieldAttrA['data-required'] = 'true';
							$fieldAttrA['data-label'] = ( isset($field['label']) ? $field['label'] : '' );
						}
						foreach ($fieldAttrA as $attrKey => $attr){
							$fieldAttr .= $attrKey.'="'.$attr.'" ';
						}
						?>
                        <div class="wppb-form-field-repeat repeater-<?php echo $fieldIndex;?>">
                            <div class="wppb-form-field-wrap">
								<?php if ( isset($field['label']) && $field['label'] && isset($settings['label_show']) && $settings['label_show'] ) { ?>
									<label class="wppb-form-field-label"><?php echo $field['label']; ?><?php if( (isset($field['require']) && $field['require']) == 1) { echo "<span class='require-sign'>*</span>";}?></label>
								<?php }?>
								<?php if(isset($field['field_type']) && $field['field_type'] ){ ?>
									<?php include WPPB_DIR_PATH."addons/form/fields/{$field['field_type']}.php"; ?>
								<?php } ?>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>

				<?php if ($enableSimpleRecaptcha){ ?>
                    <div class="wppb-custom-recaptcha">
                        <span class="wppb-form-recaptcha-input"><input type="text" name="wppb_default_form[wppb_form_recaptcha_answer]" data-required="true" placeholder="10+5 = ?" data-label="<?php _e("WPPB Simple reCaptcha", 'wp-pagebuilder'); ?>"/></span>
                    </div>
				<?php } ?>

				<?php
				if ($enableGoogleRecaptcha){
					$google_recaptcha_site_key = isset($settings['google_recaptcha_site_key']) ? $settings['google_recaptcha_site_key'] : '';
					?>
                    <div class="wppb-form-google-recaptcha google_recaptcha_wrap">
                        <div class="g-recaptcha" data-sitekey="<?php echo $google_recaptcha_site_key; ?>"></div>
                    </div>
					<?php
				} ?>

				<?php
				if($icon_position == 'left') {
					$button = (esc_attr($icon_list)) ? '<i class="' . esc_attr($icon_list) . '"></i> <span>' . esc_attr($button_text).'</span>' : '<span>' . esc_attr($button_text). '</span>';
				} else {
					$button = (esc_attr($icon_list)) ? '<span>' . esc_attr($button_text) . '</span> <i class="' . esc_attr($icon_list) . '"></i><span>' : esc_attr($button_text).'</span>';
				}
				?>

                <div class="wppb_form_addon_submit_btn_wrap wppb-form-btn-wrap">
                    <button class="wppb-btn-forms wppb_form_addon_submit <?php echo esc_attr($classlist); ?>" type="submit"> <?php echo $button; ?> </button>
                </div>

                <div class="wppb_form_response"></div>
            </form>

			<?php
		}

		$htmlForm .= ob_get_clean();

		return $htmlForm;
	}

	/**
	 * Process Form when user submit
	 */
	public function wppb_form_process(){
		$this->check_wp_nonce();

		//Getting basic form information
		$formAddonData = sanitize_text_field(stripslashes($_POST['wppb_form_data']));
		$formAddonData = json_decode($formAddonData, true);

		if ( ! isset($formAddonData['addon_id']) || ! isset($formAddonData['page_id'])){
			wp_send_json_error( __('Form data error', 'wp-pagebuilder') );
		}

		$addon_id = (int) sanitize_text_field($formAddonData['addon_id']);
		$page_id = (int) sanitize_text_field($formAddonData['page_id']);

		//Getting addon settings from database
		$formData = wppb_get_saved_addon_settings($addon_id, $page_id);

		//Getting only settings from form
		$formSettings = $formData['settings'];
		unset($formSettings['wppb_default_form'], $formSettings['addon_background']);

		//Response variable

		$responseData = array();
		$responseData['enable_redirect_url'] = false;
		$responseData['msg'] = __('Something went wrong, please try again later', 'wp-pagebuilder');


		//Checking Recaptcha if exists?
		$enableSimpleRecaptcha = false;
		if ( ! empty($formSettings['enable_simple_recaptcha'])){
			$enableSimpleRecaptcha = (bool) $formSettings['enable_simple_recaptcha'];
		}

		if ($enableSimpleRecaptcha){
			//$recaptchaAnswer = (string)  ! empty($formSettings['wppb_form_recaptcha_answer']) ?
            // $formSettings['wppb_form_recaptcha_answer'] : '';
			$usersAnswere = (string) ! empty($_POST['wppb_default_form']['wppb_form_recaptcha_answer']) ? sanitize_text_field($_POST['wppb_default_form']['wppb_form_recaptcha_answer']) : '';

			if (15 != $usersAnswere){
				$responseData['msg'] = __('recaptcha answer does not matched', 'wp-pagebuilder');
				wp_send_json_error($responseData);
			}
		}

		$enableGoogleRecaptcha = false;
		if ( ! empty($formSettings['enable_google_recaptcha'])){
			$enableGoogleRecaptcha = (bool) $formSettings['enable_google_recaptcha'];
		}
		if ($enableGoogleRecaptcha){
			$g_captcha_secret_key = isset($formSettings['google_recaptcha_secret_key']) ? $formSettings['google_recaptcha_secret_key'] : '';
			$this->googleReCaptchaVerify($g_captcha_secret_key);
		}

		$formField = array();

		if ( ! empty($formData['settings']['wppb_default_form'])){
			$formField = $formData['settings']['wppb_default_form'];
		}

		$submitedRowData = array();
		if (isset($_POST['wppb_default_form'])){
			$submitedRowData = $_POST['wppb_default_form'];
		}

		//Getting only fields from form
		$submittedFormData = array();
		foreach ($submitedRowData as $key => $rowData){
			$field = $formField[$key];
			$field['submitted_data'] = $rowData;

			$submittedFormData[] = $field;
		}

		//Get Email Template and parse IT
		$email_format = ! empty($formSettings['email_format']) ? $formSettings['email_format'] : null;
		if ($email_format){
			$getFieldIdsValue = array();
			foreach ($submittedFormData as $submittedData){
				if (isset($submittedData['field_id'])){
					$submittedValue = '';
					if (isset($submittedData['submitted_data'])){
						if (is_array($submittedData['submitted_data'])){
							$submittedValue = implode('<br />', $submittedData['submitted_data']);
						}else{
							$submittedValue = $submittedData['submitted_data'];
						}
					}
					$getFieldIdsValue["{{$submittedData['field_id']}}"] = $submittedValue;
				}
			}

			$uniqueFields = array_keys($getFieldIdsValue);
			$uniqueFieldsValue = array_values($getFieldIdsValue);

			$email_format = str_replace($uniqueFields, $uniqueFieldsValue, $email_format);
		}


		$toEmail = ! empty($formSettings['wppb_default_form_to_email']) ? $formSettings['wppb_default_form_to_email'] : '';
		$fromEmail = ! empty($formSettings['wppb_default_form_from_email']) ? $formSettings['wppb_default_form_from_email'] : '';
		$subject = ! empty($formSettings['wppb_default_form_subject']) ? $formSettings['wppb_default_form_subject'] : '';

		$date = date(get_option('date_format'));
		$time = date(get_option('time_format'));
		$subjectVariable = array(
            '{date}' => $date,
            '{time}' => $time,
            '{datetime}' => $date.' '.$time
        );
		$subject = str_replace(array_keys($subjectVariable), array_values($subjectVariable), $subject);

		$emailHtml = '';
		if ($email_format){
			$emailHtml = $email_format;
		}else{
			//Getting E-Mail Template
			ob_start();
			include WPPB_DIR_PATH."addons/form/email-template/default.php";
			$emailHtml = ob_get_clean();
		}
		$htmlEmail = apply_filters('wppb_form', $emailHtml, $submittedFormData);

		//Setting Mail Headers
		$headers = array('Content-Type: text/html; charset=UTF-8');

		//Send E-Mail Now or through error msg
		try{
			$isMail = wp_mail($toEmail, $subject, $htmlEmail, $headers );
			if ($isMail){
				$responseData['msg'] = __('Thank you for submitting form', 'wp-pagebuilder');
				if ( ! empty($formSettings['success_message'])){
					$responseData['msg'] = $formSettings['success_message'];
				}

				if ( ! empty($formSettings['enable_redirect_url'])){
					$responseData['enable_redirect_url'] = (bool) $formSettings['enable_redirect_url'];
					$responseData['redirect_url'] = $formSettings['redirect_url'];
				}
			}
			wp_send_json_success($responseData);
		}catch (\Exception $e){
			$responseData['msg'] = $e->getMessage();
			wp_send_json_error($responseData);
		}
		wp_send_json_error($responseData);
	}

	/**
	 * Check nonce
	 */
	public function check_wp_nonce(){
		if (
			! isset( $_POST['wppb_form_nonce_field'] )
			|| ! wp_verify_nonce( $_POST['wppb_form_nonce_field'], 'wppb_form_submit_action' )
		) {
			exit;
		}
	}

	public function googleReCaptchaVerify($recapcha_secret_key = ''){
		$response_msg = array();
		$response_msg['msg'] = __('Something went wrong, please try again later', 'wp-pagebuilder');

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$g_response = isset($_POST['g-recaptcha-response']) ? sanitize_text_field($_POST['g-recaptcha-response']) : '';

		if ( ! $g_response){
			$response_msg['msg'] = __('Check reCaptcha required', 'wp-pagebuilder');
			wp_send_json_error($response_msg);
		}

		$params = array(
			'secret' => $recapcha_secret_key,
			'response' => $g_response,
			'remoteip' => $this->getIP(),
		);
		$response = wp_remote_post( $url, array( 'body' => $params ) );

		if (is_wp_error($response)){
			wp_send_json_error(array('msg' => $response->get_error_messages()));
		}

		$res = json_decode($response['body'], true);

		if ($res['success']){
			return true;
		}else{
			$response_msg['msg'] = implode(', ', $res['error-codes']);
		}

		wp_send_json_error($response_msg);
	}

	public function getIP(){
		$ip = false;
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}


	// Form
	public function render($data = null){
		$settings 				= $data['settings'];
		$form_type 				= isset($settings["form_type"]) ? $settings["form_type"] : '';
		$cf7_form 				= isset($settings["cf7_form"]) ? $settings["cf7_form"] : '';
		$we_form 				= isset($settings["we_form"]) ? $settings["we_form"] : '';
		$textarea_resize 		= isset($settings["textarea_resize"]) ? $settings["textarea_resize"] : '';

		$output = '';

		$output  .= '<div class="wppb-global-form-addon">';
		$output .= '<div class="wppb-global-form-content  wppb-textarea-disbale-'.$textarea_resize.'">';

		if ($form_type === 'wppb_default_form'){
			$output .= $this->generateDefaultForm($data);
		}

		if( $form_type === 'cf7_form' ){
			$output .= do_shortcode( '[contact-form-7 id="'.esc_attr($cf7_form).'"]' );
		}

		if($form_type === 'we_form'){
			$output .= do_shortcode( '[weforms id="'.esc_attr($we_form).'"]' );
		}

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function getTemplate(){
		$output = '
		<# var classList = " wppb-btn-"+data.fullwidth_button; #>
		<div class="wppb-forms-addon">
            <div class="wppb-form-content">
                <# if(data.wppb_default_form && data.form_type === "wppb_default_form") { #>
                    <div class="wppb-form-field-item-wrap">
                        <# __.forEach(data.wppb_default_form, function(field, key){ #>
                            <div class="wppb-form-field-repeat repeater-{{key}}">
                                <div class="wppb-form-field-wrap">
                                    <# if( data.label_show == 1 ) { #>
                                    <# if(field.label) { #>
                                        <label class="wppb-form-field-label">
                                            {{field.label}} {{{ (field.require == 1) ? "<span class=\"require-sign\">*</span>" : "" }}}
                                        </label>
                                    <# } #>
                                    <# } #>
                                    
                                    <# switch(field.field_type){ case "text" : #>
                                        <span class="wppb-form-field-item wppb-form-field-input">
                                            <input type="text" <# if(field.placeholder) { #> placeholder="{{field.placeholder}}" <# } #> />
                                        </span>	
                                    <# break; #>

                                    <# case "email" :  #>
                                        <span class="wppb-form-field-item wppb-form-field-email">
                                            <input type="email" <# if(field.placeholder) { #> placeholder="{{field.placeholder}}" <# } #> />
                                        </span>	
                                    <# break; #>

                                    <# case "textarea" :  #>
                                        <span class="wppb-form-field-item wppb-form-field-textarea wppb-textarea-disbale-{{data.textarea_resize}}">
                                            <textarea <# if(field.placeholder) { #> placeholder="{{field.placeholder}}" <# } #> ></textarea>
                                        </span>
                                    <# break; #>

                                    <# case "radio" : 
                                    if(field.radio_field_options){ __.forEach(field.radio_field_options, function(radioField){ #>
                                        <span class="wppb-form-field-item wppb-form-field-radio"><input type="radio" value="{{radioField.label}}" /> <label for="{{radioField.label}}">{{radioField.label}}</label></span>
                                        <# });
                                    } break; #>
                                    
                                    <# case "checkbox" : 
                                    if(field.checkbox_field_options){ __.forEach(field.checkbox_field_options, function(checkBoxField){ #>
                                        <span class="wppb-form-field-item wppb-form-field-checkbox"><input type="checkbox" value="{{checkBoxField.label}}" /> <label for="{{checkBoxField.label}}"> {{checkBoxField.label}} </label></span>
                                    <# }); 
                                    } break; #>

                                    <# case "select" : #>
                                        <span class="wppb-form-field-item wppb-form-field-select">
                                        <select>
                                            <# __.forEach(field.select_options, function(selectOption){ #>
                                            <option value="{{selectOption.label}}">{{selectOption.label}}</option>
                                            <# }); #>
                                        </select>
                                        </span>
                                    <# break; #>
                                    <# } #>
                                </div>
                            </div>
                        <# }); #>
                    </div>
                        
                    <# if(data.enable_simple_recaptcha == 1){ #>
                        <div class="wppb-custom-recaptcha">
                            <span class="wppb-form-recaptcha-input"><input type="text" placeholder="10+5 = ?" name="wppb_default_form[wppb_form_recaptcha_answer]" /></span>
                        </div>
                    <# } #>

                    <# if(data.enable_google_recaptcha == 1){ #>
                        <div class="wppb-form-google-recaptcha google_recaptcha_wrap">
                            <img src="{{wppb_form.form_addon_dir_url}}/assets/img/recaptcha-img.png" />
                        </div>
                        <# } #>
                        <div class="wppb-form-btn-wrap">
                            <button class="wppb-btn-forms {{classList}}" type="button"><# if(data.icon_position == "left" && !_.isEmpty(data.icon_list)) { #><i class="{{ data.icon_list }}"></i> <# } #><span>{{ data.button_text ? data.button_text : "Submit Form" }}</span><# if(data.icon_position == "right" && !_.isEmpty(data.icon_list)) { #> <i class="{{ data.icon_list }}"></i><# } #></button>
                        </div>
                        
                    <# }else{
                        var formHtmlContainer = "";
                        data.action = "wppb_form_addon";
                        $.ajax({
                            url: _wpUtilSettings.ajax.url,
                            method: \'POST\',
                            async: false,
                            data: data,
                            success: function (data) {
                                formHtmlContainer = data.data.html;
                            }
                        });
                     #>		
                    {{{formHtmlContainer}}}
                    
                    <# } #>		

            </div>
			</div>
		';
		return $output;
	}

	/**
	 * Render others integrated plugins shortcode
	 */
	public function wppb_shortcode_form_render(){
		$formType = isset($_POST['form_type']) ? sanitize_text_field($_POST['form_type']) : '';

		$html = '';
		if ($formType === 'cf7_form'){
			//Contact Form 7
			$formID = (int) isset($_POST['cf7_form']) ? sanitize_text_field($_POST['cf7_form']) : 0;
			if ($formID){
				$post = get_post($formID);
				$shortCode = '[contact-form-7 id="'.$formID.'" title="'.$post->post_title.'"]';
				$html = do_shortcode($shortCode);
			}

		}elseif ($formType === 'we_form'){
			$formID = (int) isset($_POST['we_form']) ? sanitize_text_field($_POST['we_form']) : 0;
			if ($formID){
				$shortCode = '[weforms id="'.$formID.'"]';
				$html = do_shortcode($shortCode);
			}
		}

		wp_send_json_success(array('html' => $html));
	}
}