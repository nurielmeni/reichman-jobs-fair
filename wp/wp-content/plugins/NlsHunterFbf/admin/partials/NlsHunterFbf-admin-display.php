<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    NlsHunterFbf
 * @subpackage NlsHunterFbf/admin/partials
 */


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="NlsHunterFbf_settings" class="wrap">
    <h1>Niloos HunterHRMS Settings Page</h1>

    <form method="POST">
        <section id="email-settings">
            <h2 class="section-title">Email Settings</h2>
            <label for="nlsFromName">From Name</label>
            <input type="text" name="nlsFromName" id="nlsFromName" value="<?= $nlsFromName ?>">
            <br>

            <label for="nlsFromMail">From Mail</label>
            <input type="text" name="nlsFromMail" id="nlsFromMail" value="<?= $nlsFromMail ?>">
            <br>

            <label for="nlsToMail">To Mail</label>
            <input type="text" name="nlsToMail" id="nlsToMail" value="<?= $nlsToMail ?>">
            <br>

            <label for="nlsToMail">Bcc Mail (testing)</label>
            <input type="text" name="nlsBccMail" id="nlsBccMail" value="<?= $nlsBccMail ?>">
            <br>
        </section>

        <section id="api-service-settings">
            <h2 class="section-title">API Service Settings</h2>
            <label for="nlsDirectoryWsdlUrl">Directory WSDL</label>
            <input type="text" name="nlsDirectoryWsdlUrl" id="nlsDirectoryWsdlUrl" value="<?= $nlsDirectoryWsdlUrl ?>">
            <br>

            <label for="nlsCardsWsdlUrl">Cards WSDL</label>
            <input type="text" name="nlsCardsWsdlUrl" id="nlsCardsWsdlUrl" value="<?= $nlsCardsWsdlUrl ?>">
            <br>

            <label for="nlsSecurityWsdlUrl">Security WSDL</label>
            <input type="text" name="nlsSecurityWsdlUrl" id="nlsSecurityWsdlUrl" value="<?= $nlsSecurityWsdlUrl ?>">
            <br>

            <label for="nlsSearchWsdlUrl">Search WSDL</label>
            <input type="text" name="nlsSearchWsdlUrl" id="nlsSearchWsdlUrl" value="<?= $nlsSearchWsdlUrl ?>">
            <br>
        </section>

        <section id="application-settings">
            <h2 class="section-title">Application Settings</h2>
            <label for="nlsNsoftSupplierId">Supplier ID</label>
            <input type="text" name="nlsNsoftSupplierId" id="nlsNsoftSupplierId" value="<?= $nlsNsoftSupplierId ?>">
            <br>
            <label for="nlsNsoftHotJobsSupplierId">Hot Jobs Supplier ID</label>
            <input type="text" name="nlsNsoftHotJobsSupplierId" id="nlsNsoftHotJobsSupplierId" value="<?= $nlsNsoftHotJobsSupplierId ?>">
            <br>
        </section>

        <section id="login-settings">
            <h2 class="section-title">Login Settings</h2>
            <label for="nlsConsumerKey">Consumer</label>
            <input type="text" name="nlsConsumerKey" id="nlsConsumerKey" value="<?= $nlsConsumerKey ?>">
            <br>

            <label for="nlsWebServiceDomain">Domain</label>
            <input type="text" name="nlsWebServiceDomain" id="nlsWebServiceDomain" value="<?= $nlsWebServiceDomain ?>">
            <br>

            <label for="nlsSecurityUsername">Username</label>
            <input type="text" name="nlsSecurityUsername" id="nlsSecurityUsername" value="<?= $nlsSecurityUsername ?>">
            <br>

            <label for="nlsSecurityPassword">Password</label>
            <input type="text" name="nlsSecurityPassword" id="nlsSecurityPassword" value="<?= $nlsSecurityPassword ?>">
            <br>
        </section>

        <section id="job-search-settings">
            <h2 class="section-title">Search Settings</h2>

            <label for="nlsJobsCount">Jobs Count</label>
            <input type="number" name="nlsJobsCount" id="nlsJobsCount" value="<?= $nlsJobsCount ?>">
            <br>
            <label for="nlsHotJobsCount">Hot Jobs Count</label>
            <input type="number" name="nlsHotJobsCount" id="nlsHotJobsCount" value="<?= $nlsHotJobsCount ?>">
            <br>
        </section>
        <br>
        <section id="hunter_page_settings">
            <h2 class="section-title">Hunter Page Settings</h2>
            <p>[Shortcodes]</p>
            <?= $this->adminSelectPage(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_EN, $nlsSearchResultsPageEn, 'Search Results Page EN') ?>
            <small>* The page must have the slug <i>[nls_hunter_search_results]</i></small>
            <br>
            <?= $this->adminSelectPage(NlsHunterFbf_Admin::NLS_SEARCH_RESULTS_PAGE_HE, $nlsSearchResultsPageHe, 'Search Results Page HE') ?>
            <small>* The page must have the slug <i>[nls_hunter_search_results]</i></small>
            <br>
            <hr>
            <?= $this->adminSelectPage(NlsHunterFbf_Admin::NLS_JOB_DETAILS_PAGE_EN, $nlsJobDetailsPageEn, 'Job Details Page EN') ?>
            <small>* The page must have the slug <i>[nls_hunter_job_details]</i></small>
            <br>
            <?= $this->adminSelectPage(NlsHunterFbf_Admin::NLS_JOB_DETAILS_PAGE_HE, $nlsJobDetailsPageHe, 'Job Details Page HE') ?>
            <small>* The page must have the slug <i>[nls_hunter_job_details]</i></small>
            <br>
            <small>* Hunter hot jobs module <i>[nls_hot_jobs]</i></small>
            <small>* Hunter categories module <i>[nls_hunter_categories]</i></small>
        </section>

        <section>
            <h2>Help Details</h2>
            <p><label>Short Code - FBF</label>nls_hunter_fbf</p>
        </section>
        <input type="submit" value="Save" class="button button-primary button-large">
    </form>
</div>