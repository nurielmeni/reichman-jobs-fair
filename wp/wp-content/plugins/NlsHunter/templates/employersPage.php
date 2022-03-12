  <?php foreach ($employers as $employer) : ?>
    <?= render('employer', [
            'employer' => $employer,
            'defaultLogo' => esc_url(plugins_url('NlsHunter/public/images/employer-logo.svg'))
        ]) ?>
  <?php endforeach; ?>