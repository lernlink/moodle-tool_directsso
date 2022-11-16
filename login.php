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
 * Admin tool "Direct SSO Entrypoint" - SSO Entrypoint
 *
 * @package    tool_directsso
 * @copyright  2022 Alexander Bias, lern.link GmbH <alexander.bias@lernlink.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// @codingStandardsIgnoreStart
// Let codechecker ignore the next line because otherwise it would complain about a missing login check
// after requiring config.php which is really not needed.
require_once('../../../config.php');
// @codingStandardsIgnoreEnd

// Require local library.
require_once($CFG->dirroot.'/admin/tool/directsso/locallib.php');

// Required parameters.
$auth = required_param('auth', PARAM_AUTH);
$wantspage = required_param('wantspage', PARAM_ALPHA);

// Set up page.
$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/admin/tool/directsso/login.php', ['auth' => $auth, 'wantspage' => $wantspage]));

// Get plugin config.
$config = get_config('tool_directsso');

// Prepare login page URL as fallback.
$loginpageurl = new moodle_url('/login/index.php');

// Prepare wantsURL based on the submitted wantspage parameter.
$allowedwantspages = explode(',', $config->allowedwantspages);
$wantsurl = null;
if ($wantspage === TOOL_DIRECTSSO_WANTSPAGE_FRONTPAGE && in_array(TOOL_DIRECTSSO_WANTSPAGE_FRONTPAGE, $allowedwantspages)) {
    $wantsurl = new moodle_url('/?redirect=0');
}

if ($wantspage === TOOL_DIRECTSSO_WANTSPAGE_DASHBOARD && in_array(TOOL_DIRECTSSO_WANTSPAGE_DASHBOARD, $allowedwantspages)) {
    $wantsurl = new moodle_url('/my');
}

// Pick redirect URL based on the submitted auth parameter.
$allowedauths = explode(',', $config->allowedauths);

// If the caller requested oauth2.
if($auth === 'oauth2')
{
    // In this case, we require one more parameter.
    $issuerid = required_param('id', PARAM_INT);

    // And the page has one more parameter.
    $PAGE->set_url(new moodle_url('/admin/tool/directsso/login.php',
            ['auth' => $auth, 'id' => $issuerid, 'wantspage' => $wantspage]));

    // If the admin allowed this auth method.
    if (in_array('oauth2', $allowedauths)) {
        // Compose the URl, add the sesskey (as OAuth2 expects it together with the wantsurl)
        // and redirect to the OAuth login page.
        $redirectparams = ['wantsurl' => $wantsurl, 'sesskey' => sesskey(), 'id' => $issuerid];
        $redirecturl = new moodle_url('/auth/oauth2/login.php', $redirectparams);
        redirect($redirecturl);
    }
}

redirect($loginpageurl);