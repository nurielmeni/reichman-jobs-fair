<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      2.0.0
 *
 * @package    NlsHunter
 * @subpackage NlsHunter/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    NlsHunter
 * @subpackage NlsHunter/includes
 * @author     Your Name <email@example.com>
 */

class NlsHunter
{
	const SEARCH_PAGE_SLUG = 'search_page';
	const SEARCH_RESULTS_PAGE_SLUG = 'search_results_page';
	const JOB_DETAILS_PAGE_SLUG = 'job_deatails_page';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      NlsHunter_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $NlsHunter    The string used to uniquely identify this plugin.
	 */
	protected $NlsHunter;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The job search results.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @var      array    $searchResultJobs    The jobs of the search result.
	 */
	private $searchResultJobs;

	/**
	 * The job details of the current job Id.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @var      array    $jobDetails    The jobs of the search result.
	 */
	private $jobDetails;

	/**
	 * The model instance
	 */
	private $model;

	/**
	 * The modules instance
	 */
	private $modules;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function __construct()
	{
		if (defined('NlsHunter_VERSION')) {
			$this->version = NlsHunter_VERSION;
		} else {
			$this->version = '2.0.0';
		}
		$this->NlsHunter = 'NlsHunter';

		$this->load_dependencies();
		$this->loader = new NlsHunter_Loader();

		$this->set_locale();

		// Instantiate the modules class
		try {
			$this->model = new NlsHunter_model();

			$this->modules = new NlsHunter_modules($this->model, $this->version);
		} catch (\Exception $e) {
			$this->addErrorToPage($e->getMessage(), "Error: Could not create Niloos Module.");
			return null;
			//throw new \Exception("Error: Could not create Niloos Module.\n" . $e->getMessage());
		}

		$this->define_admin_hooks();
		$this->define_shortcodes();
		//$this->add_fbf_widget();
		$this->define_public_hooks();

		/**
		 *  Load the search results or the job details
		 *  If Search Results page loads the jobs to $searchResultJobs
		 *  If JobDetails Loads the Job Data to $jobDetails
		 * */
	}

	public function addFlash($message, $subject = '', $type = 'info')
	{
		$flash = '<div class="nls-flash-message-wrapper flex">';
		$flash .= '<div class="nls-flash-message ' . $type . '">';
		$flash .= '<div><strong>' . $subject . '</strong> ' . $message . '</div><strong>x</strong>';
		$flash .= '</div></div>';
		return $flash;
	}

	public function addErrorToPage($message, $subject)
	{
		add_action('the_post', function () use ($message, $subject) {
			echo $this->addFlash(
				$message,
				$subject,
				'error'
			);
		});
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - NlsHunter_Loader. Orchestrates the hooks of the plugin.
	 * - NlsHunter_i18n. Defines internationalization functionality.
	 * - NlsHunter_Admin. Defines all hooks for the admin area.
	 * - NlsHunter_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-NlsHunter-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-NlsHunter-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-NlsHunter-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-NlsHunter-public.php';

		require_once 'class-NlsHunter-model.php';
		require_once 'class-NlsHunter-modules.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the NlsHunter_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new NlsHunter_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new NlsHunter_Admin($this->get_NlsHunter(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('admin_menu', $plugin_admin, 'NlsHunter_plugin_menu');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{
		// Set to true to get log messages in file /logs/default.log
		$debug = false;

		$plugin_public = new NlsHunter_Public($this, $this->get_version(), $debug);

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		//$this->loader->add_action('wp_body_open', $plugin_public, 'add_code_on_body_open');

		// THE AJAX APPLY CV ADD ACTIONS
		$this->loader->add_action('wp_ajax_apply_cv_function', $plugin_public, 'apply_cv_function');
		$this->loader->add_action('wp_ajax_nopriv_apply_cv_function', $plugin_public, 'apply_cv_function'); // need this to serve non logged in users
		$this->loader->add_action('wp_ajax_load_employers_function', $plugin_public, 'load_employers_function');
		$this->loader->add_action('wp_ajax_nopriv_load_employers_function', $plugin_public, 'load_employers_function'); // need this to serve non logged in users
		$this->loader->add_action('wp_ajax_load_jobs_function', $plugin_public, 'load_jobs_function');
		$this->loader->add_action('wp_ajax_nopriv_load_jobs_function', $plugin_public, 'load_jobs_function'); // need this to serve non logged in users
	}

	/**
	 * Register all of the shortcodes related to the plugin
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_shortcodes()
	{
		// Add Shortcode
		add_shortcode('nls_hunter_employers', [$this->modules, 'nlsHunterEmployers_render']);
		add_shortcode('nls_hunter_employer_details', [$this->modules, 'nlsHunterEmployerDetails_render']);
		add_shortcode('nls_hunter_job_details', [$this->modules, 'nlsHunterJobDetails_render']);
		add_shortcode('nls_hunter_all_jobs', [$this->modules, 'nlsHunterAllJobs_render']);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_NlsHunter()
	{
		return $this->NlsHunter;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 * @return    NlsHunter_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	/**
	 * Retrieve the search results for search results page
	 *
	 * @since     2.0.0
	 * @return    array    The search results.
	 */
	public function get_searchResults()
	{
		return $this->searchResultsUrl;
	}

	/**
	 * Retrieve the Job details for the current job ID.
	 *
	 * @since     2.0.0
	 * @return    array    The Job details for the current job ID.
	 */
	public function get_jobDetails()
	{
		return $this->jobDetails;
	}

	/**
	 * Retrieve the model object.
	 *
	 * @since     2.0.0
	 * @return    Object model.
	 */
	public function get_model()
	{
		return $this->model;
	}
}
