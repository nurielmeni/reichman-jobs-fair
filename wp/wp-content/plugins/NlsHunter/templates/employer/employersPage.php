  <?php foreach ($employers as $employerId => $employer) : ?>
    <?= render('employer/employer', [
      'employer' => $employer,
      'defaultLogo' => esc_url(plugins_url('NlsHunter/public/images/employer-logo.svg')),
      'employerDetailsUrl' => isset($model) && method_exists($model, 'getHunterEmployerDetailsPageUrl') ? $model->getHunterEmployerDetailsPageUrl($employerId) : ''
    ]) ?>
  <?php endforeach; ?>