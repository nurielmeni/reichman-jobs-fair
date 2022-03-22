    <div class="footer flex flex-col justify-between md:flex-row px-5 md:px-10 w-full">
        <div class="flex gap-2 md:gap-5"><?= render('tags', ['tags' => $job->TagWords]) ?></div>
        <div class="flex justify-center md:justify-end">
            <a href="<?= $model->getHunterJobDetailsPageUrl($job->JobCode) ?>" class="job-details bg-primary text-white text-xl px-6 py-1 rounded-lg"><?= __('More Details', 'NlsHunter') ?></a>
        </div>
    </div>