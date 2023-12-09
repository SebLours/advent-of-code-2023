<?php

declare(strict_types=1);

namespace AdventOfCode\Day01;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'day01:2', description: 'Day 1 - Answer 2')]
final class Answer2 extends Command
{
    public function __construct(
        private readonly InputLoader $inputLoader,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'input',
                null,
                InputOption::VALUE_OPTIONAL,
                'The input file',
                'day01/input.txt',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = $this->inputLoader->lines($input->getOption('input'));

        $sum = $lines
            ->map(static function (string $line): Collection {
                preg_match_all('/(?=(\d|one|two|three|four|five|six|seven|eight|nine))/', $line, $matches);

                return Collection::fromIterable($matches[1]);
            })
            ->map(
                static fn (Collection $values): Collection => $values
                    ->map(static fn (string $value): string => str_replace(
                        ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'],
                        range(1, 9),
                        $value,
                    )),
            )
            ->map(static fn (Collection $digits): int => (int) ($digits->first() . $digits->last()))
            ->reduce(static fn (int $carry, int $item): int => $carry + $item, 0)
        ;

        $output->writeln(sprintf(
            'The sum of all of the calibration values is <options=bold,underscore>%d</>',
            $sum,
        ));

        return Command::SUCCESS;
    }
}
