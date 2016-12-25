<?php

include_once __DIR__ . '/../vendor/autoload.php';

$configure = new Deimos\Flow\Configure();

$configure->compile(dirname(__DIR__) . '/cache');
$configure->template(dirname(__DIR__) . '/view');

$flow = new Deimos\Flow\Flow($configure);

$flow->title = 'World';

class DI extends Deimos\DI\DI
{
    /**
     * @var \Deimos\Helper\Helper
     */
    protected $helper;

    public function __construct()
    {
        $builder      = new \Deimos\Builder\Builder();
        $this->helper = new \Deimos\Helper\Helper($builder);

        parent::__construct();
    }

    protected function configure()
    {
        $this->build('arr', function ()
        {
            return $this->helper->arr();
        });

        $this->build('str', function ()
        {
            return $this->helper->str();
        });

        $this->build('json', function ()
        {
            return $this->helper->json();
        });
    }
}

//$di = new DI();
//
//$result = $di->call('arr.get', [['a' => 1], 'a']);
//var_dump($result);
//
//$result = $di->call('json.encode', [[['a' => 1], 6=>'a']]);
//var_dump($result);
//
//$result = $di->call('json.decode', [$result]);
//var_dump($result);

echo $flow->render('admin/cms');