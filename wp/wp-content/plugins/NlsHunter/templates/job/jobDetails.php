<?php $jobLink = $model->getExtendedProperty($job, 'JobLink', ''); ?>
<?= render('employer/employerTitle', [
    'employer' => $employer,
    'employerUrl' => $employerUrl
]) ?>
<section class="job-details flex flex-col md:flex-row md:drop-shadow-md">
    <?= render('job/jobDetailsJob', ['job' => $job]) ?>

    <div class="job-apply-form-wrapper flex flex-col justify-center items-center w-full md:w-5/12 bg-primary text-white pb-8">
        <h3 class="w-72 text-lg md:text-2xl font-bold my-8 text-center"><?= __('Submit Application', 'NlsHunter') ?></h3>
        <?php if (!empty($jobLink)) : ?>
            <?= render('job/jobApplyExternal', ['jobLink' => $jobLink]) ?>
        <?php else : ?>
            <?= render('job/jobApplyForm', ['job' => $job]) ?>
        <?php endif; ?>
    </div>
</section>