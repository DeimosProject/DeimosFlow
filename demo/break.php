<?php

include_once __DIR__ . '/../vendor/autoload.php';

$flow = new Deimos\Flow\Flow();

$flow->setCompileDir(dirname(__DIR__) . '/compile');
$flow->setTemplateDir(dirname(__DIR__) . '/view');

$flow->template = 'test';

echo $flow->render('admin/break');
