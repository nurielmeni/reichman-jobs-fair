<?php

?>

<div class="job-apply-form-wrapper w-full hidden overflow-hidden origin-top relative">
    <div class="decor my-10 mx-auto h-1 bg-light w-9/12"></div>
    <form class="flex flex-col flex-wrap justify-center items-center lg:flex-row">
        <div class="apply-rounded-container bg-primary">
            <span class="text-xl text-white mb-12"><?= __('Select CV file', 'NlsHunterFbf') ?></span>
            <?= render('nlsSelectField', [
                'options' => [['id' => 1, 'name' => 'Meni']],
                'name' => 'cv-file',
                'class' => 'text-lg rounded-md',
            ]) ?>
            <p class="text-xl text-white mt-1 mb-2"><?= __('Or', 'NlsHunterFbf') ?></p>
            <button type="button" class="rounded-md bg-white text-primary text-lg py-1 w-44"><?= __('Add New', 'NlsHunterFbf') ?></button>
        </div>

        <img src="<?= plugins_url('NlsHunterFbf/public/images/down-chevron.svg') ?>" class="lg:rotate-270 rtl:lg:rotate-90" width="40" alt="">

        <div class="apply-rounded-container bg-dark-gray">
            <span class="text-xl text-white text-center"><?= __('Select other files', 'NlsHunterFbf') ?></span>
            <p class="text-sm text-white text-center mb-7"><?= __('(Not Required)', 'NlsHunterFbf') ?></p>
            <?= render('nlsSelectField', [
                'options' => [['id' => 1, 'name' => 'Meni']],
                'name' => 'cv-file',
                'class' => 'text-lg rounded-md',
            ]) ?>
            <p class="text-xl text-white mt-1 mb-2"><?= __('Or', 'NlsHunterFbf') ?></p>
            <button type="button" class="rounded-md bg-white text-primary text-lg py-1 w-44"><?= __('Add New', 'NlsHunterFbf') ?></button>
        </div>

        <img src="<?= plugins_url('NlsHunterFbf/public/images/down-chevron.svg') ?>" class="lg:rotate-270 rtl:lg:rotate-90" width="40" alt="">

        <div class="apply-rounded-container bg-light">
        <button type="button" class="rounded-md bg-white text-primary text-xl text-bold py-2 mb-12 w-44"><?= __('Apply CV', 'NlsHunterFbf') ?></button>

            <div class="hidden md:flex justify-end  items-center">
                <img src="http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply.png" srcset="http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply@2x.png 2x,
      http://localhost:8080/wp-content/plugins/NlsHunterFbf/public/images/apply@3x.png 3x" class="">
            </div>
        </div>
    </form>
</div>