<?php

declare(strict_types=1);

namespace Headsnet\Collections;

use Headsnet\Collections\Exception\ItemNotFoundException;

/**
 * @template TValue
 */
interface Collection
{
    /**
     * Static factory method to create a collection
     * from an array of items.
     *
     * @param array<TValue> $items
     */
    public static function from(array $items): static;

    /**
     * Returns the class-string of the item objects
     * in this collection.
     */
    public function getItemClassName(): string;

    /**
     * Returns an item from the specified position.
     *
     * @return TValue
     */
    public function get(int $index);

    /**
     * Check if an item exists at the specified position.
     */
    public function has(int $index): bool;

    /**
     * Returns true if the collection contains zero items
     */
    public function isEmpty(): bool;

    /**
     * Returns true if the collection contains one
     * or more items
     */
    public function isNotEmpty(): bool;

    /**
     * Returns the first item in the collection.
     * If no item is found, returns null.
     *
     * @return TValue|null
     */
    public function first();

    /**
     * Returns the first item in the collection.
     * Throws an exception if there is no first item.
     *
     * @throws ItemNotFoundException
     *
     * @return TValue
     */
    public function firstOrFail();

    /**
     * Returns the last item in the collection.
     * If no item is found, returns null.
     *
     * @return TValue|null
     */
    public function last();

    /**
     * Returns the last item in the collection.
     * Throws an exception if there is no last item.
     *
     * @return TValue
     * @throws ItemNotFoundException
     */
    public function lastOrFail();

    /**
     * Compare with a different collection of the same type.
     * Returns true if the two collections are identical.
     *
     * @param Collection<TValue> $compareWith
     */
    public function equals(Collection $compareWith): bool;

    /**
     * Returns true if the specified items is present in
     * the collection.
     *
     * @param TValue $element
     */
    public function contains($element): bool;

    /**
     * Apply a callable function to each item in the
     * collection and return the result as an array.
     *
     * @return array<mixed>
     */
    public function map(callable $func): array;

    /**
     * Map each collection item via a callable into
     * a new collection of type $newCollectionClass.
     *
     * @template NewTValue of Collection
     * @param class-string<NewTValue> $newCollectionClass
     *
     * @return Collection<NewTValue>
     */
    public function mapTo(callable $func, string $newCollectionClass): Collection;

    /**
     * Return a new collection of the same type, with
     * only the items that pass the condition specified
     * in the passed callable present in the new collection.
     *
     * @return static<TValue>
     */
    public function filter(callable $func): Collection|static;

    /**
     * Returns a new collection with the items in reverse
     * order. Keys are not preserved.
     *
     * @return static<TValue>
     */
    public function reverse(): Collection|static;

    /**
     * Apply a callable function to each item in
     * the collection.
     */
    public function walk(callable $func): bool;

    /**
     * Return all collection items as an array.
     *
     * @return array<int, TValue>
     */
    public function all(): array;

    /**
     * Get the number of items in the collection.
     */
    public function count(): int;
}
