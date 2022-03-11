<h3 class="p-8 text-xl font-semibold md:text-3xl"><?= __('Employers List', 'NlsHunter') ?></h3>
<section class="employers-grid grid grid-cols-autofit-120 md:grid-cols-autofit-160 gap-4 md:gap-8 lg:gap-10">
  <?php foreach ($employers as $employer) : ?>
    <?= render('employer', [
      'employer' => $employer,
      'defaultLogo' => esc_url(plugins_url('NlsHunter/public/images/employer-logo.svg'))
    ]) ?>
  <?php endforeach; ?>
</section>
<div class="footer flex justify-center items-center p-2">
  <span class="spinner">
    <svg class="hidden animate-spin mis-4 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#002952" stroke-width="4"></circle>
      <path class="opacity-75" fill="#002952" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
  </span>
</div>