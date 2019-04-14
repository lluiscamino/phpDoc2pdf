<?php
namespace tests;

require '../vendor/autoload.php';
require '../src/create_documentation/PDFFile.php';

use Mpdf\MpdfException;
use PHPUnit\Framework\TestCase;
use create_documentation\PDFFile;

class PDFFileTest extends TestCase
{

    /**
     * @test
     */
    public function PDFFileCannotBeCreatedFromInvalidPath(): void {
        $this->expectException(MpdfException::class);
        PDFFile::fromString('invalid-path');
    }
}