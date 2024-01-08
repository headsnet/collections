<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Exception\ItemNotFoundException;
use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class FirstTest extends TestCase
{
    public function test_first_returns_first_item(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertSame($collectionItem1, $sut->first());
    }

    public function test_first_returns_null_if_collection_is_empty(): void
    {
        $sut = DummyImmutableCollection::from([]);

        $this->assertNull($sut->first());
    }

    public function test_first_or_fail_returns_first_item(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertSame($collectionItem1, $sut->firstOrFail());
    }

    public function test_first_or_fail_throws_exception_if_collection_is_empty(): void
    {
        $sut = DummyImmutableCollection::from([]);

        $this->expectException(ItemNotFoundException::class);

        $sut->firstOrFail();
    }
}
