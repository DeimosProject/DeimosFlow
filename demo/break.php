<?php

include_once __DIR__ . '/../vendor/autoload.php';

$configure = new Deimos\Flow\Configure();

$configure->compile(dirname(__DIR__) . '/cache');
$configure->template(dirname(__DIR__) . '/view');

$flow = new Deimos\Flow\Flow($configure);

$flow->template = 'test';

echo $flow->render('admin/break');