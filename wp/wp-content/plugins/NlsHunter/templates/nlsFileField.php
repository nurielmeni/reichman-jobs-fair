<?php

/**
 * @wrapperClass
 * @label
 * @name
 * @buttonText
 * @accept
 * @textClass
 * @buttonClass
 * @validators
 */
$value = isset($value) ? $value : '';
$required =  isset($validators) && is_array($validators) && in_array('required', $validators) !== false;
?>
<div class="nls-field file <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <input type="file" name="<?= isset($name) ? $name : '' ?>" accept="<?= isset($accept) ? $accept : '' ?>" class="hidden">
  <?php if (isset($label)) : ?>
    <label class="w-100 flex justify-between"><?= $label ?><span><? $required ? __('Not required', 'NlsHunter') : '' ?></span></label>
  <?php endif; ?>

  <div class="flex file-picker">
    <input type="text" readonly name="file-name" value="<?= isset($value) ? $value : '' ?>" class="border-2 truncate <?= isset($textClass) ? $textClass : '' ?>" validator="<?= is_array($validators) ? implode(' ', $validators) : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>">
    <button type="button" class="bg-description text-white <?= isset($buttonClass) ? $buttonClass : '' ?>"><?= isset($buttonText) ? $buttonText : '' ?></button>
  </div>

  <div class="help-block"></div>
</div>