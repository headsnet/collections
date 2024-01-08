<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class EqualsTest extends TestCase
{
    public function test_equality_check_succeeds_correctly(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $collection1 = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);
        $collection2 = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertTrue($collection1->equals($collection2));
    }

    public function test_equality_check_fails_correctly(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $collection1 = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);
        $collection2 = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $this->assertFalse($collection1->equals($collection2));
    }

    public function test_equality_check_fails_correctly_with_deep_differences(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $collectionItem3 = new DummyCollectionItem('three');

        $collection1 = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);
        $collection2 = DummyImmutableCollection::from([$collectionItem1, $collectionItem3]);

        $this->assertFalse($collection1->equals($collection2));
    }
}
