<?php

require_once 'NlsService.php';
require_once 'NlsHelper.php';

/**
 * Description of NlsCards
 *
 * @author nurielmeni
 */
class NlsCards extends NlsService
{
    /**
     * 
     * @param type $config the $auth and $settings
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->init();
    }

    /**
     * Override init to set the service URL
     */
    public function init()
    {
        $this->url = get_option(NlsHunterFbf_Admin::CARDS_WSDL_URL);
        parent::init();
    }

    public function Test()
    {
        try {
            return $this->client->isServiceReachable()->isServiceReachableResult;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // IList<Niloosoft.CardsServiceReference.CardProfessinalField> CardProfessinalFieldsGet(Guid cardID, Guid transactionCode)
    public function cardProfessinalField($cardId)
    {
        $transactionCode = NlsHelper::newGuid();
        $params = [
            'cardID' => $cardId,
            'transactionCode' => $transactionCode
        ];

        try {
            $res = $this->client->CardProfessinalFieldsGet($params)->CardProfessinalFieldsGetResult;
            $list = json_decode(json_encode($res), TRUE);
        } catch (Exception $ex) {
            throw new Exception("Error: CardService: cardProfessinalField: Could not get professional field for card. \n\rTC: $transactionCode \n\rCardId: $cardId");
        }

        return $list;
    }

    /**
     * Meni: If CV insert CV, if other Insert other files
     * @param $cardId - the user id (Card Id)
     * @param $file - the file data
     * @param $name - the file name (with no ext)
     * @param $type - the file type (file extension)
     * @param $fileType - if "cv" will upload cv file
     */
    public function InsertNewFile($cardId, $file, $name, $type, $fileType = null)
    {

        $transactionCode = NlsHelper::newGuid();
        try {
            if ($fileType == "cv") {
                $params = [
                    "TransactionCode" => $transactionCode,
                    "CountryCode" => "IS",
                    "SupplierId" => NlsHunterFbf_Admin::NSOFT_SUPPLIER_ID,
                    "LanguageId" => NlsHelper::languageCode(),
                    "fInfo" => [
                        "CardId" => $cardId,
                        "CreatedBy" => 2,
                        "FolderId" => 1,
                        "Type" => $type,
                        "Name" => $name,
                        "FileContent" => $file,
                    ],
                ];
                $res = $this->client->InsertNewCvFile($params);
            } else {
                $params = array(
                    "transactionCode" => $transactionCode,
                    "resumeInfo" => array(
                        "CardId" => $cardId,
                        "CreatedBy" => 6,
                        "FolderId" => 2,
                        "Type" => $type,
                        "Name" => $name,
                        "FileContent" => $file,
                    ),
                );
                $res = $this->client->FileInsertBinary($params);
            }
            return $res->FileInsertBinaryResult;
        } catch (Exception $ex) {
            throw new Exception("Error: CardService: InsertNewCvFile: Could not insert new file. \n\rTC: $transactionCode \nrCardId: $cardId");
        }
    }


    /**
     * Return the applicants for a specific basket
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantsGetByBasket($basketGuid)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'languageId' => NlsHelper::languageCode(),
                'basketId' => $basketGuid,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantsGetByBasket($params);
            $applicantsList = json_decode(json_encode($res), TRUE);


            return ['res' => $applicantsList, 'Params' => $params];
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Return the applicants for a specific basket
     * (int languageId, string ActivityType, Guid basketId, Guid transactionCode)
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantsGetByBasket2($basketGuid, $activityType = '704')
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'languageId' => NlsHelper::languageCode(),
                'ActivityType' => $activityType,
                'basketId' => $basketGuid,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantsGetByBasket2($params);
            $applicantsList = json_decode(json_encode($res), TRUE);


            return ['res' => $applicantsList, 'Params' => $params];
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Remove the applicant from a specific basket
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantRemoveFromBaskets($applicantGuid, $basketGuid)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'applicantId' => $applicantGuid,
                'basketsIDs' =>  array($basketGuid),
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantRemoveFromBaskets($params);

            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Remove the applicant from a specific basket
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantsAddToBaskets($applicantGuid, $basketGuid)
    {
        $transactionCode = NlsHelper::newGuid();
        if (!is_array($applicantGuid)) $applicantGuid = array($applicantGuid);
        try {
            $params = [
                'applicantsIDs' => $applicantGuid,
                'basketsIDs' => array($basketGuid),
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantsAddToBaskets($params);

            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Update fields for applicant
     * @param guid $applicantGuid the applicant Id
     * @param string $name the applicant new name
     * @return List of Applicants
     */
    public function applicantUpdateFields($applicantGuid, $name)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'appEnum' => ['EntityLocalName'],
                'appInfo' => [
                    'CardId' => $applicantGuid,
                    'EntityLocalName' => $name,
                ],
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantUpdateFields($params);
            $res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Remove the applicant from a specific basket
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantGet($applicantGuid, $collections = 'None')
    {
        // collections(enum): None, Addresses, CardLogos, CardProfessionalFields, CardTagWords, Phones, ComputerKnowledge, CardUserDefineFields, RelatedCards, Qualification, ProfessionalExperiences, Languages, DrivingLicense, All  
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'cardId' => $applicantGuid,
                'collections' => $collections,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantGet($params);
            $res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Search applicant by parameters
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantGetByFilter2($entityLocalName = '', $mobilePhone = '', $officePhone = '', $homePhone = '', $email = '', $foreignEntityCode = '')
    {
        $filter = json_decode(
            '{"FromView":"Applicants",' .
                ' "NumberOfRows":null,' .
                ' "OffsetIndex":null,' .
                ' "OrderByFilterSort":[{"Direction": "Ascending","Field": "EntityLocalName"}],' .
                ' "SelectFilterFields":["CardId","EntityLocalName","MobilePhone","OfficePhone","HomePhone","Email","ForeignEntityCode"],' .
                ' "WhereFilters":[' .
                '   {"Condition":"OR",' .
                '    "Filters":[' .
                '       {"Field":"EntityLocalName","SearchPhrase":"Like","Value":"' . $entityLocalName . '"},' .
                '       {"Field":"MobilePhone","SearchPhrase":"Like","Value":"' . $mobilePhone . '"},' .
                '       {"Field":"OfficePhone","SearchPhrase":"Like","Value":"' . $officePhone . '"},' .
                '       {"Field":"HomePhone","SearchPhrase":"Like","Value":"' . $homePhone . '"},' .
                '       {"Field":"Email","SearchPhrase":"Like","Value":"' . $email . '"},' .
                '       {"Field":"ForeignEntityCode","SearchPhrase":"Exact","Value":"' . $foreignEntityCode . '"}' .
                '     ]}' .
                '  ]}'
        );

        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'totalNumResults' => 0,
                'cardFilter' => $filter,
                'transactionCode' => $transactionCode,
                'languageId' => NlsHelper::languageCode(),
            ];

            $res = $this->client->ApplicantGetByFilter2($params);
            if ($res->totalNumResults > 0) {
                $xmlObj = isset($res->ApplicantGetByFilter2Result->any) ? substr($res->ApplicantGetByFilter2Result->any, strpos($res->ApplicantGetByFilter2Result->any, '<diffgr:')) : null;
                $resObj = simplexml_load_string($xmlObj);
                $resArray = json_decode(json_encode($resObj), TRUE);
                foreach ($resArray['DocumentElement']['Cards'] as &$card) {
                    foreach ($card as $key => $value)
                        if (!is_string($value))
                            $card[$key] = "";
                }
                $result = ['totalNumResults' => $res->totalNumResults, 'results' => $resArray['DocumentElement']['Cards']];
            } else {
                $result = ['totalNumResults' => $res->totalNumResults, 'results' => []];
            }

            return ['res' => $result, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Search applicant by parameters
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function ApplicantHunterExecuteNewQuery2($entityLocalName = '', $mobilePhone = '', $officePhone = '', $homePhone = '', $email = '', $foreignEntityCode = '')
    {
        $filter = new stdClass();
        $filter->FromView = 'Applicants';
        $filter->NumberOfRows = 1;
        $filter->OffsetIndex = 0;
        $filter->SelectFilterFields = [
            'CardId',
            'EntityLocalName',
            'MobilePhone',
            'Email'
        ];
        $filter->OrderByFilterSort = [
            $this->jobFilterSort('EntityLocalName', 'Ascending')
        ];

        $whereFilters = [];
        if (!empty($mobilePhone)) {
            $whereFilters[] = $this->jobFilterWhere([$this->jobFilterField('MobilePhone', 'Like', $mobilePhone)], 'OR');
        }
        if (!empty($email)) {
            $whereFilters[] = $this->jobFilterWhere([$this->jobFilterField('Email', 'Like', $email)], 'OR');
        }
        if (count($whereFilters) > 0) {
            $filter->WhereFilters = $whereFilters;
        }


        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'totalNumResults' => 0,
                'cardFilter' => $filter,
                'transactionCode' => $transactionCode,
                'languageId' => NlsHelper::languageCode(),
            ];

            $res = $this->client->ApplicantGetByFilter2($params);
            if (isset($res->ApplicantGetByFilter2Result->any)) {
                $xmlObj = substr($res->ApplicantGetByFilter2Result->any, strpos($res->ApplicantGetByFilter2Result->any, '<diffgr:'));
                $resObj = simplexml_load_string($xmlObj);
                $resArray = json_decode(json_encode($resObj), TRUE);

                if (!key_exists('DocumentElement', $resArray)) return [];

                $cards = count($resArray['DocumentElement']) === 1 ?
                    [$resArray['DocumentElement']['Cards']] :
                    $resArray['DocumentElement']['Cards'];

                return $cards;
            }

            return [];
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * 
     * @param type $applicantGuid
     * @return boolian true if applicant is favorite
     */
    public function applicantIsFavorite($applicantGuid)
    {
        $applicantInfo = $this->applicantGet($applicantGuid);
        return isset($applicantInfo['res']['ApplicantGetResult']['IsFavourite']) ? $applicantInfo['res']['ApplicantGetResult']['IsFavourite'] : false;
    }

    /**
     * Remove the applicant from a specific basket
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantFavouriteAdd($applicantGuid)
    {
        $transactionCode = NlsHelper::newGuid();
        //if (!is_array($applicantGuid)) $applicantGuid = array($applicantGuid); 
        try {
            $params = [
                'cardId' => $applicantGuid,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantFavouriteAdd($params);
            $res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Remove the applicant from a specific basket
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function applicantFavouriteRemove($applicantGuid)
    {
        $transactionCode = NlsHelper::newGuid();
        //if (!is_array($applicantGuid)) $applicantGuid = array($applicantGuid); 
        try {
            $params = [
                'cardId' => $applicantGuid,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ApplicantFavouriteRemove($params);
            $res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Get history of suppliers
     * @param guid $basketGuid the Basket Id
     * @typeArray array of strings, the activity types to filter, null = all
     * @return List of Applicants
     */
    public function activitiesListGet($applicantGuid, $typeArray = null)
    {
        $transactionCode = NlsHelper::newGuid();

        try {
            $totalNum = 0;
            $params = [
                'ParentId' => $applicantGuid,
                'fromRow' => 1,
                'toRow' => 1,
                'sortColumn' => 'StartDate',
                'isAscending' => false,
                'filter' => [
                    'JobId' => null,
                    'ActivityId' => null,
                    'ActivityType' => $typeArray,
                ],
                'languageId' => NlsHelper::languageCode(),
                'transactionCode' => $transactionCode,
                'totalNumResults' => $totalNum,
            ];
            $res = $this->client->ActivitiesListGet($params);
            //$res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Add Activity Info
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function activityAdd2($applicantGuid, $noteTitle = '', $noteDescription = '')
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'activityInfo' => [
                    'CardId' => $applicantGuid,
                    'Description' => $noteDescription,
                    'Title' => $noteTitle,
                    'Type' => '704',
                    //'CreationTime' => date("Y-m-d\TH:i:s"),
                    'StartDate' => date("Y-m-d\TH:i:s"),
                ],
                'RelatedActivities' => null,
                'options' => null,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->activityAdd2($params);
            $res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Get Activity Info
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function activityGet($applicantGuid, $activityId)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'cardId' => $applicantGuid,
                'activityId' => $activityId,
                'withRelatedActivities' => false,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ActivityGet($params);
            //$res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Get Activity Info
     * @param guid $basketGuid the Basket Id
     * @return List of Applicants
     */
    public function activityUpdate($activityInfo)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'activityInfo' => $activityInfo,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->ActivityUpdate($params);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Get the last CV Info, including source
     * @param $applicantGuid the applicant ID
     * @return CvInfo of last CV
     */
    public function cvInfoGetLast($applicantGuid)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'cardId' => $applicantGuid,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->CvInfoGetLast($params);
            $res = json_decode(json_encode($res), TRUE);
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    /**
     * Get file by file Id
     * @param applicantGuid the apllicantId (Card ID)
     * @param fileId the file ID to get
     * @return FileInfo of the requested file (byte array)
     */
    public function fileGetByFileId($applicantGuid, $fileId, $includeFileContent = false)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'cardId' => $applicantGuid,
                'fileId' => $fileId,
                'IncludeFileContent' => $includeFileContent,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->FileGetByFileId($params);
            $res = isset($res->FileGetByFileIdResult) ? $res->FileGetByFileIdResult : null;
            return ['res' => $res, 'Params' => $params];
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }


    private function searchResultToArray($searchResult)
    {
        $result = [];

        if (!empty($searchResult)) {
            foreach ($searchResult as $job) {
                $jobCode = $job->JobCode->__toString();
                $result[$jobCode] = [
                    "jobId" => $job->JobId->__toString(),
                    "jobTitle" => $job->JobTitle->__toString(),
                    "jobCode" => $jobCode,
                    "updateDate" => date("d/m/Y", strtotime($job->UpdateDate)),
                    "employmentType" => $job->EmploymentType->__toString(),
                    "employerId" => $job->EmployerId->__toString(),
                    "employerName" => $job->EmployerName->__toString(),
                    "rank" => $job->Rank->__toString(),
                    "description" => $job->Description->__toString(),
                    "regionText" => $job->RegionText->__toString(),
                    "cityId" => $job->CityId->__toString(),
                    "expertiseId" => $job->ExpertiseId->__toString(),
                    "categoryId" => $job->CategoryId->__toString(),
                    "professionalFieldId" => $job->ProfessionalFieldId->__toString(),
                    "supplierId" => $job->SupplierId->__toString(),
                    "updateDate" => $job->updateDate->__toString(),
                ];
            }
        }

        return $result;
    }

    /**
     * keywords, categoryIds, expertise, regionIds, employmentTypes, jobscops,
     * jobscops, jobLocations, employerIds, updateDate, suplierId, lastId, countPerPage
     */
    public function jobsGetByFilter($filterArr)
    {
        if (!is_array($filterArr) || empty($filterArr)) return [];

        $params = array(
            "jobFilter" => $this->createFilter('Jobs', $filterArr),
            "LanguageId" => NlsHelper::languageCode(),
            "transactionCode" => NlsHelper::newGuid()
        );

        try {
            $res = $this->client->JobsGetByFilter($params);
        } catch (Exception $ex) {
            echo "Search Error!";
            die;
        }

        // The jobs returned as xml wrapped by unnecessary tags
        $strJobs = $res->JobsGetByFilterResult->any;
        $docStart = strpos($strJobs, "<diffgr:diffgram");
        $docEnd = strrpos($strJobs, "</diffgr:diffgram>");
        $doc = substr($strJobs, $docStart);
        $xml = simplexml_load_string($doc);
        $result = $this->searchResultToArray($xml->DocumentElement->Jobs);

        return $result;
    }

    public function jobGetConsideringIsDiscreetFiled($jobId)
    {
        try {
            $params = array(
                "JobId" => $jobId,
                "transactionCode" => NlsHelper::newGuid()
            );

            $response = $this->client->JobGetConsideringIsDiscreetFiled($params);

            return $response->JobGetConsideringIsDiscreetFiledResult;
        } catch (Exception $e) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    public function jobGet($jobId)
    {
        try {
            $params = array(
                "JobId" => $jobId,
                "transactionCode" => NlsHelper::newGuid()
            );

            $response = $this->client->JobGet($params);

            return $response->JobGetResult;
        } catch (Exception $e) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;ß
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    public function searchJobByJobCode($jobCode = null)
    {
        if (!$jobCode || empty($jobCode)) return [];
        $filter = new stdClass();
        $filter->FromView = "Jobs";
        $filter->SelectFilterFields = array(
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
            "CategoryId",
            "ProfessionalFieldId",
        );

        $filter->WhereFilters = array();
        # Filter Sort
        $filter->OrderByFilterSort = array(
            $this->jobFilterSort("UpdateDate", "Descending"),
            $this->jobFilterSort("JobCode", "Ascending"),
        );
        # Supplier
        // The supplier Id is not required here (looking for a specific job)
        //$this->jobFilterEntry($filter, get_option(NlsHunterFbf_Admin::NSOFT_SUPPLIER_ID), "SupplierId");
        # jobCode
        $this->jobFilterEntry($filter, $jobCode, "JobCode");

        $params = array(
            "jobFilter" => $filter,
            "LanguageId" => NlsHelper::languageCode(),
            "transactionCode" => NlsHelper::newGuid()
        );

        try {
            $res = $this->client->JobsGetByFilter($params);
        } catch (Exception $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
        //        echo '<pre style="direction:ltr;">';
        //        print_r($params);
        //        echo "</pre>";

        // The jobs returned as xml wrapped by unnecessary tags
        $strJobs = $res->JobsGetByFilterResult->any;
        $docStart = strpos($strJobs, "<diffgr:diffgram");
        $docEnd = strrpos($strJobs, "</diffgr:diffgram>");
        $doc = substr($strJobs, $docStart);
        $xml = simplexml_load_string($doc);
        $result = $this->searchResultToArray($xml->DocumentElement->Jobs);

        return $result;
    }

    public function getJobFields($jobId)
    {
        try {
            $params = array(
                "JobId" => $jobId,
                "transactionCode" => NlsHelper::newGuid()
            );

            $response = $this->client->JobProfessionalFieldsGet($params);

            return $response->JobProfessionalFieldsGetResult;
        } catch (Exception $e) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }


    public function getCVList($userID)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "applicantId" => $userID,
                "transactionCode" => $transactionCode,
            );
            $res = $this->client->CvInfoGetCvVersions($params);

            if (property_exists($res->CvInfoGetCvVersionsResult, "CvVersionInfo")) {
                $cvs = $res->CvInfoGetCvVersionsResult->CvVersionInfo;
                return is_array($cvs) ? $cvs : [$cvs];
            } else {
                return [];
            }
        } catch (Exception $ex) {
            throw new Exception('Error: getCVList: Niloos services are not availiable, try later.');
        }
    }

    public function getFileInfo($fileId, $cardId, $showContent = false)
    {
        $transactionCode = NlsHelper::newGuid();
        $params = array(
            "transactionCode" => $transactionCode,
            "fileId" => $fileId,
            "cardId" => $cardId,
            "IncludeFileContent" => $showContent
        );

        try {
            $res = $this->client->FileGetByFileId($params);
            return $res;
        } catch (Exception $ex) {
            throw new Exception('Error: getFileInfo: Niloos services are not availiable, try later.' . $ex->getMessage());
        }
    }
}
