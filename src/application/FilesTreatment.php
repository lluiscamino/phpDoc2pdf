<?php
namespace application;
require dirname(__DIR__) . '/create_documentation/PDFFile.php';

use create_documentation\PDFFile;

/**
 * Class FilesTreatment
 * @package application
 */
class FilesTreatment {

    /**
     * @var \phpDocumentor\Reflection\File\LocalFile
     */
    private $files = array();

    /**
     * FilesTreatment constructor.
     * @param string $fileOrDir
     * @throws \Exception if $fileOrDir is not file or directory.
     */
    public function __construct(string $fileOrDir) {
        if (is_file($fileOrDir)) {
            $this->files[] = new \phpDocumentor\Reflection\File\LocalFile($fileOrDir);
        } else if (is_dir($fileOrDir)) {
            $this->files = self::filesFromDirectory($fileOrDir);
        } else {
            throw new \Exception('Input should be a file or a directory.');
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $outputPath
     * @throws \Mpdf\MpdfException
     * @throws \phpDocumentor\Reflection\Exception
     */
    public function createDocs(\Symfony\Component\Console\Output\OutputInterface $output, string $outputPath): void {
        $projectFactory = \phpDocumentor\Reflection\Php\ProjectFactory::createInstance();
        $project = $projectFactory->create('Project to document', $this->files);
        foreach ($project->getFiles() as $file) {
            foreach ($file->getClasses() as $class) {
                $pdfFile = new PDFFile($outputPath . '/' . $class->getName());
                $output->writeln('Documenting class ' . $class->getName());
                $pdfFile->createFromClass($class);
            }
            foreach ($file->getInterfaces() as $interface) {
                $pdfFile = new PDFFile($outputPath . '/' . $interface->getName());
                $output->writeln('Documenting interface ' . $interface->getName());
                $pdfFile->createFromInterface($interface);
            }
            foreach ($file->getTraits() as $trait) {
                $pdfFile = new PDFFile($outputPath . '/' . $trait->getName());
                $output->writeln('Documenting trait ' . $trait->getName());
                $pdfFile->createFromTrait($trait);
            }
        }
    }

    /**
     * @param string $directory
     * @param string[] $results
     * @return \phpDocumentor\Reflection\File\LocalFile[]
     */
    private static function filesFromDirectory(string $directory, array &$results = array()): array {
        $files = scandir($directory);
        foreach($files as $value) {
            $path = realpath($directory . DIRECTORY_SEPARATOR . $value);
            if(!is_dir($path)) {
                if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    $results[] = new \phpDocumentor\Reflection\File\LocalFile($path);
                }
            } else if($value != '.' && $value != '..') {
                self::filesFromDirectory($path, $results);
            }
        }
        return $results;
    }
}