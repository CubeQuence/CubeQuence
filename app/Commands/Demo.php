<?php

declare(strict_types=1);

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Demo
{
    /**
     * Demo command.
     */
    public function demo(InputInterface $input, OutputInterface $output, SymfonyStyle $io): void
    {
        $io->success('Demo run successfully');
    }
}
