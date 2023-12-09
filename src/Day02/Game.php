<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

final class Game
{
    private array $sets;

    public function __construct(
        public readonly Bag $bag,
        public readonly int $id,
        string ...$sets,
    ) {
        $this->sets = $sets;
    }

    public function isPossible(): bool
    {
        foreach ($this->sets as $set) {
            if (!$this->isSetPossible($set)) {
                return false;
            }
        }

        return true;
    }

    public function isSetPossible(string $set): bool
    {
        $bag = new Bag(...$this->bag->cubes());
        $cubes = Cube::fromExpr($set);

        try {
            foreach ($cubes as $cube) {
                $bag->out($cube);
            }
        } catch (NotEnoughCubeException) {
            return false;
        }

        return true;
    }
}
