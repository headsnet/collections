<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

use Headsnet\Collections\AbstractImmutableCollection;

/**
 * @extends AbstractImmutableCollection<DummyCollectionItem>
 *
 * @method self filter(callable $func)
 * @method self reverse()
 */
final class OtherImmutableCollection extends AbstractImmutableCollection
{
    public function getItemClassName(): string
    {
        return OtherCollectionItem::class;
    }
}
