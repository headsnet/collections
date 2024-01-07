<?php
declare(strict_types=1);

namespace Headsnet\Collections;

use Headsnet\Collections\Exception\ItemNotFoundException;

/**
 * @template TValue
 * @extends AbstractImmutableCollection<TValue>
 * @implements MutableCollection<TValue>
 */
abstract class AbstractMutableCollection extends AbstractImmutableCollection implements MutableCollection
{
    /**
     * @param TValue $item
     */
    public function add($item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param TValue $item
     */
    public function remove($item): void
    {
        $this->items = array_filter(
            $this->items,
            fn ($storedItem): bool => $item !== $storedItem
        );
    }

    public function removeAtPosition(int $index): void
    {
        if (!array_key_exists($index, $this->items)) {
            throw new ItemNotFoundException();
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }
}
