<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class('bg-mainbg text-gray-900 antialiased'); ?>>

	<?php do_action('reichman_site_before'); ?>

	<div id="page" class="min-h-screen flex flex-col">

		<?php do_action('reichman_header'); ?>

		<header>
			<div class="header-wrapper flex justify-center items-center bg-primary">
				<div class="mx-full container">
					<div class="md:flex md:justify-between md:items-center py-6 px-4 md:px-0">
						<div class="flex justify-between items-center text-white">

							<div class="flex items-center">
								<?= get_header_ml_logo(); ?>
								<h2 class="text-lg sm:text-xl md:text-2xl font-bold mx-2">
									<?= _e(get_bloginfo('description'), 'reichman'); ?>
								</h2>
							</div>

							<div class="flex md:hidden">
								<?php
								wp_nav_menu(
									array(
										'container_id'    => 'header-language-switcher',
										'container_class' => 'flex  md:hidden',
										'menu_class'      => 'flex text-white',
										'theme_location'  => 'language-switcher',
										'li_class'        => 'mx-4 text-white two-chars',
										'fallback_cb'     => false,
									)
								);
								?>
							</div>

						</div>
						<?php
						wp_nav_menu(
							array(
								'container_id'    => 'primary-menu',
								'container_class' => 'hidden bg-gray-100 mt-4 p-4 lg:mt-0 lg:p-0 lg:bg-transparent lg:block',
								'menu_class'      => 'lg:flex lg:-mx-4 text-white',
								'theme_location'  => 'primary',
								'li_class'        => 'lg:mx-4 lg:text-white text-primary',
								'fallback_cb'     => false,
							)
						);
						wp_nav_menu(
							array(
								'container_id'    => 'header-language-switcher',
								'container_class' => 'hidden md:flex',
								'menu_class'      => 'md:flex md:-mx-4 text-white',
								'theme_location'  => 'language-switcher',
								'li_class'        => 'md:mx-4 text-white',
								'fallback_cb'     => false,
							)
						);
						?>
					</div>
				</div>
			</div>
		</header>

		<div id="content" class="site-content flex-grow">



			<?php do_action('reichman_content_start'); ?>

			<main>