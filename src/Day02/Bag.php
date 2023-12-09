<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

use ArrayObject;
use SplObjectStorage;

final class Bag
{
    private SplObjectStorage $byColorCubes;

    public function __construct(Cube ...$cubes)
    {
        $this->byColorCubes = new SplObjectStorage();

        foreach ($cubes as $cube) {
            if (!$this->byColorCubes->contains($cube)) {
                $this->byColorCubes->attach($cube, new ArrayObject());
            }

            $this->byColorCubes[$cube]->append($cube);
        }
    }

    public function cubes(): iterable
    {
        foreach ($this->byColorCubes as $cube) {
            yield from $this->byColorCubes[$cube];
        }
    }

    public function out(Cube $cube): void
    {
        $colorCubes = $this->byColorCubes[$cube]->getArrayCopy();

        if (null === array_pop($colorCubes)) {
            throw new NotEnoughCubeException('Not enough cube');
        }

        $this->byColorCubes[$cube] = new ArrayObject($colorCubes);
    }
}
