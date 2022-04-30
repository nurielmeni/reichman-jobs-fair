<?php
require_once 'Hunter/NlsHelper.php';
require_once ABSPATH . 'wp-content/plugins/NlsHunter/renderFunction.php';

/**
 * Description of class-NlsHunter-modules
 *
 * @author nurielmeni
 */
class NlsHunter_modules
{
    private $model;
    private $version;
    private $attributes;
    private $applicantId;

    public function __construct($model, $version)
    {
        $this->model = $model;
        $this->version = $version;
        $this->attributes = [
            'phone' => ['054-7641456'],
            'fullName' => ['כלכלה כלכלה'],
            'applicantID' => ['55555']
        ];

        $this->applicantId = '826084ab-89b4-4909-b831-bb790a2ede7b';
    }

    private function getHunterAllJobsPageUrl()
    {
        $language = get_bloginfo('language');
        $hunterAllJobsPageId = $language === 'he-IL' ?
            get_option(NlsHunter_Admin::NLS_HUNTER_ALL_JOBS_HE) :
            get_option(NlsHunter_Admin::NLS_HUNTER_ALL_JOBS_EN);
        $hunterAllJobsPageUrl = get_page_link($hunterAllJobsPageId);
        return $hunterAllJobsPageUrl;
    }

    /**
     * Shortcodes Renderers functions
     */
    public function nlsHunterEmployers_render()
    {
        ob_start();

        // Look for published Job Fair
        $jobFair = get_posts([
            'category_name' => 'reichman-job-fair',
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order'   => 'DESC',
            'numberposts' => 1,
        ]);

        if ($jobFair && count($jobFair) > 0) {
            echo render('jobFairBanner', [
                'title' => $jobFair[0]->post_title,
                'blocks' => parse_blocks($jobFair[0]->post_content),
                'allJobsPage' => $this->getHunterAllJobsPageUrl()
            ]);

            $employers = $this->model->getEmployers(0);

            echo render('employer/employersGrid', [
                'employers' => $employers,
                'model' => $this->model
            ]);
        } else {
            echo $this->noFair_render();
        }

        //$this->model->front_display_message('Meni Nuriel');

        return ob_get_clean();
    }

    private function noFair_render()
    {
        $locale = get_locale();
        $the_slug = 'no-fair-' . $locale;
        $args = array(
            'name'        => $the_slug,
            'post_type'   => 'post',
            'post_status' => 'publish',
            'numberposts' => 1
        );
        $noFair = get_posts($args);
        return $noFair[0]->post_content;
    }

    public function nlsHunterEmployerDetails_render()
    {
        $employerId = $this->model->queryParam('employer-id', null);

        if ($employerId) {
            $employer = $this->model->getEmployerProperties($employerId, true);
        }

        if (!$employerId || !$employer) {
            ob_start();
            echo render('employer/employerNotFound', ['employerId' => $employerId]);
            return ob_get_clean();
        };

        // Get employer Jobs
        $jobs = $this->model->getJobHunterExecuteNewQuery2(['EmployerId' => $employerId]);

        // Get employer text file to view (additional info), file download link
        $textFiles = $this->model->filesListGet($employerId, 'text');

        ob_start();

        echo render('employer/employerDetails', [
            'employer' => $employer,
            'textFiles' => $textFiles
        ]);

        echo render('job/jobList', [
            'jobs' => $jobs['list'],
            'total' => $jobs['totalHits'],
            'model' => $this->model,
            'jobDetailsPageUrl' => $this->model->getHunterJobDetailsPageUrl()
        ]);

        return ob_get_clean();
    }

    public function nlsHunterJobDetails_render()
    {
        $jobCode = $this->model->queryParam('job-code', null);
        if ($jobCode) {
            $job = $this->model->searchJobByJobCode($jobCode);
        }
        if (!$jobCode || !$job) {
            ob_start();
            echo render('job/jobNotFound', ['jobCode' => $jobCode]);
            return ob_get_clean();
        };

        $employerId = property_exists($job, 'EmployerId') ? $job->EmployerId : null;
        $employer = $this->model->getEmployerProperties($employerId);

        // Add form scripts
        wp_enqueue_script('nls-form-validation', plugins_url('NlsHunter/public/js/NlsHunterForm.js'), array('jquery'), $this->version, false);

        ob_start();

        echo render('job/jobDetails', [
            'job' => $job,
            'employer' => $employer,
            'employerUrl' => $this->model->getHunterEmployerDetailsPageUrl($employerId),
            'model' => $this->model,
        ]);

        return ob_get_clean();
    }

    public function nlsHunterAllJobs_render()
    {
        $jobs = $this->model->getJobHunterExecuteNewQuery2();
        if (!is_array($jobs) || !key_exists('list', $jobs) || !key_exists('totalHits', $jobs)) return '';
        ob_start();

        echo render('job/jobList', [
            'jobs' => $jobs['list'],
            'total' => $jobs['totalHits'],
            'model' => $this->model,
            'jobDetailsPageUrl' => $this->model->getHunterJobDetailsPageUrl()
        ]);

        return ob_get_clean();
    }
}
