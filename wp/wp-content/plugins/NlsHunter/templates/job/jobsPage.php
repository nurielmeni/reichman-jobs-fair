    <?php foreach ($jobs as $job) : ?>
        <?= render('job/jobCard', [
            'job' => $job,
            'model' => $model
        ]) ?>
    <?php endforeach; ?>