<?php
namespace tests;

require '../vendor/autoload.php';
require '../src/application/FilesTreatment.php';

use phpDocumentor\Reflection\File\LocalFile;
use PHPUnit\Framework\TestCase;
use application\FilesTreatment;

class FilesTreatmentTest extends TestCase
{
    /**
     * @test
     */
    public function FilesTreatmentCannotBeInstantiatedFromInvalidFile(): void {
        $this->expectException(\Exception::class);
        new FilesTreatment('invalid-file.php');
    }

    /**
     * @test
     */
    public function FilesTreatmentCannotBeInstantiatedFromInvalidPath(): void {
        $this->expectException(\Exception::class);
        new FilesTreatment('invalid-path');
    }

    /**
     * @test
     * @throws \Exception
     */
    public function filesFromDirectoryAreCorrect(): void {
        $attribute = (new \ReflectionClass('application\FilesTreatment'))->getProperty('files');
        $attribute->setAccessible(true);
        $filesAttribute = array_map(function(LocalFile $localFileObject): string {
            $localFileObjectAttribute = (new \ReflectionClass('\phpDocumentor\Reflection\File\LocalFile'))->getProperty('path');
            $localFileObjectAttribute->setAccessible(true);
            return $localFileObjectAttribute->getValue($localFileObject);
        }, ($attribute->getValue(new FilesTreatment(dirname(__DIR__ . '/tests')))));
        $expectedFilesAttribute = array(
            dirname(__DIR__) . '/tests/FilesTreatmentTest.php',
            dirname(__DIR__) . '/tests/PDFFileTest.php'
        );
        $this->assertEquals($expectedFilesAttribute, $filesAttribute);
    }
}