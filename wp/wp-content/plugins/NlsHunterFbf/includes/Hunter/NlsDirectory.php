<?php

include_once 'NlsHelper.php';
include_once 'NlsService.php';

/**
 * Description of NlsDirectory
 *
 * @author nurielmeni
 */
class NlsDirectory extends NlsService
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
        $this->url = get_option(NlsHunterFbf_Admin::DIRECTORY_WSDL_URL);
        parent::init();
    }

    public function getListByName($listname = null)
    {
        $transactionCode = NlsHelper::newGuid();
        try {

            // print_r($this->client->__getTypes());
            $params = array(
                "transactionCode" => $transactionCode,
                "parentItemId" => null,
                "listName" => $listname,
                "languageId" => $this->langCode
            );

            $res = $this->client->GetListItems($params)->GetListItemsResult; //->ListItemInfo;
            $list = [];

            if (property_exists($res, "ListItemInfo"))
                $res = $res->ListItemInfo;
            else
                return $list;


            foreach ($res as $cat) {
                $list[] = [
                    "id" => $cat->ListItemId,
                    "name" => $cat->ValueTranslated
                ];
            }


            return $list;
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

    public function getListItemById($list = false, $id = false)
    {
        if (!$list || !$id) return '';
        $listItems = $this->getListByName($list);
        if (is_array($listItems)) {
            foreach ($listItems as $listItem) {
                if ($listItem['id'] == $id) {
                    return $listItem;
                }
            }
        }
        return '';
    }

    public function getCategories($parentId = null)
    {
        $transactionCode = NlsHelper::newGuid();
        try {

            // print_r($this->client->__getTypes());
            $params = array(
                "listName" => "",
                "languageId" => $this->langCode,
                "parentItemId" => $parentId,
                "transactionCode" => $transactionCode,
            );

            if ($parentId == null) {
                $params["listName"] = 'ProfessionalCategories';
            } else {
                $params["listName"] = 'ProfessionalFields';
            }

            $res = $this->client->GetListItems($params)->GetListItemsResult; //->ListItemInfo;
            $list = [];

            if (property_exists($res, "ListItemInfo"))
                $res = $res->ListItemInfo;
            else
                return $list;


            foreach ($res as $cat) {
                $list[] = [
                    "id" => $cat->ListItemId,
                    "name" => $cat->ValueTranslated
                ];
            }


            return $list;
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

    public function getLocations($parentId = null)
    {
        $transactionCode = NlsHelper::newGuid();
        try {

            // print_r($this->client->__getTypes());
            $params = array(
                "transactionCode" => $transactionCode,
                "parentItemId" => $parentId,
                "listName" => 'Regions',
                "languageId" => $this->langCode
            );

            $res = $this->client->GetListItems($params)->GetListItemsResult->ListItemInfo;

            $list = [];

            foreach ($res as $cat) {
                // Do not display the All the country Option Test 9 Prod 9
                if ((int)$cat->ListItemId !== 9)
                    $list[] = [
                        "id" => $cat->ListItemId,
                        "name" => $cat->ValueTranslated
                    ];
            }


            return $list;
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

    public function getJobScopes()
    {
        $transactionCode = NlsHelper::newGuid();
        try {

            // print_r($this->client->__getTypes());

            $params = array(
                "transactionCode" => $transactionCode,
                "listName" => 'JobScope',
                "languageId" => $this->langCode,
                "parentItemId" => null
            );
            $res = $this->client->GetListItems($params)->GetListItemsResult->ListItemInfo;


            $list = [];
            // Do not display all option Test 302 Prod 3
            foreach ($res as $cat) {
                if ((int)$cat->ListItemId !== 3)
                    $list[] = ["id" => $cat->ListItemId, "name" => $cat->ValueTranslated];
            }

            return $list;
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

    public function getJobRanks()
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "languageId" => $this->langCode,
                "listName" => 'JobRank',
                "transactionCode" => $transactionCode,
            );
            $res = $this->client->GetListByListName($params)->GetListByListNameResult->HunterListItem;


            $list = [];
            if (isset($res)) {
                foreach ($res as $rank) {
                    $list[] = ["id" => $rank->Value, "name" => $rank->Text];
                }
            }

            return $list;
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

    public function getJobEnploymentType()
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = array(
                "languageId" => $this->langCode,
                "listName" => 'JobEnploymentType',
                "transactionCode" => $transactionCode,
            );
            $result = $this->client->GetListByListName($params)->GetListByListNameResult->HunterListItem;
            if (!is_array($result)) $result[] = $result;

            $list = [];
            foreach ($result as $enploymentType) {
                $list[] = ["id" => $enploymentType->Value, "name" => $enploymentType->Text];
            }

            return $list;
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

    public function getjoblocations()
    {
        $list = array(
            [
                "id" => 1,
                "name" => "aaaa"
            ],
            [
                "id" => 2,
                "name" => "bbb"
            ]
        );

        return $list;
    }

    public function getApplicantByUserName($username)
    {

        $transactionCode = NlsHelper::newGuid();
        try {


            $params = array(
                "transactionCode" => $transactionCode,
                "userName" => $username
            );

            $res = $this->client->GetCardIdByUserName2($params);

            return $res;
        } catch (SoapFault $ex) {
            /**
             * var_dump($ex);
             * echo "Request " . $this->client->__getLastRequest();
             * echo "Response " . $this->client->__getLastResponse();
             * die;
             **/
            throw new Exception('Error: Niloos services are not availiable, try later.');
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

    public function getJobArea()
    {

        $transactionCode = NlsHelper::newGuid();
        try {

            // print_r($this->client->__getTypes());
            $params = array(
                "transactionCode" => $transactionCode,
                "languageId" => $this->langCode,
                "listName" => 'EmploymentForm'
            );


            $res = $this->client->GetListByListName($params)->GetListByListNameResult->HunterListItem;
            $list = [];
            foreach ($res as $area) {
                $list[] = ['id' => $area->Value, 'name' => $area->Text];
            }
            return $list;
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

    public function getProfessionalFields()
    {
        $transactionCode = NlsHelper::newGuid();
        try {

            $params = array(
                "transactionCode" => $transactionCode,
                "languageId" => $this->langCode,
                "listName" => 'ProfessionalFields'
            );


            $res = $this->client->GetListByListName($params)->GetListByListNameResult->HunterListItem;
            $list = [];
            foreach ($res as $area) {
                $list[] = ['id' => $area->Value, 'name' => $area->Text];
            }
            return $list;
        } catch (Exception $ex) {
            throw new Exception('Error: Niloos services are not availiable, try later.');
        }
    }

    public function getUserIdByCardId($cardId)
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'cardId' => $cardId,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->GetUserIdByCardId($params);
            return $res->GetUserIdByCardIdResult;
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
     * Gets the user info by the user id
     * $userId user id (not GUID)
     * $utilizerId the utilizer Id
     * @return List of Applicants
     */
    public function userGetById($userId, $utilizerId = 5806) //3856
    {
        $transactionCode = NlsHelper::newGuid();
        try {
            $params = [
                'utilizerId' => $utilizerId,
                'userId' => $userId,
                'transactionCode' => $transactionCode,
            ];
            $res = $this->client->UserGetById($params);

            return $res->UserGetByIdResult;
        } catch (Exception $ex) {
            throw new Exception('Error: userGetById: Niloos services are not availiable, try later.');
        }
    }
}
