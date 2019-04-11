<h2>Methods</h2>
<?php
$parsedown = new \Parsedown();
foreach ($methods as $method) {
    $argumentNames = array();
    foreach ($method->getArguments() as $argument) {
        $argumentNames[] = $argument->getType() . ' $' . $argument->getName();
    }
    $summary = ($method->getDocBlock() !== null && $method->getDocBlock()->getSummary() !== '') ? $method->getDocBlock()->getSummary() . '<br>' : '';
    $description = ($method->getDocBlock() !== null && $method->getDocBlock()->getDescription() !== '') ? $parsedown->text($method->getDocBlock()->getDescription()) : '';
    ?>
    <h3><a name="method:<?php echo $method->getName() ?>"><?php echo $method->getName() ?> (<?php echo $method->getVisibility() ?>)</a></h3>
    <pre><?php echo $method->getName() ?>(<?php echo implode(', ', $argumentNames) ?>)<?php echo ($method->getReturnType() != 'mixed' ? ': ' . $method->getReturnType() : '') ?></pre>
    <i><?php echo $summary ?></i>
    <?php echo $description;
    if (!empty($method->getArguments())) {
        ?>
        <h4>Parameters</h4>
        <?php
    }
    foreach ($method->getArguments() as $argument) {
        echo $argument->getType() ?> <strong><?php echo $argument->getName() ?></strong><br>
        <?php
    }
    if ($method->getDocBlock() !== null) {
        if (!empty($method->getDocBlock()->getTagsByName('throws'))) {
            ?>
            <h4>Throws</h4>
            <?php
        }
        foreach ($method->getDocBlock()->getTagsByName('throws') as $throwsTag) {
            echo str_replace('@throws', '', $throwsTag->render() . '</strong><br>');
        }
    }
    ?>
    <br>
    <?php
}