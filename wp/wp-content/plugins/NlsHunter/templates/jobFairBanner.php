<div class="banner-wrapper full-width relative">
    <?php foreach ($blocks as $block) : ?>
        <?= render_block($block); ?>
    <?php endforeach; ?>
</div>
<div class="flex justify-center">
    <a href="<?= $allJobsPage ?>" class="all-fair-jobs bg-secondary text-white text-xl md:text-3xl px-8 py-3 rounded-lg"><?= __('All Fair Jobs', 'NlsHunter') ?></a>
</div>
<div class="search-box relative px-8">
    <label for="employer-search" class="block text-primary font-bold md:text-3xl mt-3 md:mt-28"><?= __('Search By Employer', 'NlsHunter') ?></label>
    <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-20 md:bottom-3 left-11 rtl:right-11" width="23.45" height="23.442" viewBox="0 0 23.45 23.442">
        <path d="M7.747 7.247a10 10 0 0 1 14.815 13.4l5.692 5.692-1.414 1.414-5.692-5.692A10 10 0 0 1 7.747 7.247zm12.728 1.414a8 8 0 1 0 0 11.314 8 8 0 0 0 0-11.314z" transform="translate(-4.803 -4.311)" data-name="find,-glass,-magnify,-search" style="opacity:.254" />
    </svg>
    <input id="employer-search" name="employer-search" type="text" class="block md:inline w-full md:w-96 border border-primary rounded-lg mt-3 text-2xl py-2 pl-10 rtl:pl-4 pr-4 rtl:pr-10" />
    <button type="button" class="block md:inline w-full md:w-auto search-btn bg-primary text-white border border-primary rounded-lg mt-5 md:mt-3 text-2xl py-2 px-6"><?= __('Search', 'NlsHunter') ?></button>
</div>