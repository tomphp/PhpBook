Feature: A visitor can view a list of recipes
    In order to view a list of recipes
    As a visitor
    I need to be able get a list of recipes

    Scenario: View an empty list of recipes
        Given there are no recipes
        When I request a list of recipes
        Then I should see an empty list

    Scenario: Viewing a list with 1 item
        Given there is a recipe called "Mojito" with a rating of 5 submitted by "tom"
        When I request a list of recipes
        Then I should see a list of recipes containing:
            | name   | rating | user |
            | Mojito | 5.0    | tom  |

    Scenario: Recipes are sorted by rating
        Given there is a recipe called "Daquiri" with a rating of 4 submitted by "clare"
        And there is a recipe called "Pina Colada" with a rating of 2 submitted by "jess"
        And there is a recipe called "Mojito" with a rating of 5 submitted by "tom"
        When I request a list of recipes
        Then I should see a list of recipes containing:
            | name        | rating | user  |
            | Mojito      | 5.0    | tom   |
            | Daquiri     | 4.0    | clare |
            | Pina Colada | 2.0    | jess  |
