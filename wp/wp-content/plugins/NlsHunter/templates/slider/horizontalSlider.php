<?php
require_once ABSPATH . 'wp-content/plugins/NlsHunter/renderFunction.php';
/**
 * @param elements, array of elements
 * @param elementTemplate, template view file for the element
 * 
 **/
?>

<div class="hs-wrapper flex justify-center  items-center relative w-full">

  <div class="">
    <button type="button" class="nav opacity-80 left absolute top-1/2 transform -translate-y-1/2 left-3 w-10 h-10 z-20 bg-sliderbg rounded-full">
      <img src="<?= plugins_url('NlsHunter/public/images/left-chevron.svg') ?>" alt="" class="p-2">
    </button>
    <button type="button" class="nav opacity-80 right absolute top-1/2 transform -translate-y-1/2 right-3 w-10 h-10 z-20 bg-sliderbg rounded-full">
      <img src="<?= plugins_url('NlsHunter/public/images/right-chevron.svg') ?>" alt="" class="p-2">
    </button>
  </div>
  <div class="hs-container overflow-hidden flex justify-start items-center py-4 w-full md:gap-4" dir="ltr">
    <?php foreach ($elements as $element) : ?>
      <?= render($elementTemplate, ['element' => $element]) ?>
    <?php endforeach; ?>
  </div>
</div>