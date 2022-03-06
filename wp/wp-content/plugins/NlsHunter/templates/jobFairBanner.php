<div class="banner-wrapper full-width relative">
    <?php foreach ($blocks as $block) : ?>
        <?= render_block($block); ?>
    <?php endforeach; ?>
</div>
<div class="flex justify-center">
    <button type="button" class="bg-secondary text-white text-xl md:text-3xl px-8 rounded-2"><?= __('All Fair Jobs', 'reichman') ?></button>
</div>