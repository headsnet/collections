<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Headsnet\Collections\Exception\InvalidTypeException;
use Headsnet\Collections\Test\Fixtures\AugmentedImmutableCollection;
use Headsnet\Collections\Test\Fixtures\CompanionObject;
use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use Headsnet\Collections\Test\Fixtures\OtherCollectionItem;
use PHPUnit\Framework\TestCase;

/**
 * This test covers instantiation of the collection.
 *
 * Helper methods each have their own test class in the "Helpers" sub-namespace.
 *
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

    public function test_can_create_collection_from_doctrine_collection(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();
        $doctrineCollection = new ArrayCollection([$collectionItem1, $collectionItem2]);

        $sut = DummyImmutableCollection::fromDoctrine($doctrineCollection);

        $this->assertEquals($collectionItem1, $sut->firstOrFail());
        $this->assertEquals($collectionItem2, $sut->lastOrFail());
    }

    public function test_can_create_collection_by_mapping_array_of_other_objects(): void
    {
        $collectionItem1 = new CompanionObject('one');
        $collectionItem2 = new CompanionObject('two');

        $sut = DummyImmutableCollection::mapFrom(
            [$collectionItem1, $collectionItem2],
            fn (CompanionObject $companionObject): DummyCollectionItem => new DummyCollectionItem($collectionItem2->name)
        );

        $this->assertEquals(2, $sut->count());
    }
}
