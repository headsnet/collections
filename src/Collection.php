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
     * @param array<TValue> $items
     */
    public static function from(array $items): static;

    public function getItemClassName(): string;

    /**
     * @return TValue
     */
    public function get(int $index);

    public function has(int $index): bool;

    public function isEmpty(): bool;

    public function isNotEmpty(): bool;

    /**
     * @return TValue|null
     */
    public function first();

    /**
     * @throws ItemNotFoundException
     *
     * @return TValue
     */
    public function firstOrFail();

    /**
     * @return TValue|null
     */
    public function last();

    /**
     * @throws ItemNotFoundException
     *
     * @return TValue
     */
    public function lastOrFail();

    /**
     * @param Collection<TValue> $compareWith
     */
    public function equals(Collection $compareWith): bool;

    /**
     * @param TValue $element
     */
    public function contains($element): bool;

    /**
     * @return array<mixed>
     */
    public function map(callable $func): array;

    /**
     * @template NewTValue of Collection
     * @param class-string<NewTValue> $newCollectionClass
     *
     * @return Collection<NewTValue>
     */
    public function mapTo(callable $func, string $newCollectionClass): Collection;

    /**
     * @return static<TValue>
     */
    public function filter(callable $func): Collection|static;

    /**
     * @return static<TValue>
     */
    public function reverse(): Collection|static;

    public function walk(callable $func): bool;

    /**
     * @return array<int, TValue>
     */
    public function all(): array;

    public function count(): int;
}
