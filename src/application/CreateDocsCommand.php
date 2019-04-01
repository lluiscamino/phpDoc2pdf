<?php
namespace application;
require 'Command.php';

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateDocsCommand
 * @package application
 */
class CreateDocsCommand extends Command {

    /**
     * Configure method.
     */
    public function configure(): void
    {
        $this->setName('create')
            ->setDescription('Create PDF format documentation.')
            ->setHelp('This command allows you to generate documentation for your PHP files.')
            ->addArgument('inputPath', InputArgument::REQUIRED, 'File or directory path where the PHP code is.')
            ->addArgument('outputPath', InputArgument::REQUIRED, 'Directory where the documentation will be created.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->createDocs($input, $output);
    }
}