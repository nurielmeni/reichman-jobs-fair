<?php
require_once 'Hunter/NlsCards.php';
require_once 'Hunter/NlsSecurity.php';
require_once 'Hunter/NlsDirectory.php';
require_once 'Hunter/NlsSearch.php';
require_once 'Hunter/NlsHelper.php';
require_once 'Hunter/NlsFilter.php';
/**
 * Description of class-NlsHunter-modules
 *
 * @author nurielmeni
 */
class NlsHunter_model
{
    const STATUS_OPEN = 1;
    const CACHE_EXPIRATION = 20 * 60; // 20 min


    private $nlsSecutity;
    private $auth;
    private $nlsCards;
    private $nlsSearch;
    private $nlsDirectory;
    private $supplierId;

    private $countPerPage = 10;
    private $countHotJobs = 6;

    private $regions;

    public function __construct()
    {
        try {
            $this->nlsSecutity = new NlsSecurity();
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not create Model.', 'NlsHunter'),
                __('Error: NlsHunter_model: ', 'NlsHunter')
            );
            return null;
        }
        $this->auth = $this->nlsSecutity->isAuth();
        $this->countPerPage = get_option(NlsHunter_Admin::NLS_JOBS_COUNT, 10);
        $this->countHotJobs = get_option(NlsHunter_Admin::NLS_HOT_JOBS_COUNT, 6);
        $this->supplierId = $this->queryParam('sid', get_option(NlsHunter_Admin::NSOFT_SUPPLIER_ID));

        if (!$this->auth) {
            $username = get_option(NlsHunter_Admin::NLS_SECURITY_USERNAME);
            $password = get_option(NlsHunter_Admin::NLS_SECURITY_PASSWORD);
            $this->auth = $this->nlsSecutity->authenticate($username, $password);

            // Check if Auth is OK and convert to object
            if ($this->nlsSecutity->isAuth() === false) {
                $this->nlsAdminNotice('Authentication Error', 'Can not connect to Niloos Service.');
                $this->nlsPublicNotice('Authentication Error', 'Can not connect to Niloos Service.');
            }
        }

