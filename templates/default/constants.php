<h2>Constants</h2>
<?php
$parsedown = new \Parsedown();
foreach ($constants as $constant) {
    $summary = ($constant->getDocBlock() !== null && $constant->getDocBlock()->getSummary() !== '') ? $constant->getDocBlock()->getSummary() . '<br>' : '';
    $description = ($constant->getDocBlock() !== null && $constant->getDocBlock()->getDescription() !== '') ? $constant->getDocBlock()->getDescription() : '';
    ?>
    <h3><a name="constant:<?php echo $constant->getName() ?>">
            <?php echo $constant->getName() ?>
        </a>
    </h3>
    <pre><?php echo $constant->getName() ?></pre>
    <i><?php echo $summary ?></i><br>
    <?php echo $parsedown->text($description);
}