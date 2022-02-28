<?php

/**
 * @label
 * @name
 * @class
 * @required
 * @placeHolder
 * @multiple
 * @value
 * @options
 */
$required =  isset($required) && $required;
$value = isset($value) && is_array($value) ? $value : [];
?>
<div class="nls-field select <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label class="w-100 flex justify-between"><?= $label ?><span><? $required ? __('Not required', 'NlsHunterFbf') : '' ?></span></label>
  <?php endif; ?>
  <div class="relative">
    <select name="<?= isset($name) ? $name : '' ?><?= isset($multiple) && $multiple ? '[]' : '' ?>" class="sumo <?= isset($class) ? $class : '' ?>" validator="<? isset($required) && $required ? 'required' : '' ?>" aria-invalid="false" aria-required="<?= isset($required) && $required ? 'true' : 'false' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" <?= isset($multiple) && $multiple ? 'multiple' : '' ?>>
      <?php foreach ($options as $option) : ?>
        <option value="<?= $option['id'] ?>" <?= in_array($option['id'], $value) ? 'selected' : '' ?>><?= $option['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="help-block"></div>
</div>