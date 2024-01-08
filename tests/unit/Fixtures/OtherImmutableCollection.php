<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

use Headsnet\Collections\AbstractImmutableCollection;

/**
 * @extends AbstractImmutableCollection<DummyCollectionItem>
 */
final class OtherImmutableCollection extends AbstractImmutableCollection
{
    public function getItemClassName(): string
    {
        return OtherCollectionItem::class;
    }
}
