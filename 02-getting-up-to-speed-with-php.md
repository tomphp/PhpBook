Getting up to Speed with PHP
============================

As I said previously this book assumes you are already familiar with PHP. In
this chapter I will just quickly cover a few newer additions to PHP as well as
some tools and techniques process which you will need to know about to continue
with this book.

I don't intend to go into anything in too much depth, it will contain just
enough information of the things we will be using and I encourage you to
research them further yourself.

Namespaces
----------

If namespaces are new to you then I think the easiest analogy I can think of is
that they are like folders for your code. Using namespaces means you can have 2
or more classes with the same name in different namespaces, just like you can
have 2 or more files with the same name in different folders.

Without covering all the details of PHP namespaces here I will quickly cover
the aspects of them which we will be using.

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

To use a class in a piece of code in the same namespace you can simply refer
to it by name:

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

And finally you can pull a class from a different namespace into scope with the
`use` statement. Add this at the top of the file just after the `namespace`
statement. This is the way I prefer in most situations. Here's an example:

```php
<?php

namespace MyApp;

use MyApp\Entity\Contact;

$contact = new Contact();
```

One final thing, if you want to use a class from another namespace in a
namespace which already has a class with the same name in it, then you can
rename the one you're importing with the `as` keyword like so:

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

It's all pretty simple really right? That's everything you'll need to know about
namespaces to continue with this book.

Typehinting
-----------

PHP started off as a dynamically typed language. It has a few basic, scalar
types:

```php
<?php

42; // integer

12.5; // float or double

'abc123'; // string

false; // boolean
```

It also has arrays, callables and any user define class or interface which are
all also types.

Being a dynamic language means that an variable or function arguement can contain
any type at any time (this also goes for function return types):

```php
<?php

function fn($p)
{
    return $p;
}

$x = 42; // $x contains an integer

$x = 12.5; // now $x contains a float

$y = fn(123); // $p in fn() contains an integer and $y contains an integer

$y = fn(fals); // $p in fn() contains a boolean and $y contains a boolean

class C1
{
}

class C2
{
}

$c = new C1(); // $c contains a C1 instance

$c = new C2(); // $c contains a C2 instance

```

In contrast, in a statically typed language a variable, function argument or
return value can only ever be the type it is defined to contain, if another
type is assigned it will either be an error or it will get converted. Here's a
C++ version of the last example:

```c++

int fn(int p) {
    return p;
}

int x = 42; // x contains an integer

x = 12.5; // x contains 12, it keeps only the integer part

y = fn(123); // p in fn() contains an integer and y contains an integer

y = fn(false); // p in fn() contains 0 and y contains 0

class C1 {
};

class C2 {
};

C1 *c = new C1(); // c contains a C1 instance

c = new C2(); // this is an error as c can only contains instances of C1
```

Statically typed languages actually have great benefits, because you always
know what type everything is there's never a chance of you doing something to a
variable which you are not allow to do to the type it contains. On the other
hand dynamically typed langauges let you get on and do things quickly without
having to worry about how to work with type constraints.

Since static typing does have benifits PHP introduced typehints on function
arguments. Typehints allow you to specify exactly what user defined type a function
accepts for each parameter, it will throw an exception if the wrong type is given:

```php
<?php

class C1
{
}

class C2
{
}

function fn(C1 $c)
{
}

fn(new C1()); // works perfectly

fn(new C2()); // error

fn(5); // error
```

Frustratingly PHP does not allow typehint for scalar types or function return
values.

However even though PHP is a dynamically typed language you should still strive
to keep your typing sensible, this means if you create a variable that contains
a specific type try not to reuse it to contain a different type. Also don't
call methods on objects which are not in the typehinted interface, it's not an
error but it's not good practice:

```php
<?php

interface Fooer
{
    public function doFoo();
}

class FooBar implements Fooer
{
    public function doFoo()
    {
    }

    public function doBar()
    {
    }
}

function performAction(Fooer $f)
{
    // This is fine, doFoo() is defined in the Fooer interface
    $f->doFoo();

    // Don't do this, $f is a Fooer and doBar() is not defined
    // in the Fooer interface
    $f->doBar();
}

performAction(new FooBar());
```

