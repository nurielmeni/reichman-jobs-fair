<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.1.0
 *
 * @package    NlsHunter
 * @subpackage NlsHunter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    NlsHunter
 * @subpackage NlsHunter/admin
 * @author     Meni Nuriel <nurielmeni@gmail.com>
 */
class NlsHunter_Admin
{
    const FROM_NAME = 'nlsFromName';
    const FROM_MAIL = 'nlsFromMail';
    const TO_MAIL = 'nlsToMail';
    const BCC_MAIL = 'nlsBccMail';
    const NSOFT_SUPPLIER_ID = 'nlsNsoftSupplierId';
    const NSOFT_HOT_JOBS_SUPPLIER_ID = 'nlsNsoftHotJobsSupplierId';
    const DIRECTORY_WSDL_URL = 'nlsDirectoryWsdlUrl';
    const CARDS_WSDL_URL = 'nlsCardsWsdlUrl';
    const SECURITY_WSDL_URL = 'nlsSecurityWsdlUrl';
    const SEARCH_WSDL_URL = 'nlsSearchWsdlUrl';
    const NLS_CONSUMER_KEY = 'nlsConsumerKey';
    const NLS_WEB_SERVICE_DOMAIN = 'nlsWebServiceDomain';
    const NLS_SECURITY_USERNAME = 'nlsSecurityUsername';
    const NLS_SECURITY_PASSWORD = 'nlsSecurityPassword';
    const NLS_JOBS_COUNT = 'nlsJobsCount';
    const NLS_HOT_JOBS_COUNT = 'nlsHotJobsCount';
    const NLS_EMPLOYERS_COUNT = 'nlsEmployersCount';
    const NLS_HUNTER_ALL_JOBS_EN = 'nlsHunterAllJobs_en';
    const NLS_HUNTER_ALL_JOBS_HE = 'nlsHunterAllJobs_he';
    const NLS_HUNTER_EMPLOYER_DETAILS_EN = 'nlsHunterEmployerDetails_en';
    const NLS_HUNTER_EMPLOYER_DETAILS_HE = 'nlsHunterEmployerDetails_he';
    const NLS_HUNTER_EMPLOYERS_EN = 'nlsHunterEmployers_en';
    const NLS_HUNTER_EMPLOYERS_HE = 'nlsHunterEmployers_he';
    const NLS_HUNTER_JOB_DETAILS_EN = 'nlsJobDetails_en';
    const NLS_HUNTER_JOB_DETAILS_HE = 'nlsJobDetails_he';
    const NLS_FLASH_CACHE = 'nlsFlashCache';
    const NLS_CACHE_TIME = 'nlsCacheTime';

    private $defaultValue;
    /**
     * The ID of this plugin.
     *
     * @since    1.1.0
     * @access   private
     * @var      string    $NlsHunter    The ID of this plugin.
     */
    private $nlsHunterApi;

