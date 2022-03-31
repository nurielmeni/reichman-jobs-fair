<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             2.0.0
 * @package           NlsHunter - Reichman
 *
 * @wordpress-plugin
 * Plugin Name:       NlsHunter
 * Description:       API fot Niloosoft HunterHRMS System.
 * Version:           2.0.0
 * Author:            Meni Nurie
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       NlsHunter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 2.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('NlsHunter_VERSION', '2.0.3');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-NlsHunter-activator.php
 */
function activate_NlsHunter()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-NlsHunter-activator.php';
	NlsHunter_Activator::activate();
}

/**
 *  NLS Plugin path constant
 */
define('NLS__PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-NlsHunter-deactivator.php
 */
function deactivate_NlsHunter()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-NlsHunter-deactivator.php';
	NlsHunter_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_NlsHunter');
register_deactivation_hook(__FILE__, 'deactivate_NlsHunter');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-NlsHunter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_NlsHunter()
{

	$plugin = new NlsHunter();
	$plugin->run();
}
run_NlsHunter();
