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
 * Admin tool "Direct SSO Entrypoint" - Language pack
 *
 * @package    tool_directsso
 * @copyright  2022 Alexander Bias, lern.link GmbH <alexander.bias@lernlink.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = 'Direct SSO Entrypoint';
$string['privacy:metadata'] = 'The Direct SSO Entrypoint plugin does not store any personal data.';
$string['setting_allowedauths'] = 'Allowed authentication plugins';
$string['setting_allowedauths_desc'] = 'With this setting, you control if an auth method can be used with the direct SSO entrypoint or not. Please note that not all installed and enabled auth methods are available here, only selected auth methods where support has been implemented into this plugin are available.';
$string['setting_allowedwantspages'] = 'Allowed wantspage targets';
$string['setting_allowedwantspages_desc'] = 'With this setting, you control to where the user can be redirected by the direct SSO entrypoint. Please note that the user can only be redirected to selected pages and not to arbitrary URLs within Moodle.';
$string['setting_configurationheading'] = 'Configuration';
$string['setting_explanationstatic_desc'] = 'This admin tool provides an entrypoint which can be used as persistent URL where external websites can redirect users directly to the Moodle SSO mechanisms without ever showing the login page to the user and especially without the need that the user clicks on a SSO button on the login page.';
$string['setting_introductionheading'] = 'Introduction';
$string['setting_usableurls_none'] = 'None';
$string['setting_usableurlsheading'] = 'Usable URLs';
$string['setting_usableurlsintro_desc'] = '<p>The entrypoint URLs are composed from multiple elements:</p><ul><li>The Moodle site\'s domain</li><li>The path to the entrypoint PHP script</li><li>The auth parameter which indicates the requested auth method</li><li>The wantspage parameter which indicates to which page the user should be redirected to after the SSO login</li><li>If the requested auth method allows to configure multiple auth backends: The id parameter which indicates the id of the configured auth backend.</li><li>If you selected course as wantspage target: The courseid parameter which indicates the particular course id to which the user should be redirected.</li></ul>';
$string['setting_usableurlslist_desc'] = 'Based on the stored configuration above, the following entrypoint URLs are usable currently:';
