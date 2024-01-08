<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class GettersTest extends TestCase
{
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
