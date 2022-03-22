<div class="employer-description-wrapper bg-primary text-white mt-4 p-4 md:text-xl">
    <?php if (key_exists('generalDescription', $employer) && strlen($employer['generalDescription']) > 0) : ?>
        <?= html_entity_decode($employer['generalDescription']) ?>
    <?php endif; ?>
    <?php if (key_exists('webSite', $employer) && strlen($employer['webSite']) > 0) : ?>
        <p class="mt-8"><span class="text-bold"><?= __('Company Website:', 'NlsHunter') ?></span><a href="<?= $employer['webSite'] ?>" class="px-2" target="_blank"><?= $employer['webSite'] ?></a></p>
    <?php endif; ?>
</div>