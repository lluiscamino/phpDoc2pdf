<?php
namespace application;
require 'FilesTreatment.php';

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 * @package application
 */
class Command extends SymfonyCommand {

    /**
     * Command constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function createDocs(InputInterface $input, OutputInterface $output): void {
        $inputPath = $input->getArgument('inputPath');
        $outputPath = $input->getArgument('outputPath');
        try {
            $filesTreatment = new FilesTreatment($inputPath);
            $filesTreatment->createDocs($output, $outputPath);
        } catch (\Exception $e) {
            $output->writeln('Documentation could not be created.');
        }
    }
}