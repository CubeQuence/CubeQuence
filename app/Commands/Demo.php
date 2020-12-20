<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Demo
{
    /**
     * Demo command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param SymfonyStyle    $io
     */
    public function demo(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        $io->success('Demo run successfully');
    }
}
