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

#[AsCommand(name: 'day04:2', description: 'Day 4 - Answer 2')]
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
                'day04/input.txt',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = $this->inputLoader->lines($input->getOption('input'));

        $copies = $lines
            ->map(static function (string $line, int $key): iterable {
                $parts = preg_split('/\|/', $line);

                preg_match_all('/\d+/', preg_replace('/^Card\s+\d+:/', '', $parts[0]), $cardMatches);
                preg_match_all('/\d+/', $parts[1], $listMatches);

                yield ($key + 1) => [
                    'numbers' => $cardMatches[0],
                    'list' => $listMatches[0],
                ];
            })
            ->flatten(1)
            ->map(static function (array $set, int $cardNumber): iterable {
                $winning = Collection::fromIterable($set['numbers'])
                    ->intersect(...$set['list'])
                    ->count()
                ;

                yield $cardNumber => $winning;
            })
            ->reduce(
                static function (array $copies, \Generator $card) {
                    $cardNumber = $card->key();
                    $winningCards = $card->current();

                    $copies[$cardNumber] = ($copies[$cardNumber] ?? 0) + 1;

                    for ($i = 1; $i <= $copies[$cardNumber]; ++$i) {
                        for ($j = $cardNumber + 1; $j <= $cardNumber + $winningCards; ++$j) {
                            $copies[$j] = ($copies[$j] ?? 0) + 1;
                        }
                    }

                    return $copies;
                },
                [],
            )
        ;

        $total = array_sum($copies);

        $output->writeln(sprintf(
            'The total scratchcards is <options=bold,underscore>%d</>',
            $total,
        ));

        return Command::SUCCESS;
    }
}
