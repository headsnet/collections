![Build Status](https://github.com/headsnet/collections/actions/workflows/ci.yml/badge.svg)
![Coverage](https://raw.githubusercontent.com/headsnet/collections/image-data/coverage.svg)
[![Latest Stable Version](https://poser.pugx.org/headsnet/collections/v)](//packagist.org/packages/headsnet/collections)
[![Total Downloads](https://poser.pugx.org/headsnet/collections/downloads)](//packagist.org/packages/headsnet/collections)
[![License](https://poser.pugx.org/headsnet/collections/license)](//packagist.org/packages/headsnet/collections)

Headsnet Collections
=====

### Installation

```bash
composer require headsnet/collections
```

### Usage

Assuming you have some class `Foo` that you want to put into a collection:
```php
final class Foo
{
    public function __construct(
        public string $name
    ) {
    }
}
```

Then create a custom named collection to hold the `Foo` instances:
```php
/**
 * @extends AbstractImmutableCollection<Foo>
 */
final class FooCollection extends AbstractImmutableCollection
{
    /**
     * @param array<Foo> $items
     */
    public function __construct(array $items)
    {
        parent::__construct(Foo::class, $items);
    }
}
```

Then instantiate the collection:
```php
$foo1 = new Foo();
$foo2 = new Foo();

$allFoos = new FooCollection([$foo1, $foo2]);
```

You then have an immutable, iterable object that can be filtered, mapped and walked:
```php
foreach ($allFoos as $foo) {
    $this->assertInstanceOf(Foo::class, $foo);
}
```

### Contributing

Contributions are welcome. Please submit pull requests with one fix/feature per
pull request.