Throughout this book I will be writing as if I'm writing in a statically typed
language 90% of the time and typehint whenever possible. However PHP is a
dynamic language and some times its helpful to take advantage of this, whenever
I do do this I will point it out.

Front Controllers
-----------------

The front controller is a design pattern for web applications which involves
creating a single entry point into your application. It requires configuring
your webserver to redirect all requests to a single PHP script which then
processes the request and decides what content to display.

Lets take a look at a little example:

### The Traditional Approach

First lets look at the traditional approach of using PHP. Lets create 2 files
inside an empty folder, the first one we'll call `page1.php`:

```php
<?php

echo 'You are viewing page 1';
```

And the second one we'll call `page2.php`

```php
<?php

echo 'You are viewing page 2';
```

Next open a terminal and `cd` into the directory containing these files and use
the following command to start up PHP's built in webserver:

`php -S localhost:8080`

Now if you open your browser and go to `http://localhost:8080/page1.php` then
you will see `You are viewing page 1`. If you then go to
`http://localhost:8080/page2.php` you will see `You are viewing page 2`.

When you are done, press `CTRL+C` in your terminal to stop the webserver.

This is the approach that you normally first learn when starting out with
PHP.  There's nothing wrong with this approach, but in general using a front
controller is better so let's take a look at that.

### Single Entry Point

Create a new folder and this time create a single file called `index.php`
containing:

```php
<?php

echo 'You are looking at: ' . $_SERVER['REQUEST_URI'];
```

Then in the terminal again `cd` to this new directory. This time start the PHP
built in webserver with the name of the file we want to use as the application
entry point like so:

`php -S localhost:8080 index.php`

Again open your browser and visit `http://localhost:8080/page1` and you will
see `You are looking at: /page1`, and again go to`http://localhost:8080/page2`
and you will see `You are looking at: /page2`.

So as you can see, anything you type after the `http://localhost:8080` is
redirected to the `index.php` file and you can use the `$_SERVER` superglobal
to get the actual URI requested.

### The Simplest Front Controller in the World

So lets modify the `index.php` file to look like this:

```php
<?php

switch ($_SERVER['REQUEST_URI']) {
    case '/page1':
        echo 'You are viewing page 1';
        break;

    case '/page2':
        echo 'You are viewing page 2';
        break;

    default:
        header('HTTP/1.0 404 Not Found');

        echo '<html>'
            . '<head><title>404 Not Found</title></head>'
            . '<body><h1>404 Not Found</h1></body>'
            . '</html>';
}

```

Now if we go to our browser and go to `http://localhost:8080/page1` or
`http://localhost:8080/page2` then they work as expected. Also going to
`http://localhost:8080/anything-else` now shows a 404 message.

Obviously this is a pretty pointless and limiting front controller but
hopefully you now understand the theory behind it.

Stop the webserver again by pressing `CTRL+C` in the terminal.

### Front Controllers using Apache

In order to use a front controller with Apache you need to tell Apache where to
find the PHP script to use for the application entry point. As of Apache
version `2.2.16` you can do this by simply adding:

`FallbackResource /index.php`

to your `.htaccess` file in your document root.

Standards
---------

As languages get more powerful it often allows many different ways and
approaches to achieve the same thing. Each person then has their own
preferences of how they personally like to do things.

On one hand this is great; it allows programmers to be to write their code in
the way which best fits how they think, lay it out in they way which look the
most asthetically pleasing to them, and structure it in the way which they find
easiest to navigate.

On the other hand this becomes a total nightmare when you are working with
several libraries, all written by different programmers who each have their own
way of doing all things. You have to learn each of the different approaches to
efficiently navigate and understand each author's code. Also it may make it
tricky for some of the libraries to happily interact with each other.

