**NOT COMPLETE**

To do:
1. User Types
2. User/UserInterface Class
3. Tests for Authentication
4. User Injector extends Injector implements InjectorInterface

=======
User
=======

[![Build Status](https://travis-ci.org/Molajo/User.png?branch=master)](https://travis-ci.org/Molajo/User)

Validates and filters input. Escapes and formats output.

Supports standard data type and PHP-specific filters and validation, value lists verification, callbacks, regex checking, and more.
 Use with rendering process to ensure proper escaping of output data and for special formatting needs.

## Basic Usage ##

Each field is processed by one, or many, field handlers for validation, filtering, or escaping.

```php
    try {
        $adapter = new Molajo/User/Adapter
            ->($method, $field_name, $field_value, $User_type_chain, $options);

    } catch (Exception $e) {
        //handle the exception here
    }

    // Success!
    echo $adapter->field_value;
```

###There are five input parameters:###

1. **$method** can be `validate`, `filter`, or `escape`;
2. **$field_name** name of the field containing the data value to be verified or filtered;
3. **$field_value** contains the data value to be verified or filtered;
4. **$User_type_chain** one or more field handlers, separated by a comma, processed in left-to-right order;
5. **$options** associative array of named pair values required by field handlers.


## System Requirements ##

* PHP 5.3.3, or above
* [PSR-0 compliant Autoloader](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
* PHP Framework independent
* [optional] PHPUnit 3.5+ to execute the test suite (phpunit --version)

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

About
=====

Molajo Project observes the following:

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

Pull requests [GitHub](https://github.com/Molajo/User/pulls)

Features [GitHub](https://github.com/Molajo/User/issues)

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
