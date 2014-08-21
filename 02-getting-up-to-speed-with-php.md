Getting up to Speed with PHP
============================

As I said previously this book assumes you are already familiar with PHP. In
this chapter I will just cover a few newer additions to PHP which you will need
to know about to continue with this book. It will also cover some important
tools as well as discuss programming style.

Namespaces
----------

If namespaces are new to you then I think the easiest analogy I can think of is
that they are like folders for your code. Using namespaces means that you can
have 2 or more classes with the same name in different namespaces just like you
can have 2 or more files with the same name in different folders.

Without covering all the details of PHP namespaces here I'll quickly cover
everything you will need to know about them to get through this book.

The full documentation for PHP namespaces can be found at
http://php.net/manual/en/language.namespaces.php

Firstly, in order to define a class inside a specific namespace you use the
`namespace` statement on the first line of the file containing the class like
so:

```php
<?php

namespace MyApp\Entity;

class Contact
{
    // ...
}
```

This defines the class `Contact` inside the `Entity` namespace which is inside
the `MyApp` namespace. Namespaces are seperated by backslashes.

To use a class in another piece of code in the same namespace you can simply
refere to it by name:

```php
<?php

namespace MyApp\Entity;

$contact = new Contact();
```

To use the class in a piece of code in a differnt namespace you can refer to it
by it's fully qualified class name (FQCN) like so:

```php
<?php

namespace MyApp;

$contact = new \MyApp\Entity\Contact();
```

You can also refer to a class in a sub-namespace relative to the current
namespace like so:

```php
<?php

namespace MyApp;

$contact = new Entity\Contact();
```

And finally you can pull a class from a different namespace into scope from
another namespace with the `use` statement at the top of the file after the
`namespace` statement. This is the way I will prefer in most situations. Here
is an example

```php
<?php

namespace MyApp;

use MyApp\Entity\Contact;

$contact = new Contact();
```

One final thing is if you want to use a class from another namespace in a
namespace which already has a class of the same name in it, then you can rename
the one your are importing with the `as` statment like so:

```php
<?php

namespace MyApp\Form\Contact;

use MyApp\Entity\Contact as ContactEntity;

class Contact
{
    public function __construct(ContactEntity $entity)
    {
        // ...
    }

    // ...
}
```

Simple really right? From this point on in the book that is everything you will
need to know about PHP namespaces.

Front Controllers
-----------------

???

Standards
---------

As languages get more powerful it often allows many different ways an
approaches to achieve the same thing and everyone has their own preferences of
how they personally like to do things. On one hand this is great; it allows
programmers to be to write their code in the way which best fits how they
think, lay it out in they way which look the most asthetically pleasing to
them, and structure it in the way which they find easiest to navigate. On the
other hand this becomes a total nightmare when you are working with several
libraries, all written by different programmers who each have their own way of
doing all this. You have to learn each of the different approaches to
efficiently navigate and understand the code. Also it may make it tricky for
the libraries to happily interact with each other.

So for the reasons just mentioned, programmers get together is groups and
create standards with a nice middle ground which everyone is mostly happy with.
You'll often find that you might not agree with everything define in a standard
but by putting that to one side and accepting it you reap the benefits over
have you code being much more consistent with all the other users of the
standard's code, as well as any tools which have been built to work with that
standard.

### PHP-FIG

Introducing PHP-FIG! PHP-FIG or the PHP Framework Interop Group is a group
built up of various key people in the PHP community who have got together and
started to build some standards for using PHP. Many PHP software project have
now adopted or are adopting many of these standards and I full recommend you do
the same.

At the time of writing this there are 5 published standards:

* PSR-0 - Autoloading Standard
* PSR-1 - Basic Coding Standard
* PSR-2 - Coding Style Guide (implies PSR-1)
* PSR-3 - Logger Interface
* PSR-4 - Improved Autoloading (an extension to PSR-0)

In this book I will be using PSR-0 for all code (except for small examples)
and PSR-2 for coding style. I will explain a bit more about these in the next 
few sections.

