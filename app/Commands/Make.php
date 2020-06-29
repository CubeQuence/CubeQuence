<?php

namespace App\Commands;

use CQ\Helpers\App;
use Exception;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Make
{
    /**
     * Make migration.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param SymfonyStyle    $io
     */
    public function migration(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        if (App::environment('production')) {
            $io->note('Application In Production!');
            if (!$io->confirm('Do you really wish to run this command?', false)) {
                $io->note('Command Canceled!');

                return;
            }
        }

        try {
            $name = $input->getArgument('name');
            $phinx = new PhinxApplication();
            $command = $phinx->find('create');

            $arguments = [
                'command' => 'create',
                'name' => $name,
                '--template' => __DIR__.'/../../vendor/cubequence/framework/src/CubeQuence/DB/Template/Migration.php',
                '--configuration' => __DIR__.'/../../phinx.php',
            ];

            $command->run(new ArrayInput($arguments), $output);
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        $io->success('Migration created');
    }

    /**
     * Make seed.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param SymfonyStyle    $io
     */
    public function seed(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        if (App::environment('production')) {
            $io->note('Application In Production!');
            if (!$io->confirm('Do you really wish to run this command?', false)) {
                $io->note('Command Canceled!');

                return;
            }
        }

        try {
            $name = $input->getArgument('name');
            $phinx = new PhinxApplication();
            $command = $phinx->find('seed:create');

            $arguments = [
                'command' => "seed:create {$name}",
                'name' => $name,
                '--configuration' => __DIR__.'/../../phinx.php',
            ];

            $command->run(new ArrayInput($arguments), $output);
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        $io->success('Seed created');
    }
}
