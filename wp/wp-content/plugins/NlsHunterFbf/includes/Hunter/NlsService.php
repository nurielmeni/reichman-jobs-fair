<?php

require_once 'NlsSoapClient.php';
require_once 'NlsHelper.php';
require_once 'NlsSecurity.php';

/**
 * Description of NlsService
 *
 * @author nurielmeni
 */
class NlsService
{
    const AUTH_KEY = 'niloosAuth';
    const AUTH_USER_KEY = 'niloosUserAuth';
    const USERNAME_TOKEN = 'nlsUsernameToken';
    const PASSWORD_TOKEN = 'nlsPasswordToken';
    /**
     *
     * @var string the WSDL url for the service
     */
    public $url;

    /**
     *
     * @var SOAP client object
     */
    public $auth;

    /**
     *
     * @var SOAP client object
     */
    public $client;

    /**
     *
     * @var SOAP header object
     *  - namespace
     *  - name
     *  - data
     *  - mustUnderstand
     *  - actor
     */
    public $soap_headers;

    public $langCode;

    /**
     * 
     * @param type $config the $auth and $settings
     */
    public function __construct($config = array(), $chachAuth = true)
    {
        if ($chachAuth && key_exists('auth', $config) && $config['auth'] !== null) {
            $this->auth = $config['auth'];
        } else {
            $nlsSecurity = new NlsSecurity();
            $this->auth = $nlsSecurity->isAuth();
        }
        $this->soap_headers = [
            new SoapHeader('_', 'NiloosoftCred1', $this->auth ? $this->auth->UsernameToken : null),
            new SoapHeader('_', 'NiloosoftCred2', $this->auth ? $this->auth->PasswordToken : null)
        ];
        $this->langCode = NlsHelper::languageCode();
    }

    public function addErrorToPage($message, $subject)
    {
        add_action('the_post', function () use ($message, $subject) {
            echo NlsHelper::addFlash(
                $message,
                $subject,
                'error'
            );
        });
    }

    /**
     * @return availiable SOAP functions
     */
    public function getFunctions()
    {
        return $this->client->__getFunctions();
    }

    public function init()
    {
        try {
            $this->client = new NlsSoapClient($this->url, array(
                'trace' => 0,
                'exceptions' => 1,
                'cache_wsdl' => WSDL_CACHE_BOTH,
                'location' => explode('?', $this->url)[0],
            ));

            $this->client->__setSoapHeaders($this->soap_headers);
        } catch (\Exception $e) {
            throw new Exception("Could not init NLS Service\n" . $e->getMessage());
        }
    }

    protected function jobFilterWhere($filters, $condition)
    {
        $filterWhere = new stdClass();
        $filterWhere->Filters = $filters;
        $filterWhere->Condition = $condition;
        return $filterWhere;
    }

    protected function jobFilterField($field, $searchPhrase, $value)
    {
        $filterField = new stdClass();
        $filterField->Field = $field;
        $filterField->SearchPhrase = $searchPhrase;
        $filterField->Value = $value;
        return $filterField;
    }

    protected function jobFilterEntry(&$filter, $entity, $filterKeyword, $phrase = "Exact")
    {
        if (!empty($entity)) {

            if (is_array($entity)) {
                $jobFilterArray = array();
                foreach ($entity as $value) {
                    $jobFilterArray[] = $this->jobFilterField($filterKeyword, $phrase, $value);
                }

                $filter->WhereFilters[] = $this->jobFilterWhere($jobFilterArray, "OR");
            } else {
                $filter->WhereFilters[] = $this->jobFilterWhere(array(
                    $this->jobFilterField($filterKeyword, $phrase, $entity)
                ), "AND");
            }
        }
    }

    protected function jobFilterSort($field, $direction)
    {
        $filterSort = new stdClass();
        $filterSort->Field = $field;
        $filterSort->Direction = $direction;
        return $filterSort;
    }

    /**
     * @return filter
     */
    /**
     * Create filter
     * @param view string, from which view
     * @param params array of filter options
     * Fields:
     *   $keywords = "",
     *   $categoryIds = [], // professionalFields
     *   $expertise = [],
     *   $regionIds = [],
     *   $employmentTypes = [],
     *   $jobscops = [],
     *   $jobLocations = [], // areas
     *   $employerIds = [],
     *   $updateDate = "",
     *   $suplierId = "",
     *   $lastId = 0,
     *   $countPerPage = NlsHunterFbf_modules::NLS_SEARCH_COUNT_PER_PAGE,
     */
    public function createFilter($view, $params = [])
    {
        if (empty($view) || count($params) === 0) return [];

        $filter = new stdClass();
        $filter->FromView = $view;

        $filter->SelectFilterFields = [
            //  "CategoryId",
            "JobId",
            "JobTitle",
            "JobCode",
            "RegionValue",
            "RegionText",
            "UpdateDate",
            "ExpertiseId",
            "EmploymentType",
            "EmployerId",
            "EmployerName",
            "JobScope",
            "Rank",
            "CityId",
            "Description",
        ];

        $filter->NumberOfRows = key_exists('countPerPage', $params) ? $params['countPerPage'] : null;
        $filter->OffsetIndex = key_exists('lastId', $params) ? $params['lastId'] : null;
        $filter->WhereFilters = [];
        $filter->OrderByFilterSort = array(
            $this->jobFilterSort("UpdateDate", "Descending"),
            $this->jobFilterSort("JobCode", "Ascending"),
        );

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'keywords':
                    if (!empty($value)) {
                        $keywords = explode(',', $value);
                        foreach ($keywords as $key => $keyword) {
                            $keywordsFilter[] = $this->jobFilterField("Description", "Like", $keyword);
                            $keywordsFilter[] = $this->jobFilterField("Requiremets", "Like", $keyword);
                            $keywordsFilter[] = $this->jobFilterField("JobTitle", "Like", $keyword);
                            $keywordsFilter[] = $this->jobFilterField("Skills", "Like", $keyword);
                            $keywordsFilter[] = $this->jobFilterField("JobCode", "Exact", $keyword);
                            if (is_numeric($keyword)) {
                                $keywordsFilter[] = $this->jobFilterField("JobId", "Exact", $keyword);
                            }

                            $filter->WhereFilters[] = $this->jobFilterWhere($keywordsFilter, "OR");
                        }
                    }
                    break;
                case 'categoryId':
                case 'expertise':
                case 'regionValue':
                case 'employmentType':
                case 'jobScope':
                case 'jobLocation':
                case 'employerId':
                case 'supplierId':
                case 'status':
                    if (!empty($value)) {
                        $this->jobFilterEntry($filter, $value, ucfirst($key));
                    }
                    break;
                case 'updateDate':
                    if (!empty($value)) {
                        $fromDate = DateTime::createFromFormat('j/m/Y', $value);
                        if ($fromDate) {
                            $dateDateStr = $fromDate->format('m/j/Y H:i') . '-' . date('m/j/Y H:i');
                            $filter->WhereFilters[] = $this->jobFilterWhere([$this->jobFilterField("UpdateDate", "BetweenDates", $dateDateStr)], "AND");
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        return $filter;
    }
}
