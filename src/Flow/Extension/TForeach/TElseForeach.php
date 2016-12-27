<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TElseForeach extends FlowFunction
{

    public static $elseForeach = [];

    public function view()
    {
        self::$elseForeach[TForeach::$level] = true;

        $init = '';

        if (!empty(TForeach::$name[TForeach::$level]))
        {
//            $init = '$this->foreach->' . TForeach::$name[TForeach::$level] . '->end();';

            TForeach::$name[TForeach::$level] = null;
        }

        return '<?php endforeach; ' . $init . ' else: ?>';
    }

}