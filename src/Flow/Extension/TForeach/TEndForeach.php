<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TEndForeach extends FlowFunction
{

    public function view()
    {
        if (TElseForeach::$elseForeach)
        {
            TElseForeach::$elseForeach = false;

            return '<?php endif; ?>';
        }

        return '<?php endforeach; endif; ?>';
    }

}