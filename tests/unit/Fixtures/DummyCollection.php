<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

use Headsnet\Collections\AbstractImmutableCollection;

/**
 * @extends AbstractImmutableCollection<DummyCollectionItem>
 */
final class DummyCollection extends AbstractImmutableCollection
{
    /**
     * @param array<int, DummyCollectionItem> $items
     */
    public function __construct(array $items)
    {
        parent::__construct(DummyCollectionItem::class, $items);
    }
}
