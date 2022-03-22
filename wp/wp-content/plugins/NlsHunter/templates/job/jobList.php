<div class="jobs-wrapper">
    <?= render('nlsSelectField', [
        'wrapperClass' => 'sumo px-8 md:px-0 w-full',
        'label' => __('Open positions by area', 'NlsHunter'),
        'labelClass' => 'md:text-3xl text-primary font-bold my-6',
        'name' => 'jobs-by-area',
        'placeHolder' => __('Select Area', 'NlsHunter'),
        'options' => $model->regions(),
        'clearAllButton' => true, // For single select
        'clearAllButtonClass' => 'hidden bg-primary text-white py-1 px-2 mx-1 border border-primary rounded-xl', // For single select
    ]) ?>
    <h2 class="md:text-3xl text-primary my-6 px-3 md:px-0"><span class="total-hits"><?= $total ?></span>&nbsp;<?= __('Open Positions', 'NlsHunter') ?></h2>
    <section class="all-jobs flex flex-col gap-8 px-3 md:px-0">
        <?= render('job/jobsPage', [
            'jobs' => $jobs,
            'model' => $model,
            'jobDetailsPageUrl' => $jobDetailsPageUrl
        ]) ?>
    </section>
    <?= render('loader', ['id' => 'all-jobs-loader']) ?>
</div>