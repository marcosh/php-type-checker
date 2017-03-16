<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Command;

use Marcosh\PhpReturnTypeChecker\Checker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CheckReturnTypes extends Command
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

        foreach ($check($path) as $method) {
            $output->writeln(sprintf(
                'Method %s of the class %s defined in %s does not have a return type.',
                $method->getName(),
                $method->getDeclaringClass()->getName(),
                $method->getFileName()
            ));
        }

        $output->writeln('Done!');
    }
}
