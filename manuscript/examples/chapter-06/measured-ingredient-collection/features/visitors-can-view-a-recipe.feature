Feature: A visitor can view a recipe
    In order to view a recipe
    As a visitor
    I need to be able see a recipe and all it's measured ingredients

    Scenario: Requesting a recipe by an ID which does not exist
        Given there are no recipes
        When I request to view recipe using a bad id
        Then I should see an invalid id error

    Scenario: Viewing a recipe
        Given there's a recipe for "Mojito" by user "tom" with 5 stars
        And the recipe for "Mojito" has method:
          """
          Instructions to make a Mojito.
          """
        And the recipe for "Mojito" has measured ingredients:
          | name        | amount | unit  |
          | White Run   | 2      | fl oz |
          | Mint Leaves | 8      |       |
          | Lime        | 1      |       |
          | Sugar       | 2      | tsp   |
          | Soda        |        |       |
        When I request to view recipe for "Mojito"
        Then I should see a field "name" with value of "Mojito"
        And I should see a field "username" with value of "tom"
        And I should see a field "rating" with value of "5.0"
        And I should see a field "method" with value:
          """
          Instructions to make a Mojito.
          """
        And I should see a list of measured ingredients containing:
          | name        | amount | unit  |
          | White Run   | 2      | fl oz |
          | Mint Leaves | 8      |       |
          | Lime        | 1      |       |
          | Sugar       | 2      | tsp   |
          | Soda        |        |       |
