<div class="job-apply-form-wrapper flex flex-col justify-center items-center w-full md:w-5/12 bg-primary text-white">
    <h3 class="w-72 text-lg md:text-2xl font-bold my-8"><?= __('Submit Application', 'NlsHunter') ?></h3>
    <form class="nls-apply-for-jobs flex flex-col">

        <input type="hidden" name="job-code" value="<?= $job->JobCode ?>">
        <input type="hidden" name="sid" value="">

        <?= render('nlsInputField', [
            'wrapperClass' => 'w-72 mb-4',
            'class' => 'rounded-md px-3 py-2 text-primary w-full',
            'label' => __('Full Name', 'NlsHunter'),
            'name' => 'fullname',
            'validators' => ['required'],
            'autofocus' => true
        ]) ?>

        <?= render('nlsInputField', [
            'wrapperClass' => 'w-72 mb-4',
            'type' => 'tel',
            'class' => 'rounded-md px-3 py-2 text-primary w-full',
            'label' => __('Phone', 'NlsHunter'),
            'name' => 'phone',
            'validators' => ['required', 'phone']
        ]) ?>

        <?= render('nlsInputField', [
            'wrapperClass' => 'w-72 mb-4',
            'type' => 'email',
            'class' => 'rounded-md px-3 py-2 text-primary w-full',
            'label' => __('Email', 'NlsHunter'),
            'name' => 'email',
            'validators' => ['required', 'email']
        ]) ?>

        <?= render('nlsFileField', [
            'wrapperClass' => 'w-72 mb-4',
            'label' => __('Upload CV', 'NlsHunter'),
            'name' => 'cv-file',
            'buttonText' => __('Select file', 'NlsHunter'),
            'accept' => '.txt, .pdf, .doc, .docx, .rtf',
            'textClass' => 'rounded-l-md rtl:rounded-l-none rtl:rounded-r-md px-3 py-2 text-primary w-8/12',
            'buttonClass' => 'rounded-r-md rtl:rounded-r-none rtl:rounded-l-md px-3 py-2 text-center w-4/12',
            'validators' => ['required']
        ]) ?>

        <button type="submit" class="apply-job rounded-md bg-secondary w-fit text-white text-2xl md:text-3xl px-12 py-2 my-8 mx-auto"><?= __('Send', 'NlsHunter') ?></button>

    </form>
</div>