<?php
namespace create_documentation;

/**
 * Class that generates the PDF output.
 * @package create_documentation
 */
class PDFFile extends \Mpdf\Mpdf {

    /**
     * @var string
     */
    private $templatesPath = '../../templates/default';

    /**
     * @var \League\Plates\Engine
     */
    private $templatesEngine;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $html = '';

    /**
     * PDFFile constructor.
     * @param string $path
     * @throws \Mpdf\MpdfException
     */
    public function __construct(string $path) {
        $this->path = $path;
        $this->templatesEngine = new \League\Plates\Engine($this->templatesPath);
        parent::__construct();
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Class_ $class
     * @throws \Mpdf\MpdfException
     */
    public function createFromClass(\phpDocumentor\Reflection\Php\Class_ $class): void {
        $summary = $class->getDocBlock() !== null ? $class->getDocBlock()->getSummary() : '';
        $description = $class->getDocBlock() !== null ? $class->getDocBlock()->getDescription() : '';
        $this->writeHeader($class->getName(), $summary, $description);
        $this->writeSummary($class->getConstants(), $class->getProperties(), $class->getMethods());
        $this->writeConstants($class->getConstants());
        $this->writeProperties($class->getProperties());
        $this->writeMethods($class->getMethods());
        $this->create();
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Interface_ $interface
     * @throws \Mpdf\MpdfException
     */
    public function createFromInterface(\phpDocumentor\Reflection\Php\Interface_ $interface): void {
        $summary = $interface->getDocBlock() !== null ? $interface->getDocBlock()->getSummary() : '';
        $description = $interface->getDocBlock() !== null ? $interface->getDocBlock()->getDescription() : '';
        $this->writeHeader($interface->getName(), $summary, $description);
        $this->writeSummary($interface->getConstants(), array(), $interface->getMethods());
        $this->writeConstants($interface->getConstants());
        $this->writeMethods($interface->getMethods());
        $this->create();
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Trait_ $trait
     * @throws \Mpdf\MpdfException
     */
    public function createFromTrait(\phpDocumentor\Reflection\Php\Trait_ $trait): void {
        $summary = $trait->getDocBlock() !== null ? $trait->getDocBlock()->getSummary() : '';
        $description = $trait->getDocBlock() !== null ? $trait->getDocBlock()->getDescription() : '';
        $this->writeHeader($trait->getName(), $summary, $description);
        $this->writeSummary(array(), $trait->getProperties(), $trait->getMethods());
        $this->writeProperties($trait->getProperties());
        $this->writeMethods($trait->getMethods());
        $this->create();
    }

    /**
     * @param string $name
     * @param string $summary
     * @param string $description
     * @throws \Mpdf\MpdfException
     */
    private function writeHeader(string $name, string $summary, string $description): void {
        $this->WriteHTML(file_get_contents($this->templatesPath . '/styles.css'),\Mpdf\HTMLParserMode::HEADER_CSS);
        $this->SetHeader('Generated with <a href="https://github.com/lluiscamino/phpDoc2pdf">phpDoc2pdf</a>');
        $this->html .= $this->templatesEngine->render('header', array ('name' => $name, 'summary' => $summary, 'description' => $description));
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Constant[] $constants
     * @param \phpDocumentor\Reflection\Php\Property[] $properties
     * @param \phpDocumentor\Reflection\Php\Method[] $methods
     */
    private function writeSummary(array $constants, array $properties, array $methods): void {
        $constants_ = $properties_ = $methods_ = array(
            'public' => '',
            'protected' => '',
            'private' => ''
        );
        foreach ($constants as $constant) {
            $constants_['public'] .= '<a href="#constant:' . $constant->getName() . '">' . $constant->getName() . '</a><br>';
        }
        foreach ($properties as $property) {
            $properties_[strval($property->getVisibility())] .= '<a href="#property:' .$property->getName() . '">$' .$property->getName() . '</a><br>';
        }
        foreach ($methods as $method) {
            $methods_[strval($method->getVisibility())] .= '<a href="#method:' .$method->getName() . '">' .$method->getName() . '</a><br>';
        }
        $this->html .= $this->templatesEngine->render('summary', array('methods' => $methods_, 'properties' => $properties_, 'constants' => $constants_));
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Constant[] $constants
     */
    private function writeConstants(array $constants): void {
        if (!empty($constants)) {
            $this->html .= $this->templatesEngine->render('constants', array('constants' => $constants));
        }
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Property[] $properties
     */
    private function writeProperties(array $properties): void {
        if (!empty($properties)) {
            $this->html .= $this->templatesEngine->render('properties', array('properties' => $properties));
        }
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Method[] $methods
     */
    private function writeMethods(array $methods): void {
        if (!empty($methods)) {
            $this->html .= $this->templatesEngine->render('methods', array('methods' => $methods));
        }
    }

    /**
     * Generates PDF file.
     * @throws \Mpdf\MpdfException
     */
    private function create(): void {
        $this->WriteHTML($this->html);
        $this->output($this->path . '.pdf', 'F');
    }
}