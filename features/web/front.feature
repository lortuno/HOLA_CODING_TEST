Feature: Front
  In order to check the navigation works properly
  As a website user
  I need to be able to see the right messages
  on each page

  Scenario: Search for a page one not
    Given I am on homepage
    When I go to "/page/1"
    Then print current URL
    Then I should not see "Hello 1"

  Scenario: Search for a page two not logged
    Given I am on homepage
    When I go to "/page/2"
    Then print current URL
    Then I should not see "Hello 2"

  Scenario: Go to page 1 being logged
    Given I go to "/login"
    Then print current URL
    When I fill in the input box "#inputPassword" with "adminpassword"
    And I fill in "admin" for "username"
    And I press "Entrar"
    Then I should see "Logout"
    When I go to "/page/1"
    Then print current URL
    Then I should see "Hello 1"

  Scenario: Go to page 2 being logged
    Given I go to "/login"
    When I fill in the input box "#inputPassword" with "adminpassword"
    And I fill in "admin" for "username"
    And I press "Entrar"
    Then I should see "Logout"
    When I go to "/page/2"
    Then I should see "Hello 2"
    And I should see "Logout"

  Scenario: Check working logout
    Given I go to "/login"
    When I fill in the input box "#inputPassword" with "adminpassword"
    And I fill in "admin" for "username"
    And I press "Entrar"
    Then I should see "Logout"
    When I go to "/logout"
    Then I should see "Login"

  Scenario: User story redirection
    Given I go to "/page/1"
    Then I should see "Login"
    And the url should match "login"
    When I fill in the input box "#inputPassword" with "1234"
    And I fill in "admin" for "username"
    And I press "Entrar"
    Then I should see "Invalid credentials"
    Given I fill in the input box "#inputPassword" with "adminpassword"
    And I fill in "admin" for "username"
    And I press "Entrar"
    Then I should see "Logout"
    And the url should match "/page/1"
    Then print current URL
