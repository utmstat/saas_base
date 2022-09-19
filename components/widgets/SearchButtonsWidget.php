<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 20.07.17
 * Time: 1:29
 */

namespace app\components\widgets;

use app\components\common\AppWidget;
use yii\helpers\Url;

class SearchButtonsWidget extends AppWidget
{
    /** @var string */
    public $resetUrl;

    /** @var bool  */
    public $showHr = true;

    /** @var string */
    public $clearUrl;

    public function run()
    {
        if (!$this->resetUrl) {
            $this->resetUrl = Url::to(['index']);
        }

        return $this->render('searchButtonsWidget',
            [
                'clearUrl' => $this->clearUrl,
                'resetUrl' => $this->resetUrl,
                'showHr' => $this->showHr
            ]);
    }

}