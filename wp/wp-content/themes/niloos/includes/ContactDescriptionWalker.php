<?php
class contact_description_walker extends Walker_Nav_Menu
{
      public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 )
      {
        parent::start_el( $output, $item, $depth, $args );
        $output .= sprintf( 
            '<p class="px-4 font-bold"><a href="tel:%s">%s</a></p>', 
            esc_html( $item->description ) ,
            esc_html( $item->description ) 
        );
      }
}