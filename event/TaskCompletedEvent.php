<?php

namespace app\event;

class TaskCompletedEvent extends BaseEvent
{
    public function getEventText(): string
    {
        return \Yii::t('app', 'Task completed');
    }
}