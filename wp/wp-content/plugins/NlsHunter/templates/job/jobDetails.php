<?= render('employer/employerTitle', [
    'employer' => $employer,
    'employerUrl' => $employerUrl
]) ?>
<section class="job-details flex flex-col md:flex-row md:drop-shadow-md">
    <?= render('job/jobDetailsJob', ['job' => $job]) ?>
    <?= render('job/jobApplyForm', ['job' => $job]) ?>
</section>