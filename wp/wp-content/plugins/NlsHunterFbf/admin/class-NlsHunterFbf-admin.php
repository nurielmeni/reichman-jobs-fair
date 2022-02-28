<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.1.0
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/admin
 * @author     Meni Nuriel <nurielmeni@gmail.com>
 */
class NlsHunterFbf_Admin
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
    const NLS_SEARCH_RESULTS_PAGE_EN = 'nlsSearchResultsPage_en';
    const NLS_SEARCH_RESULTS_PAGE_HE = 'nlsSearchResultsPage_he';
    const NLS_JOB_DETAILS_PAGE_EN = 'nlsJobDetailsPage_en';
    const NLS_JOB_DETAILS_PAGE_HE = 'nlsJobDetailsPage_he';

    private $defaultValue;
    /**
     * The ID of this plugin.
     *
     * @since    1.1.0
     * @access   private
     * @var      string    $NlsHunterFbf    The ID of this plugin.
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
     * @param      string    $NlsHunterFbf       The name of this plugin.
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
         * defined in NlsHunterFbf_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunterFbf_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->nlsHunterApi, plugin_dir_url(__FILE__) . 'css/NlsHunterFbf-admin.css', array(), $this->version, 'all');
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
         * defined in NlsHunterFbf_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The NlsHunterFbf_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->nlsHunterApi, plugin_dir_url(__FILE__) . 'js/NlsHunterFbf-admin.js', array('jquery'), $this->version, false);
    }

    public function NlsHunterFbf_plugin_menu()
    {
        add_options_page(
            'HunterHRMS Options',
            'HunterHRMS',
            'manage_options',
            'NlsHunterFbf-unique-identifier',
            array(
                $this,
                'NlsHunterFbf_plugin_options'
            )
        );
    }

    // Load the plugin admin page partial.
    public function NlsHunterFbf_plugin_options()
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
        $nlsSearchResultsPageEn = $this->getFieldValue(self::NLS_SEARCH_RESULTS_PAGE_EN);
        $nlsSearchResultsPageHe = $this->getFieldValue(self::NLS_SEARCH_RESULTS_PAGE_HE);
        $nlsJobDetailsPageEn = $this->getFieldValue(self::NLS_JOB_DETAILS_PAGE_EN);
        $nlsJobDetailsPageHe = $this->getFieldValue(self::NLS_JOB_DETAILS_PAGE_HE);

        require_once plugin_dir_path(__FILE__) . 'partials/NlsHunterFbf-admin-display.php';
    }

    private function getFieldValue($field)
    {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            update_option($field, $value);
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
