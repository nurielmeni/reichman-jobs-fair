<h3 class="p-8 text-xl font-semibold md:text-3xl"><?= __('Employers List', 'NlsHunter') ?></h3>
<section class="employers-grid grid grid-cols-autofit-120 md:grid-cols-autofit-160 gap-4 md:gap-8 lg:gap-10">
  <?php foreach ($employers as $employer) : ?>
    <?= render('employer', [
      'employer' => $employer,
      'defaultLogo' => esc_url(plugins_url('NlsHunter/public/images/employer-logo.svg'))
    ]) ?>
  <?php endforeach; ?>
</section>
<div class="flex justify-center items-center"><span class="spinner">loading</span></div>