<?php

declare(strict_types=1);

namespace Headsnet\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @template TKey
 * @template TValue
 * @extends IteratorAggregate<TKey, TValue>
 * @extends ArrayAccess<TKey, TValue>
 */
interface ImmutableCollection extends Countable, IteratorAggregate, ArrayAccess
{
    public function getItemClassName(): string;

    /**
     * @param TKey $index
     * @return TValue
     */
    public function getItem($index);
}
