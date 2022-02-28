<?php
include_once ABSPATH . 'wp-content/plugins/NlsHunterFbf/renderFunction.php';

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/public
 * @author     Meni Nuriel <nurielmeni@gmail.com>
 */
class NlsHunterFbf_Public
{
    /**
     * Fields names
     */
    const SID = 'sid';

    const FRIEND_NAME = 'friend-name';
    const FRIEND_CELL = 'friend-cell';
    const FRIEND_AREA = 'friend-area';
    const FRIEND_JOB_CODE = 'friend-job-code';
    const FRIEND_CV = 'friend-cv';

    const EMPLOYEE_NAME = 'employee-name';
    const EMPLOYEE_ID = 'employee-id';
    const EMPLOYEE_EMAIL = 'employee-email';

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $NlsHunterFbf    The ID of this plugin.
     */
    private $NlsHunterFbf;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /** 
     * Show log messages
     */
    private $debug;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $NlsHunterFbf       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($NlsHunterFbf, $version, $debug = false)
    {
        $this->NlsHunterFbf = $NlsHunterFbf;
        $this->version = $version;
        $this->debug = $debug;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in NlsHunterFbf_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunterFbf_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('NlsHunterFbf', plugin_dir_url(__FILE__) . 'css/NlsHunterFbf-public.css', array(), $this->version, 'all');
        wp_enqueue_style('NlsHunterFbf-responsive', plugin_dir_url(__FILE__) . 'css/NlsHunterFbf-public-responsive.css', array(), $this->version, 'all');
        wp_enqueue_style('sumoselect', plugin_dir_url(__FILE__) . 'css/sumoselect.min.css', array(), $this->version, 'all');
        wp_enqueue_style('front-page-loader', plugin_dir_url(__FILE__) . 'css/loader.css', array(), $this->version, 'all');

        if (is_rtl()) {
            wp_enqueue_style('sumoselect-rtl', plugin_dir_url(__FILE__) . 'css/sumoselect-rtl.css', array(), $this->version, 'all');
        }

        wp_enqueue_style('jquery-ui-theme-smoothness', sprintf('https://ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css', wp_scripts()->registered['jquery-ui-core']->ver));
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in NlsHunterFbf_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunterFbf_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('mobile-check-js', plugin_dir_url(__FILE__) . 'js/mobileCheck.js', array('jquery'), $this->version, false);
        wp_enqueue_script('hot-jobs-js', plugin_dir_url(__FILE__) . 'js/hotJobs.js', array('jquery'), $this->version, false);
        wp_enqueue_script('job-search-js', plugin_dir_url(__FILE__) . 'js/jobSearch.js', array('jquery'), $this->version, false);
        wp_enqueue_script('job-apply-js', plugin_dir_url(__FILE__) . 'js/jobApply.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-form-validation', plugin_dir_url(__FILE__) . 'js/NlsHunterForm.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-swipe-detect', plugin_dir_url(__FILE__) . 'js/swipeDetect.js', array('jquery'), $this->version, false);
        wp_enqueue_script('nls-sumo-select', plugin_dir_url(__FILE__) . 'js/jquery.sumoselect.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery-ui-datepicker');
        //wp_enqueue_script('jquery-datepicker-he', plugin_dir_url(__FILE__) . 'js/datepicker-he.js', array('jquery'), $this->version, false);

        // enqueue and localise scripts for handling Ajax Submit CV
        // Don't forget to add the action (apply_cv_function)
        // defined in the  class-NlsHunterFbf-public.php (define_public_hooks)
        wp_localize_script('nls-form-validation', 'frontend_ajax', ['url' => admin_url('admin-ajax.php')]);
    }

    /**
     * Helper function to write log messages
     */
    public function writeLog($message, $level = 'debug')
    {
        if (!$this->debug) return;

        $logFile = NLS_FBF_PLUGIN_PATH . 'logs/default.log';

        $data = date("Ymd") . ' ' . $level . ' ' . $message;
        file_put_contents($logFile, $data, FILE_APPEND);
    }

