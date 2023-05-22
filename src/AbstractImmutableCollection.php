<?php
declare(strict_types=1);

namespace Headsnet\Collections;

use ArrayIterator;
use Headsnet\Collections\Exception\ImmutabilityException;
use Headsnet\Collections\Exception\InvalidTypeException;
use Headsnet\Collections\Exception\OutOfRangeException;

/**
 * @template TValue
 * @implements ImmutableCollection<TValue>
 */
abstract class AbstractImmutableCollection implements ImmutableCollection
{
    protected string $itemClassName;

    protected array $items = [];

    /**
     * Creates a new typed collection.
     *
     * @param string $itemClassName String representing the class name of the valid type for the items
     * @param array<TValue> $items Array with all the objects to be added. They must be of the class $itemClassName.
     */
    public function __construct(string $itemClassName, array $items = [])
    {
        $this->itemClassName = $itemClassName;

        foreach ($items as $item)
        {
            if (!($item instanceof $itemClassName))
            {
                throw new InvalidTypeException();
            }

            if (!in_array($item, $this->items, true))
            {
                $this->items[] = $item;
            }
        }
    }

    public function getItemClassName(): string
    {
        return $this->itemClassName;
    }

    /**
     * @return TValue
     */
    public function getItem(int $index)
    {
        if ($index >= $this->count())
        {
            throw new OutOfRangeException('Index: ' . $index);
        }

        return $this->items[$index];
    }

    public function indexExists(int $index): bool
    {
        return $index < $this->count();
    }

    /**
     * @return TValue
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * @return TValue
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * @param AbstractImmutableCollection $compareWith
     */
    public function equals(self $compareWith): bool
    {
        foreach ($this->items as $index => $item)
        {
            if (false === $item->equals($compareWith->getItem($index)))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * @param TValue $element
     */
    public function contains($element): bool
    {
        return in_array($element, $this->items, true);
    }

    public function map(callable $func): array
    {
        return array_map($func, $this->items);
    }

    public function filter(callable $func): self
    {
        $class = static::class;

        return new $class(array_filter($this->items, $func));
    }

    public function walk(callable $func): bool
    {
        return array_walk($this->items, $func);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    //---------------------------------------------------------------------//
    // Implementations                                                     //
    //---------------------------------------------------------------------//

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param int   $offset
     * @param TValue $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new ImmutabilityException();
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset): void
    {
        throw new ImmutabilityException();
    }

    /**
     * @param int $offset
     *
     * @return TValue
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getItem($offset);
    }

    /**
     * @param int $offset
     */
    public function offsetExists($offset): bool
    {
        return $this->indexExists($offset);
    }
}
