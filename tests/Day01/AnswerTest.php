<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day01;

use AdventOfCode\Tests\ApplicationAwareTester;

final class AnswerTest extends ApplicationAwareTester
{
    public function test_answer_1_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day01:1',
            '--input' => 'day01/input.sample.txt',
        ]);

        $this->assertSame(
            'The sum of all of the calibration values is 142',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_1(): void
    {
        $this->applicationTester->run([
            'command' => 'day01:1',
        ]);

        $this->assertSame(
            'The sum of all of the calibration values is 54159',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day01:2',
            '--input' => 'day01/input.2.sample.txt',
        ]);

        $this->assertSame(
            'The sum of all of the calibration values is 281',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2(): void
    {
        $this->applicationTester->run([
            'command' => 'day01:2',
            '--input' => 'day01/input.txt',
        ]);

        $this->assertSame(
            'The sum of all of the calibration values is 53866',
            trim($this->applicationTester->getDisplay()),
        );
    }
}
