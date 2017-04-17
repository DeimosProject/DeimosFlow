<?php

include_once __DIR__ . '/../vendor/autoload.php';

$configure = new \Deimos\Flow\Configure();

$configure->debugEnable();

$configure->addResource('admin', dirname(__DIR__) . '/view/admin');
$configure->addResource('ux', dirname(__DIR__) . '/view/ux');

$flow = new Deimos\Flow\Flow($configure);

$flow->setCompileDir(dirname(__DIR__) . '/compile');
$flow->setTemplateDir(dirname(__DIR__) . '/view');

$flow->assign('content', 'Have fun code!');
$flow->storage = range(1, 5);
$flow->array = ['hello' => '<h1>hello world</h1>'];

echo $flow->render('admin:cms-simple');
