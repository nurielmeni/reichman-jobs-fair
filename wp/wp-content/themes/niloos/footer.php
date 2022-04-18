<?php
include_once 'includes/ContactDescriptionWalker.php';
include_once 'includes/SocialWalker.php';
?>

</main>

<?php do_action('reichman_content_end'); ?>

</div>

<?php do_action('reichman_content_after'); ?>

<footer id="colophon" class="site-footer bg-primary p-2 sticky bottom-0" role="contentinfo">
	<?php do_action('reichman_footer'); ?>

	<div class="container mx-auto flex flex-col justify-center items-center primary text-white">
		<?php
		// Social Menu
		wp_nav_menu(
			array(
				'container_id'    => 'footer-social',
				'container_class' => '',
				'menu_class'      => 'flex justify-center',
				'theme_location'  => 'footer-social',
				'li_class'        => 'px-2 mt-2 mb-1',
				'walker' => new social_walker,
				'fallback_cb'     => false,
			)
		);
		?>
	</div>

	<div class="container mx-auto flex flex-col justify-center items-center text-white">
		&copy; <?php echo date_i18n('Y'); ?> - <?= _e('All rights reserved to Reichman University.', 'reichman') ?>
		<div class="text-xs">
			POWERED BY <a href="https://niloosoft.com/he/">NILOOSOFT HUNTER EDGE</a> </div>
	</div>

</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>