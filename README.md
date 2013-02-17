=======
User
=======

[![Build Status](https://travis-ci.org/Molajo/User.png?branch=master)](https://travis-ci.org/Molajo/User)

Scaffolding for an Adapter Pattern. Can be used as the basis for a Molajo User.

## System Requirements ##

* PHP 5.3.3, or above
* [PSR-0 compliant Autoloader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
* PHP Framework independent
* [optional] PHPUnit 3.5+ to execute the test suite (phpunit --version)

## What is User? ##

**Users** are used as **Services**, defined as **Interfaces** in Molajo.

## Basic Usage ##

```php
    $adapter = new Molajo/User/Adapter($action, $user_type, $options);
```
#### Parameters ####

- **$action** valid values: `This`, `That`, and `TheOther`;
- **$user_type** Identifier for the user. Examples include `UserType1` (default) and `UserType2`;
- **$options** Associative array of named pair values needed for the specific Action.

#### Results ####

The output from the user action request, along with relevant data, can be accessed from the returned
object, as follows:

**Action Results:** For any request where data is to be returned, this example shows how to retrieve the output:

```php
    echo $adapter->ct->field;
```

### Installation

#### Install using Composer from Packagist

**Step 1** Install composer in your project:

```php
    curl -s https://getcomposer.org/installer | php
```

**Step 2** Create a **composer.json** file in your project root:

```php
{
    "require": {
        "Molajo/User": "1.*"
    }
}
```

**Step 3** Install via composer:

```php
    php composer.phar install
```

**Step 4** Add this line to your application’s **index.php** file:

```php
    require 'vendor/autoload.php';
```

This instructs PHP to use Composer’s autoloader for **User** project dependencies.

#### Or, Install Manually

Download and extract **User**.

Create a **Molajo** folder, and then a **User** subfolder in your **Vendor** directory.

Copy the **User** files directly into the **User** subfolder.

Register `Molajo\User\` subfolder in your autoload process.

About
=====

Molajo Project adopted the following:

 * [Semantic Versioning](http://semver.org/)
 * [PSR-0 Autoloader Interoperability](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
 * [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
 and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
 * [phpDocumentor2] (https://github.com/phpDocumentor/phpDocumentor2)
 * [phpUnit Testing] (https://github.com/sebastianbergmann/phpunit)
 * [Travis Continuous Improvement] (https://travis-ci.org/profile/Molajo)
 * [Packagist] (https://packagist.org)


Submitting pull requests and features
------------------------------------

Pull requests [GitHub](https://github.com/Molajo/Fileservices/pulls)

Features [GitHub](https://github.com/Molajo/Fileservices/issues)

Author
------

Amy Stephen - <AmyStephen@gmail.com> - <http://twitter.com/AmyStephen><br />
See also the list of [contributors](https://github.com/Molajo/User/contributors) participating in this project.

License
-------

**Molajo User** is licensed under the MIT License - see the `LICENSE` file for details

More Information
----------------
- [Extend](https://github.com/Molajo/User/blob/master/.dev/Doc/extend.md)
- [Install](https://github.com/Molajo/User/blob/master/.dev/Doc/install.md)
