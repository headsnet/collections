<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test;

use Headsnet\Collections\Exception\InvalidTypeException;
use Headsnet\Collections\Exception\ItemNotFoundException;
use Headsnet\Collections\Test\Fixtures\AugmentedImmutableCollection;
use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use Headsnet\Collections\Test\Fixtures\OtherCollectionItem;
use Headsnet\Collections\Test\Fixtures\CompanionObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class ImmutableCollectionTest extends TestCase
{
    public function test_item_class_name_matches_instantiation_class(): void
    {
        $sut = new DummyImmutableCollection([]);

        $this->assertEquals(DummyCollectionItem::class, $sut->getItemClassName());
    }

    public function test_empty_factory_method_creates_empty_collection(): void
    {
        $sut = DummyImmutableCollection::empty();

        $this->assertEquals(0, $sut->count());
    }

    public function test_from_factory_method_can_create_empty_collection(): void
    {
        $sut = DummyImmutableCollection::from([]);

        $this->assertEquals(0, $sut->count());
    }

    public function test_contains_items_it_was_instantiated_with(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        foreach ($sut as $collectionItem) {
            $this->assertInstanceOf(DummyCollectionItem::class, $collectionItem);
        }
    }

    public function test_cannot_add_incorrect_type_to_collection(): void
    {
        $incorrectItem = new OtherCollectionItem();

        $this->expectException(InvalidTypeException::class);

        DummyImmutableCollection::from([$incorrectItem]); // @phpstan-ignore-line
    }

    public function test_can_create_collection_with_extra_properties(): void
    {
        $someValueObject1 = new CompanionObject();
        $sut = new AugmentedImmutableCollection([], $someValueObject1);

        $this->assertEquals(DummyCollectionItem::class, $sut->getItemClassName());
        $this->assertEquals($someValueObject1, $sut->companionObject);
    }

    public function test_is_empty_check_is_correct(): void
    {
        $sut = DummyImmutableCollection::empty();

        $this->assertTrue($sut->isEmpty());
    }

    public function test_is_not_empty_check_is_correct(): void
    {
        $sut = DummyImmutableCollection::empty();

        $this->assertFalse($sut->isNotEmpty());
    }

    public function test_has_item_check_is_correct(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertTrue($sut->has(2));
    }

    public function test_get_item_check_is_correct(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $collectionItem3 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $this->assertEquals($collectionItem3, $sut->get(2));
    }

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

    public function test_can_find_contained_element(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $this->assertTrue($sut->contains($collectionItem1));
        $this->assertTrue($sut->contains($collectionItem2));
    }

    public function test_can_map_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $arrayOfClassNames = $sut->map(fn (DummyCollectionItem $item): string => get_class($item));

        $this->assertIsArray($arrayOfClassNames);
        $this->assertEquals([DummyCollectionItem::class, DummyCollectionItem::class], $arrayOfClassNames);
    }

    public function test_can_filter_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $filteredCollection = $sut->filter(fn (DummyCollectionItem $item): bool => $item->name === 'one');

        $this->assertInstanceOf(DummyImmutableCollection::class, $filteredCollection);
        $this->assertCount(1, $filteredCollection);
        $this->assertTrue($filteredCollection->contains($collectionItem1));
    }

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

    public function test_can_walk_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $sut->walk(fn (DummyCollectionItem $item) => $item->name = 'player ' . $item->name);

        $this->assertInstanceOf(DummyImmutableCollection::class, $sut);
        $this->assertCount(2, $sut);
        $this->assertEquals('player one', $collectionItem1->name);
        $this->assertEquals('player two', $collectionItem2->name);
    }

    public function test_can_convert_to_array(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $arrayOfCollectionItems = $sut->toArray();

        $this->assertIsArray($arrayOfCollectionItems);
        $this->assertEquals($arrayOfCollectionItems[0], $collectionItem1);
        $this->assertEquals($arrayOfCollectionItems[1], $collectionItem2);
        $this->assertCount(2, $arrayOfCollectionItems);
    }
}
