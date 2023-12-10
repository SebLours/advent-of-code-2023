<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use loophp\collection\Collection;

final class Almanac
{
    public function __construct(
        private readonly array $seeds = [],
        private array $maps = [],
    ) {
    }

    public function addMapRange(string $map, int $destinationRangeStart, int $sourceRangeStart, int $rangeLength): void
    {
        $this->maps[$map][] = [
            'start' => $sourceRangeStart,
            'end' => $sourceRangeStart + --$rangeLength,
            'offset' => $destinationRangeStart - $sourceRangeStart,
        ];
    }

    public function getMapOffset(string $map, int $location): int
    {
        foreach ($this->maps[$map] as $range) {
            if ($range['start'] <= $location && $range['end'] >= $location) {
                return $range['offset'];
            }
        }

        return 0;
    }

    public function seedLocations(int $seed): iterable
    {
        yield 'seed' => $location = $seed;

        foreach (array_keys($this->maps) as $map) {
            yield $map => ($location += $this->getMapOffset($map, $location));
        }

        yield 'location' => $location;
    }

    public function getLowestLocation(): int
    {
        $locations = Collection::fromIterable([]);

        foreach ($this->seeds as $seed) {
            $locations = $locations->append(Collection::fromIterable($this->seedLocations($seed))->last());
        }

        return $locations->min();
    }
}
