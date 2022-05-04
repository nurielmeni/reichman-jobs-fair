<?php
include_once 'ContactDescriptionWalker.php';

function contact_description_function()
{
    $lang = pll_current_language();
    ob_start();

?>
    <h2 class="text-3xl text-primary mb-4 mt-8 px-10"><?= __('Contact Us', 'reichman') ?></h2>
    <div class="container mx-auto flex flex-col md:flex-row items-top primary gap-12 px-10">
        <?php

        wp_nav_menu(
            array(
                'menu' => 'footer-1-' . $lang,
                'container_id'    => 'footer-1',
                'container_class' => 'mt-1 mb-2',
                'menu_class'      => 'marker:text-green-400 list-disc pl-5 space-y-3 text-primary',
                'echo' => true,
                'li_class'        => 'mx-4',
                'walker' => new contact_description_walker,
                'fallback_cb'     => false,
            )
        );

        wp_nav_menu(
            array(
                'menu' => 'footer-2-' . $lang,
                'container_id'    => 'footer-2',
                'container_class' => 'mt-1 mb-2',
                'menu_class'      => 'marker:text-green-400 list-disc pl-5 space-y-3 text-primary',
                'echo' => true,
                'li_class'        => 'mx-4',
                'walker' => new contact_description_walker,
                'fallback_cb'     => false,
            )
        );
        ?>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('contact_description', 'contact_description_function');
