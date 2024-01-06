<?php
declare(strict_types=1);

namespace Headsnet\Collections;

use ArrayIterator;
use Headsnet\Collections\Exception\ImmutabilityException;
use Headsnet\Collections\Exception\InvalidTypeException;
use Headsnet\Collections\Exception\OutOfRangeException;

/**
 * @template TKey
 * @template TValue
 * @implements ImmutableCollection<TKey, TValue>
 */
abstract class AbstractImmutableCollection implements ImmutableCollection
{
    protected string $itemClassName;

    /**
     * @var array<TKey, TValue>
     */
    protected array $items = [];

    /**
     * Creates a new typed collection.
     *
     * @param string $itemClassName String representing the class name of the valid type for the items
     * @param array<TKey, TValue> $items Array with all the objects to be added. They must be of the class $itemClassName.
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
     * @param TKey $index
     *
     * @return TValue
     */
    public function getItem($index)
    {
        if ($index >= $this->count())
        {
            throw new OutOfRangeException('Index: ' . $index);
        }

        return $this->items[$index];
    }

    /**
     * @param TKey $index
     */
    public function indexExists($index): bool
    {
        return $index < $this->count();
    }

    /**
     * @return TValue|false
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * @return TValue|false
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * @param AbstractImmutableCollection<TKey, TValue> $compareWith
     */
    public function equals(self $compareWith): bool
    {
        foreach ($this->items as $index => $item)
        {
            try
            {
                if ($item !== $compareWith->getItem($index))
                {
                    return false;
                }
            }
            catch (OutOfRangeException)
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

    /**
     * @return array<mixed>
     */
    public function map(callable $func): array
    {
        return array_map($func, $this->items);
    }

    /**
     * @return static<TKey, TValue>
     */
    public function filter(callable $func): AbstractImmutableCollection|static
    {
        $class = static::class;

        return new $class(array_filter($this->items, $func));
    }

    public function walk(callable $func): bool
    {
        return array_walk($this->items, $func);
    }

    /**
     * @return array<TKey, TValue>
     */
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

    /**
     * @return ArrayIterator<(int&TKey)|(string&TKey), TValue>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param TKey   $offset
     * @param TValue $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new ImmutabilityException();
    }

    /**
     * @param TKey $offset
     */
    public function offsetUnset($offset): void
    {
        throw new ImmutabilityException();
    }

    /**
     * @param TKey $offset
     *
     * @return TValue
     */
    public function offsetGet($offset): mixed
    {
        return $this->getItem($offset);
    }

    /**
     * @param TKey $offset
     */
    public function offsetExists($offset): bool
    {
        return $this->indexExists($offset);
    }
}
