<?php

declare(strict_types=1);

namespace Headsnet\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * @template TValue
 * @extends IteratorAggregate<TValue>
 */
interface ImmutableCollection extends Countable, IteratorAggregate, ArrayAccess
{
    public function getItemClassName(): string;

    /**
     * @return TValue
     */
    public function getItem(int $index);
}
