<div class="header flex items-center px-4">
    <div class="flex justify-center items-center sm-logo-image-wrapper rounded-full bg-white drop-shadow-md">
        <img src="<?= $data['logo'] ?>" alt="" class="object-contain">
    </div>
    <div class="mx-4">
        <h3 class="text-primary text-lg md:text-3xl"><?= $job->JobTitle ?></h3>
        <div class="flex flex-wrap text-indigo-300 md:text-xl -mx-2">
            <span class="px-2 "><?= $data['name'] ?></span>
            <span class="px-2 whitespace-nowrap border-x-2 border-indigo-300"><?= $job->JobCode ?></span>
            <span class="px-2 whitespace-nowrap"><?= date("d/m/Y", strtotime($job->UpdateDate)) ?></span>
        </div>
    </div>
</div>