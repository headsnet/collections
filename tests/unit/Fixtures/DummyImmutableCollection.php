<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

use Headsnet\Collections\AbstractImmutableCollection;

/**
 * @extends AbstractImmutableCollection<DummyCollectionItem>
 */
final class DummyImmutableCollection extends AbstractImmutableCollection
{
    public function getItemClassName(): string
    {
        return DummyCollectionItem::class;
    }
}
