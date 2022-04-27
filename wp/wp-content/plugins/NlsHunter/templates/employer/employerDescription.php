<div class="employer-description-wrapper bg-primary text-white mt-4 p-4 md:text-xl <?= NlsHelper::isHebrew($employer['generalDescription']) ? 'text-right' : 'text-left' ?>">
    <?php if (key_exists('generalDescription', $employer) && strlen($employer['generalDescription']) > 0) : ?>
        <?= html_entity_decode($employer['generalDescription']) ?>
    <?php endif; ?>
    <?php if (is_array($textFiles) and count($textFiles) === 1) : ?>
        <div class="flex justify-center items-center my-4">
            <a href="<?= $textFiles[0]['src'] ?>" title="<?= $textFiles[0]['alt'] ?>" class="flex bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center gap-4" target="_blank">
                <img src="<?= plugins_url('NlsHunter/public/images/download.svg') ?>" width="32" alt="">
                <span><?= __('Full Description', 'NlsHunter') ?></span>
            </a>
        </div>
    <?php endif; ?>
    <?php if (key_exists('webSite', $employer) && strlen($employer['webSite']) > 0) : ?>
        <p class="mt-8"><span class="text-bold"><?= __('Company Website:', 'NlsHunter') ?></span><a href="<?= $employer['webSite'] ?>" class="px-2" target="_blank"><?= $employer['webSite'] ?></a></p>
    <?php endif; ?>
</div>