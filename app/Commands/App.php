<?php

namespace App\Commands;

use CQ\Helpers\App as AppHelper;
use CQ\Helpers\Str;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class App
{
    /**
     * Generate key command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param SymfonyStyle    $io
     */
    public function key(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        if (AppHelper::environment('production')) {
            $io->note('Application In Production!');
            if (!$io->confirm('Do you really wish to run this command?', false)) {
                $io->note('Command Canceled!');

                return;
            }
        }

        try {
            $length = $io->ask('Key length', 64, function ($number) {
                if (!is_numeric($number)) {
                    throw new \RuntimeException('You must type a number.');
                }

                return (int) $number;
            });

            $key = Str::random($length);
            $path = __DIR__.'/../../.env';

            if (!file_exists($path)) {
                $io->warning('.env file not found, please set key manually');
                $io->text("APP_KEY=\"{$key}\"");

                return;
            }

            file_put_contents($path, str_replace(
                'APP_KEY="'.getenv('APP_KEY').'"',
                'APP_KEY="'.$key.'"',
                file_get_contents($path)
            ));
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        $io->success('Key set successfully');
    }
}
