<?php

namespace App\Commands;

use CQ\Helpers\App;
use Exception;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DB
{
    /**
     * Migrate command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param SymfonyStyle    $io
     */
    public function migrate(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        if (App::environment('production')) {
            $io->note('Application In Production!');
            if (!$io->confirm('Do you really wish to run this command?', false)) {
                $io->note('Command Canceled!');

                return;
            }
        }

        try {
            $fresh = $input->getOption('fresh');
            $phinx = new PhinxApplication();
            $command = $phinx->find('rollback');

            $arguments = [
                'command' => 'rollback',
                '--environment' => App::environment(),
                '--target' => '0',
                '--force',
            ];

            if ($fresh) {
                $command->run(new ArrayInput($arguments), $output);
                $io->success('Reset successful');
            }
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        try {
            $phinx = new PhinxApplication();
            $command = $phinx->find('migrate');

            $arguments = [
                'command' => 'migrate',
                '--environment' => App::environment(),
                '--configuration' => __DIR__.'/../../phinx.php',
            ];

            $command->run(new ArrayInput($arguments), $output);
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        $io->success('Migration successful');
    }

    /**
     * Seed command.
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
            $phinx = new PhinxApplication();
            $command = $phinx->find('seed:run');

            $arguments = [
                'command' => 'seed:run',
                '--environment' => App::environment(),
                '--configuration' => __DIR__.'/../../phinx.php',
            ];

            $command->run(new ArrayInput($arguments), $output);
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        $io->success('Seeding successful');
    }
}
