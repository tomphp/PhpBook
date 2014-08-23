<?php

// Load up Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// This class will loaded automatically
$app = new \ComposerExample\HelloApplication();
$app->run();
