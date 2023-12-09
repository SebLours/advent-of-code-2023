<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day03;

use AdventOfCode\Tests\ApplicationAwareTester;

final class AnswerTest extends ApplicationAwareTester
{
    public function test_answer_1_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day03:1',
            '--input' => 'day03/input.sample.txt',
        ]);

        $this->assertSame(
            'The sum of part numbers is 4361',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_1(): void
    {
        $this->applicationTester->run([
            'command' => 'day03:1',
        ]);

        $this->assertSame(
            'The sum of part numbers is 529618',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day03:2',
            '--input' => 'day03/input.sample.txt',
        ]);

        $this->assertSame(
            'The sum of all of the gear ratios is 467835',
            trim($this->applicationTester->getDisplay()),
        );
    }
}
