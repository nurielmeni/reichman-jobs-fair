<?php
include_once 'includes/ContactDescriptionWalker.php';
include_once 'includes/SocialWalker.php';
?>

</main>

<?php do_action('reichman_content_end'); ?>

</div>

<?php do_action('reichman_content_after'); ?>

<footer id="colophon" class="site-footer bg-primary p-4" role="contentinfo">
	<?php do_action('reichman_footer'); ?>

	<div class="container mx-auto flex justify-start text-white text-lg pb-4">
		<?= _e('Contact us', 'reichman') ?>
	</div>

	<div class="container mx-auto flex flex-col justify-center lg:flex-row lg:justify-between items-top primary text-white">
		<?php
		wp_nav_menu(
			array(
				'container_id'    => 'footer-1',
				'container_class' => 'mt-1 mb-2',
				'menu_class'      => 'marker:text-green-400 list-disc pl-5 space-y-3 text-white',
				'theme_location'  => 'footer-1',
				'li_class'        => 'mx-4',
				'walker' => new contact_description_walker,
				'fallback_cb'     => false,
			)
		);

		wp_nav_menu(
			array(
				'container_id'    => 'footer-2',
				'container_class' => 'mt-1 mb-2',
				'menu_class'      => 'marker:text-green-400 list-disc pl-5 space-y-3 text-white',
				'theme_location'  => 'footer-2',
				'li_class'        => 'mx-4',
				'walker' => new contact_description_walker,
				'fallback_cb'     => false,
			)
		);

		// Social Menu
		wp_nav_menu(
			array(
				'container_id'    => 'footer-social',
				'container_class' => 'mt-1 mb-2',
				'menu_class'      => 'flex justify-start lg:flex-col',
				'theme_location'  => 'footer-social',
				'li_class'        => 'px-2 mt-2',
				'walker' => new social_walker,
				'fallback_cb'     => false,
			)
		);
		?>
	</div>

	<div class="container mx-auto flex flex-col justify-start text-white mt-8">
		&copy; <?php echo date_i18n('Y'); ?> - <?= _e('All rights reserved to Reichman University.', 'reichman') ?>
		<div class="text-sm">
			POWERED BY <a href="https://niloosoft.com/he/">NILOOSOFT HUNTER EDGE</a> </div>
	</div>

</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>