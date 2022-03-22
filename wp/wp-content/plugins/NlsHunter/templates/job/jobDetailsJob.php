<div class="job-details-wrapper bg-white py-7 px-8 w-full md:w-7/12">
    <?= render('job/jobDetailsHeader', ['job' => $job]) ?>
    <div class="content py-4 md:py-5 px-5 md:px-8 md:text-xl text-primary"><?= html_entity_decode($job->Description) ?></div>
    <?= render('job/jobDetailsFooter', ['job' => $job]) ?>
</div>