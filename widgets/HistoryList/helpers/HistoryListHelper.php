<?php

namespace app\widgets\HistoryList\helpers;

use app\models\Call;
use app\models\Customer;
use app\models\History;
use Yii;

class HistoryListHelper
{
    public static function getBodyByModel(History $model)
    {
        $event = $model->getEventText();

        switch ($event) {
            case 'Task created':
            case 'Task updated':
            case 'Task completed':
                $task = $model->task;
                return "$event: " . ($task->title ?? '');
            case 'Incoming message':
            case 'Outgoing message':
                return $model->sms->message ? $model->sms->message : '';
            case 'Outgoing fax':
            case 'Incoming fax':
                return $event;
            case 'Type changed':
                return "$event " .
                    (Customer::getTypeTextByType($model->getDetailOldValue('type')) ?? "not set") . ' to ' .
                    (Customer::getTypeTextByType($model->getDetailNewValue('type')) ?? "not set");
            case 'Quality changed':
                return "$event " .
                    (Customer::getQualityTextByQuality($model->getDetailOldValue('quality')) ?? "not set") . ' to ' .
                    (Customer::getQualityTextByQuality($model->getDetailNewValue('quality')) ?? "not set");
            case 'Incoming call':
            case 'Outgoing call':
                /** @var Call $call */
                $call = $model->call;
                return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ? " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');
            default:
                return $event;
        }
    }
}
