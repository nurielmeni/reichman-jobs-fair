<?php
  include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/includes/Hunter/NlsHelper.php';
?>

<div class="hot-job-card flex flex-col justify-between items-center md:p-4" job-code="<?= NlsHelper::proprtyValue($element, 'JobCode') ?>">
  <div class="flex justify-end w-full"><span class="text-sm md:text-lg"><?= NlsHelper::dateFormat(NlsHelper::proprtyValue($element, 'UpdateDate')) ?></span></div>
  <div class="flex justify-center items-center"><span class="text-center font-bold text-base md:text-3xl"><?= NlsHelper::proprtyValue($element, 'JobTitle') ?></span></div>
  <div class="flex flex-col-reverse md:flex-row justify-around w-full items-center">
    <span class="text-sm md:text-xl text-center text-ellipsis overflow-hidden whitespace-nowrap"><?= NlsHelper::proprtyValue($element, 'EmployerName') ?></span>
    <span class="text-sm md:text-xl text-center"><?= NlsHelper::proprtyValue($element, 'JobCode') ?></span>
  </div>
  <div class="flex justify-center">
    <button type="button" class="w-120 font-bold text-sm md:text-lg py-1 mt-1 md:py-3 px-5 border-t border-gray-300">
      <?=  __('More details', 'NlsHunterFbf') ?>
    </span>
  </div>
</div>