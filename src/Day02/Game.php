<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

use ArrayObject;

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

    public function getSetPower(): int
    {
        $score = new \SplObjectStorage();

        foreach ($this->sets as $key => $set) {
            foreach (Cube::fromExpr($set) as $cube) {
                if (!$score->contains($cube)) {
                    $score[$cube] = new ArrayObject();
                }

                $score[$cube][$key] = ($score[$cube][$key] ?? 0) + 1;
            }
        }

        $power = 1;

        foreach ($score as $cube) {
            $power *= max(1, max($score[$cube]->getArrayCopy()));
        }

        return $power;
    }
}