    /**
     * The version of this plugin.
     *
     * @since    1.1.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.1.0
     * @param      string    $NlsHunter       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($nlsHunterApi, $version)
    {

        $this->nlsHunterApi = $nlsHunterApi;
        $this->version = $version;
        $this->defaultValue = [
            self::DIRECTORY_WSDL_URL => 'https://hunterdirectory.hunterhrms.com/DirectoryManagementService.svc?wsdl',
            self::CARDS_WSDL_URL => 'https://huntercards.hunterhrms.com/HunterCards.svc?wsdl',
            self::SECURITY_WSDL_URL => 'https://hunterdirectory.hunterhrms.com/SecurityService.svc?wsdl',
            self::SEARCH_WSDL_URL => 'https://huntersearchengine.hunterhrms.com/SearchEngineHunterService.svc?wsdl',
            self::NLS_EMPLOYERS_COUNT => 20,
            self::NLS_JOBS_COUNT => 20,
            self::NLS_HOT_JOBS_COUNT => 20,
            self::NLS_CACHE_TIME => 20,
            self::NLS_FLASH_CACHE => ''
        ];
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.1.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in NlsHunter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->nlsHunterApi, plugin_dir_url(__FILE__) . 'css/NlsHunter-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.1.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in NlsHunter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->nlsHunterApi, plugin_dir_url(__FILE__) . 'js/NlsHunter-admin.js', array('jquery'), $this->version, false);
    }

    public function NlsHunter_plugin_menu()
    {
        add_options_page(
            'HunterHRMS Options',
            'HunterHRMS',
            'manage_options',
            'NlsHunter-unique-identifier',
            array(
                $this,
                'NlsHunter_plugin_options'
            )
        );
    }

    // Load the plugin admin page partial.
    public function NlsHunter_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        if (isset($_POST) && count($_POST) > 0) {
            // Remove the auth key from previous settings
            update_option(NlsService::AUTH_KEY, null);
        }
        $nlsFromName = $this->getFieldValue(self::FROM_NAME);
        $nlsFromMail = $this->getFieldValue(self::FROM_MAIL);
        $nlsToMail = $this->getFieldValue(self::TO_MAIL);
        $nlsBccMail = $this->getFieldValue(self::BCC_MAIL);
        $nlsNsoftSupplierId = $this->getFieldValue(self::NSOFT_SUPPLIER_ID);
        $nlsNsoftHotJobsSupplierId = $this->getFieldValue(self::NSOFT_HOT_JOBS_SUPPLIER_ID);
        $nlsDirectoryWsdlUrl = $this->getFieldValue(self::DIRECTORY_WSDL_URL);
        $nlsCardsWsdlUrl = $this->getFieldValue(self::CARDS_WSDL_URL);
        $nlsSecurityWsdlUrl = $this->getFieldValue(self::SECURITY_WSDL_URL);
        $nlsSearchWsdlUrl = $this->getFieldValue(self::SEARCH_WSDL_URL);
        $nlsConsumerKey = $this->getFieldValue(self::NLS_CONSUMER_KEY);
        $nlsWebServiceDomain = $this->getFieldValue(self::NLS_WEB_SERVICE_DOMAIN);
        $nlsSecurityUsername = $this->getFieldValue(self::NLS_SECURITY_USERNAME);
        $nlsSecurityPassword = $this->getFieldValue(self::NLS_SECURITY_PASSWORD);
        $nlsJobsCount = $this->getFieldValue(self::NLS_JOBS_COUNT);
        $nlsHotJobsCount = $this->getFieldValue(self::NLS_HOT_JOBS_COUNT);
        $nlsEmployersCount = $this->getFieldValue(self::NLS_EMPLOYERS_COUNT);
        $nlsHunterAllJobsEn = $this->getFieldValue(self::NLS_HUNTER_ALL_JOBS_EN);
        $nlsHunterAllJobsHe = $this->getFieldValue(self::NLS_HUNTER_ALL_JOBS_HE);
        $nlsHunterEmployerDetailsEn = $this->getFieldValue(self::NLS_HUNTER_EMPLOYER_DETAILS_EN);
        $nlsHunterEmployerDetailsHe = $this->getFieldValue(self::NLS_HUNTER_EMPLOYER_DETAILS_HE);
        $nlsHunterEmployersEn = $this->getFieldValue(self::NLS_HUNTER_EMPLOYERS_EN);
        $nlsHunterEmployersHe = $this->getFieldValue(self::NLS_HUNTER_EMPLOYERS_HE);
        $nlsHunterJobDetailsEn = $this->getFieldValue(self::NLS_HUNTER_JOB_DETAILS_EN);
        $nlsHunterJobDetailsHe = $this->getFieldValue(self::NLS_HUNTER_JOB_DETAILS_HE);
        $nlsFlashCache = $this->getFieldValue(self::NLS_FLASH_CACHE, true);
        $nlsCacheTime = $this->getFieldValue(self::NLS_CACHE_TIME);

        require_once plugin_dir_path(__FILE__) . 'partials/NlsHunter-admin-display.php';
    }

    private function getFieldValue($field, $checkbox = false)
    {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            update_option($field, $value);
        } else if ($_POST && $checkbox) {
            update_option($field, '');
            return '';
        }
        $value = get_option($field, key_exists($field, $this->defaultValue) ? $this->defaultValue[$field] : '');
        return $value;
    }

    private function adminSelectPage($name, $value, $label)
    {
        $selectPage = '<label for="' . $name . '">' . $label . '</label>';
        $selectPage .= '<select name="' . $name . '">';
        $selectPage .=    '<option selected="selected" disabled="disabled" value="">';
        $selectPage .=    esc_attr(__($label)) . '</option>';
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->ID . '" ';
            $option .= ($page->ID == $value) ? 'selected="selected"' : '';
            $option .= '>';
            $option .= $page->post_title;
            $option .= '</option>';
            $selectPage .= $option;
        }
        $selectPage .= '</select>';
        return $selectPage;
    }
}
