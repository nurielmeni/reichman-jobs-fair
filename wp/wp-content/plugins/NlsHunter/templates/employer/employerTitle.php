<div class="employer flex justify-start items-center w-full mb-7">
    <div class="rounded-full bg-white drop-shadow-md p-6 md:p-8">
        <img src="<?= $employer['logo'] ?>" alt="" class="w-12 md:w-20 h-12 md:h-20" />
    </div>
    <div class="mx-4">
        <h3 class="md:text-2xl text-primary"><?= $employer['name'] ?></h3>
        <?php if (isset($employerUrl) && strlen($employerUrl) > 0) : ?>
            <a href="<?= $employerUrl ?>" class="text-primary"><?= __('To employer page', 'NlsHunter') ?></a>
        <?php endif; ?>
    </div>
</div>