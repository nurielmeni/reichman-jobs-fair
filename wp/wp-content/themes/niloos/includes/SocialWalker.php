<?php
class social_walker extends Walker_Nav_Menu
{
      public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 )
      {
        parent::start_el( $output, $item, $depth, $args );
        $icon = sprintf( 
            '<span class="social-icon"><a href="%s" target="_blank"></a></span>', 
            esc_html( $item->url ) 
        ) ;
        $output .= $icon;
      }
}