<?php
declare(strict_types=1);

namespace Headsnet\Collections;

use ArrayIterator;
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Headsnet\Collections\Exception\InvalidTypeException;
use Headsnet\Collections\Exception\ItemNotFoundException;
use Headsnet\Collections\Exception\OutOfRangeException;

/**
 * @template TValue
 * @implements ImmutableCollection<TValue>
 */
abstract class AbstractImmutableCollection implements ImmutableCollection
{
    protected string $itemClassName;

    /**
     * @var array<TValue>
     */
    protected array $items = [];

    /**
     * @param array<TValue> $items
     */
    public function __construct(array $items)
    {
        $itemClassName = $this->getItemClassName();
        $this->itemClassName = $itemClassName;

        foreach ($items as $item) {
            if (!$item instanceof $itemClassName) {
                throw new InvalidTypeException();
            }

            if (!in_array($item, $this->items, true)) {
                $this->items[] = $item;
            }
        }
    }

    /**
     * @return class-string
     */
    abstract public function getItemClassName(): string;

    /**
     * @param array<TValue> $items
     */
    public static function from(array $items): static
    {
        $class = static::class;

        return new $class($items);
    }

    /**
     * @param DoctrineCollection<int, TValue> $items
     */
    public static function fromDoctrine(DoctrineCollection $items): static
    {
        $class = static::class;

        return new $class($items->toArray());
    }

    /**
     * @param array<mixed> $items
     */
    public static function mapFrom(array $items, callable $mapper): static
    {
        $class = static::class;

        return new $class(
            array_map($mapper, $items)
        );
    }

    public static function empty(): static
    {
        $class = static::class;

        return new $class([]);
    }

    /**
     * @return TValue
     */
    public function get(int $index)
    {
        if ($index >= $this->count()) {
            throw new OutOfRangeException('Index: ' . $index);
        }

        return $this->items[$index];
    }

    public function has(int $index): bool
    {
        return $index < $this->count();
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    /**
     * @return TValue|null
     */
    public function first()
    {
        return reset($this->items) ?: null;
    }

    /**
     * @return TValue
     */
    public function firstOrFail()
    {
        return reset($this->items) ?: throw new ItemNotFoundException();
    }

    /**
     * @return TValue|null
     */
    public function last()
    {
        return end($this->items) ?: null;
    }

    /**
     * @return TValue
     */
    public function lastOrFail()
    {
        return end($this->items) ?: throw new ItemNotFoundException();
    }

    /**
     * @param Collection<TValue> $compareWith
     */
    public function equals(Collection $compareWith): bool
    {
        foreach ($this->items as $index => $item) {
            try {
                if ($item !== $compareWith->get($index)) {
                    return false;
                }
            } catch (OutOfRangeException) {
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
     * @return static<TValue>
     */
    public function filter(callable $func): Collection|static
    {
        $class = static::class;

        return new $class(array_filter($this->items, $func));
    }

    /**
     * @return static<TValue>
     */
    public function reverse(): Collection|static
    {
        $class = static::class;

        return new $class(array_reverse($this->items));
    }

    public function walk(callable $func): bool
    {
        return array_walk($this->items, $func);
    }

    /**
     * @return array<int, TValue>
     */
    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return ArrayIterator<(int&int)|(string&int), TValue>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
