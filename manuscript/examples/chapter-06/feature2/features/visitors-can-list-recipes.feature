Feature: A visitor can view a list of recipes
    In order to view a list of recipes
    As a visitor
    I need to be able get a list of recipes

    Scenario: View an empty list of recipes
        Given there are no recipes
        When I request a list of recipes
        Then I should see an empty list

   Scenario: Viewing a list with 1 item
        Given there's a recipe for "Mojito" by user "tom" with 5 stars
        When I request a list of recipes
        Then I should see a list of recipes containing:
            | name   | rating | user |
            | Mojito | 5.0    | tom  |

    Scenario: Recipes are sorted by rating
        Given there's a recipe for "Daquiri" by user "clare" with 4 stars
        And there's a recipe for "Pina Colada" by user "jess" with 2 stars
        And there's a recipe for "Mojito" by user "tom" with 5 stars
        When I request a list of recipes
        Then I should see a list of recipes containing:
            | name        | rating | user  |
            | Mojito      | 5.0    | tom   |
            | Daquiri     | 4.0    | clare |
            | Pina Colada | 2.0    | jess  |
