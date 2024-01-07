<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

use Headsnet\Collections\AbstractMutableCollection;

/**
 * @extends AbstractMutableCollection<DummyCollectionItem>
 */
final class DummyMutableCollection extends AbstractMutableCollection
{
    public function getItemClassName(): string
    {
        return DummyCollectionItem::class;
    }
}
