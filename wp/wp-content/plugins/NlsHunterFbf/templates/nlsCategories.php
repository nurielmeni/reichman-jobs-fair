<section class="nls-hunter-categories-wrapper alignwide">
  <div class="grid md:grid-rows-1 md:grid-cols-4">
    <div class="hidden md:flex justify-start  items-center -mb-1">
      <img src="<?= plugins_url('NlsHunterFbf/public/images') ?>/categories.png" srcset="<?= plugins_url('NlsHunterFbf/public/images') ?>/categories@2x.png 2x,
     <?= plugins_url('NlsHunterFbf/public/images') ?>/categories@3x.png 3x" class="">
    </div>
    <div class="flex flex-col justify-center items-center col-span-2 text-center font-bold">
      <span class="md:text-4xl md:pb-2"><?= __('Categories', 'NlsHunterFbf') ?></span>
      <div class="underline-decor"></div>
    </div>
    <div class="hidden md:flex  justify-end items-end">
      <button type="button" class="all-jobs btn mb-3"><?= __('All Jobs', 'NlsHunterFbf') ?></button>
    </div>
  </div>


  <div class="bg-white my-4 md:my-0 p-2 md:p-4 flex gap-2 md:gap-4 justify-between flex-wrap">
    <?php foreach ($categories as $category) : ?>
      <button type="button" class="category-card flex flex-cols-3 md:w-fit md:flex-grow justify-center flex-col items-center p-4" category-id="<?= $category['categoryId'] ?>">
        <div class="mb-4">
          <?= $category['imageTag'] ?>
        </div>
        <span class="text-sm md:text-2xl text-bold"><?= $category['title'] ?></span>
    </button>
    <?php endforeach; ?>
    <button type="button" class="md:hidden all-jobs category-card flex flex-grow  justify-center flex-col items-center p-4" category-id="<?= $category['categoryId'] ?>">
        <span class="md:text-2xl text-bold"><?= __('To all jobs  >>', 'NlsHunterFbf') ?></span>
    </button>
  </div>
</section>