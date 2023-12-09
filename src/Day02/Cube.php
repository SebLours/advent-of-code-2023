<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

enum Cube
{
    case RED;
    case GREEN;
    case BLUE;

    public static function fromExpr(string $expression): iterable
    {
        preg_match_all('/(\d+) (blue|red|green)/', $expression, $matches, \PREG_SET_ORDER);

        foreach ($matches as $match) {
            for ($i = 1; $i <= (int) $match[1]; ++$i) {
                yield Cube::{strtoupper($match[2])};
            }
        }
    }
}