For more Information on PHP-FIG visit the website at http://www.php-fig.org/

### PHP The Right Way

PHP The Right Way is not a standard as such, it is simply a website which lists
lots of things about how PHP should be used if you are serious about writing
good code. It contains lots of fantastic advice and I thoroughily recommend
studying it.

It can be found at http://www.phptherightway.com/

The Autoloader
--------------

You may never have written a PHP autoloader callback, or maybe never have heard
of one but you may well have used it if you have build any PHP applications
using a framework. If however you are referencing code in different files by
using PHP's `require`, `require_once`, `include` and `include_once` statements
then you need to STOP and read this section now!

The autoloader is a system in PHP where you can create a callback function that
will be called if your try and use a class which has not yet been defined. This
callback recieves the name of the class trying to be used a a parameter and the
function can then use this to lookup and require the file needed to provide the
class definition.

In order to use an autoloader callback you can either define a function called
`__autoload` which will provide the autoloading logic, or you can use the more
recent and flexible `spl_autoload_register` function to register you
autoloading function.

Now you know what an autoloader is there's some good news, there's no actual
need to write the autoloader function yourself, the wonderful tool called
Composer can take care of that for you.

However if you do want to look into autoloading in more detail you can read
about it in the manual here http://php.net/manual/en/language.oop5.autoload.php

PSR-0 - Autoloading Standard
----------------------------

Before talking about Composer I'd like to first introduce PSR-0. PSR-0 is a
standard which was designed to make it easy to find the files where given
classes are defined.

The basic rules are as follows:

* There is exactly one class defined per file
* The file name is the same name (and case) as the name of the class defined in it with `.php` appended to it
* The file exists in directory stucture which fully matches the namespace which the class is defined within

For the full PSR-0 specification see http://www.php-fig.org/psr/psr-0/

### Example

A file located at
`/home/tom/projects/AutoloadExample/src/MyApp/Entity/Contact.php` would contain
the following code:

```php
<?php

namespace MyApp\Entity;

class Contact
{
    // ...
}
```

Whatever comes before the root namespace in the file name (in this case
`/home/tom/projects/AutoloadExample/src`) is not important, so long as the 
FQCN is mirror in the folder structure up to the class name.

**From this point on in the book I will not mentioned file names when
displaying code examples unless the file name does not match the PSR-0
standard.**

Composer
--------

Composer is a dependency manager for PHP, it allows you to specify all the
libraries and tools that your PHP project depends on in a simple JSON file, it
will then correct versions of those dependencies into your project.

This means it's easy to distribute your project without including its 3rd party
dependencies while making it very easy for an users or developers working on
the project to easily install the required dependencies. It also makes it easy
to quickly update to newer versions of dependencies.

Composer installs its dependencies locally to the project in a directory called
`vendor`, rather than installing them globally onto the system your are running
on.  This is a definite plus as it means you can run many different projects on
the same system all working with different versions their dependencies without
getting in to a mess.

Now this is all very interesting but you might think you have no intention of
using any external librarys or tools with your new project, so is Composer
still useful?

The answer is most definitely yes:

* Firstly there are lots of great development tools which can be installed via
Composer which you should definitely be using even if you don't intend on using
3rd party libraries.
* Secondly you may not intend on using 3rd party libraries but if you start off
using Composer from the beginning you can always change your mind an add a
dependency very easily.
* And thirdly, Composer provides a nice and easy to set up autoloader for PHP.
By simply adding a few line of JSON your autoloader is up and ready to go.

While there are plenty of people out there who will have a good reason not to
use Composer, in my oppion if you don't have on then you should definitely be
using it in your projects.

So that's a little intro on what Composer can do for you. The full
documentation can be found at https://getcomposer.org/ but to save you the
hassle of reading it all now lets have a look at a little example of the
basics.

### Composer example

#### Installing

#### Setting up the Autoloader

#### Adding a Dependency

#### Adding Development Tools

Coding Style
------------
