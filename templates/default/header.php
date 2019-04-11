<h1><?php echo $name ?></h1>
<i><?php echo $summary ?></i><br>
<?php
$parsedown = new \Parsedown();
echo $parsedown->text($description) ?>