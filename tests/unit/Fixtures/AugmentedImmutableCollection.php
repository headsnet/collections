<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

use Headsnet\Collections\AbstractImmutableCollection;

/**
 * This is an example of a collection holding a property in addition to the collection items.
 *
 * @extends AbstractImmutableCollection<DummyCollectionItem>
 */
final class AugmentedImmutableCollection extends AbstractImmutableCollection
{
    public function __construct(
        array $items,
        public CompanionObject $companionObject
    ) {
        parent::__construct($items);
    }

    public function getItemClassName(): string
    {
        return DummyCollectionItem::class;
    }
}
