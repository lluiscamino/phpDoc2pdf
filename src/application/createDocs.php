<?php
require '../../vendor/autoload.php';
require 'CreateDocsCommand.php';
use Symfony\Component\Console\Application;
error_reporting(0);

$app = new Application('phpDoc2pdf');
$app->add(new \application\CreateDocsCommand());
try {
    $app->run();
} catch (\Exception $e) {}