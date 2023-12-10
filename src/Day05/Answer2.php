<?php

declare(strict_types=1);

namespace AdventOfCode\Day05;

use AdventOfCode\InputLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'day05:2', description: 'Day 5 - Answer 2')]
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
                'day05/input.txt',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = $this->inputLoader->lines($input->getOption('input'));

        $lines = $lines
            ->map(static function (string $line, int $key) {
                static $almanac, $map;

                if (empty($line)) {
                    return $almanac;
                }

                if (0 === $key) {
                    preg_match_all('/\d+/', $line, $matches);

                    $seeds = [];

                    foreach (array_chunk(array_map('intval', $matches[0]), 2) as $input) {
                        $seeds = array_merge($seeds, range($input[0], $input[0] + --$input[1]));
                    }

                    return $almanac = new Almanac(seeds: array_map('intval', $seeds));
                }

                if (preg_match('/(.*) map\:/', $line, $matches)) {
                    $map = $matches[1];

                    return $almanac;
                }

                preg_match_all('/\d+/', $line, $matches);

                $almanac->addMapRange($map, (int) $matches[0][0], (int) $matches[0][1], (int) $matches[0][2]);

                return $almanac;
            })
        ;

        $almanac = $lines->last();

        $output->writeln(sprintf(
            'There lowest location is <options=bold,underscore>%d</>',
            $almanac->getLowestLocation(),
        ));

        return Command::SUCCESS;
    }
}
