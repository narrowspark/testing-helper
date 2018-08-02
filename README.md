<h1 align="center">Narrowspark Testing Helper</h1>
<p align="center">
    <a href="https://github.com/narrowspark/testing-helper/releases"><img src="https://img.shields.io/packagist/v/narrowspark/testing-helper.svg?style=flat-square"></a>
    <a href="https://php.net/"><img src="https://img.shields.io/badge/php-%5E7.2.0-8892BF.svg?style=flat-square"></a>
    <a href="https://travis-ci.org/narrowspark/testing-helper"><img src="https://img.shields.io/travis/narrowspark/testing-helper/master.svg?style=flat-square"></a>
    <a href="https://codecov.io/gh/narrowspark/testing-helper"><img src="https://img.shields.io/codecov/c/github/narrowspark/testing-helper/master.svg?style=flat-square"></a>
    <a href="https://gitter.im/narrowspark/framework"><img src="https://img.shields.io/gitter/room/nwjs/nw.js.svg?style=flat-square"></a>
    <a href="http://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square"></a>
</p>

Installation
-------------

Via Composer

``` bash
$ composer require narrowspark/testing-helper
```

Usage
-------------

``` php
use Narrowspark\TestingHelper\Traits\TestHelperTrait;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    use TestHelperTrait;

    // Now you can do something like this.
    public function testIfArrayContainIrix()
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        self::assertInArray('Irix', $haystack);
    }
}
```

Testing
-------------

You need to run:
``` bash
$ phpunit
```

Contributing
------------

If you would like to help take a look at the [list of issues](http://github.com/narrowspark/testing-helper/issues) and check our [Contributing](CONTRIBUTING.md) guild.

> **Note:** Please note that this project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its terms.

Credits
-------------

- [Daniel Bannert](https://github.com/prisis)
- [All Contributors](../../contributors)

License
-------------

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
