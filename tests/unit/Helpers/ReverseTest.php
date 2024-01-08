<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class ReverseTest extends TestCase
{
    public function test_can_reverse_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $reversedCollection = $sut->reverse();

        $this->assertCount(3, $reversedCollection);
        $this->assertEquals($collectionItem3, $reversedCollection->get(0));
        $this->assertEquals($collectionItem2, $reversedCollection->get(1));
        $this->assertEquals($collectionItem1, $reversedCollection->get(2));
    }

    public function test_reversing_elements_returns_new_collection(): void
    {
        $sut = DummyImmutableCollection::empty();

        $reversedCollection = $sut->reverse();

        $this->assertInstanceOf(DummyImmutableCollection::class, $reversedCollection);
    }
}
