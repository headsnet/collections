<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test;

use Headsnet\Collections\Exception\InvalidTypeException;
use Headsnet\Collections\Test\Fixtures\DummyCollection;
use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\OtherCollectionItem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class CollectionTest extends TestCase
{
    public function test_item_class_name_matches_instantiation_class(): void
    {
        $sut = new DummyCollection([]);

        $this->assertEquals(DummyCollectionItem::class, $sut->getItemClassName());
    }

    public function test_contains_items_it_was_instantiated_with(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();

        $sut = new DummyCollection([$collectionItem1, $collectionItem2]);

        foreach ($sut as $collectionItem)
        {
            $this->assertInstanceOf(DummyCollectionItem::class, $collectionItem);
        }
    }

    public function test_cannot_add_incorrect_type_to_collection(): void
    {
        $incorrectItem = new OtherCollectionItem();

        $this->expectException(InvalidTypeException::class);

        new DummyCollection([$incorrectItem]); // @phpstan-ignore-line
    }

    public function test_first_returns_first_item(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = new DummyCollection([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertSame($collectionItem1, $sut->first());
    }

    public function test_last_returns_last_item(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = new DummyCollection([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertSame($collectionItem3, $sut->last());
    }

    public function test_equality_check_succeeds_correctly(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $collection1 = new DummyCollection([$collectionItem1, $collectionItem2, $collectionItem3]);
        $collection2 = new DummyCollection([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertTrue($collection1->equals($collection2));
    }

    public function test_equality_check_fails_correctly(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $collection1 = new DummyCollection([$collectionItem1, $collectionItem2, $collectionItem3]);
        $collection2 = new DummyCollection([$collectionItem1, $collectionItem2]);

        $this->assertFalse($collection1->equals($collection2));
    }

    public function test_equality_check_fails_correctly_with_deep_differences(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $collectionItem3 = new DummyCollectionItem('three');

        $collection1 = new DummyCollection([$collectionItem1, $collectionItem2]);
        $collection2 = new DummyCollection([$collectionItem1, $collectionItem3]);

        $this->assertFalse($collection1->equals($collection2));
    }

    public function test_can_find_contained_element(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();

        $sut = new DummyCollection([$collectionItem1, $collectionItem2]);

        $this->assertTrue($sut->contains($collectionItem1));
        $this->assertTrue($sut->contains($collectionItem2));
    }

    public function test_can_map_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $sut = new DummyCollection([$collectionItem1, $collectionItem2]);

        $arrayOfClassNames = $sut->map(fn (DummyCollectionItem $item): string => get_class($item));

        $this->assertIsArray($arrayOfClassNames);
        $this->assertEquals([DummyCollectionItem::class, DummyCollectionItem::class], $arrayOfClassNames);
    }

    public function test_can_filter_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $sut = new DummyCollection([$collectionItem1, $collectionItem2]);

        $filteredCollection = $sut->filter(fn (DummyCollectionItem $item): bool => $item->name === 'one');

        $this->assertInstanceOf(DummyCollection::class, $filteredCollection);
        $this->assertCount(1, $filteredCollection);
        $this->assertTrue($filteredCollection->contains($collectionItem1));
    }

    public function test_can_walk_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $sut = new DummyCollection([$collectionItem1, $collectionItem2]);

        $sut->walk(fn (DummyCollectionItem $item) => $item->name = 'player ' . $item->name);

        $this->assertInstanceOf(DummyCollection::class, $sut);
        $this->assertCount(2, $sut);
        $this->assertEquals('player one', $collectionItem1->name);
        $this->assertEquals('player two', $collectionItem2->name);
    }

    public function test_can_convert_to_array(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $sut = new DummyCollection([$collectionItem1, $collectionItem2]);

        $arrayOfCollectionItems = $sut->toArray();

        $this->assertIsArray($arrayOfCollectionItems);
        $this->assertEquals($arrayOfCollectionItems[0], $collectionItem1);
        $this->assertEquals($arrayOfCollectionItems[1], $collectionItem2);
        $this->assertCount(2, $arrayOfCollectionItems);
    }
}