        // Load data on ajax calls
        if (!wp_doing_ajax()) {
        }
    }

    public function queryParam($param, $default = '', $post = false)
    {
        if ($post) {
            return isset($_POST[$param]) ? $_POST[$param] : $default;
        }
        return isset($_GET[$param]) ? $_GET[$param] : $default;
    }

    public function nlsGetSupplierId()
    {
        return $this->supplierId;
    }

    public function nlsGetCountPerPage()
    {
        return $this->countPerPage;
    }

    public function front_add_message()
    {
        add_filter('the_content', 'front_display_message');
    }

    public function front_display_message($msg)
    {
        add_filter('the_content', function ($content) use ($msg) {
            $message = '<div class="absolute top-0 z-20 p-4 bg-danger">' . $msg . '</div>';
            $content = "$message\n\n" . $content;
            return $content;
        });
    }

    public function nlsPublicNotice($title, $notice)
    {
        $cont = '<div class="notice notice-error"><label>' . $title . '</label><p>' . $notice . '</p></div>';

        add_action('the_post', function ($post) use ($cont) {
            echo $cont;
        });
    }

    public function nlsAdminNotice($title, $notice)
    {
        add_action('admin_notices', function () use ($title, $notice) {
            $class = 'notice notice-error';
            printf('<div class="%1$s"><label>%2$s</label><p>%3$s</p></div>', esc_attr($class), esc_html($title), esc_html($notice));
        });
    }

    /**
     * Gets a card by email or phone
     */
    public function getCardByEmailOrCell($email, $cell)
    {
        $card = [];
        if (!empty($email)) {
            $card = $this->nlsCards->ApplicantHunterExecuteNewQuery2('', '', '', '', $email);
        }
        if (count($card) === 0 && !empty($cell)) {
            $card = $this->nlsCards->ApplicantHunterExecuteNewQuery2('', $cell, '', '', '');
        }
        return $card;
    }

    /**
     * Add file to card
     */
    public function insertNewFile($cardId, $file)
    {
        $fileContent = file_get_contents($file['path']);
        return $this->nlsCards->insertNewFile($cardId, $fileContent, $file['name'], $file['ext']);
    }

    /**
     * Init cards service
     */
    public function initCardService()
    {
        try {
            if ($this->auth !== false && !$this->nlsCards) {
                $this->nlsCards = new NlsCards([
                    'auth' => $this->auth,
                ]);
            }
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not init Card Services.', 'NlsHunter'),
                __('Error: Card Services: ', 'NlsHunter')
            );
            return null;
        }
    }

    /**
     * Init directory service
     */
    public function initDirectoryService()
    {
        try {
            if ($this->auth !== false && !$this->nlsDirectory) {
                $this->nlsDirectory = new NlsDirectory([
                    'auth' => $this->auth
                ]);
            }
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not init Directory Services.', 'NlsHunter'),
                __('Error: Directory Services: ', 'NlsHunter')
            );
            return null;
        }
    }

    /**
     * Init search service
     */
    public function initSearchService()
    {
        try {
            if ($this->auth !== false && !$this->nlsSearch) {
                $this->nlsSearch = new NlsSearch([
                    'auth' => $this->auth,
                ]);
            }
        } catch (\Exception $e) {
            $this->nlsAdminNotice(
                __('Could not init Search Services.', 'NlsHunter'),
                __('Error: Search Services: ', 'NlsHunter')
            );
            return null;
        }
    }

    public function searchJobByJobCode($jobCode)
    {
        return $this->nlsCards->searchJobByJobCode($jobCode);
    }

    /**
     * Return the categories
     */
    public function categories()
    {
        $this->initDirectoryService();
        $categories = $this->nlsDirectory->getCategories();
        return $categories;
    }

    public function jobScopes()
    {
        $this->initDirectoryService();

        $cacheKey = 'JOB_SCOPES';
        $jobScopes = wp_cache_get($cacheKey);

        if (false === $jobScopes) {
            $jobScopes = $this->nlsDirectory->getJobScopes();
            wp_cache_set($cacheKey, $jobScopes, 'directory', self::CACHE_EXPIRATION);
        }

        return is_array($jobScopes) ? $jobScopes : [];
    }

    public function jobRanks()
    {
        $this->initDirectoryService();

        $cacheKey = 'JOB_RANKS';
        $jobRanks = wp_cache_get($cacheKey);

        if (false === $jobRanks) {
            $jobRanks = $this->nlsDirectory->getJobRanks();
            wp_cache_set($cacheKey, $jobRanks, 'directory', self::CACHE_EXPIRATION);
        }

        return is_array($jobRanks) ? $jobRanks : [];
    }

    public function professionalFields()
    {
        $this->initDirectoryService();

        $cacheKey = 'PROFESSIONAL_FIELD';
        $professionalFields = wp_cache_get($cacheKey);

        if (false === $professionalFields) {
            $professionalFields = $this->nlsDirectory->getProfessionalFields();
            wp_cache_set($cacheKey, $professionalFields, 'directory', self::CACHE_EXPIRATION);
        }

        return is_array($professionalFields) ? $professionalFields : [];
    }

    /**
     * Uses the card service to get jobs (depricted)
     * The search is noe done by Search service (getJobHunterExecuteNewQuery2)
     */
    public function getJobsGetByFilter($searchParams, $lastId, $sendToAgent = false)
    {
        $this->initCardService();

        if (!is_array($searchParams)) return [];

        $jobs = $this->nlsCards->jobsGetByFilter([
            'keywords' => key_exists('keywords', $searchParams) ? $searchParams['keywords'] : '',
            'categoryId' => key_exists('categoryIds', $searchParams) ? $searchParams['categoryIds'] : [],
            'regionValue' => key_exists('regionValues', $searchParams) ? $searchParams['regionValues'] : [],
            'employmentType' => key_exists('employmentTypes', $searchParams) ? $searchParams['employmentTypes'] : [],
            'jobScope' => key_exists('jobScopes', $searchParams) ? $searchParams['jobScopes'] : [],
            'jobLocation' => key_exists('jobLocations', $searchParams) ? $searchParams['jobLocations'] : [],
            'employerId' => key_exists('employerId', $searchParams) ? $searchParams['employerId'] : '',
            'updateDate' => key_exists('updateDate', $searchParams) ? $searchParams['updateDate'] : '',
            'supplierId' => $this->nlsGetSupplierId(),
            'lastId' => $lastId,
            'countPerPage' => $this->nlsGetCountPerPage(),
            'status' => self::STATUS_OPEN,
            'sendToAgent' => $sendToAgent
        ]);

        return $jobs;
    }

    public function getHotJobs($professionalFields)
    {
        $searchParams = is_array($professionalFields) ? ['' => $professionalFields] : [];

        $res =  $this->getJobHunterExecuteNewQuery2($searchParams, null, 0, $this->countHotJobs);
        return property_exists($res, 'Results') && property_exists($res->Results, 'JobInfo')
            ? $res->Results->JobInfo
            : [];
    }

    public function getEmployers($page = null, $flash = false)
    {
        $cache_key = 'nls_hunter_employers' . get_bloginfo('language');
        if ($flash) wp_cache_delete($cache_key);

        $employers = wp_cache_get($cache_key);
        if (false === $employers) {

            $res = $this->getJobHunterExecuteNewQuery2([], null, 0, 10000);
            if ($res && property_exists($res, 'Results') && property_exists($res->Results, 'JobInfo')) {
                foreach ($res->Results->JobInfo as $job) {
                    if (property_exists($job, 'EmployerId') && $job->EmployerId !== null) {
                        $employers[$job->EmployerId][] = $job;
                    }
                }

                wp_cache_set($cache_key, $employers, '', self::CACHE_EXPIRATION);
            }
        }
        if ($page !== null && is_int($page)) {
            $window = intval(get_option(NlsHunter_Admin::NLS_EMPLOYERS_COUNT, 1));
            return array_slice($employers, $page * $window, $window);
        }
        return $employers;
    }

    public function getJobHunterExecuteNewQuery2($searchParams = [], $hunterId = null, $resultRowOffset = 0, $resultRowLimit = null)
    {
        $this->initSearchService();
        $resultRowLimit = $resultRowLimit ? $resultRowLimit : $this->nlsGetCountPerPage();

        if (!is_array($searchParams)) return [];
        $filter = new NlsFilter();

        $filter->addSuplierIdFilter($this->nlsGetSupplierId());
        try {
            $jobs = $this->nlsSearch->JobHunterExecuteNewQuery2(
                $hunterId,
                $resultRowOffset,
                $resultRowLimit,
                $filter
            );
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return null;
        }

        return $jobs;
    }

    public function getCardProfessinalField($cardId)
    {
        $this->initCardService();

        $professionalFields = $this->nlsCards->cardProfessinalField($cardId);

        return $professionalFields;
    }

    /**
     * Get job details by jon id
     * @jobId - the jon id
     */
    public function getJobDetails($jobId)
    {
        $this->initCardService();

        return $this->nlsCards->jobGet($jobId);
    }

    public function getApplicantCVList($applicantId)
    {
        $cacheKey = 'APPLICANT_CV_' . $applicantId;
        $applicantCvList = wp_cache_get($cacheKey);

        if (false === $applicantCvList) {
            $applicantCvList = [];
            $this->initCardService();
            $cvList = $this->nlsCards->getCVList($applicantId);

            foreach ($cvList as $cv) {
                $fileInfo = $this->nlsCards->getFileInfo($cv->FileId, $applicantId);
                $applicantCvList[] = $fileInfo->FileGetByFileIdResult;
            }
        }
        return $applicantCvList;
    }
}
