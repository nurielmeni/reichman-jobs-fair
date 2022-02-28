<?php
const HEADER_ML_LOGO = 'header_ml_logo';
const HEADER_ML_LOGO_WIDTH = 158;
const HEADER_ML_LOGO_HEIGHT = 56;

/**
 *  Adds to the customizer a footer logo option that can the be used 
 *  in the the footer position.
 */
function add_header_ml_logo($wp_customize, $panel)
{
  /**
   * Add the new Flow section
   */
  $section = $wp_customize->add_section('header_ml_logo', [
    'title' => __('Header ML logo', 'nls_fbf'),
    'description' => __('Settings for header multilanguage logo', 'reichman'),
    'panel' => $panel
  ]);

  $wp_customize->add_setting(HEADER_ML_LOGO, array(
    'default' => '',
    'type' => 'theme_mod',
  ));

  $wp_customize->add_control(
    new WP_Customize_Media_Control(
      $wp_customize,
      HEADER_ML_LOGO,
      array(
        'label' => __('Header ML Logo', 'reichman'),
        'section' => $section->id,
        'settings' => HEADER_ML_LOGO,
      )
    )
  );
}


// The function to generate the html
function get_header_ml_logo()
{
  $html          = '';
  $header_ml_logo_id = get_theme_mod(HEADER_ML_LOGO);

  // We have a logo. Logo is go.
  if ($header_ml_logo_id) {
    $header_ml_logo_attr = array(
      'class'   => 'custom-logo',
      'loading' => false,
    );

    $image_alt = get_post_meta($header_ml_logo_id, '_wp_attachment_image_alt', true);
    if (empty($image_alt)) {
      $header_ml_logo_attr['alt'] = get_bloginfo('name', 'display');
    }

    $header_ml_logo_attr = apply_filters('get_custom_logo_image_attributes', $header_ml_logo_attr, $header_ml_logo_id, 0);

    $image = wp_get_attachment_image($header_ml_logo_id, [HEADER_ML_LOGO_WIDTH, HEADER_ML_LOGO_HEIGHT], false, $header_ml_logo_attr);
    $imageSrc  = wp_get_attachment_image_src( $header_ml_logo_id );
    if (!empty($image) && !empty($imageSrc)) {
      $lang = pll_current_language();
      $fileName = explode('/', $imageSrc[0]);
      $fileName = is_array($fileName) ?  end($fileName) : $fileName;
      $langFileName = preg_replace('/_\w+\./', '_' . $lang . '.', $fileName);
      $image = str_replace($fileName, $langFileName, $image);
    }

    if (is_front_page() && !is_paged()) {
      // If on the home page, don't link the logo to home.
      $html = sprintf(
        '<span class="custom-logo-link">%1$s</span>',
        $image
      );
    } else {
      $aria_current = is_front_page() && !is_paged() ? ' aria-current="page"' : '';

      $html = sprintf(
        '<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
        esc_url(home_url('/')),
        $aria_current,
        $image
      );
    }
  } elseif (is_customize_preview()) {
    // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
    $html = sprintf(
      '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo" alt="" /></a>',
      esc_url(home_url('/'))
    );
  }

  return apply_filters('get_custom_logo', $html, 0);
}
