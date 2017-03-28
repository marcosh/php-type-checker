<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\Command;

use Marcosh\PhpTypeChecker\Checker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CheckTypes extends Command
{
    protected function configure()
    {
        $this->setName('check');
        $this->setDescription('Check methods return types');
        $this->addArgument('path', InputArgument::OPTIONAL, 'The path to check', '.');
        $this->setHelp(
            'This command allows you to check if all the methods ' .
            'of your application have an explicit return type'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        $check = new Checker();

        foreach ($check($path) as $typeHint) {
            $output->writeln($typeHint->message());
        }

        $output->writeln('Done!');
    }
}
