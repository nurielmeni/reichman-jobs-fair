<?php

/**
 * @label
 * @name
 * @placeHolder
 * @type
 * @class
 * @validators
 * @prepend
 * @append
 * @iconSize
 */
$value = isset($value) ? $value : '';
$required =  isset($validators) && strpos($validators, 'required')  !== false;
?>
<div class="nls-field input <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label class="w-100 flex justify-between"><?= $label ?><span><? $required ? __('Not required', 'NlsHunterFbf') : '' ?></span></label>
  <?php endif; ?>
  <div class="relative">
    <?= isset($prepend) ? '<img src="' . $prepend . '" width="' . (isset($iconSize) ? $iconSize : 24) . '" height="' . (isset($iconSize) ? $iconSize : 24) . '" class="prepend inset-center" aria-hidden="true" focusable="false" />' : '' ?>
    <input type="<?= isset($type) ? $type : 'text' ?>" name="<?= isset($name) ? $name : '' ?>" value="<?= isset($value) ? $value : '' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" class="<?= isset($prepend) ? ' pl-11 rtl:pl-0 rtl:pr-11' : '' ?> <?= isset($class) ? $class : '' ?>" validator="<?= isset($validators) ? $validators : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>">
    <?= isset($append) ? '<img src="' . $append . '" width="' . (isset($iconSize) ? $iconSize : 24) . '" height="' . (isset($iconSize) ? $iconSize : 24) . '" class="append inset-center" aria-hidden="true" focusable="false" />' : '' ?>
  </div>

  <div class="help-block"></div>
</div>