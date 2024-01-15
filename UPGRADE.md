Upgrading this plugin
=====================

This is an internal documentation for plugin developers with some notes what has to be considered when updating this plugin to a new Moodle major version.

General
-------

* Generally, this is a quite simple plugin with just one purpose.
* It does not rely on any fluctuating library functions and should remain quite stable between Moodle major versions. 
* Thus, the upgrading effort is low.


Upstream changes
----------------

* This plugin does not inherit or copy anything from upstream sources. 
* However, as it redirects especially to the auth_oauth2 auth plugin, you should have a look if anything important has changed within /auth/oauth2/login.php in Moodle core.


Automated tests
---------------

* Due to the fact that the plugin deals with links from external applications to Moodle and with identity backend providers, there aren't any automated test (yet).


Manual tests
------------

### Prerequisites:

* Install the plugin to Moodle
  
### Test OAuth backend

* Login as admin
  
* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2" 
* In the "Allowed wantspage targets" setting, enable "Dashboard"
* Save the settings
* Pick the usable URL for the SSO entrypoint

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result: 

* You are logged into Moodle
* You are on the Moodle Dashboard

### Test backend disabling

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Dashboard"
* Save the settings
* Pick the usable URL for the SSO entrypoint
* In the "Allowed authentication plugins" setting, disable "OAuth 2"
* Save the settings again

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are not logged into Moodle
* You are on the Moodle login page

### Test wantspage disabling

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Dashboard"
* Save the settings
* Pick the usable URL for the SSO entrypoint
* In the "Allowed wantspage targets" setting, disable all options
* Save the settings again

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are not logged into Moodle
* You are on the Moodle login page

### Test Dashboard wantspage target

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Dashboard"
* Save the settings
* Pick the usable URL for the SSO entrypoint

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are logged into Moodle
* You are on the Moodle Dashboard

### Test Frontpage wantspage target

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Frontpage"
* Save the settings
* Pick the usable URL for the SSO entrypoint

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are logged into Moodle
* You are on the Moodle Frontpage

### Test Course wantspage target

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend
* Create a course and enrol yourself into the course

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Course"
* Save the settings
* Pick the usable URL for the SSO entrypoint and replace the COURSEID placeholder with the ID of the course which you just created 

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are logged into Moodle
* You are on the Moodle course

### Test Course wantspage target without course ID

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Course"
* Save the settings
* Pick the usable URL for the SSO entrypoint and remove the courseid parameter from the URL

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are not logged into Moodle
* You see an error message which informs you that the required courseid parameter is missing

### Test (non-existing) disabled wantspage fallback

* Login as admin

* Go to Site administration -> Server -> OAuth 2 services
* Add a working OAuth 2 backend

* Go to Site administration -> Plugins -> Authentication -> Direct SSO Entrypoint
* In the "Allowed authentication plugins" setting, enable "OAuth 2"
* In the "Allowed wantspage targets" setting, enable "Frontpage" and "Dashboard"
* Save the settings
* Pick the usable URL for the SSO entrypoint to the frontpage
* In the "Allowed wantspage targets" setting, disable "Frontpage" but keep "Dashboard" enabled
* Save the settings again

* Open a new private browser window
* Make sure that you are logged in with the SSO provider, but not into Moodle
* Go to the SSO entrypoint URL

#### Expected result:

* You are not logged into Moodle
* You are on the Moodle login page
