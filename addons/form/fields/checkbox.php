<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( isset( $field['checkbox_field_options'] ) ){
    $options = $field['checkbox_field_options'];
    if (count($options)){
        foreach ($options as $key => $option){
            $label_value = isset($option['label']) ? sanitize_text_field( $option['label'] ) : '';
            $label_name = 'wppb_default_form['.$fieldIndex.']['.$key.']';
            ?>
            <span class="wppb-form-field-item wppb-form-field-checkbox">
                <input type="checkbox" name="<?php echo esc_attr( $label_name ); ?>" value="<?php echo esc_attr( $label_value ); ?>" <?php echo isset($fieldAttr); ?> > 
                <label for="<?php echo esc_attr( $label_name ); ?>"><?php echo esc_html( $label_value ); ?></label>
            </span>
            <?php
        }
    }
}