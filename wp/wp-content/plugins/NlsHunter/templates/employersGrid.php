<section class="employers-grid grid grid-flow-row auto-rows-max">
  <?php foreach($employers as $employer) : ?>
    <?= render('employer', [
      'employer' => $employer,
      'defaultLogo' => esc_url( plugins_url( 'NlsHunter/public/images/employer-logo.png' ) )
    ]) ?>
    <?php endforeach; ?>
</section>