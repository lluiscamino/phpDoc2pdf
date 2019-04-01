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
    private $path;

    /**
     * @var string
     */
    private $html = '';

    /**
     * @var string
     */
    private $styles = 'a { text-decoration: none; } pre {background-color: #fff3d4; font-size: 0.9em;
                       border: 1px solid #f6b73c; border-radius: 4px; padding: 4px;} table { width: 100%; }
                       th, tr { text-align: left; padding-left: 30px; } em { font-size: 0.8em; }';

    /**
     * PDFFile constructor.
     * @param string $path
     * @throws \Mpdf\MpdfException
     */
    public function __construct(string $path) {
        $this->path = $path;
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
     */
    private function writeHeader(string $name, string $summary, string $description): void {
        $this->html = '<style>' . $this->styles . '</style>';
        $this->SetHeader('Generated with <a href="https://github.com/lluiscamino/phpDoc2pdf">phpDoc2pdf</a>');
        $this->html .= '<h1>' . $name . '</h1><i>' . $summary . '</i><br>' . $description;
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
        $this->html .= '<h2>Summary</h2>';
        $this->html .= '<table>
                            <tr>
                                <th></th>
                                <th>Methods</th>
                                <th>Properties</th>
                                <th>Constants</th>
                            </tr>
                            <tr>
                                <td>Public</td>
                                <td>' . ($methods_['public'] !== '' ? $methods_['public'] : '<em>No public methods found</em>') . '</td>
                                <td>' . ($properties_['public'] !== '' ? $properties_['public'] : '<em>No public properties found</em>') . '</td>
                                <td>' . ($constants_['public'] !== '' ? $constants_['public'] : '<em>No public constants found</em>') . '</td>
                            </tr>
                            <tr>
                                <td>Protected</td>
                                <td>' . ($methods_['protected'] !== '' ? $methods_['protected'] : '<em>No protected methods found</em>') . '</td>
                                <td>' . ($properties_['protected'] !== '' ? $properties_['protected'] : '<em>No protected properties found</em>') . '</td>
                                <td><em>N/A</em></td>
                            </tr>
                            <tr>
                                <td>Private</td>
                                <td>' . ($methods_['private'] !== '' ? $methods_['private'] : '<em>No private methods found</em>') . '</td>
                                <td>' . ($properties_['private'] !== '' ? $properties_['private'] : '<em>No private properties found</em>') . '</td>
                                <td><em>N/A</em></td>
                            </tr>
                        </table>';
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Constant[] $constants
     */
    private function writeConstants(array $constants): void {
        if (!empty($constants)) {
            $this->html .= '<h2>Constants</h2>';
            foreach ($constants as $constant) {
                $summary = ($constant->getDocBlock() !== null && $constant->getDocBlock()->getSummary() !== '') ? $constant->getDocBlock()->getSummary() . '<br>' : '';
                $description = ($constant->getDocBlock() !== null && $constant->getDocBlock()->getDescription() !== '') ? $constant->getDocBlock()->getDescription() : '';
                $this->html .= '<h3><a name="constant:' . $constant->getName() . '">' . $constant->getName() . '</a></h3>
                <pre>'. $constant->getName() . '</pre><i>' . $summary . '</i><br>' . $description;
            }
        }
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Property[] $properties
     */
    private function writeProperties(array $properties): void {
        if (!empty($properties)) {
            $this->html .= '<h2>Properties</h2>';
            foreach ($properties as $property) {
                $summary = ($property->getDocBlock() !== null && $property->getDocBlock()->getSummary() !== '') ?$property->getDocBlock()->getSummary() . '<br>' : '';
                $description = ($property->getDocBlock() !== null && $property->getDocBlock()->getDescription() !== '') ? $property->getDocBlock()->getDescription() : '';
                $type = ($property->getDocBlock() !== null && $property->getDocBlock()->hasTag('var')) ? explode(' ', $property->getDocBlock()->getTagsByName('var')[0]->render(), 2)[1] : '';
                $separator = $type !== '' ? ': ' : '';
                $this->html .= '<h3><a name="property:' . $property->getName() . '">$' . $property->getName() . ' (' . $property->getVisibility() .')</a></h3>
                <pre>$'. $property->getName() . $separator .  $type . '</pre><i>' . $summary . '</i>' . $description .
                     ($type !== '' ? ('<h4>Type</h4>' . $type) : '');
            }
        }
    }

    /**
     * @param \phpDocumentor\Reflection\Php\Method[] $methods
     */
    private function writeMethods(array $methods): void {
        if (!empty($methods)) {
            $this->html .= '<h2>Methods</h2>';
            foreach ($methods as $i => $method) {
                $argumentNames = array();
                foreach ($method->getArguments() as $argument) {
                    $argumentNames[] = $argument->getType() . ' $' . $argument->getName();
                }
                $summary = ($method->getDocBlock() !== null && $method->getDocBlock()->getSummary() !== '') ? $method->getDocBlock()->getSummary() . '<br>' : '';
                $description = ($method->getDocBlock() !== null && $method->getDocBlock()->getDescription() !== '') ? $method->getDocBlock()->getDescription() : '';
                $this->html .= '<h3><a name="method:' . $method->getName() . '">' . $method->getName() . ' (' . $method->getVisibility() . ')</a></h3>
                <pre>' . $method->getName() . '('. implode(', ', $argumentNames) . ')' . ($method->getReturnType() != 'mixed' ? ': ' . $method->getReturnType() : '');
                $this->html .= '</pre><i>' . $summary . '</i>' . $description;
                if (!empty($method->getArguments())) {
                    $this->html .= '<h4>Parameters</h4>';
                }
                foreach ($method->getArguments() as $argument) {
                    $this->html .= $argument->getType() . ' <strong>' . $argument->getName() . '</strong><br>';
                }
                if ($method->getDocBlock() !== null) {
                    if (!empty($method->getDocBlock()->getTagsByName('throws'))) {
                        $this->html .= '<h4>Throws</h4>';
                    }
                    foreach ($method->getDocBlock()->getTagsByName('throws') as $throwsTag) {
                        $this->html .= str_replace('@throws', '', $throwsTag->render() . '</strong><br>');
                    }
                }
                $this->html .= '<br>';
            }
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