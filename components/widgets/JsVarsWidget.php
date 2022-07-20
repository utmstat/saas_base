<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 31.05.17
 * Time: 22:39
 */

namespace app\components\widgets;

use app\components\common\AppWidget;

class JsVarsWidget extends AppWidget
{

    public function run()
    {
        return $this->render('jsVarsWidget');
    }

}