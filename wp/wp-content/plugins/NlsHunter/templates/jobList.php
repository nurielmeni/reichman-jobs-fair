<?= render('nlsSelectField', [
    'wrapperClass' => 'px-8 md:px-0 w-full',
    'label' => __('Open positions by area', 'NlsHunter'),
    'labelClass' => 'md:text-3xl text-primary font-bold my-6',
    'name' => 'search-by-employer',
    'placeHolder' => __('Select Area', 'NlsHunter'),
    'options' => [['id' => 1, 'name' => 'First']]
]) ?>
<h2 class="md:text-3xl text-primary my-6 px-3 md:px-0"><?= sprintf(__('%s Open Positions', 'NlsHunter'), $total) ?></h2>
<section class="all-jobs flex flex-col gap-8 px-3 md:px-0">
    <?= render('jobsPage', [
        'jobs' => $jobs,
        'model' => $model
    ]) ?>
</section>
<?= render('loader', ['id' => 'all-jobs-loader']) ?>