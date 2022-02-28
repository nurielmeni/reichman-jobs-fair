<?php
require_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';
/**
 * @param elements, array of elements
 * @param elementTemplate, template view file for the element
 * 
 **/
?>

<div class="hs-wrapper flex justify-center  items-center relative w-full px-6 pb-8">
  <div class="hidden md:block">
    <button type="button" class="nav opacity-50 left  hidden md:block absolute top-auto left-3 w-10 h-10  bg-sliderbg rounded-full">
      <img src="<?= plugins_url('NlsHunterFbf/public/images/left-chevron.svg') ?>" alt="" class="p-2">
    </button>
    <button type="button" class="nav opacity-50 right hidden md:block absolute top-auto right-3 w-10 h-10 bg-sliderbg rounded-full">
      <img src="<?= plugins_url('NlsHunterFbf/public/images/right-chevron.svg') ?>" alt="" class="p-2">
    </button>
  </div>
  <div class="hs-container overflow-hidden flex justify-start items-center py-4 w-full" dir="ltr">
    <?php foreach ($elements as $element) : ?>
      <?= render($elementTemplate, ['element' => $element]) ?>
    <?php endforeach; ?>
  </div>
</div>