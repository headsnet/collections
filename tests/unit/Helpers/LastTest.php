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
final class LastTest extends TestCase
{
    public function test_last_returns_last_item(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertSame($collectionItem3, $sut->last());
    }

    public function test_last_returns_null_if_collection_is_empty(): void
    {
        $sut = DummyImmutableCollection::from([]);

        $this->assertNull($sut->last());
    }

    public function test_last_or_fail_returns_first_item(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertSame($collectionItem3, $sut->lastOrFail());
    }

    public function test_last_or_fail_throws_exception_if_collection_is_empty(): void
    {
        $sut = DummyImmutableCollection::from([]);

        $this->expectException(ItemNotFoundException::class);

        $sut->lastOrFail();
    }
}
