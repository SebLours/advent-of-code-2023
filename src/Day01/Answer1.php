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

#[AsCommand(name: 'day01:1', description: 'Day 1 - Answer 1')]
final class Answer1 extends Command
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
            ->map(static fn (string $line): Collection => Collection::fromString($line))
            ->map(
                static fn (Collection $values): Collection => $values
                    ->filter(static fn (string $value): bool => is_numeric($value)),
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
