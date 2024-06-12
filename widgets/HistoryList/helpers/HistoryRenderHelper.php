<?php

namespace app\widgets\HistoryList\helpers;

use yii\helpers\Html;

class HistoryRenderHelper
{
    public static function renderItemCommon($view, $model, $iconClass, $footer = '', $extraParams = [])
    {
        echo $view->render('_item_common', array_merge([
            'user' => $model->user,
            'body' => HistoryListHelper::getBodyByModel($model),
            'footerDatetime' => $model->ins_ts,
            'iconClass' => $iconClass,
            'footer' => $footer,
        ], $extraParams));
    }

    public static function renderItemStatusChange($view, $model, $oldValue, $newValue)
    {
        echo $view->render('_item_statuses_change', [
            'model' => $model,
            'oldValue' => $oldValue,
            'newValue' => $newValue,
        ]);
    }
}
