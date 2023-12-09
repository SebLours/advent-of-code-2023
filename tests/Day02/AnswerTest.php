<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day02;

use AdventOfCode\Tests\ApplicationAwareTester;

final class AnswerTest extends ApplicationAwareTester
{
    public function test_answer_1_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day02:1',
            '--input' => 'day02/input.sample.txt',
        ]);

        $this->assertSame(
            'The sum of the IDs of the games that would have been possible is 8',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_1(): void
    {
        $this->applicationTester->run([
            'command' => 'day02:1',
        ]);

        $this->assertSame(
            'The sum of the IDs of the games that would have been possible is 2156',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day02:2',
            '--input' => 'day02/input.sample.txt',
        ]);

        $this->assertSame(
            'The sum of the sets power is 2286',
            trim($this->applicationTester->getDisplay()),
        );
    }
}
