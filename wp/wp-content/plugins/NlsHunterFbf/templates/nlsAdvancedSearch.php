<?php

/**
 * @model
 * @searchParams keywords, categoryId, regionValue, employmentType, jobScope, jobLocation, employerId, updateDate
 */

?>

<!-- Professional Fields -->
<?= render('nlsSelectField', [
    'options' => $model->categories(),
    'placeHolder' => __('Job Area', 'NlsHunterFbf'),
    'name' => 'job-category',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'value' => key_exists('categoryId', $searchParams) ? $searchParams['categoryId'] : '',
    'multiple' => true
]) ?>

<!-- Job Scope -->
<?= render('nlsSelectField', [
    'options' => $model->jobScopes(),
    'placeHolder' => __('Job Scope', 'NlsHunterFbf'),
    'name' => 'job-scope',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'value' => key_exists('jobScope', $searchParams) ? $searchParams['jobScope'] : '',
    'multiple' => true
]) ?>

<!-- Audiance -->
<?= render('nlsSelectField', [
    'options' => $model->jobRanks(),
    'placeHolder' => __('Job Rank', 'NlsHunterFbf'),
    'name' => 'job-rank',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'multiple' => true
]) ?>

<!-- Last Update -->
<?= render('nlsInputField', [
    'label' => null,
    'placeHolder' => __('Last Date', 'NlsHunterFbf'),
    'name' => 'last-update',
    'type' => 'text',
    'wrapperClass' => '',
    'class' => 'text-xl py-2 rounded-xl px-2 w-auto lg:w-40',
    'append' => plugins_url('NlsHunterFbf/public/images/crate-down.svg'),
    'iconSize' => 11
]) ?>

<!-- Employment Type -->
<?= render('nlsSelectField', [
    'options' => $model->professionalFields(),
    'placeHolder' => __('Employment Type', 'NlsHunterFbf'),
    'name' => 'employment-type',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'multiple' => true
]) ?>

<!-- Employer Type -->
<?= render('nlsSelectField', [
    'options' => $model->jobScopes(),
    'placeHolder' => __('Employer Type', 'NlsHunterFbf'),
    'name' => 'employer-type',
    'class' => 'rounded-xl border-none py-2 text-xl',
    'multiple' => true
]) ?>