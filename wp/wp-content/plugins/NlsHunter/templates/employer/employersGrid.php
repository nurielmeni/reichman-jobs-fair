<h3 class="p-8 text-xl font-semibold md:text-3xl"><?= __('Employers List', 'NlsHunter') ?></h3>
<section data-page="0" class="employers-grid grid grid-cols-autofit-120 md:grid-cols-autofit-160 gap-4 md:gap-8 lg:gap-10">
  <?= render('employer/employersPage', [
    'employers' => $employers,
    'model' => $model
  ]) ?>
</section>
<?= render('loader', ['id' => 'employers-loader']) ?>