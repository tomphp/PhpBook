Feature: List books
    In order to list books
    As a reader
    I must be able to view a list of all books stored on the system

    Scenario: Display an empty list
        Given there are no books
        When I list all books
        Then I should see an empty list

    Scenario: Books are listed in alphabetical order
        Given there is a book called "Domain Driven Design" by "Eric Evans"
        And there is a book called "Refactoring" by "Martin Fowler"
        And there is a book called "Design Patterns" by "The Gang of Four"
        When I list all books
        Then I should see:
            | title                | author           |
            | Design Patterns      | The Gang of Four |
            | Domain Driven Design | Eric Evans       |
            | Refactoring          | Martin Fowler    |
