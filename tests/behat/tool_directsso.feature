@tool @tool_directsso
Feature: Using the admin tool Direct SSO
  In order to allow direct SSO logins
  As admin
  I need to be able to configure and provide direct SSO login URLs

  Background:
    Given a OAuth2 provider for Wiremock is configured
    And the following config values are set as admin:
      | name                     | value        |
      | curlsecurityblockedhosts |              |
      | curlsecurityallowedport  |              |
      | auth                     | email,oauth2 |
    And the following "courses" exist:
      | fullname | shortname | idnumber |
      | Course 1 | C1        | C1       |

  Scenario: Login as a user using OAuth2 (not yet related to the Direct SSO plugin, just to be sure)
    When I go to the login page
    And ".login-identityproviders .login-identityprovider-btn" "css_element" should exist
    And I follow "Wiremock"
    Then I should see "Welcome, John"

  Scenario Outline: Login as user using Direct SSO with Dashboard wantspage
    Given the following config values are set as admin:
      | name              | value       | plugin         |
      | allowedauths      | <auth>      | tool_directsso |
      | allowedwantspages | <wantspage> | tool_directsso |
    And I open the Direct SSO entrypoint URL with OAuth2 auth method and dashboard wantspage
    Then I <shouldseeornot1> see "Welcome, John"
    And I <shouldseeornot1> see "You are logged in as"
    And I <shouldseeornot2> see "Log in to Acceptance test site"

    Examples:
      | auth   | wantspage           | shouldseeornot1 | shouldseeornot2 |
      | oauth2 | dashboard           | should          | should not      |
      | oauth2 | dashboard,frontpage | should          | should not      |
      |        | dashboard           | should not      | should          |
      | oauth2 |                     | should not      | should          |

  Scenario Outline: Login as user using Direct SSO with frontpage wantspage
    Given the following config values are set as admin:
      | name              | value       | plugin         |
      | allowedauths      | <auth>      | tool_directsso |
      | allowedwantspages | <wantspage> | tool_directsso |
    And I open the Direct SSO entrypoint URL with OAuth2 auth method and frontpage wantspage
    Then I <shouldseeornot1> see "Available courses"
    And I <shouldseeornot1> see "You are logged in as"
    And I <shouldseeornot2> see "Log in to Acceptance test site"

    Examples:
      | auth   | wantspage           | shouldseeornot1 | shouldseeornot2 |
      | oauth2 | frontpage           | should          | should not      |
      | oauth2 | dashboard,frontpage | should          | should not      |
      |        | frontpage           | should not      | should          |
      | oauth2 |                     | should not      | should          |

  Scenario Outline: Login as user using Direct SSO with course wantspage
    Given the following config values are set as admin:
      | name              | value       | plugin         |
      | allowedauths      | <auth>      | tool_directsso |
      | allowedwantspages | <wantspage> | tool_directsso |
    And I open the Direct SSO entrypoint URL with OAuth2 auth method and course wantspage
    Then I <shouldseeornot1> see "Course 1"
    And I <shouldseeornot1> see "Enrolment options"
    And I <shouldseeornot1> see "You are logged in as"
    And I <shouldseeornot2> see "Log in to Acceptance test site"

    Examples:
      | auth   | wantspage         | shouldseeornot1 | shouldseeornot2 |
      | oauth2 | course            | should          | should not      |
      | oauth2 | dashboard,course  | should          | should not      |
      |        | course            | should not      | should          |
      | oauth2 |                   | should not      | should          |

  Scenario Outline: Login as user using Direct SSO with Dashboard wantspage, but wrong auth method (Countercheck)
    Given the following config values are set as admin:
      | name              | value       | plugin         |
      | allowedauths      | <auth>      | tool_directsso |
      | allowedwantspages | <wantspage> | tool_directsso |
    And I open the Direct SSO entrypoint URL with wrong auth method and dashboard wantspage
    Then I <shouldseeornot1> see "Welcome, John"
    And I <shouldseeornot1> see "You are logged in as"
    And I <shouldseeornot2> see "Log in to Acceptance test site"

    Examples:
      | auth   | wantspage | shouldseeornot1 | shouldseeornot2 |
      | oauth2 | dashboard | should not      | should          |

  Scenario Outline: Login as user using Direct SSO with course wantspage, but wrong course ID (Countercheck)
    Given the following config values are set as admin:
      | name              | value       | plugin         |
      | allowedauths      | <auth>      | tool_directsso |
      | allowedwantspages | <wantspage> | tool_directsso |
    And I open the Direct SSO entrypoint URL with OAuth2 auth method and wrong course ID wantspage
    Then I <shouldseeornot1> see "Course 1"
    And I <shouldseeornot1> see "Enrolment options"
    And I <shouldseeornot1> see "You are logged in as"
    And I <shouldseeornot2> see "Log in to Acceptance test site"

    Examples:
      | auth   | wantspage | shouldseeornot1 | shouldseeornot2 |
      | oauth2 | course    | should not      | should          |

  # Unfortunately, this can't be tested with Behat as Moodle core would throw a
  # 'A required parameter (courseid) was missing' exception when calling the URL without a course ID.
  # Scenario Outline: Login as user using Direct SSO with course wantspage, but without course ID (Countercheck)

  # Unfortunately, this can't be tested with Behat as Moodle core would throw a
  # 'Can't find data record in database table oauth2_issuer' exception when using a wrong issuer ID.
  # Scenario Outline: Login as user using Direct SSO with Dashboard wantspage, but wrong issuer ID (Countercheck)
