<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use Headsnet\Collections\Test\Fixtures\OtherCollectionItem;
use Headsnet\Collections\Test\Fixtures\OtherImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class MapTest extends TestCase
{
    public function test_can_map_elements_to_array(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $arrayOfClassNames = $sut->map(
            fn (DummyCollectionItem $item): string => get_class($item),
        );

        $this->assertIsArray($arrayOfClassNames);
        $this->assertEquals([DummyCollectionItem::class, DummyCollectionItem::class], $arrayOfClassNames);
    }

    public function test_can_map_elements_to_new_collection(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $newCollection = $sut->mapTo(
            fn (DummyCollectionItem $item): OtherCollectionItem => new OtherCollectionItem(),
            OtherImmutableCollection::class
        );

        $this->assertInstanceOf(OtherImmutableCollection::class, $newCollection);
        $this->assertEquals(2, $newCollection->count());
    }
}
