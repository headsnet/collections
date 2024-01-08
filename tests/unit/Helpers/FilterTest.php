<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class FilterTest extends TestCase
{
    public function test_can_filter_elements(): void
    {
        $collectionItem1 = new DummyCollectionItem('one');
        $collectionItem2 = new DummyCollectionItem('two');
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $filteredCollection = $sut->filter(fn (DummyCollectionItem $item): bool => $item->name === 'one');

        $this->assertCount(1, $filteredCollection);
        $this->assertTrue($filteredCollection->contains($collectionItem1));
    }

    public function test_chain_multiple_filters_together(): void
    {
        $collectionItem1 = new DummyCollectionItem('foo 1');
        $collectionItem2 = new DummyCollectionItem('bar 2');
        $collectionItem3 = new DummyCollectionItem('bar 3');
        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2, $collectionItem3]);

        $filteredCollection = $sut
            ->filter(fn (DummyCollectionItem $item): bool => str_contains((string) $item->name, 'bar'))
            ->filter(fn (DummyCollectionItem $item): bool => str_contains((string) $item->name, '3'))
        ;

        $this->assertCount(1, $filteredCollection);
        $this->assertTrue($filteredCollection->contains($collectionItem3));
    }

    public function test_filtering_elements_returns_new_collection(): void
    {
        $sut = DummyImmutableCollection::empty();

        $filteredCollection = $sut->filter(fn (DummyCollectionItem $item): bool => false);

        $this->assertInstanceOf(DummyImmutableCollection::class, $filteredCollection);
    }
}
