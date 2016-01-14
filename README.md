# testing-helper

[![Author](http://img.shields.io/badge/author-@anolilab-blue.svg?style=flat-square)](https://twitter.com/@anolilab)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/narrowspark/testing-helper.svg?style=flat-square)](https://packagist.org/packages/narrowspark/testing-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/narrowspark/testing-helper.svg?style=flat-square)](https://packagist.org/packages/narrowspark/testing-helper)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Master

[![Build Status](https://img.shields.io/travis/narrowspark/testing-helper/master.svg?style=flat-square)](https://travis-ci.org/narrowspark/testing-helper)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/narrowspark/testing-helper/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/narrowspark/testing-helper/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/narrowspark/testing-helper.svg?style=flat-square)](https://scrutinizer-ci.com/g/narrowspark/testing-helper)

## Develop

[![Build Status](https://img.shields.io/travis/narrowspark/testing-helper/develop.svg?style=flat-square)](https://travis-ci.org/narrowspark/testing-helper)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/narrowspark/testing-helper/develop.svg?style=flat-square)](https://scrutinizer-ci.com/g/narrowspark/testing-helper/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/narrowspark/testing-helper/develop.svg?style=flat-square)](https://scrutinizer-ci.com/g/narrowspark/testing-helper)

## Install

Via Composer

``` bash
$ composer require narrowspark/testing-helper
```

## Usage

``` php
use Narrowspark\TestingHelper\Traits\TestHelperTrait;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    use TestHelperTrait;

    // Now you can do something like this.
    public function testIfArrayContainIrix()
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        $this->assertInArray('Irix', $haystack);
    }
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email d.bannert@anolilab.de instead of using the issue tracker.

## Credits

- [Daniel Bannert](https://github.com/prisis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
