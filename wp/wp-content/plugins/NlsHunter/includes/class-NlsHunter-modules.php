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
            get_option(NlsHunter_Admin::NLS_HUNTER_ALL_JOBS_EN) :
            get_option(NlsHunter_Admin::NLS_HUNTER_ALL_JOBS_HE);
        $hunterAllJobsPageUrl = get_page_link($hunterAllJobsPageId);
        return $hunterAllJobsPageUrl;
    }

    private function getHunterEmployerDetailsPageUrl()
    {
        $language = get_bloginfo('language');
        $hunterEmployerDetailsPageId = $language === 'he-IL' ?
            get_option(NlsHunter_Admin::NLS_HUNTER_EMPLOYER_DETAILS_EN) :
            get_option(NlsHunter_Admin::NLS_HUNTER_EMPLOYER_DETAILS_HE);
        $hunterEmployerDetailsPageUrl = get_page_link($hunterEmployerDetailsPageId);
        return $hunterEmployerDetailsPageUrl;
    }

    private function searchParams()
    {
        $params['keywords'] = $this->model->queryParam('keywords');
        $params['categoryId'] = $this->model->queryParam('job-category', []);
        $params['regionValue'] = $this->model->queryParam('job-region', []);
        $params['employmentType'] = $this->model->queryParam('employments-type', []);
        $params['jobScope'] = $this->model->queryParam('job-scope', []);
        $params['jobLocation'] = $this->model->queryParam('job-location', []);
        $params['employerId'] = $this->model->queryParam('employerId');
        $params['updateDate'] = $this->model->queryParam('last-update');

        return $params;
    }

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
                'blocks' => parse_blocks($jobFair[0]->post_content)
            ]);
            $employers = $this->model->getEmployers();
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

    public function nlsHunterAllJobs_render()
    {
        ob_start();

        echo '<p>All Jobs Short Code</p>';

        return ob_get_clean();
    }
}
