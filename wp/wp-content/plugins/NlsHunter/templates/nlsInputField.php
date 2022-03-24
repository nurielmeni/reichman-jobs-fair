<?php

/**
 * @wrapperClass
 * @label
 * @name
 * @placeHolder
 * @type
 * @class
 * @validators
 * @prepend
 * @append
 * @iconSize
 * @autofocus
 */
$value = isset($value) ? $value : '';
$required =  isset($validators) && is_array($validators) && in_array('required', $validators) !== false;
?>
<div class="nls-field input <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label class="w-100 flex justify-between"><?= $label ?><span><? $required ? __('Not required', 'NlsHunter') : '' ?></span></label>
  <?php endif; ?>
  <div class="relative">
    <?= isset($prepend) ? '<img src="' . $prepend . '" width="' . (isset($iconSize) ? $iconSize : 24) . '" height="' . (isset($iconSize) ? $iconSize : 24) . '" class="prepend inset-center" aria-hidden="true" focusable="false" />' : '' ?>
    <input type="<?= isset($type) ? $type : 'text' ?>" name="<?= isset($name) ? $name : '' ?>" value="<?= isset($value) ? $value : '' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" class="border-2 <?= isset($prepend) ? ' pl-11 rtl:pl-0 rtl:pr-11' : '' ?> <?= isset($class) ? $class : '' ?>" validator="<?= is_array($validators) ? implode(' ', $validators) : '' ?>" aria-invalid="false" aria-required="<?= $required  ? 'true' : 'false' ?>" <?= isset($autofocus) &&  $autofocus ? 'autofocus' : '' ?>>
    <?= isset($append) ? '<img src="' . $append . '" width="' . (isset($iconSize) ? $iconSize : 24) . '" height="' . (isset($iconSize) ? $iconSize : 24) . '" class="append inset-center" aria-hidden="true" focusable="false" />' : '' ?>
  </div>

  <div class="help-block"></div>
</div>