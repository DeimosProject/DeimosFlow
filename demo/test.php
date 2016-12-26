<?php

include_once __DIR__ . '/../vendor/autoload.php';

$configure = new Deimos\Flow\Configure();

$configure->compile(dirname(__DIR__) . '/cache');
$configure->template(dirname(__DIR__) . '/view');

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
        $this->addCallback('escape', function ($string)
        {
            return htmlentities($string, ENT_QUOTES | ENT_IGNORE, 'UTF-8');
        });

        $this->addCallback('var_dump', 'var_dump');
        $this->addCallback('substr', 'mb_substr');
        $this->addCallback('strlen', 'mb_strlen');

        $this->addCallback('default', function ($string, $default)
        {
            return empty($string) ? $this->escape($default) : $string;
        });

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

$di = new DI();

$configure->di($di);

$flow = new Deimos\Flow\Flow($configure);

//$flow->title = 'World';

//$result = $di->call('arr.get', [['a' => 1], 'a']);
//var_dump($result);
//
//$result = $di->call('json.encode', [[['a' => 1], 6=>'a']]);
//var_dump($result);
//
//$result = $di->call('json.decode', [$result]);
//var_dump($result);

echo $flow->render('admin/cms');