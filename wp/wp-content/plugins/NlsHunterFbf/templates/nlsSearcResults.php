<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/includes/Hunter/NlsHelper.php';
/**
 * @jobs
 * @jobDetailsPageUrl
 */
?>

<section class="search-results-wrapper">
    <div class="title flex justify-start mb-2 py-6 px-4 text-2xl text-white bg-primary">
        <span><?= NlsHelper::proprtyValue($jobs, 'TotalHits', 0) ?></span><span class="mx-2"><?= __('Jobs', 'NlsHunterFbf') ?></span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?= render('nlsJobApplyForm', ['nlsJobApplyUrl' => '#']) ?>
        <?php foreach (NlsHelper::proprtyValue(NlsHelper::proprtyValue($jobs, 'Results'), 'JobInfo', []) as $job) : ?>
            <?= render('nlsJobCard', [
                'model' => $model,
                'job' => $job,
                'jobDetailsPageUrl' => $jobDetailsPageUrl . '?jobcode=' .  NlsHelper::proprtyValue($job, 'JobCode')
            ]) ?>
        <?php endforeach; ?>
        <div class="footer flex justify-center items-center md:col-span-2 lg:col-span-3">
            <button class="more-results transition ease-in-out duration-150 inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-primary" type="button" data-page="0">
                <?= __('More Results', 'NlsHunterFbf') ?>
                <svg class="hidden animate-spin mis-4 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#002952" stroke-width="4"></circle>
                    <path class="opacity-75" fill="#002952" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </div>
</section>