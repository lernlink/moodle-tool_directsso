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

* The plugin has a good coverage with Behat tests which test all of the plugin's user stories.
* To run the automated tests, a running OAuth2 server is necessary. This is realized in the Github actions workflow with Wiremock. If you want to run the automated tests locally, you have to adapt the tests to a local OAuth2 server yourself.
If you do not have a running OAuth2 server at hand, you can try to spin up Wiremock which is used in Github actions with this docker-compose command:
```
docker-compose -p wiremock -f admin/tool/directsso/tests/fixtures/wiremock-docker-compose.yml up
```


Manual tests
------------

* Even though there are automated tests, as the plugin deals with the communication to a backend system, manual tests should be carried out to see if the plugin's functionality really works with a real OAuth2 server.
* Additionally, if you look at the Behat feature file, you will see that there are some scenarios still commented out. If you have time, you should test them manually or write a Behat test for it.


Visual checks
-------------

* There aren't any additional visual checks in the Moodle GUI needed to upgrade this plugin.
