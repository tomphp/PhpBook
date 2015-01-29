Feature: View customer
  In order to look after a customer and keep them happy
  As an Employee
  I must be able to view their details

  Scenario: View existing customer
    Given there is a customer named "John" with email address "john@gmail.com"
    When I fetch details for customer named "John"
    Then I should see the email address "john@gmail.com"

  Scenario: Try and view customer which doesn't exist
    When I fetch details for customer named "Kyza Soze"
    Then I should receiver a not found error
