<?php

declare(strict_types=1);

namespace AdventOfCode\Day02;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'day02:2', description: 'Day 2 - Answer 2')]
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
                'day02/input.txt',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bag = new Bag(
            ...Cube::fromExpr('12 red, 13 green, 14 blue'),
        );

        $result = $this->inputLoader->lines($input->getOption('input'))
            ->map(static function (string $line) use ($bag): Game {
                preg_match('/^Game (\d+): (.*)$/', $line, $matches);

                return new Game($bag, (int) $matches[1], ...explode(';', $matches[2]));
            })
            ->reduce(static fn (int $carry, Game $game): int => $carry + $game->getSetPower(), 0)
        ;

        $output->writeln(sprintf(
            'The sum of the sets power is <options=bold,underscore>%d</>',
            $result,
        ));

        return Command::SUCCESS;
    }
}