So for the reasons just mentioned, programmers get together is groups and
create standards which are a nice middle ground which everyone is mostly happy
with.  You'll often find that you might not agree with everything defined in a
standard but by putting that to one side and accepting it you reap the benefits
of having your code being much more consistent with all the other users of the
standard's code; as well as any tools which have been built to work with that
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

And a few more in discussion:

* PSR-5 - PHPDoc
* PSR-6 - Caching Interface

In this book I will be using PSR-0 for all code (except in small examples)
and PSR-2 for coding style. I will explain a bit more about these in the next 
few sections.

For more Information on PHP-FIG visit the website at http://www.php-fig.org/

### PHP The Right Way

PHP The Right Way is not a standard as such, it is simply a website which lists
lots of things about how PHP should be used if you are serious about writing
good code. It contains lots of fantastic advice and I highly recommend studying
it.

It can be found at http://www.phptherightway.com/

The Autoloader
--------------

You may never have written a PHP autoloader callback, or maybe never have heard
of one, but you may well have used it if you have build any PHP applications
using a framework. If however you are not aware of the autoloader and are
referencing code in different files by using PHP's `require`, `require_once`,
`include` and `include_once` statements then you need to STOP and read this
section now!

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
need to write the autoloader function yourself, there's a wonderful tool called
Composer which can take care of that for you.

However if you do want to look into autoloading in more detail you can read
about it in the manual here http://php.net/manual/en/language.oop5.autoload.php

PSR-0 - Autoloading Standard
----------------------------

Before talking about Composer I'd like to first introduce PSR-0. PSR-0 is a
standard which was designed to make it easy to find the files where given
classes are defined.

The basic rules are as follows:

* There is exactly one class defined per file
* The file name is the same name (and case) as the name of the class defined
inside it with `.php` appended to it
* The file exists in directory stucture which fully matches the namespace which
the class is defined in

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
FQCN is mirrored in the folder structure up to the class name.

**From this point on in the book I will not mentioned file names when
displaying code examples unless the file name does not match the PSR-0
standard.**

Composer
--------

Composer is a dependency manager for PHP, it allows you to specify all the
libraries and tools that your PHP project depends on in a simple JSON file, it
will then fetch the correct versions of those dependencies into your project.

This means it's easy to distribute your project without including its 3rd party
dependencies, while making it very easy for an users or developers working on
the project to easily install them themselves. It also makes it easy to quickly
update to newer versions of dependencies.

Composer installs its dependencies locally to the project in a directory called
`vendor` rather than installing them globally onto the system on. This is a
definite plus as it means you can run many different projects on the same
system, all working with different versions their dependencies, without getting
in to a mess.

Now this is all very interesting but you might think you have no intention of
using any external libraries or tools with your new project, so is Composer
still useful?

The answer is most definitely yes:

* Firstly, there are lots of great development tools which can be installed via
Composer which you should definitely be using even if you don't intend on using
3rd party libraries
* Secondly, you may not intend on using 3rd party libraries but if you start
off using Composer from the beginning you can always change your mind an add a
dependency very easily
* And thirdly, Composer provides a nice and easy to set up autoloader for PHP.
By simply adding a few line of JSON to your project your autoloader is up and
ready to go

While there are plenty of people out there who will have a good reason not to
use Composer, in my opinion if you don't have on then you should definitely be
using it in your projects.

So that's a little intro on what Composer can do for you. The full
documentation can be found at https://getcomposer.org/ but to save you the
hassle of reading it all now lets have a look at a little example of the
basics.

### Composer Example

#### Installing

The various installion options for Composer can be found at
https://getcomposer.org/

You can either install a copy locally to your project which means your call it
by running:

`./composer.phar`

Or you can install it globally on your system and rename it to `composer` which
is what I have done. So on my system I run Composer by simply typing:

`composer`

But if you have installed it differently you will need to adjust my
instructions accordingly.

#### Setting up the Autoloader

To start of create a new project folder and `cd` into it:

```
mkdir ComposerExample
cd ComposerExample
```

If you want to you Composer locally you'll want to install it inside this
folder now, if you have installed it global already then you can just carry on.

