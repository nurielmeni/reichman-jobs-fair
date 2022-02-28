<?php
include_once 'nlsFbfFlow.php';
include_once 'headerLogo.php';

/**
 * Customize the theme customizer
 */
add_action('customize_register', 'reichman_customizer_additions');

function reichman_customizer_additions($wp_customize)
{

  // Add the new Flow Panel
  $panel = $wp_customize->add_panel(
    'reichman_theme_options',
    array(
      //'priority'       => 100,
      'title'            => __('Theme Options', 'nls_fbf'),
      'description'      => __('Theme Modifications for Reichman site', 'nls_fbf'),
    )
  );

  // Adds the flow element and the shortcode (nls_fbf_flow)
  add_flow_elements_general_section($wp_customize, $panel->id);

  /**
   * Add the Flow elements sections
   */
  for ($i = 1; $i <= NLS_FLOW_ELEMENTS; $i++) {
    add_flow_element_item_section($wp_customize, $panel->id, $i);
  }

  // Adds the footer logo customizer
  add_header_ml_logo($wp_customize, $panel->id);
}


function our_sanitize_function($input)
{
  return wp_kses_post(force_balance_tags($input));
}
