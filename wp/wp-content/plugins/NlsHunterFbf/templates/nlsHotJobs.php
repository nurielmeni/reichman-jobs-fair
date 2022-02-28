<section class="nls-hunter-hot-jobs-wrapper alignfull">
  <div class="grid grid-rows-1 grid-cols-4 alignwide">
    <div class="flex justify-start items-end">
    </div>

    <div class="flex flex-col justify-center items-center md:col-span-2 col-span-4 text-center font-bold">
      <span class="md:text-4xl md:pb-2"><?= __('Jobs we thought would interest you', 'NlsHunterFbf') ?></span>
      <div class="underline-decor"></div>
    </div>

    <div class="hidden md:flex justify-end  items-center">
      <img src="<?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs.png" srcset="<?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs@2x.png 2x,
      <?= plugins_url('NlsHunterFbf/public/images') ?>/hotjobs@3x.png 3x" class="">
    </div>
  </div>

  <div class="flex flex-col-reverse md:flex-col justify-between items-center flex-wrap w-full bg-sliderbg py-3">
    <div class="flex justify-center md:justify-end md:px-8 w-full"><button class="btn mb-3 px-20 md:px-2"><?= __('All Jobs', 'NlsHunterFbf') ?></button></div>
    <?= render('horizontalSlider', [
      'elements' => $hotJobs,
      'elementTemplate' => 'nlsHotJob'
    ]) ?>
  </div>
</section>