<?php

/**
 * @wrapperClass
 * @label
 * @labelClass
 * @name
 * @class
 * @required
 * @placeHolder
 * @multiple
 * @value
 * @options
 * @clearAllButton
 */
$required =  isset($required) && $required;
$value = isset($value) && is_array($value) ? $value : [];
?>
<div class="nls-field select <?= isset($wrapperClass) ? $wrapperClass : '' ?>">
  <?php if (isset($label)) : ?>
    <label class="w-full flex justify-between <?= isset($labelClass) ? $labelClass : '' ?>"><?= $label ?><?= $required ? ('<span>' . __('Not required', 'NlsHunter') . '</span>') : '' ?></label>
  <?php endif; ?>
  <div class="relative flex md:justify-start items-center w-full md:w-64">
    <select name="<?= isset($name) ? $name : '' ?><?= isset($multiple) && $multiple ? '[]' : '' ?>" class="sumo <?= isset($class) ? $class : '' ?>" validator="<? isset($required) && $required ? 'required' : '' ?>" aria-invalid="false" aria-required="<?= isset($required) && $required ? 'true' : 'false' ?>" placeholder="<?= isset($placeHolder) ? $placeHolder : '' ?>" <?= isset($multiple) && $multiple ? 'multiple' : '' ?>>
      <?php foreach ($options as $option) : ?>
        <option value="<?= $option['id'] ?>" <?= in_array($option['id'], $value) ? 'selected' : '' ?>><?= $option['name'] ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($clearAllButton) && $clearAllButton) : ?>
      <button type="button" class="clear <?= isset($clearAllButtonClass) ? $clearAllButtonClass : '' ?>">Claer</button>
    <?php endif; ?>
  </div>

  <div class="help-block"></div>
</div>