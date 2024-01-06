<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Fixtures;

final class DummyCollectionItem
{
    public function __construct(
        public ?string $name = null
    ) {
    }
}
