moodle-tool_directsso
=====================

[![Moodle Plugin CI](https://github.com/lernlink/moodle-tool_directsso/actions/workflows/moodle-plugin-ci.yml/badge.svg?branch=main)](https://github.com/lernlink/moodle-tool_directsso/actions?query=workflow%3A%22Moodle+Plugin+CI%22+branch%3Amain)

Moodle admin tool which provides an entrypoint that can be used as persistent URL where external websites can redirect users directly to the Moodle SSO mechanisms without ever showing the login page to the user and especially without the need that the user clicks on a SSO button on the login page.


Requirements
------------

This plugin requires Moodle 5.1+


Motivation for this plugin
--------------------------

Moodle core allows admins to configure auth backends which provide SSO functionalities to the Moodle users. One of the most important auth backends with this SSO functionality is OAuth2.

If you add OAuth2 to your Moodle instance, an additional login button will appear on the login page which allows users to login via OAuth instead of logging in with the Moodle login form. By design, the URL of this OAuth button on the login form contains the Moodle sesskey which is bount to an active Moodle session.

Because of this design choice, admins who want to link from external websites (like corporation portals) to Moodle and want the users to be directly logged in via SSO, do not have a possibility to realize this goals with Moodle core tools.
This tool solves this problem by providing such a persistent SSO URL within Moodle. Additionally, as the SSO login into Moodle will happen really transparently for the user, the tool makes sure that the users can't be maliciously redirected to any Moodle page / URL after the SSO login so that CSRF attacks are avoided.


Installation
------------

Install the plugin like any other plugin to folder
/admin/tool/directsso

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

After installing the plugin, it does not do anything to Moodle yet.

To configure the plugin and its behaviour, please visit:
Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint

There, you find two settings:

### 1. Allowed authentication plugins

With this setting, you control if an auth method can be used with the direct SSO entrypoint or not. Please note that not all installed and enabled auth methods are available here, only selected auth methods where support has been implemented into this plugin are available.

### 2. Allowed wantspage targets

With this setting, you control to where the user can be redirected by the direct SSO entrypoint. Please note that the user can only be redirected to selected pages and not to arbitrary URLs within Moodle.

### Usable URLs

On the same page, you find a list of usable URLs which you can use to link to Moodle.


Security implications
---------------------

This tool does not add any new authentication mechanisms to Moodle. It also does not weaken any existing authentication or SSO mechanisms.


Capabilities
------------

This plugin does not add any additional capabilities.


Scheduled Tasks
---------------

This plugin does not add any additional scheduled tasks.


Theme support
-------------

This plugin acts behind the scenes, therefore it should work with all Moodle themes.
This plugin is developed and tested on Moodle Core's Boost theme.
It should also work with Boost child themes, including Moodle Core's Classic theme. However, we can't support any other theme than Boost.


Plugin repositories
-------------------

This plugin is published and regularly updated in the Moodle plugins repository:
http://moodle.org/plugins/view/tool_directsso

The latest development version can be found on Github:
https://github.com/lernlink/moodle-tool_directsso


Bug and problem reports
-----------------------

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.

Please report bugs and problems on Github:
https://github.com/lernlink/moodle-tool_directsso/issues


Community feature proposals
---------------------------

The functionality of this plugin is primarily implemented for the needs of our clients and published as-is to the community. We are aware that members of the community will have other needs and would love to see them solved by this plugin.

Please issue feature proposals on Github:
https://github.com/lernlink/moodle-tool_directsso/issues

Please create pull requests on Github:
https://github.com/lernlink/moodle-tool_directsso/pulls


Paid support
------------

We are always interested to read about your issues and feature proposals or even get a pull request from you on Github. However, please note that our time for working on community Github issues is limited.

As certified Moodle Partner, we also offer paid support for this plugin. If you are interested, please have a look at our services on https://lern.link or get in touch with us directly via team@lernlink.de.


Moodle release support
----------------------

This plugin is only maintained for the most recent major release of Moodle as well as the most recent LTS release of Moodle. Bugfixes are backported to the LTS release. However, new features and improvements are not necessarily backported to the LTS release.

Apart from these maintained releases, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major release - please let us know on Github.

If you are running a legacy version of Moodle, but want or need to run the latest version of this plugin, you can get the latest version of the plugin, remove the line starting with $plugin->requires from version.php and use this latest plugin version then on your legacy Moodle. However, please note that you will run this setup completely at your own risk. We can't support this approach in any way and there is an undeniable risk for erratic behavior.


Translating this plugin
-----------------------

This Moodle plugin is shipped with an english language pack only. All translations into other languages must be managed through AMOS (https://lang.moodle.org) by what they will become part of Moodle's official language pack.

As the plugin creator, we manage the translation into german for our own local needs on AMOS. Please contribute your translation into all other languages in AMOS where they will be reviewed by the official language pack maintainers for Moodle.


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


Maintainers
-----------

lern.link GmbH\
Alexander Bias


Copyright
---------

lern.link GmbH\
Alexander Bias
