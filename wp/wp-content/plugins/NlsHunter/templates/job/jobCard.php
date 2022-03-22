<div class="job-card w-full bg-white pt-3 pb-6 drop-shadow-md">
    <?= render('job/jobCardHeader', [
        'job' => $job,
        'data' => $model->getEmployerProperties($job->EmployerId)
    ]) ?>
    <div class="content py-4 md:py-5 px-5 md:px-8 md:text-xl text-primary"><?= html_entity_decode($job->Description) ?></div>
    <?= render('job/jobCardFooter', [
        'job' => $job,
        'model' => $model
    ]) ?>
</div>