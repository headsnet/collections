<?php

declare(strict_types=1);

namespace Headsnet\Collections;

use Headsnet\Collections\Exception\ItemNotFoundException;

/**
 * @template TValue
 * @extends ImmutableCollection<TValue>
 */
interface MutableCollection extends ImmutableCollection
{
    /**
     * @param TValue $item
     */
    public function add($item): void;

    /**
     * @param TValue $item
     */
    public function remove($item): void;

    /**
     * @throws ItemNotFoundException
     */
    public function removeAtPosition(int $index): void;
}
