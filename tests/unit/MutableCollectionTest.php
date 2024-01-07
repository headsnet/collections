<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test;

use Headsnet\Collections\Exception\ItemNotFoundException;
use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyMutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractMutableCollection
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class MutableCollectionTest extends TestCase
{
    public function test_can_add_item(): void
    {
        $sut = DummyMutableCollection::from([]);
        $itemToAdd = new DummyCollectionItem();

        $sut->add($itemToAdd);

        $this->assertEquals(1, $sut->count());
        $this->assertTrue($sut->contains($itemToAdd));
    }

    public function test_can_remove_item(): void
    {
        $itemToRemove = new DummyCollectionItem();
        $sut = DummyMutableCollection::from([$itemToRemove]);

        $sut->remove($itemToRemove);

        $this->assertEquals(0, $sut->count());
        $this->assertFalse($sut->contains($itemToRemove));
    }

    public function test_can_remove_item_at_position(): void
    {
        $itemToRemove = new DummyCollectionItem();
        $sut = DummyMutableCollection::from([$itemToRemove]);

        $sut->removeAtPosition(0);

        $this->assertEquals(0, $sut->count());
        $this->assertFalse($sut->contains($itemToRemove));
    }

    public function test_cannot_remove_item_if_position_is_empty(): void
    {
        $itemToRemove = new DummyCollectionItem();
        $sut = DummyMutableCollection::from([$itemToRemove]);

        $this->expectException(ItemNotFoundException::class);

        $sut->removeAtPosition(1);
    }
}
