<?php

declare(strict_types=1);

namespace Headsnet\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface ImmutableCollection extends Countable, IteratorAggregate, ArrayAccess
{
    public function getItemClassName(): string;

    /**
     * @return mixed
     */
    public function getItem(int $index);
}
