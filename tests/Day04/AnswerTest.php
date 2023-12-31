<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day04;

use AdventOfCode\Tests\ApplicationAwareTester;

final class AnswerTest extends ApplicationAwareTester
{
    public function test_answer_1_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day04:1',
            '--input' => 'day04/input.sample.txt',
        ]);

        $this->assertSame(
            'There are 13 points worth in total',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_1e(): void
    {
        $this->applicationTester->run([
            'command' => 'day04:1',
        ]);

        $this->assertSame(
            'There are 20407 points worth in total',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day04:2',
            '--input' => 'day04/input.sample.txt',
        ]);

        $this->assertSame(
            'The total scratchcards is 30',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2(): void
    {
        $this->applicationTester->run([
            'command' => 'day04:2',
        ]);

        $this->assertSame(
            'The total scratchcards is 23806951',
            trim($this->applicationTester->getDisplay()),
        );
    }
}
