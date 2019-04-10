<h2>Properties</h2>
<?php
foreach ($properties as $property) {
    $summary = ($property->getDocBlock() !== null && $property->getDocBlock()->getSummary() !== '') ?$property->getDocBlock()->getSummary() . '<br>' : '';
    $description = ($property->getDocBlock() !== null && $property->getDocBlock()->getDescription() !== '') ? $property->getDocBlock()->getDescription() : '';
    $type = ($property->getDocBlock() !== null && $property->getDocBlock()->hasTag('var')) ? explode(' ', $property->getDocBlock()->getTagsByName('var')[0]->render(), 2)[1] : '';
    $separator = $type !== '' ? ': ' : '';
    ?>
    <h3>
        <a name="property:<?php echo $property->getName() ?>">$<?php echo $property->getName() ?> (<?php echo $property->getVisibility() ?>)</a>
    </h3>
    <pre>$<?php echo $property->getName() . $separator .  $type ?></pre>
    <i><?php echo $summary ?></i>
    <?php echo $description . ($type !== '' ? ('<h4>Type</h4>' . $type) : '');
}