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
Admin tool "Direct SSO Entrypoint" - Settings
 *
 * @package    tool_directsso
 * @copyright  2022 Alexander Bias, lern.link GmbH <alexander.bias@lernlink.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG;

if ($hassiteconfig) {
    $settings = new admin_settingpage('tool_directsso', get_string('pluginname', 'tool_directsso', null, true));

    if ($ADMIN->fulltree) {
        // Require local library.
        require_once($CFG->dirroot.'/admin/tool/directsso/locallib.php');

        // Create introduction heading widget.
        $setting = new admin_setting_heading('tool_directsso/introductionheading',
                get_string('setting_introductionheading', 'tool_directsso', null, true),
                '');
        $settings->add($setting);

        // Create static explanation widget.
        $setting = new admin_setting_heading('tool_directsso/explanationstatic',
                '',
                get_string('setting_explanationstatic_desc', 'tool_directsso', null, true));
        $settings->add($setting);

        // Create configuration heading widget.
        $setting = new admin_setting_heading('tool_directsso/configurationheading',
                get_string('setting_configurationheading', 'tool_directsso', null, true),
                '');
        $settings->add($setting);

        // Create allowed authentication methods widget.
        $authoptions = ['oauth2' => get_string('pluginname', 'auth_oauth2')];
        $setting = new admin_setting_configmulticheckbox('tool_directsso/allowedauths',
                get_string('setting_allowedauths', 'tool_directsso', null, true),
                get_string('setting_allowedauths_desc', 'tool_directsso', null, true),
                [],
                $authoptions);
        $settings->add($setting);

        // Create allowed wantspage targets widget.
        $wantspageoptions = [
                TOOL_DIRECTSSO_WANTSPAGE_DASHBOARD => get_string('myhome', 'moodle'),
                TOOL_DIRECTSSO_WANTSPAGE_FRONTPAGE => get_string('sitehome', 'core'),
        ];
        $setting = new admin_setting_configmulticheckbox('tool_directsso/allowedwantspages',
                get_string('setting_allowedwantspages', 'tool_directsso', null, true),
                get_string('setting_allowedwantspages_desc', 'tool_directsso', null, true),
                [],
                $wantspageoptions);
        $settings->add($setting);

        // Create usable urls heading widget.
        $setting = new admin_setting_heading('tool_directsso/usableurlsheading',
                get_string('setting_usableurlsheading', 'tool_directsso', null, true),
                '');
        $settings->add($setting);

        // Create usable urls list widget.
        $setting = new admin_setting_heading('tool_directsso/usableurlslist',
                '',
                get_string('setting_usableurlsintro_desc', 'tool_directsso', null, true).
                        '<br />'.
                        get_string('setting_usableurlslist_desc', 'tool_directsso', null, true).
                        '<br />'.
                        tool_directsso_get_usable_urls());
        $settings->add($setting);
    }

    $ADMIN->add('authsettings', $settings);
}
