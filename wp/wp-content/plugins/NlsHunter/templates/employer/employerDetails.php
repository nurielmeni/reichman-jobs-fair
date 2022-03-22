<section class="employer-details-wrapper drop-shadow-md bg-white p-5" data-employer-id="<?= $employer['id'] ?>">
    <?php if ($employer && is_array($employer)) : ?>
        <?= render('employer/employerTitle', ['employer' => $employer]) ?>

        <?= render('employer/employerVideo', [
            'employer' => $employer,
            'autoplay' => true,
            'controls' => true,
            'loop' => true
        ]) ?>

        <?= render('employer/employerDescription', ['employer' => $employer]) ?>

        <?= render('slider/horizontalSlider', [
            'elementTemplate' => 'slider/elementTemplate',
            'elements' => $employer['images'],
        ]) ?>
    <?php endif; ?>
</section>