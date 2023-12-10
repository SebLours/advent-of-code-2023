<?php

declare(strict_types=1);

namespace AdventOfCode\Day03;

use AdventOfCode\InputLoader;
use loophp\collection\Collection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'day03:2', description: 'Day 3- Answer 2')]
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
                'day03/input.txt',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = $this->inputLoader->lines($input->getOption('input'));

        $items = $lines
            ->map(static function (string $value, int $key): iterable {
                preg_match_all('/\d+/', $value, $matches, \PREG_OFFSET_CAPTURE);

                foreach ($matches[0] as $match) {
                    yield 'number' => new Number((int) $match[1], $key, (int) $match[0]);
                }

                preg_match_all('/[^\d\.]/', $value, $matches, \PREG_OFFSET_CAPTURE);

                foreach ($matches[0] as $match) {
                    yield 'symbol' => new Symbol((int) $match[1], $key, (string) $match[0]);
                }
            })
            ->flatten()
            ->groupBy(static fn (Number|Symbol $item, string $key): string => $key)
            ->all(false)
        ;

        $numbers = Collection::fromIterable($items['number']);

        $result = Collection::fromIterable($items['symbol'])
            ->filter(static fn (Symbol $symbol): bool => '*' === $symbol->value)
            ->map(static function (Symbol $symbol) use ($numbers): iterable {
                $adjacentNumbers = Collection::fromIterable($numbers)
                    ->filter(static fn (Number $number): bool => $number->isAdjacent($symbol))
                ;

                if ($adjacentNumbers->count() === 2) {
                    yield $adjacentNumbers->reduce(static fn (int $carry, Number $number): int => $carry * $number->value, 1);
                }
            })
            ->flatten()
            ->reduce(static fn (int $carry, int $ratio): int => $carry + $ratio, 0)
        ;

        $output->writeln(sprintf(
            'The sum of all of the gear ratios is <options=bold,underscore>%d</>',
            $result,
        ));

        return Command::SUCCESS;
    }
}
