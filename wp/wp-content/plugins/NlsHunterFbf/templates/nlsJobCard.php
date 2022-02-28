<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/includes/Hunter/NlsHelper.php';

/**
 * @job
 * 
 */
?>
<div class="job-card flex flex-col justify-between items-center w-full">
  <div class="flex space-between items-center w-full">
    <h2 class="job-title text-2xl text-primary font-bold truncate w-full" title="<?= NlsHelper::proprtyValue($job, 'JobTitle') ?>">
      <?= NlsHelper::proprtyValue($job, 'JobTitle') ?>
    </h2>
    <button type="button" class="hidden additional cancel"><img src="<?= plugins_url('NlsHunterFbf/public/images/cancel.svg') ?>" width="30" alt=""></button>
  </div>
  <div class="flex justify-center text-xl my-3 w-full">
    <span class="whitespace-nowrap"><?= NlsHelper::proprtyValue($job, 'JobCode') ?></span>
    <span class="w-full border-x-4 mx-2 px-2 border-primary text-center"><?= NlsHelper::proprtyValue($job, 'EmployerName') ?></span>
    <span class="whitespace-nowrap"><?= NlsHelper::dateFormat(NlsHelper::proprtyValue($job, 'UpdateDate')) ?></span>
  </div>
  <div class="text-description text-xl overflow-hidden no-additional w-full">
    <?= mb_strimwidth(strip_tags(html_entity_decode(NlsHelper::proprtyValue($job, 'Description'))), 0, 130, '...') ?>
  </div>
  <div class="text-description additional text-xl overflow-hidden w-full hidden">
    <?= strip_tags(html_entity_decode(NlsHelper::proprtyValue($job, 'Description'))) ?>
  </div>
  <button type="button" class="additional-details no-additional text-center text-primary text-xl my-3"><?= __('Additional Details', 'NlsHunterFbf') ?></button>
  <div class="flex justify-start gap-3 w-full mb-4">
    <?php if (strlen(NlsHelper::getValueById($model->jobRanks(), NlsHelper::proprtyValue($job, 'Rank'))) > 0) : ?>
      <span class="bg-chip text-primary px-2 rounded-md"><?= NlsHelper::getValueById($model->jobRanks(), NlsHelper::proprtyValue($job, 'Rank')) ?></span>
    <?php endif; ?>
    <span class="bg-chip text-primary px-2 rounded-md">מלאה</span>
  </div>

  <?php if (false) : ?>
    <button type="button" class="apply-employer rounded-md bg-secondary text-white px-8 text-xl font-bold py-1">
      <?= __('Submit in employer site', 'NlsHunterFbf') ?>
    </button>
  <?php else : ?>
    <button type="button" class="apply rounded-md bg-primary text-white px-8 text-xl font-bold py-1">
      <?= __('Upload CV and submit', 'NlsHunterFbf') ?>
    </button>
  <?php endif; ?>

</div>