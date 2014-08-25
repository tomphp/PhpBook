Methodologies, Techniques and Tools
===================================

In this chapter I want to introduce the paradigms, methodologies and techniques
incorporated in this book. Like the previous chapter I don't want to go into
any real depth with any of these topics, rather I just want to give a primer on
the various subjects which should be enough to understand the content of this
book. As always I do encourage you dig deeper into each of the subjects
yourself. I will provide references of where to start looking when you want
to do this.

Object Oriented Programming (OOP)
---------------------------

Sometimes I think there is a misconception that if you use classes in your code
then you are doing OOP. This is not the case, OOP is an approach to modelling
which involves grouping related data and behaviour (methods) in your code as
classes and then defining how they interact with each other.

OOP style of programming can be even be done in languages which have no
concepts of classes and classes can be used ways which really doesn't represent
good OO code.

This is not a book on OO design but we will be using it extensively and I will
be explaining my choices for doing the things I do. As a result coming in cold
you will probably get a good feel for OOP but if this is the case you should
go and learn more on the subject. If you have some experience of OOP but are
not an expert then I hope you will really have a lot to gain from this book.

Before moving on I just want to quickly cover a couple of OO topics.

### Encapsulation

Objects consist of state (it's properties) and it's public interface (all
public methods and properties).  Generally there are rules as to what are the
valid values for the state. Encapsulation is making that state private so that
it can only be changed via the public interface methods.

The point I want to make here is your should design your public methods so that
there is not way that the object can be put into an invalid state.

Lets look at a couple of examples:

An object to represent an email address should not contain strings which could
not be valid email addresses. In this case it would make sense to throw an
exception if the email address provided does not look like an email address:

```php
<?php

class EmailAddress
{
    /** @var string */
    private $address;

    /** @param string $address */
    public function __construct($address)
    {
        if (strpos($address, '@') === false) {
            throw new InvalidArgumentException(
                'Email addresses must contain an @ symbol'
            );
        }

        $this->address = $address;
    }

    public function __toString()
    {
        return $this->address;
    }
}
```

In the example above we chosen the simple rule that anything with an `@` symbol
in it could be an email address (obviously in production code this needs to be
more strict). If you study the code you will find that there is no way that you
can get it create an instance with an email address which does not contain an
`@` symbol. This is good design.

In another example consider implementing a collection words which maintains a
count of how many words it contains. This collection calls will have 2
properties, the list of words and the count. In order to add word to the
collection we add the word to the list and increment the count, firstly lets do
this with 2 seperate methods:

```php
<?php

class WordCollection
{
    /** @var string[] */
    private $words = [];

    /** @var int */
    private $count = 0;

    /** @param string $word */
    public function addWord($word)
    {
        $this->words[] = $word;
    }

    public function incrementCounter()
    {
        $this->count++;
    }

    /** @return string[] */
    public getWords()
    {
        return $this->words;
    }

    /** @return int */
    public getNumberOfWords()
    {
        return $this->count;
    }
}
```

Now you can probably see what's wrong with that straight away but let me
explain for completeness. Take the following code:

```php
<?php

$collection = new WordCollection();

$collection->addWord('hello');
$collection->incrementCounter();
```

It looks OK and `$collection` is left in a valid state right, but is it always in a
valid state? Look again:

```php
<?php

$collection = new WordCollection();

// words in list = 0
// counter = 0

$collection->addWord('hello');

// words in list = 1
// counter = 0
// Oh dear!

$collection->incrementCounter();

// words in list = 1
// counter = 1
```

So there's a point in the middle whether the state of the object is invalid, we
do fix it in the next line of code but what if a developer forgot to increment
the counter? It could lead to a nasty bug!

The solution is simple, design the class so it can never be put into an invalid
state:

```php
<?php

class WordCollection
{
    /** @var string[] */
    private $words = [];

    /** @var int */
    private $count = 0;

    /** @param string $word */
    public function addWord($word)
    {
        $this->words[] = $word;

        // increment the counter when the word is added
        $this->count++;
    }

    /** @return string[] */
    public getWords()
    {
        return $this->words;
    }

    /** @return int */
    public getNumberOfWords()
    {
        return $this->count;
    }
}
```

SORTED!

### Inheritance vs. Composition

Design Patterns
---------------

Value Objects & Immutability
----------------------------

Method Names
------------

Command Query Separation (CQS)
------------------------------

Dependency Injection
--------------------

The SOLID Principals
--------------------

Refactoring
-----------

Code Callisthenics
-----------------

Automated Testing
-----------------

Test Driven Development (TDD)
-----------------------------

Behaviour Driven Development (BDD)
----------------------------------

Uncle Bob's Clean Code
----------------------

Domain Driven Design (DDD)
--------------------------

Agile
-----

User Stories
------------
