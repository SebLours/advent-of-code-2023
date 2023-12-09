<?php

declare(strict_types=1);

namespace AdventOfCode\Day03;

final class Number
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $value,
    ) {
    }

    public function isAdjacent(Symbol $symbol): bool
    {
        if ($this->y === $symbol->y) {
            return $symbol->x === ($this->x - 1) || $symbol->x === ($this->x + strlen((string) $this->value));
        }

        if (abs($this->y - $symbol->y) > 1) {
            return false;
        }

        return ($this->x - 1) <= $symbol->x && $symbol->x <= ($this->x + strlen((string) $this->value));
    }
}
