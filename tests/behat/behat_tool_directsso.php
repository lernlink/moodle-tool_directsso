<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin tool "Direct SSO Entrypoint" - Behat step definitions
 *
 * @package    tool_directsso
 * @copyright  2024 Alexander Bias <bias@alexanderbias.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');

/**
 * Step definitions.
 *
 * @package    tool_directsso
 * @copyright  2024 Alexander Bias <bias@alexanderbias.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_tool_directsso extends behat_base {
    /**
     * The name of the OAuth2 issuer for Wiremock.
     */
    private const OAUTH2_ISSUER_NAME = 'OAuth2 Wiremock';

    /**
     * The step makes sure that a OAuth2 provider is configured in a way that it can connect to a running Wiremock instance.
     *
     * @Given /^a OAuth2 provider for Wiremock is configured/
     * @return void
     */
    public function a_oauth2_provider_for_wiremock_is_configured() {
        global $DB;

        // Check if the OAuth2 provider already exists.
        if ($DB->record_exists('oauth2_issuer', ['name' => self::OAUTH2_ISSUER_NAME])) {
            // Return directly.
            return;
        }

        // Prepare the mdl_oauth2_issuer table entry.
        $oauth2issuer = [
            'timecreated' => 1732360328,
            'timemodified' => 1732399248,
            'usermodified' => 2,
            'name' => self::OAUTH2_ISSUER_NAME,
            'image' => '',
            'baseurl' => 'http://localhost:8080/oauth2',
            'clientid' => 'foo',
            'clientsecret' => 'bar',
            'loginscopes' => 'openid profile email',
            'loginscopesoffline' => 'openid profile email',
            'loginparams' => '',
            'loginparamsoffline' => '',
            'alloweddomains' => '',
            'scopessupported' => null,
            'enabled' => 1,
            'showonloginpage' => 2,
            'basicauth' => 1,
            'sortorder' => 0,
            'requireconfirmation' => 0,
            'servicetype' => '',
            'loginpagename' => self::OAUTH2_ISSUER_NAME,
        ];

        // Insert the record into the database and remember the ID of the newly added record.
        $issuerid = $DB->insert_record('oauth2_issuer', $oauth2issuer);

        // Prepare the mdl_oauth2_endpoint table entries.
        $oauth2endpoint1 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'name' => 'token_endpoint',
            'url' => 'http://localhost:8080/oauth/token',
            'issuerid' => $issuerid,
        ];
        $oauth2endpoint2 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'name' => 'userinfo_endpoint',
            'url' => 'http://localhost:8080/oauth/userinfo',
            'issuerid' => $issuerid,
        ];
        $oauth2endpoint3 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'name' => 'authorization_endpoint',
            'url' => 'http://localhost:8080/oauth/authorize',
            'issuerid' => $issuerid,
        ];

        // Prepare the mdl_oauth2_user_field_mapping table entries.
        $oauth2userfieldmapping1 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'issuerid' => $issuerid,
            'externalfield' => 'email',
            'internalfield' => 'email',
        ];
        $oauth2userfieldmapping2 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'issuerid' => $issuerid,
            'externalfield' => 'given_name',
            'internalfield' => 'firstname',
        ];
        $oauth2userfieldmapping3 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'issuerid' => $issuerid,
            'externalfield' => 'family_name',
            'internalfield' => 'lastname',
        ];
        $oauth2userfieldmapping4 = [
            'timecreated' => 1732360420,
            'timemodified' => 1732399262,
            'usermodified' => 2,
            'issuerid' => $issuerid,
            'externalfield' => 'preferred_username',
            'internalfield' => 'username',
        ];

        // Insert the records into the database.
        $DB->insert_record('oauth2_endpoint', $oauth2endpoint1);
        $DB->insert_record('oauth2_endpoint', $oauth2endpoint2);
        $DB->insert_record('oauth2_endpoint', $oauth2endpoint3);
        $DB->insert_record('oauth2_user_field_mapping', $oauth2userfieldmapping1);
        $DB->insert_record('oauth2_user_field_mapping', $oauth2userfieldmapping2);
        $DB->insert_record('oauth2_user_field_mapping', $oauth2userfieldmapping3);
        $DB->insert_record('oauth2_user_field_mapping', $oauth2userfieldmapping4);
    }

    /**
     * Open the login page.
     *
     * @Given /^I go to the login page$/
     */
    public function i_go_to_the_login_page() {
        $this->execute('behat_general::i_visit', ['/login/index.php']);
    }

    /**
     * Opens the Direct SSO entrypoing URL with OAuth2 auth method and dashboard wantspage.
     *
     * @When I open the Direct SSO entrypoint URL with OAuth2 auth method and dashboard wantspage
     * @return void
     */
    public function i_open_the_direct_sso_entrypoint_url_oauth2_dashboard() {
        $issuer = $this->get_oauth2_issuer_id();
        $url = new \core\url('/admin/tool/directsso/login.php', ['auth' => 'oauth2', 'id' => $issuer, 'wantspage' => 'dashboard']);
        $this->execute('behat_general::i_visit', [$url]);
    }

    /**
     * Opens the Direct SSO entrypoing URL with OAuth2 auth method and frontpage wantspage.
     *
     * @When I open the Direct SSO entrypoint URL with OAuth2 auth method and frontpage wantspage
     * @return void
     */
    public function i_open_the_direct_sso_entrypoint_url_oauth2_frontpage() {
        $issuer = $this->get_oauth2_issuer_id();
        $url = new \core\url('/admin/tool/directsso/login.php', ['auth' => 'oauth2', 'id' => $issuer, 'wantspage' => 'frontpage']);
        $this->execute('behat_general::i_visit', [$url]);
    }

    /**
     * Opens the Direct SSO entrypoing URL with OAuth2 auth method and course wantspage.
     *
     * @When I open the Direct SSO entrypoint URL with OAuth2 auth method and course wantspage
     * @return void
     */
    public function i_open_the_direct_sso_entrypoint_url_oauth2_course() {
        $issuer = $this->get_oauth2_issuer_id();
        $courseid = $this->get_wantspage_course_id();
        $url = new \core\url('/admin/tool/directsso/login.php', ['auth' => 'oauth2', 'id' => $issuer, 'wantspage' => 'course',
                'courseid' => $courseid]);
        $this->execute('behat_general::i_visit', [$url]);
    }

    /**
     * Opens the Direct SSO entrypoing URL with wrong auth method and dashboard wantspage.
     *
     * @When I open the Direct SSO entrypoint URL with wrong auth method and dashboard wantspage
     * @return void
     */
    public function i_open_the_direct_sso_entrypoint_url_wrongauth_dashboard() {
        $issuer = $this->get_oauth2_issuer_id();
        $url = new \core\url('/admin/tool/directsso/login.php', ['auth' => 'wrong', 'id' => $issuer, 'wantspage' => 'dashboard']);
        $this->execute('behat_general::i_visit', [$url]);
    }

    /**
     * Opens the Direct SSO entrypoint URL with OAuth2 auth method and wrong course ID wantspage.
     *
     * @When I open the Direct SSO entrypoint URL with OAuth2 auth method and wrong course ID wantspage
     * @return void
     */
    public function i_open_the_direct_sso_entrypoint_url_oauth2_wrongcourse() {
        $issuer = $this->get_oauth2_issuer_id();
        $courseid = $this->get_wantspage_course_id();
        $url = new \core\url('/admin/tool/directsso/login.php', ['auth' => 'oauth2', 'id' => $issuer, 'wantspage' => 'course',
                'courseid' => $courseid + 100]);
        $this->execute('behat_general::i_visit', [$url]);
    }

    /**
     * Get the ID of the OAuth2 issuer with the name "OAuth2 Wiremock".
     *
     * @return int
     */
    private function get_oauth2_issuer_id() {
        global $DB;

        // Basically, we would not expect more than one issuer with the name "OAuth2 Wiremock".
        // However, we are using get_records() here to be on the safe side.
        $issuers = $DB->get_records('oauth2_issuer', ['name' => self::OAUTH2_ISSUER_NAME], 'id ASC', 'id');

        return array_pop($issuers)->id;
    }

    /**
     * Get the ID of the course with the shortname "C1".
     *
     * @return int
     */
    private function get_wantspage_course_id() {
        global $DB;

        return $DB->get_field('course', 'id', ['shortname' => 'C1']);
    }
}
