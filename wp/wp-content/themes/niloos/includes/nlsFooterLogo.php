<?php

/**
 *  Adds to the customizer a footer logo option that can the be used 
 *  in the the footer position.
 */
function add_footer_logo_section($wp_customize, $panel)
{
  /**
   * Add the new Flow section
   */
  $section = $wp_customize->add_section('nls_footer_logo', [
    'title' => __('Niloos FBF footer logo', 'nls_fbf'),
    'description' => __('Settings for footer logo', 'nls_fbf'),
    'panel' => $panel
  ]);

  $wp_customize->add_setting(NLS_FBF_FOOTER_LOGO, array(
    'default' => '',
    'type' => 'theme_mod',
  ));

  $wp_customize->add_control(
    new WP_Customize_Media_Control(
      $wp_customize,
      NLS_FBF_FOOTER_LOGO,
      array(
        'label' => __('Footer Logo', 'alut'),
        'section' => $section->id,
        'settings' => NLS_FBF_FOOTER_LOGO,
      )
    )
  );
}


// The function to generate the html
function get_nls_footer_logo()
{
  $html          = '';
  $nls_footer_logo_id = get_theme_mod(NLS_FBF_FOOTER_LOGO);

  // We have a logo. Logo is go.
  if ($nls_footer_logo_id) {
    $nls_footer_logo_attr = array(
      'class'   => 'custom-logo',
      'loading' => false,
    );

    $image_alt = get_post_meta($nls_footer_logo_id, '_wp_attachment_image_alt', true);
    if (empty($image_alt)) {
      $nls_footer_logo_attr['alt'] = get_bloginfo('name', 'display');
    }

    $nls_footer_logo_attr = apply_filters('get_custom_logo_image_attributes', $nls_footer_logo_attr, $nls_footer_logo_id, 0);

    $image = wp_get_attachment_image($nls_footer_logo_id, ['277', '176'], false, $nls_footer_logo_attr);

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
