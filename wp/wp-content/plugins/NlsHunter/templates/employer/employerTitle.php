<div class="employer flex justify-start items-center w-full mb-7">
    <div class="flex justify-center items-center logo-image-wrapper rounded-full bg-white drop-shadow-md">
        <img src="<?= $employer['logo'] ?>" alt="" class="object-contain" />
    </div>
    <div class="mx-4">
        <h3 class="md:text-2xl text-primary"><?= $employer['name'] ?></h3>
        <?php if (isset($employerUrl) && strlen($employerUrl) > 0) : ?>
            <a href="<?= $employerUrl ?>" class="text-primary"><?= __('To employer page', 'NlsHunter') ?></a>
        <?php endif; ?>
    </div>
</div>