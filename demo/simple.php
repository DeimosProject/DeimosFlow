<?php

include_once __DIR__ . '/../vendor/autoload.php';

$flow = new Deimos\Flow\Flow();

$flow->setCompileDir(dirname(__DIR__) . '/compile');
$flow->setTemplateDir(dirname(__DIR__) . '/view');

$flow->content = 'Have fun code!';
$flow->storage = range(1, 5);

echo $flow->render('admin/cms');