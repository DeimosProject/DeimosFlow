<?php

include_once __DIR__ . '/../vendor/autoload.php';

$configure = new Deimos\Flow\Configure();

$configure->compile(dirname(__DIR__) . '/cache');
$configure->template(dirname(__DIR__) . '/view');

$defaultConfig = new \Deimos\Flow\DefaultConfig();

class DI extends \Deimos\Flow\DefaultContainer
{
    public function configure()
    {
        parent::configure();

        $this->addCallback('length', function ($storage)
        {
            return mt_rand();
        });
    }
}

class Helper extends \Deimos\Helper\Helper
{

}

$helper = new Helper( new \Deimos\Builder\Builder() );

$configure->di(new DI($defaultConfig, $helper));

$flow = new Deimos\Flow\Flow($configure);

echo $flow->render('admin/di');