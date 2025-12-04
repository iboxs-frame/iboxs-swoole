<?php
define('STUB_DIR', realpath(__DIR__ . '/stub'));

$app = new \iboxs\App(STUB_DIR);

$app->initialize();
