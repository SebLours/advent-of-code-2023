<?php

declare(strict_types=1);

namespace AdventOfCode\Day04;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'day04:1', description: 'Day 4 - Answer 1')]
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
                'day04/input.txt',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = $this->inputLoader->lines($input->getOption('input'));

        $points = $lines
            ->map(static function (string $line): iterable {
                $parts = preg_split('/\|/', $line);

                preg_match_all('/\d+/', preg_replace('/^Card\s+\d+:/', '', $parts[0]), $cardMatches);
                preg_match_all('/\d+/', $parts[1], $listMatches);

                yield [
                    'numbers' => $cardMatches[0],
                    'list' => $listMatches[0],
                ];
            })
            ->flatten(1)
            ->map(static function (array $set): int {
                $winning = Collection::fromIterable($set['numbers'])
                    ->intersect(...$set['list'])
                    ->count()
                ;

                return $winning > 0 ? 2 ** --$winning : 0;
            })
            ->reduce(static fn (int $carry, int $points): int => $carry + $points, 0)
        ;

        $output->writeln(sprintf(
            'There are <options=bold,underscore>%d</> points worth in total',
            $points,
        ));

        return Command::SUCCESS;
    }
}
