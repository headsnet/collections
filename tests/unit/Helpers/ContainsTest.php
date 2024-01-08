<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyCollectionItem;
use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class ContainsTest extends TestCase
{
    public function test_can_find_contained_element(): void
    {
        $collectionItem1 = new DummyCollectionItem();
        $collectionItem2 = new DummyCollectionItem();

        $sut = DummyImmutableCollection::from([$collectionItem1, $collectionItem2]);

        $this->assertTrue($sut->contains($collectionItem1));
        $this->assertTrue($sut->contains($collectionItem2));
    }
}
