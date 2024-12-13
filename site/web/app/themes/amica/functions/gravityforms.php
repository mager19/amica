<?php

// add_filter('pre_option_rg_gforms_disable_css', '__return_true');
// add_filter('gform_disable_print_form_scripts', '__return_true');
// add_filter('gform_init_scripts_footer', '__return_true');


function custom_validation( $result, $value, $form, $field ) {
  if ( $field->type != 'email' ) $result['message'] = '* Required Field';
  return $result;
}
add_filter( 'gform_field_validation', 'custom_validation', 10, 4 );
add_filter( 'gform_disable_form_theme_css', '__return_true' );