Next up create a file in the project folder called `composer.json` and add the
following content:

```json
{
    "autoload": {
        "psr-0": {
            "ComposerExample\\": "./src"
        }
    }
}
```

What we have told Composer to do here is set up an autoloader to local any
classes in the `ComposerExample` namespace using the PSR-0 file structure inside
a directory inside our project directory called `src`.

Now tell Composer to apply these settings with the following command (remember
you will need to adjust it if you have installed Composer locally):

`composer install`

Once it has finished you will notice it has created a folder called `vendor`
and another file called `composer.lock`. If you're are using a Source Control
System like git (and you really should be!) then you should instruct it to
ignore your `vendor` directory from the repository, the `composer.lock` file
should be added to the repository though.

Next up create a directory structure for our PSR-0 classes to go:

`mkdir -p src/ComposerExample`

The create a file called `src/ComposerExample/HelloApplication.php` with the
following content:

```php
<?php

namespace ComposerExample;

class HelloApplication
{
    public function run()
    {
        echo "Hello beautiful World!\n";
    }
}
```

And finally create a class called `run.php` containing:

```php
<?php

// Load up Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// This class will loaded automatically
$app = new \ComposerExample\HelloApplication();
$app->run();
```

Now to see it work run:

`php run.php`

Ta da!

#### Adding a Dependency

Now lets dress it up a bit using a 3rd party library. I had a little hunt
around for something interesting to try and found Maxime Bouroumeau-Fuseau's
ConsoleKit library.

First up lets add it to the project as a dependency by updating our
`composer.json` file to contain the following:

```json
{
    "require": {
        "maximebf/consolekit": ">=1.0.0"
    },
    "autoload": {
        "psr-0": {
            "ComposerExample\\": "./src"
        }
    }
}
```

Next we tell Composer to download it new dependency by running:

`composer update`

It should download the ConsoleKit package which will now be ready to use. Let's
update our `ComposerExample\HelloApplication` class to look like this:

```php
<?php

namespace ComposerExample;

use ConsoleKit\Console;

class HelloApplication extends Console
{
    public function run()
    {
        $console = new Console();
        $console->addCommand('ComposerExample\\HelloCommand');
        $console->run();
    }
}
```

And let's add a new class called `ComposerExample\HelloCommand` like so:

```php
<?php

namespace ComposerExample;

use ConsoleKit\Command;
use ConsoleKit\Colors;

class HelloCommand extends Command
{
    public function execute(array $args, array $options = array())
    {
        $this->writeln('Hello green World!', Colors::GREEN);
    }
}
```

Now to try and run it:

`php run.php hello`

And there we have it, we have simply added a dependency to our app and used it
leaving Composer to do all the hardwork of downloading it and setting up the
autoload to find it.

#### Adding Development Tools

Composer's `require` section lets you define the requirements your project
needs to run but it also has a `require-dev` section which for dependencies
which you want to use for development (testing tools for example).

CodeSniffer is a tool which checks that your code follows a given coding style,
lets add it to our project.

Update the `composer.json` file to include the CodeSniffer dev dependency:

```json
{
    "require": {
        "maximebf/consolekit": ">=1.0.0"
    },
    "require-dev": {
        "squizlabs/php_codesniffer": "1.*"
    },
    "autoload": {
        "psr-0": {
            "ComposerExample\\": "./src"
        }
    }
}
```

Once again tell Composer to update it's dependencies by running:

`composer update`

After it has finished CodeSniffer is ready to be used. When Composer installs
tool it will install the executable files in a local directory, by default this
directory is `vendor/bin`. We can run CodeSniffer by running:

`vendor/bin/phpcs --standard=psr2 src`

If all the code in our `src` directory conforms to the PSR-2 coding style then
CodeSniffer should have complete without and errors.

To make life easier your can add `vendor/bin` to your operating systems `PATH`
variable so you can execute your tools more easily. On Linux you do this by adding:

`PATH=./vendor/bin:$PATH`

To your `.bashrc` file in your home directory.

Coding Style
------------

### Logic & Display Seperation
