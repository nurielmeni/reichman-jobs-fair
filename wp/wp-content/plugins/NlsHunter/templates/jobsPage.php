    <?php foreach ($jobs as $job) : ?>
        <?= render('jobCard', [
            'job' => $job,
            'model' => $model
        ]) ?>
    <?php endforeach; ?>