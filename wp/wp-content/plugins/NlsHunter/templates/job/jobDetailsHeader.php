<div class="job-detail-header">
    <h3 class="text-primary text-lg md:text-3xl"><?= $job->JobTitle ?></h3>
    <div class="flex text-indigo-300 md:text-xl -mx-2">
        <span class="px-2 whitespace-nowrap border-r-2 rtl:border-r-0 rtl:border-l-2 border-indigo-300"><?= $job->JobCode ?></span>
        <span class="px-2 whitespace-nowrap"><?= date("d/m/Y", strtotime($job->UpdateDate)) ?></span>
    </div>
</div>