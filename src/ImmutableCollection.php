<?php

declare(strict_types=1);

namespace Headsnet\Collections;

use Countable;
use IteratorAggregate;

/**
 * @template TValue
 * @extends IteratorAggregate<TValue>
 * @extends Collection<TValue>
 */
interface ImmutableCollection extends Countable, IteratorAggregate, Collection
{
}
