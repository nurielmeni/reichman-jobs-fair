<div class="banner-wrapper full-width relative">
    <?php foreach ($blocks as $block) : ?>
        <?= render_block($block); ?>
    <?php endforeach; ?>
</div>