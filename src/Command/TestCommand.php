<?php

namespace Pnl\PnlTest\Command;

use Pnl\App\AbstractCommand;
use Pnl\App\SettingsProvider;
use Pnl\Application;
use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\InputInterface;
use Pnl\Console\Output\OutputInterface;
use Pnl\PnlTest\PnlTest;

class TestCommand extends AbstractCommand
{
    protected const NAME = 'test';

    private string $secret;

    private string $rootPath;

    public function __construct(
        SettingsProvider $provider,
        Application $pnl,
    ) {
        $this->secret = $provider->get('test.secret');
        $this->rootPath = $pnl->get('PWD');
    }

    public function getDescription(): string
    {
        return 'Test command';
    }

    public static function getArguments(): ArgumentBag
    {
        $bag = new ArgumentBag();

        $bag->add('secret', true, 'Use for secret test');

        return $bag;
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln("Testing pnl ...");

        if ($this->secret !== $input->get('secret')) {
            throw new \Exception(sprintf('Secret is not valid : expected %s, got %s', $this->secret, $input->get('secret')));
        }

        $output->writeln("Succefully test settings Provider !");

        $extensions = require $this->rootPath . '/core/config/extensions.php';

        if ($extensions !== [PnlTest::class]) {
            throw new \Exception(sprintf('Extensions is not valid : expected %s, got %s', PnlTest::class, $extensions));
        }

        $output->writeln("Succefully test extensions file");


        $output->writeln("Succefully test command !");
    }
}