    private function getFields()
    {
        $fields = [];

        $fields[self::SID] = ['label' => __('Supplier Id', 'NlsHunterFbf'), 'value' => isset($_POST[self::SID]) ? $_POST[self::SID] : ""];

        $fields[self::FRIEND_NAME] = ['label' => __('Full Name', 'NlsHunterFbf'), 'value' => isset($_POST[self::FRIEND_NAME]) ? $_POST[self::FRIEND_NAME] : []];
        $fields[self::FRIEND_CELL] = ['label' => __('Cell', 'NlsHunterFbf'), 'value' => isset($_POST[self::FRIEND_CELL]) ? $_POST[self::FRIEND_CELL] : []];
        $fields[self::FRIEND_AREA] = ['label' => __('Area', 'NlsHunterFbf'), 'value' => isset($_POST[self::FRIEND_AREA]) ? $_POST[self::FRIEND_AREA] : []];
        $fields[self::FRIEND_JOB_CODE] = ['label' => __('Job Code', 'NlsHunterFbf'), 'value' => isset($_POST[self::FRIEND_JOB_CODE]) ? $_POST[self::FRIEND_JOB_CODE] : []];

        $fields[self::EMPLOYEE_NAME] = ['label' => __('Full Name', 'NlsHunterFbf'), 'value' => isset($_POST[self::EMPLOYEE_NAME]) ? $_POST[self::EMPLOYEE_NAME] : ""];
        $fields[self::EMPLOYEE_ID] = ['label' => __('Employee ID', 'NlsHunterFbf'), 'value' => isset($_POST[self::EMPLOYEE_ID]) ? $_POST[self::EMPLOYEE_ID] : ""];
        $fields[self::EMPLOYEE_EMAIL] = ['label' => __('Company email', 'NlsHunterFbf'), 'value' => isset($_POST[self::EMPLOYEE_EMAIL]) ? $_POST[self::EMPLOYEE_EMAIL] : ""];

        return $fields;
    }

    /**
     * Get the CV file for the applicable friend
     * the CV file uploads temporarily and assigned a name
     */
    private function getCvFile($i)
    {
        if (
            isset($_FILES[self::FRIEND_CV]) &&
            isset($_FILES[self::FRIEND_CV]['name']) &&
            count($_FILES[self::FRIEND_CV]['name']) > 0 &&
            strlen($_FILES[self::FRIEND_CV]['name'][$i]) > 0 &&
            strlen($_FILES[self::FRIEND_CV]['tmp_name'][$i]) > 0 &&
            !$_FILES[self::FRIEND_CV]['error'][$i] &&
            $_FILES[self::FRIEND_CV]['size'][$i] > 0
        ) {
            $fileExt = pathinfo($_FILES[self::FRIEND_CV]['name'][$i])['extension'];
            $tmpCvFile = $this->getTempFile($fileExt);
            move_uploaded_file($_FILES[self::FRIEND_CV]['tmp_name'][$i], $tmpCvFile);
            return $tmpCvFile;
        }
        return '';
    }

    /*
     * Apply the friend request
     */
    private function apply_friend($fields, $friendsNum)
    {
        $count = 0;

        for ($i = 0; $i < $friendsNum; $i++) {
            $files = [];

            // 1. Create NCAI
            $ncaiFile = $this->createNCAI($fields, $i);
            if (!empty($ncaiFile)) array_push($files, $ncaiFile);

            // 2. Get CV File
            $tmpCvFile = $this->getCvFile($i);
            if (empty($tmpCvFile)) {
                $tmpCvFile = $this->genarateCvFile($fields, $i);
            }

            if (!empty($tmpCvFile)) array_push($files, $tmpCvFile);

            // 3. Sent email with file attachments
            $jobCode = $fields[self::FRIEND_JOB_CODE]['value'][$i];
            $count += $this->sendHtmlMail($jobCode, $files, $fields, $i) ? 1 : 0;

            // 4. Remove temp files

            // Remove the temp CV file and NCAI file from the Upload directory
            foreach ($files as $file) unlink($file);
        }

        return $count;
    }

    /*
     * Return the pager data to the search result module
     */
    public function apply_cv_function()
    {
        $fields = $this->getFields();
        $friendsNum = count($fields[self::FRIEND_NAME]['value']);

        $applyCount = $this->apply_friend($fields, $friendsNum);

        $response = ['sent' => $applyCount, 'html' => ($applyCount > 0 ? $this->sentSuccess($applyCount) : $this->sentError())];
        wp_send_json($response);
    }

    /**
     * Return a temp file path
     * @param $fileExt the file extention (ncai or other)
     */
    private function getTempFile($fileExt)
    {
        $tmpFolder = 'cvTempFiles';
        $upload_dir   = wp_upload_dir();

        if (!empty($upload_dir['basedir'])) {
            $cv_dirname = $upload_dir['basedir'] . '/' . $tmpFolder;
            if (!file_exists($cv_dirname)) {
                wp_mkdir_p($cv_dirname);
            }
        }
        if ($fileExt === 'ncai') {
            return $cv_dirname . DIRECTORY_SEPARATOR . 'NlsCvAnalysisInfo.' . $fileExt;
        }

        do {
            $tempFile = $cv_dirname . 'CV_FILE_' . mt_rand(100, 999) . '.' . $fileExt;
        } while (file_exists($tempFile));

        return $tempFile;
    }

