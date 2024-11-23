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
 * Admin tool "Direct SSO Entrypoint" - Local library
 *
 * @package    tool_directsso
 * @copyright  2022 Alexander Bias, lern.link GmbH <alexander.bias@lernlink.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Contants which are used in the plugin settings.
define('TOOL_DIRECTSSO_WANTSPAGE_DASHBOARD', 'dashboard');
define('TOOL_DIRECTSSO_WANTSPAGE_FRONTPAGE', 'frontpage');
define('TOOL_DIRECTSSO_WANTSPAGE_COURSE', 'course');

/**
 * Helper function which returns a HTML list of usable URls based on the stored plugin configuration.
 *
 * @return string
 */
function tool_directsso_get_usable_urls() {
    global $DB;

    // Get config.
    $config = get_config('tool_directsso');

    // Explode the plugin configurations.
    if (isset($config->allowedauths) && $config->allowedauths != '') {
        $allowedauths = explode(',', $config->allowedauths);
    } else {
        $allowedauths = [];
    }
    if (isset($config->allowedwantspages) && $config->allowedwantspages != '') {
        $allowedwantspages = explode(',', $config->allowedwantspages);
    } else {
        $allowedwantspages = [];
    }

    // Initialize an array to hold the URL parameters.
    $urls = [];

    // Iterate over the auth methods.
    foreach ($allowedauths as $auth) {
        // Iterate over the wantspages.
        foreach ($allowedwantspages as $wp) {
            // If we are dealing with OAuth here, we have to iterate over all configured OAuth issuers.
            if ($auth == 'oauth2') {
                // Get existing OAuth issuers.
                $oauthissuer = $DB->get_records('oauth2_issuer', [], '', 'id');

                // Iterate over the issuers.
                foreach ($oauthissuer as $oi) {
                    // Initialize an array to hold the params of this URL.
                    $urlparams = [];

                    // Remember the common auth URL param first.
                    $urlparams['auth'] = $auth;

                    // Remember the additional OAuth id URL param next.
                    $urlparams['id'] = $oi->id;

                    // Remember the remaining common URL params.
                    $urlparams['wantspage'] = $wp;

                    // Add the URL to the stack.
                    $urls[] = $urlparams;
                }

                // Otherwise.
            } else {
                // Initialize an array to hold the params of this URL.
                $urlparams = [];

                // Remember the common URL params.
                $urlparams['auth'] = $auth;
                $urlparams['wantspage'] = $wp;

                // Add the URL to the stack.
                $urls[] = $urlparams;
            }
        }
    }

    // If the course wantspage is allowed, we have to add the courseid to each of their URLs.
    if (in_array(TOOL_DIRECTSSO_WANTSPAGE_COURSE, $allowedwantspages)) {
        // Iterate over the URLs.
        foreach ($urls as &$u) {
            // If we have a course wantspage now.
            if ($u['wantspage'] == TOOL_DIRECTSSO_WANTSPAGE_COURSE) {
                // Add the courseid parameter.
                $u['courseid'] = 'COURSEID';
            }
        }

        // Unset the reference on the last element - see https://www.php.net/manual/en/control-structures.foreach.php.
        unset ($u);
    }

    // If there wasn't any URL found, return directly.
    if (count($urls) < 1) {
        return get_string('setting_usableurls_none', 'tool_directsso');
    }

    // Compose the HTML code.
    $html = html_writer::start_tag('ul');
    foreach ($urls as $u) {
        $url = new moodle_url('/admin/tool/directsso/login.php', $u);
        $html .= html_writer::tag('li', html_writer::link($url, $url->out()));
    }
    $html .= html_writer::end_tag('ul');

    // Return.
    return $html;
}
