<?php

declare(strict_types=1);

namespace AdventOfCode\Tests\Day05;

use AdventOfCode\Tests\ApplicationAwareTester;

final class AnswerTest extends ApplicationAwareTester
{
    public function test_answer_1_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day05:1',
            '--input' => 'day05/input.sample.txt',
        ]);

        $this->assertSame(
            'There lowest location is 35',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_1(): void
    {
        $this->applicationTester->run([
            'command' => 'day05:1',
        ]);

        $this->assertSame(
            'There lowest location is 31599214',
            trim($this->applicationTester->getDisplay()),
        );
    }

    public function test_answer_2_sample(): void
    {
        $this->applicationTester->run([
            'command' => 'day05:2',
            '--input' => 'day05/input.sample.txt',
        ]);

        $this->assertSame(
            'There lowest location is 46',
            trim($this->applicationTester->getDisplay()),
        );
    }
}