    /**
     * Genarate cv file
     */
    private function genarateCvFile($fields, $i = 0)
    {
        $cvFile = $this->getTempFile('txt');

        // Open the file for writing.
        if (!$handle = fopen($cvFile, 'w')) {
            return '';
        }

        // Write the data
        foreach ($fields as $key => $field) {
            if (!is_array($field['value']) && empty($field['value'])) continue;
            if (strpos($key, 'friend') === false) continue;

            $dataLine = $field['label'] . ': ' . (is_array($field['value']) ? $field['value'][$i] : $field['value']) . "\r\n";

            if (fwrite($handle, $dataLine) === FALSE) break;
        }

        $dataLine = 'ניסיון: ליד' . "\n\r";
        $dataLine = 'השכלה: ליד' . "\n\r";
        fwrite($handle, $dataLine);

        // Close the file
        fclose($handle);
        return $cvFile;
    }

    private function getPhoneData($phone)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phone);
        return [
            'CountryCode' => '972',
            'AreaCode' => substr($phoneNumber, 0, 3),
            'PhoneNumber' => substr($phoneNumber, 3, 7),
            'PhoneType' => 'Mobile'
        ];
    }

    private function createNCAI($fields, $i = 0)
    {
        //create xml file
        $xml_obj = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><NiloosoftCvAnalysisInfo xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"></NiloosoftCvAnalysisInfo>');

        // Applying Person
        $applyingPerson = $xml_obj->addChild('ApplyingPerson');
        $applyingPerson->addChild('EntityLocalName', $fields[self::FRIEND_NAME]['value'][$i]);

        $phoneData = $this->getPhoneData($fields[self::FRIEND_CELL]['value'][$i]);
        $phoneInfo = $applyingPerson->addChild('Phones')->addChild('PhoneInfo');
        $phoneInfo->addChild('CountryCode', $phoneData['CountryCode']);
        $phoneInfo->addChild('AreaCode', $phoneData['AreaCode']);
        $phoneInfo->addChild('PhoneNumber', $phoneData['PhoneNumber']);
        $phoneInfo->addChild('PhoneType', $phoneData['PhoneType']);

        $applyingPerson->addChild('SupplierId', $fields[self::SID]['value']);

        // Notes
        $applicant_notes = __('Applicant form data: ', 'NlsHunterFbf') . "\r\n";
        // Change the $fields value for strongSide to include the name and not the id
        foreach ($fields as $key => $field) {
            if (!is_array($field['value']) && empty($field['value'])) continue;
            $applicant_notes .= $field['label'] . ': ' . (is_array($field['value']) ? $field['value'][$i] : $field['value']) . "\r\n";
        }
        $xml_obj->addChild('Notes', $applicant_notes);

        // Supplier ID
        $xml_obj->SupplierId = $fields[self::SID]['value'];

        // Recomending Person
        $recomendingPerson = $xml_obj->addChild('RecommendingPerson');
        $recomendingPerson->addChild('Email', $fields[self::EMPLOYEE_EMAIL]['value']);
        $recomendingPerson->addChild('EntityLocalName', $fields[self::EMPLOYEE_NAME]['value']);
        //$recomendingPerson->addChild('ForeignEntityCode', $fields[self::EMPLOYEE_ID]['value']);
        //$recomendingPerson->addChild('PersonalId', $fields[self::EMPLOYEE_ID]['value']);
        $recomendingPerson->addChild('SupplierId', $fields[self::SID]['value']);

        $ncaiFile = $this->getTempFile('ncai');
        $xml_obj->asXML($ncaiFile);
        return $ncaiFile;
    }

    public function sendHtmlMail($jobcode, $files, $fields, $i, $msg = '')
    {
        // Change the $fields value for strongSide to include the name and not the id
        $to = get_option(NlsHunterFbf_Admin::TO_MAIL);
        $bcc = get_option(NlsHunterFbf_Admin::BCC_MAIL);
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        if (strlen($bcc) > 0) array_push($headers, 'Bcc: ' . $bcc);

        $subject = __('CV Applied from Reichman Jobs Site', 'NlsHunterFbf') . ': ';
        $subject .= $jobcode ? $jobcode : $msg;

        $attachments = $files ?: [];

        $body = render('mailApply', [
            'fields' => $fields,
            'i' => $i
        ]);

        global $phpmailer;
        add_action('phpmailer_init', function (&$phpmailer) {
            $phpmailer->SMTPKeepAlive = true;
        });

        //add_filter('wp_mail_from', get_option(NlsHunterFbf_Admin::FROM_MAIL));
        //add_filter('wp_mail_from_name', get_option(NlsHunterFbf_Admin::FROM_NAME));

        $result =  wp_mail($to, $subject, $body, $headers, $attachments);
        //$this->writeLog("\nMail Result: $result");

        return $result;
    }

    private function sentSuccess($sent)
    {
        return render('mailSuccess', []);
    }

    private function sentError($msg = '')
    {
        return render('mailError', ['msg' => $msg]);
    }
}
