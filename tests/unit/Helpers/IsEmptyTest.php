<?php
declare(strict_types=1);

namespace Headsnet\Collections\Test\Helpers;

use Headsnet\Collections\Test\Fixtures\DummyImmutableCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Headsnet\Collections\AbstractImmutableCollection
 */
final class IsEmptyTest extends TestCase
{
    public function test_is_empty_check_is_correct(): void
    {
        $sut = DummyImmutableCollection::empty();

        $this->assertTrue($sut->isEmpty());
    }

    public function test_is_not_empty_check_is_correct(): void
    {
        $sut = DummyImmutableCollection::empty();

        $this->assertFalse($sut->isNotEmpty());
    }
}
