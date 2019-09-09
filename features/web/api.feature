Feature: Api
  In order to check the api responses are correct
  As a website user
  I need to be able to see the right messages
  on each request

  Background: I am on homepage
  Scenario: Search for the api users
    Given  I go to "/api/users"
    Then I should see "id"

  Scenario: Create user when not logged
    Given  I go to "/api/user/create"
    Then the response status code should be 403
