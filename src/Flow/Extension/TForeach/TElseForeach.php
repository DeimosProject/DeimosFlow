<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TElseForeach extends FlowFunction
{

    public static $elseForeach = false;

    public function view()
    {
        self::$elseForeach = true;
        return '<?php endforeach; else: ?>';
    }

}