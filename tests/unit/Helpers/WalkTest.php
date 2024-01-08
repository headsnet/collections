<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class WalkTest extends TestCase
{
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
}
