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
    private $attributes;
    private $applicantId;

    public function __construct($model)
    {
        $this->model = $model;
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

    private function getHunterEmployerDetailsPageUrl()
    {
        $language = get_bloginfo('language');
        $hunterEmployerDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunter_Admin::NLS_HUNTER_EMPLOYER_DETAILS_HE) :
            get_option(NlsHunter_Admin::NLS_HUNTER_EMPLOYER_DETAILS_EN);
        $hunterEmployerDetailsPageUrl = get_page_link($hunterEmployerDetailsPageId);
        return $hunterEmployerDetailsPageUrl;
    }

    private function getHunterJobDetailsPageUrl()
    {
        $language = get_bloginfo('language');
        $hunterJobDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunter_Admin::NLS_HUNTER_JOB_DETAILS_HE) :
            get_option(NlsHunter_Admin::NLS_HUNTER_JOB_DETAILS_EN);
        $hunterJobDetailsPageUrl = get_page_link($hunterJobDetailsPageId);
        return $hunterJobDetailsPageUrl;
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
                'defaultLogo' => $this->model->getDefaultLogo()
            ]);
        } else {
            echo $this->noFair_render();
        }

        $this->model->front_display_message('Meni Nuriel');

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
        ob_start();

        echo '<p>Employer Details Short Code</p>';

        return ob_get_clean();
    }

    public function nlsHunterJobDetails_render()
    {
        ob_start();

        echo '<strong>Job Details</strong>';

        return ob_get_clean();
    }

    public function nlsHunterAllJobs_render()
    {
        $res = $this->model->getJobHunterExecuteNewQuery2();
        $totalHits = $res->TotalHits;
        $jobs = property_exists($res, 'Results') && property_exists($res->Results, 'JobInfo') && is_array($res->Results->JobInfo) ? $res->Results->JobInfo : [];

        ob_start();

        echo render('job/jobList', [
            'jobs' => $jobs,
            'total' => $totalHits,
            'model' => $this->model
        ]);

        return ob_get_clean();
    }
}
