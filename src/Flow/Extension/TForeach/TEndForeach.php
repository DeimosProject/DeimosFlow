<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TEndForeach extends FlowFunction
{

    public function view()
    {
        if (!empty(TElseForeach::$elseForeach[TForeach::$level]))
        {
            TElseForeach::$elseForeach[TForeach::$level] = null;
            TForeach::$level--;

            return '<?php endif; ?>';
        }

        $init = '';

        if (!empty(TForeach::$name[TForeach::$level]))
        {
            $init = '$this->foreach->' . TForeach::$name[TForeach::$level] . '->end();';

            TForeach::$name[TForeach::$level] = null;
        }

        TForeach::$level--;

        return '<?php endforeach; ' . $init . ' endif; ?>';
    }

}