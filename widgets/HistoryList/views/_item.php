<?php
use app\factories\EventFactory;
use app\models\Call;
use app\models\Customer;
use app\models\History;
use app\models\search\HistorySearch;
use app\models\Sms;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use app\widgets\HistoryList\helpers\HistoryRenderHelper;
use yii\helpers\Html;

/** @var $model HistorySearch */

// Создаем объект события с помощью фабрики
$event = EventFactory::createEvent($model);

// Получаем текст события
$eventText = $event->getEventText();

switch ($eventText) {
    case 'Task created':
    case 'Task updated':
    case 'Task completed':
        $task = $model->task;
        $footer = isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : '';
        HistoryRenderHelper::renderItemCommon($this, $model, 'fa-check-square bg-yellow', $footer);
        break;

    case 'Incoming message':
    case 'Outgoing message':
        $footer = $model->sms->direction == Sms::DIRECTION_INCOMING ?
            Yii::t('app', 'Incoming message from {number}', [
                'number' => $model->sms->phone_from ?? ''
            ]) : Yii::t('app', 'Sent message to {number}', [
                'number' => $model->sms->phone_to ?? ''
            ]);
        HistoryRenderHelper::renderItemCommon($this, $model, 'icon-sms bg-dark-blue', $footer, [
            'iconIncome' => $model->sms->direction == Sms::DIRECTION_INCOMING
        ]);
        break;

    case 'Outgoing fax':
    case 'Incoming fax':
        $fax = $model->fax;
        $documentLink = isset($fax->document) ? Html::a(
            Yii::t('app', 'view document'),
            $fax->document->getViewUrl(),
            [
                'target' => '_blank',
                'data-pjax' => 0
            ]
        ) : '';
        $footer = Yii::t('app', '{type} was sent to {group}', [
            'type' => $fax ? $fax->getTypeText() : 'Fax',
            'group' => isset($fax->creditorGroup) ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
        ]);
        HistoryRenderHelper::renderItemCommon($this, $model, 'fa-fax bg-green', $footer, [
            'body' => HistoryListHelper::getBodyByModel($model) . ' - ' . $documentLink
        ]);
        break;

    case 'Type changed':
        HistoryRenderHelper::renderItemStatusChange($this, $model, 
            Customer::getTypeTextByType($model->getDetailOldValue('type')), 
            Customer::getTypeTextByType($model->getDetailNewValue('type')));
        break;

    case 'Property changed':
        HistoryRenderHelper::renderItemStatusChange($this, $model, 
            Customer::getQualityTextByQuality($model->getDetailOldValue('quality')), 
            Customer::getQualityTextByQuality($model->getDetailNewValue('quality')));
        break;

    case 'Incoming call':
    case 'Outgoing call':
        /** @var Call $call */
        $call = $model->call;
        $answered = $call && $call->status == Call::STATUS_ANSWERED;
        $iconClass = $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red';
        $footer = isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null;
        HistoryRenderHelper::renderItemCommon($this, $model, $iconClass, $footer, [
            'content' => $call->comment ?? '',
            'iconIncome' => $answered && $call->direction == Call::DIRECTION_INCOMING
        ]);
        break;

    default:
        HistoryRenderHelper::renderItemCommon($this, $model, 'fa-gear bg-purple-light');
        break;
}
