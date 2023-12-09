<?php

declare(strict_types=1);

namespace AdventOfCode\Day03;

final class Symbol
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly string $value,
    ) {
    }

    public function isAdjacent(Number $number): bool
    {
        return $number->isAdjacent($this);
    }
}
