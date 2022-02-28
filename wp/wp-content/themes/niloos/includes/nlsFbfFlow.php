<?php

/**
 * Returns a custom logo, linked to home unless the theme supports removing the link on the home page.
 *
 * @return string Custom logo markup.
 */

// Customizer settings
function add_flow_element_item_section($wp_customize, $panel, $index)
{
  /**
   * Add the new Flow element section
   */
  $section = $wp_customize->add_section('nls_flow_element_' . $index, [
    'title' => __('Flow Element - ', 'nls_fbf') . $index,
    'description' => __('Settings for the flow elements', 'nls_fbf'),
    'panel' => $panel
  ]);

  /**
   * Add the Flow element title
   */
  $wp_customize->add_setting('nls_flow_element_field_title_' . $index, array(
    'default' => '',
    'type' => 'theme_mod',
    'sanitize_callback' => 'our_sanitize_function',
  ));

  /**
   * Add the Flow element title
   */
  $wp_customize->add_control('nls_flow_element_field_title_' . $index, array(
    'label' => __('Title', 'nls_fbf'),
    'section' => $section->id,
    'settings' => 'nls_flow_element_field_title_' . $index,
    'type' => 'text'
  ));

  /**
   * Add the Flow element content
   */
  $wp_customize->add_setting('nls_flow_element_field_content_' . $index, array(
    'default' => '',
    'type' => 'theme_mod',
    'sanitize_callback' => 'our_sanitize_function',
  ));

  /**
   * Add the Flow element content
   */
  $wp_customize->add_control('nls_flow_element_field_content_' . $index, array(
    'label' => __('Content', 'nls_fbf'),
    'section' => $section->id,
    'settings' => 'nls_flow_element_field_content_' . $index,
    'type' => 'text'
  ));
}

function add_flow_elements_general_section($wp_customize, $panel)
{
  /**
   * Add the new Flow section
   */
  $section = $wp_customize->add_section('nls_flow_general', [
    'title' => __('Niloos FBF Flow - General', 'nls_fbf'),
    'description' => __('Settings for the flow elements', 'nls_fbf'),
    'panel' => $panel
  ]);

  /**
   * Add the separator image
   */
  $wp_customize->add_setting('nls_flow_element_separete_image', array(
    'default' => '',
    'type' => 'theme_mod',
  ));

  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'nls_flow_element_separete_image',
      array(
        'label' => __('Separator Image', 'nls_fbf'),
        'section' => $section->id,
        'settings' => 'nls_flow_element_separete_image',
      )
    )
  );

  /**
   * Add the separator image size
   */
  $wp_customize->add_setting('nls_flow_element_media_image_size', array(
    'default' => 42,
    'type' => 'theme_mod',
  ));

  $wp_customize->add_control('nls_flow_element_media_image_size', array(
    'label' => __('Separetor image width (px)', 'nls_fbf'),
    'section' => 'nls_flow_general',
    'settings' => 'nls_flow_element_media_image_size',
    'type' => 'number'
  ));
}


// [nls-fbf-flow numberElements=""] shortcode
function nls_fbf_flow($atts)
{
  $a = shortcode_atts(array(
    'num' => NLS_FLOW_ELEMENTS
  ), $atts);
  $numberElements = $a['num'];

  $separete_image = get_theme_mod('nls_flow_element_separete_image');
  $image_size = get_theme_mod('nls_flow_element_media_image_size');

  $html = '<section class="nls-fbf-flow-wrapper nls-main-row">';

  for ($index = 1; $index <= $numberElements; $index++) {
    $title = get_theme_mod('nls_flow_element_field_title_' . $index);
    $content = get_theme_mod('nls_flow_element_field_content_' . $index);

    $html .= elementDesign($title, $content);
    $html .= $index < $numberElements ? '<img width="' . $image_size . '" src="' . $separete_image . '" role="presentation" />' : '';
  }

  $html .= '</section>';

  return $html;
}

function elementDesign($title, $content)
{
  $html =  '<div class="flow-element-card">';
  $html .= ' <h3 class="flow-element-title">' . $title . '</h3>';
  $html .= ' <p class="flow-element-content">' . $content . '</p>';
  $html .= '</div>';

  return $html;
}

add_shortcode('nls_fbf_flow', 'nls_fbf_flow');
